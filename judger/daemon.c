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

char arr[10000][200]; 

int cmp(const void *a, const void *b)
{
     if (strlen(a) < strlen(b)) return -1; 
     else if (strlen(a) > strlen(b)) return 1; 
     else return strcmp(a, b); 
}

int work()
{
     int ret = 0, tot = 0, i; 
     char name[200]; 
     FILE *ft = fopen("judger_daemon.tmp", "r");

     while (fgets(name, 10000, ft) != NULL)
     {
          ret = 1; 
          name[strlen(name) - 1] = 0; 
          if (0 == valid(name)) continue; 
          memcpy(arr[++tot], name, sizeof(name)); 
     }

     qsort(arr + 1, tot, sizeof(arr[0]), cmp); 
     
     for (i=1; i<=tot; i++)
     {
          strcpy(cmd, "python main.py "); 
          arr[i][strlen(arr[i]) - 4] = 0;
          strcat(cmd, arr[i]); 
          system(cmd); 
          // break; 
     }

     fclose(ft); 

     return ret; 
}

int main()
{
     FILE *fp; 

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
