import sys
import commands
import os

id = sys.argv[1]
commands.getstatusoutput("mkdir ./temp")

def Output(status, exit = True):
	if (exit):
		commands.getstatusoutput("rm -rf ./temp")
	open("./results/%s.res"%(id), "w").write(status)

f = open("./requests/%s.req"%(id), "r")
def Read(s = '='):
	return f.readline().rstrip("\n"" ""\r").split(s)

tmp, SourceName = Read()
tmp, suf = Read()
tmp, SourceLimit = Read()
SourceLimit = int(SourceLimit)

Length = int(os.stat(SourceName).st_size)

if Length > SourceLimit * 1024:
	Output("5 0 0 0 %d"%(Length))
	quit(0)

ret, status = commands.getstatusoutput("python compiler.py %s %s"%(SourceName, suf))
if ret:
	open("./results/compile.tmp", "w").write(status)
	Output("1 0 0 0 %d"%(Length))
	quit(0)

tmp, nData = Read()
nData = int(nData)
stime = 0
maxmeory = 0

for i in range(1, nData + 1):

	tLimit, mLimit, inputdir, outputdir = Read(' ')
	ret, status = commands.getstatusoutput("./excutor %s %s %s"%(tLimit, mLimit, inputdir))

	timeused, memused, ret = map(int, open("./temp/excutor.tmp", "r").read().split())
	stime += timeused
	maxmeory = max(maxmeory, memused)
	
	Output("12 %d %d %d %d"%(stime, maxmeory, i, Length), False)

	if ret:
		Output("%d %d %d %d %d"%(ret, stime, maxmeory, i, Length))
		quit(0)

	ret, status = commands.getstatusoutput("python ./checker.py %s ./temp/tmp.out"%(outputdir))
	if ret:
		Output("9 %d %d %d %d"%(stime, maxmeory, i, Length))
		quit(0)

Output("0 %d %d %d %d"%(stime, maxmeory, 0, Length))

