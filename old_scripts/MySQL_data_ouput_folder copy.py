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


###Navigating to library_reagent_report to collect Veriseq lot number
veriseq_path = os.path.join(path, "ProcessLogs")
os.chdir(veriseq_path)
print(os.getcwd())
for file in os.listdir("."):
    if fnmatch.fnmatch(file, '*library_reagent_report*.tab'):
        print(file)
        library = file
print(library)
lotnumber = []
with open (library, 'r') as f:
    next(f)
    reader = csv.reader(f, delimiter='\t')
    for lotnumber in reader:
        lotnumber.append(lotnumber)
print(lotnumber)
lotnumber_vs = lotnumber[3]
print(lotnumber_vs)

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
###Get index 0 from library_prep --> get list out of list
library_prep = library_prep[0]
print(library_prep)
del library_prep[0]
del library_prep[0]
del library_prep[0]
del library_prep[1]
del library_prep[2]
del library_prep[2]
del library_prep[2]
del library_prep[2]

 ###Getting QC parameters fo seq run from output folder
veriseq_path = os.path.join(path, "ProcessLogs")
os.chdir(veriseq_path)
print(os.getcwd())
blist = []
quality = []
###Get different sequencing reports in a list, if 96 samples: A and B. If 48 samples: C. For B there where 2 results, appended in
###a list and extracted the correct one and appended to the list of QC files.
for file in os.listdir("."):
    if fnmatch.fnmatch(file, "{}_A*.tab".format(latest_subdir)):
       print(file)
       quality.append(file)
    if fnmatch.fnmatch(file, "{}_B*.tab".format(latest_subdir)):
        print(file)
        blist.append(file)
        print(blist)
    if fnmatch.fnmatch(file, "{}_C*.tab".format(latest_subdir)):
        print(file)
        quality.append(file)
###Error handling if list is empty
try:
    quality.append(blist[1])
    print(quality)
except IndexError:
    print("48 Samples")      

for qcfile in quality:
    if fnmatch.fnmatch(qcfile, "{}_A*.tab".format(latest_subdir)):
        Afile = qcfile
    if fnmatch.fnmatch(qcfile, "{}_B*.tab".format(latest_subdir)):
        Bfile = qcfile
    if fnmatch.fnmatch(qcfile, "{}_C*.tab".format(latest_subdir)):
        Cfile = qcfile
try: 
    Cfile
    qcmetricc = []
    with open (Cfile, 'r') as f:
        next(f)
        reader = csv.reader(f, delimiter='\t')
        for qcmetric in reader:
            qcmetricc.append(qcmetric)
    print(qcmetricc)
except NameError:
    qcmetrica = []
    with open (Afile, 'r') as a:
        next(a)
        reader = csv.reader(a, delimiter='\t')
        for qcmetric in reader:
            qcmetrica.append(qcmetric)
    qcmetricb = []
    with open (Bfile, 'r') as b:
        next(b)
        reader = csv.reader(b, delimiter='\t')
        for qcmetric in reader:
            qcmetricb.append(qcmetric)
###All metrics are added to a variable, it is possible to use a list for the transfer to the database. Code looks messy!!! 
# Error handling if only one list exists
try:
    print(qcmetricc)
    qcmetricc = qcmetricc[0]
    print(qcmetricc)
    del qcmetricc[1]
    del qcmetricc[3]
    del qcmetricc[3]
    del qcmetricc[3]
    del qcmetricc[3]
    del qcmetricc[3]
    del qcmetricc[9]
    del qcmetricc[9]
    print(qcmetricc)
except NameError:
    print(qcmetrica)
    qcmetrica = qcmetrica[0]
    print(qcmetrica)
    del qcmetrica[1]
    del qcmetrica[3]
    del qcmetrica[3]
    del qcmetrica[3]
    del qcmetrica[3]
    del qcmetrica[3]
    del qcmetrica[9]
    del qcmetrica[9]
    print(qcmetrica)

    print(qcmetricb)
    qcmetricb = qcmetricb[0]
    print(qcmetricb)
    del qcmetricb[1]
    del qcmetricb[3]
    del qcmetricb[3]
    del qcmetricb[3]
    del qcmetricb[3]
    del qcmetricb[3]
    del qcmetricb[9]
    del qcmetricb[9]
    print(qcmetricb)
try:
    print(qcmetricc)
    qcmetricc.extend(library_prep)
except NameError:
    qcmetrica.extend(library_prep)
    print(qcmetrica)
    qcmetricb.extend(library_prep)
    print(qcmetricb)
