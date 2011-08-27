import sys
import signal

class TimeOutException(Exception):
	pass

def TimeLimit(TimeOut_time, default):
	'''To interrpt a timeout function'''
	def TimeOut(f):
		def f2(*args):
			def Handler(signum, frame):
				raise TimeOutException()

			bakeup_handler = signal.signal(signal.SIGALRM, Handler)
			signal.alarm(TimeOut_time)

			try:
				ret = f()
			except TimeOutException:
				return default
			finally:
				signal.signal(signal.SIGALRM, bakeup_handler)
			signal.alarm(0)
			return ret
		return f2
	return TimeOut

@TimeLimit(3, "Accepted")
def test():
	print "enter anything..."
	a = raw_input()
	return a

if __name__ == "__main__":
	print test()
