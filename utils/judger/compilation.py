#error
#  1: compile failed
#  2: compile time limit exceeded
#  3: source not found
#  5: source length limit exceeded
#  0: succeed

import sys
import TimeOut_Decorator
import commands
import os

class SourceNotFound(Exception):
	pass
class SourceLengthLimitExceeded(Exception):
	pass

TIME_LIMIT = 5
Source_Length_Limie = int(raw_input())
LanguageList = [".pas", ".cpp", ".c"]

def Prepare():
	global path
	global suf
	global SourceName, PASCAL, CPP, C, Language_compile
	path = os.getcwd()
	for i in os.listdir(path):
		name, local_suf = os.path.splitext(i)
		if name == "main" and (local_suf in LanguageList):
			suf = local_suf
			SourceName = path + "/" + i
			PASCAL = "fpc %s -o %s -Co -Cr -Ci Ct" % (SourceName, "main")
			CPP = "g++ %s -o %s -O2 -Wall -lm" % (SourceName, "main")
			C = "gcc %s -o %s -O2 -Wall -lm" % (SourceName, "main")
#			PASCAL, C++, C
			Language_compile = [PASCAL, CPP, C]
			break
	else:
		raise SourceNotFound()

	SourceLength = int(os.path.getsize(SourceName))
	if SourceLength > Source_Length_Limie:
		raise SourceLengthLimitExceeded()

@TimeOut_Decorator.TimeLimit(TIME_LIMIT, 2)
def Compile():
	num = LanguageList.index(suf)
	status, output = commands.getstatusoutput(Language_compile[num])
	print output
	return status

if __name__ == "__main__":
	try:
		Prepare()
	except SourceNotFound:
		quit(3)
	except SourceLengthLimitExceeded:
		quit(5)
	status = Compile()
	if status == 2:
		quit(2)
	if status == 256:
		quit(1)
	quit(0)
