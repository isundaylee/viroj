#error
#  1: compile failed
#  2: compile time limit exceeded
#  0: succeed
#format
# python compiler.py ./taskdir/main.cpp cpp

import sys
import TimeOut_Decorator
import commands
import os

PATH = "./temp/"
TIME_LIMIT = 10
SourceName = sys.argv[1]
suf = sys.argv[2]

PASCAL = 'fpc %s -o"%s" -Co -Cr -Ci -Ct' % (SourceName, PATH + "main")
CPP = "g++ %s -o %s -O2 -Wall -lm" % (SourceName, PATH + "main")
C = "gcc %s -o %s -O2 -Wall -lm" % (SourceName, PATH + "main")
LanguageCompile = [PASCAL, CPP, C]
LanguageList=["pas", "cpp", "c"]

@TimeOut_Decorator.TimeLimit(TIME_LIMIT, 2)
def Compile():
	num = LanguageList.index(suf)
	status, output = commands.getstatusoutput(LanguageCompile[num])
	print output
	return status

if __name__ == "__main__":
	status = Compile()
	if status == 2:
		print "Compile Time Limit Exeeded!"
		quit(2)
	elif status == 256:
		quit(1)
	else:
		quit(0)
