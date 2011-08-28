#include <iostream>
#include <cstdlib>
#include <string>

using namespace std; 

string reqdir = "requests/"; 
string resdir = "results/";
string cmd = "rm -f "; 

int main(int argc, char *argv[])
{
     if (argc < 2) exit(1);

     int a = atoi(argv[1]);
          
     cmd += reqdir; 
     cmd += string(argv[1]); 
     cmd += ".req"; 
     system(cmd.c_str());
     
     for (int i=1; i<=10; i++)
     {
          FILE *fp = fopen((resdir + string(argv[1]) + ".res").c_str(), "w");
          
          if (i == 10) fprintf(fp, "acm\n0 %d %d 125 0\n", 121 * i, 534 * i); 
          else fprintf(fp, "acm\n12 %d %d 125 %d\n", 121 * i, 534 * i, i);
          
          fclose(fp); 

          sleep(1); 
     }
          
/*
  fp = fopen((resdir + string(argv[1]) + ".cmp").c_str(), "w");
  
  fprintf(fp, "Compile Error: Some variables are not declared. \n"); 
  
  fclose(fp); 
*/
     
     return 0; 
}
