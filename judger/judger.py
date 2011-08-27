import commands

ret, test = commands.getstatusouput("./main.py <config")
if ret == 5:
	print "5 0 0 0"
if ret == 1:
	print "1 0 0 0"

print "%d %s"%(ret, test)
