/*
error code:
0:success
6:RE
7:TLE
8:MLE
format:
./excutor tLimit mLimit inputdir outputdir resdir
*/

#include <string>
#include <string.h>
#include <stdio.h>
#include <stdlib.h>
#include <assert.h>
#include <unistd.h>
#include <signal.h>
#include <sys/types.h>
#include <sys/wait.h>
#include <sys/resource.h>
#include <sys/ptrace.h>
#include <sys/user.h>
#include <sys/syscall.h>
#include <sys/time.h>

#define NORMAL 0
#define RE 6
#define TLE 7
#define MLE 8
#define __PATH__ "./temp"

using namespace std;

int tLimit, mLimit;//time: MS, memory: KB
string program = "main";
string PATH = __PATH__;
char *outputdir, *inputdir, *resdir;
pid_t subpid;
int tused = 0, mused = 0;

int cnt = 0;

inline void Result(int status) {
	ptrace(PTRACE_KILL, subpid, 0, 0);
	fprintf(stdout, "%d %d %d", tused, mused, status);
	exit(0);
}

#define Read_Config {\
	double time_limit, memory_limit;\
	sscanf(argv[1], "%lf", &time_limit);\
	sscanf(argv[2], "%lf", &memory_limit);\
	inputdir = argv[3], outputdir = argv[4], resdir = argv[5];\
	program = PATH + program;\
	tLimit = time_limit * 1000;\
	mLimit = memory_limit * 1024;\
}

inline void Trans(string st, char ch[]) {
	int n = st.length();
	for (int i = 0; i < n; i++)
		ch[i] = st[i];
	ch[n + 1] = '\0';
}

char tmp[100];
inline void Run(void) {
	ptrace(PTRACE_TRACEME, 0, NULL, NULL);
	execl(tmp, tmp, NULL);
}

inline int GetMomeoryUsed(void) {
	char ch[50];
	sprintf(ch, "/proc/%d/statm", subpid);

	FILE* tmp = fopen(ch, "r");
	int memory;
	for (int i = 1; i <= 1; i++)
		fscanf(tmp, "%d", &memory);
	fclose(tmp);

	memory *= (getpagesize() / 1024);
	return memory;
}

inline bool ForbiddenSyscall(int syscall) {
	return false;
}

inline void check(void) {
	user_regs_struct reg;
	bool forbidden = false;
	int syscall = 0;
	static bool once = false;

	ptrace(PTRACE_GETREGS, subpid, NULL, &reg);
	#ifdef __i386__
	syscall = reg.orig_eax;
	#else
	syscall = reg.orig_rax;
	#endif

	if (ForbiddenSyscall(syscall))
		forbidden = true;

	if (syscall == SYS_execve) {
		if (!once)
			once = true;
		else
			forbidden = true;
	}

	if (syscall == SYS_execve || 
			syscall == SYS_mmap||
			syscall == SYS_brk||
			syscall == SYS_mmap2||
			syscall == SYS_munmap) {
		int CurMemory = GetMomeoryUsed();
		if (CurMemory > mused)
			mused = CurMemory;
		if (mused > mLimit)
			Result(MLE);
	}

	if (forbidden)
		Result(RE);
}

void Timer(int _) {
	kill(subpid, SIGUSR1);
	alarm(1);
}
inline void SetTimer(void) {
	signal(SIGALRM, Timer);
	alarm(1);
}

int main(int argc, char* argv[]) {
	Read_Config;
	freopen(inputdir, "r", stdin);
	freopen(outputdir, "w", stdout);
	
	Trans(program, tmp);
	subpid = fork();

	if (subpid == 0) {
		Run();
		exit(0);
	}

	int status;
	rusage info;
	
	SetTimer();
	while(true) {
		wait4(subpid, &status, 0, &info);
		tused = info.ru_utime.tv_sec * 1000 + info.ru_utime.tv_usec / 1000;
		
		cnt++;

		if (WIFEXITED(status)) {
			int code = WEXITSTATUS(status);
			if (code != 0) {
				Result(RE);
			}
			Result(NORMAL);
		}
		if (WIFSIGNALED(status)) {
			Result(RE);
		}
		if (WIFSTOPPED(status)) {
			int tmp = WSTOPSIG(status);
			if (tmp == SIGTRAP) {
				check();
			}
			else if (tmp != SIGUSR1 && tmp != SIGPROF) {
				printf("%d\n", tmp);
				Result(RE);
			}
		}
		if (tused > tLimit) {
			Result(TLE);
		}

		ptrace(PTRACE_SYSCALL, subpid, NULL, NULL);
	}
}
