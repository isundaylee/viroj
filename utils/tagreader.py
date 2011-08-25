import re

def read_tag(filename):
    fp = open(filename, 'r')
    lines = fp.readlines()
    taglist = {}
    for line in lines:
        p = re.compile(r"@(?P<item>[\S ]*):(?P<content>[\S ]*)")
        ans = p.search(line)
        taglist[ans.group('item')] = ans.group('content').strip();
    return taglist
