import os
import sys
import fnmatch
import xml.etree.ElementTree as ET

nipt_output = "C:\\Users\\jens_\\Desktop\\Bioinformatica\\Project\\NIPT_Input"
os.chdir(nipt_output)

###Getting the latest added folder in a directory, adding it to path and navigating to it
all_subdirs = [d for d in os.listdir('.') if os.path.isdir(d)]
latest_subdir = max(all_subdirs, key=os.path.getmtime)
print(latest_subdir)
path = os.path.join(nipt_output, latest_subdir)
print(path)
os.chdir(path)
files = os.listdir(path)
print(files) 

###XML-parsing to get data out of XML-file
tree = ET.parse("RunParameters.xml")
root = tree.getroot()
for child in root:
    print(child.tag, child.attrib)
print(root[11][2].text)
seq = root[4].text
print(seq)
lotFC = root[11][2].text
print(lotFC)
lotNS = root[12][2].text
lotNS = int(str(lotNS)[:-1])
print(lotNS)
NSlist = [seq, lotFC, lotNS]
print(NSlist)