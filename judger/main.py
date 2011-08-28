import sys
import commands

commands.getstatusoutput("mkdir ./temp")

def Output(status):
	open("./result/%s.res"%(sys.argv[1]), "w").write(status)

tmp, SourceName = raw_input().split("=")
tmp, suf = raw_input.split("=")
tmp, SourceLimit = raw_input.split("=")

Length = os.st_size(SourceName)
if Length * 1024 > SourceLimit:
	Output("5 0 0 0")
	quit(0)

ret, status = commands.getstatusoutput("python conpiler.py %s %s >./temp/tmp.com"%(SourceName, suf))
if ret:
	open("./result/compile.tmp", "w").write(status)
	Output("1 0 0 0")
	quit(0)

nData=int(raw_input())
stime = 0
maxmeory = 0
for i in range(1, nData + 1):

	tLimit, mLimit, inputdir, outputdir = raw_input().split(" ")
	ret, status = commands.getstatusoutput("./excutor %s %s %s %s"&(tLimit, mLimit, inputdir, "./temp/tmp.out"))

	timeused, memused = map(int, status.split())
	stime += timeused
	maxmeory = max(maxmeory, memused)
	
	Output("12 %d %d %d"%(stime, maxmeory, i))

	if ret:
		Output("6 %d %d %d"%(stime, maxmeory, i))
		quit(0)

	ret, status = commands.getstatusoutput("python ./checker.py %s ./temp/tmp.out"%(outputdir))
	if ret:
		print "9 %d %d %d"%(stime, maxmeory, i)
		quit(0)

commands.getstatusoutput("rm -rf ./temp")
print "0 %d %d %d"%(stime, maxmeory, 0)

