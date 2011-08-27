#format
#python checker.py std_output std_input
import commands
import sys

AC=int(0)
WA=int(9)
std_output=sys.argv[1]
usr_output=sys.argv[2]

ret, status = commands.getstatusoutput("diff %s %s -q -B" %(std_output, usr_output))

if ret == 0:
	quit(AC)
else:
	quit(WA)
