import os
import sys
import fnmatch
import csv

nipt_output = "C:\\Users\\jens_\\Desktop\\Bioinformatica\\Project\\NIPT_Output"
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

###Getting library prep parameters from output folder
veriseq_path = os.path.join(path, "ProcessLogs")
os.chdir(veriseq_path)
print(os.getcwd())
for file in os.listdir("."):
    if fnmatch.fnmatch(file, '*library_quant_report*.tab'):
        print(file)
        lib_prep = file
print(lib_prep)
library_prep = []
with open (lib_prep, 'r') as f:
    next(f)
    reader = csv.reader(f, delimiter='\t')
    for parameter in reader:
        library_prep.append(parameter)
library_prep = library_prep[0]
print(library_prep)