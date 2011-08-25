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
     
     FILE *fp = fopen((resdir + string(argv[1]) + ".res").c_str(), "w");

     cmd += reqdir; 
     cmd += string(argv[1]); 
     cmd += ".req"; 

     system(cmd.c_str()); 

     fprintf(fp, "acm\n9 121000 5340000 13\n");

     fclose(fp); 

/*
     fp = fopen((resdir + string(argv[1]) + ".cmp").c_str(), "w");

     fprintf(fp, "Compile Error: Some variables are not declared. \n"); 

     fclose(fp); 
*/

     return 0; 
}
