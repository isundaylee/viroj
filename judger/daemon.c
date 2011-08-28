#include <unistd.h>
#include <signal.h>
#include <sys/types.h>
#include <sys/stat.h>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>

#ifndef NOFILE
#define NOFILE 3
#endif

void init_daemon()
{
     int pid;
     int i; 

     if ((pid = fork()) != 0) exit(0);
     else if (pid < 0) exit(1); 

     setsid(); 

     if (pid = fork()) exit(0); 
     else if (pid < 0) exit(1); 

     for (i=0; i<NOFILE; i++)
     {
          close(i); 
     }

     umask(0); 

     return; 
}

char reqdir[200] = "requests/";
char cmd[200]; 

int valid(char *name)
{
     int i;
     int len = strlen(name);

     if (name[len - 1] != 'q'
         || name[len - 2] != 'e'
         || name[len - 3] != 'r'
         || name[len - 4] != '.') return 0;

     for (i=0; i<len-4; i++)
     {
          if (!('0' <= name[i] && name[i] <= '9')) return 0; 
     }

     return 1; 
}

int work()
{
     int ret = 0; 
     char name[200]; 
     FILE *ft = fopen("judger_daemon.tmp", "r");

     while (fgets(name, 10000, ft) != NULL)
     {
          ret = 1; 
          name[strlen(name) - 1] = 0; 
          if (0 == valid(name)) continue; 
          strcpy(cmd, "python main.py "); 
          name[strlen(name) - 4] = 0;
          strcat(cmd, name); 
          system(cmd); 
          break; 
     }

     fclose(ft); 

     return ret; 
}

int main()
{
     FILE *fp; 

     signal(SIGCHLD, SIG_IGN);

     init_daemon();

     fp = fopen("judger_daemon.log", "a"); 

     if (fp == NULL) exit(0); 
     
     while (1)
     {
          system("rm judger_daemon.tmp"); 
          strcpy(cmd, "ls "); 
          strcat(cmd, reqdir); 
          strcat(cmd, " >> judger_daemon.tmp"); 
          system(cmd); 
          if (0 == work()) sleep(1); 
     }

     return 0; 
}
