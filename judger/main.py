import sys
import commands
import os

SourceName = "main"
suf = "cpp"
SourceLimit = 50
Type = "ACM"
nData = 10

id = sys.argv[1]
commands.getstatusoutput("mkdir ./temp")

def Output(status, exit = True):
	if (exit):
		commands.getstatusoutput("rm -rf ./temp")
	open("./results/%s.res"%(id), "w").write(Type + "\n" + status)

f = open("./requests/%s.req"%(id), "r")
def Read(s = '='):
	return f.readline().rstrip("\n"" ""\r").split(s)

while (True):
	key, value = Read()
	tmpstr = key.lower()
	if (tmpstr == "source"):
		SourceName = value
	elif (tmpstr == "lang"):
		suf = value
	elif (tmpstr == "sourcelimit"):
		SourceLimit = int(value)
	elif (tmpstr == "type"):
		Type = value
	elif (tmpstr == "datanum"):
		nData = int(value)
		break

Length = int(os.stat(SourceName).st_size)

if Length > SourceLimit * 1024:
	Output("5 0 0 0 %d"%(Length))
	quit(0)

ret, status = commands.getstatusoutput("python compiler.py %s %s"%(SourceName, suf))
if ret:
	open("./results/%s.cmp"%(id), "w").write(status)
	Output("1 0 0 0 %d"%(Length))
	quit(0)

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

	ret, status = commands.getstatusoutput("python checker.py %s ./temp/tmp.out"%(outputdir))
	if ret:
		Output("9 %d %d %d %d"%(stime, maxmeory, i, Length))
		quit(0)

Output("0 %d %d %d %d"%(stime, maxmeory, 0, Length))

