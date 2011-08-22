from tagreader import *
from consts import *

def make_html_compatible(content):
    content = content.replace('\n', '</br>')
    content = content.replace(' ', '&nbsp;')
    return content

def read_file(filename):
    fp = open(filename, 'r')
    return make_html_compatible(fp.read()); 

def generate_page(taskname):
    taskroot = taskdir + taskname + '/'
    taglist = read_tag(taskroot + '.conf'); 
    str = page_template; 
    str = str.replace('*TITLE*', taglist['title'])
    str = str.replace('*DESC*', read_file(taskroot + 'desc.txt'))
    str = str.replace('*INPUT*', read_file(taskroot + 'input.txt'))
    str = str.replace('*OUTPUT*', read_file(taskroot + 'output.txt'))
    str = str.replace('*SINPUT*', read_file(taskroot + 'sinput.txt'))
    str = str.replace('*SOUTPUT*', read_file(taskroot + 'soutput.txt'))
    str = str.replace('*LIMIT*', read_file(taskroot + 'limit.txt'))
    return str

taskname = 'test'

fp = open(taskdir + taskname + "/page.html", 'w')
fp.write(generate_page(taskname))
