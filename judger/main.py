import sys
import commands

tmp, SourceName = raw_input().split("=")
tmp, suf = raw_input.split("=")
tmp, SourceLimit = raw_input.split("=")

Length = os.st_size(SourceName)
if Length * 1024 > SourceLimit:
	quit(5)

ret, status = commands.getstatusoutput("python ./conpiler.py %s %s >tmp.com"%(SourceName, suf))
if ret:
	print status
	quit(1)

nData=int(raw_input())
stime = 0
maxmeory = 0
for i in range(0, nData):

	tLimit, mLimit, inputdir, outputdir = raw_input().split(" ")
	ret, status = commands.getstatusoutput("./excutor %s %s %s %s"&(tLimit, mLimit, inputdir))

	timeused, memused = map(int, status.split())
	stime += timeused
	maxmeory = max(maxmeory, memused)

	if ret:
		print "%d %d %d"%(stime, maxmeory, i + 1)
		quit(int(ret))

	ret, status = commands.getstatusoutput("python ./main.py %s ./tmp.out"%(outputdir))
	if ret:
		print "%d %d %d"%(stime, maxmeory, i + 1)
		quit(int(ret))

print "%d %d %d"%(stime, maxmeory, 0)
quit(0)

