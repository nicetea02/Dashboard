import os
import sys
import fnmatch
import csv

nipt_output = "C:\\Users\\jens_\\Desktop\\Bioinformatica\\Project\\NIPT_Output"
os.chdir(nipt_output)

###Getting the latest added folder in a directory, adding it to path and navigating to it
all_subdirs = [d for d in os.listdir('.') if os.path.isdir(d)]
latest_subdir = max(all_subdirs, key=os.path.getmtime)
print(all_subdirs)
print(latest_subdir)
for folder in all_subdirs:
    path = os.path.join(nipt_output, folder)
    print(path)
    os.chdir(path)
    files = os.listdir(path)
    print(files)

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
    list_reag = []
    index_list = [0, 3, 0]
    index = 0
    for i in index_list:
        list_reag.append(lotnumber[index_list[index]])
        index = index + 1
    print(list_reag)

    import mysql.connector
    cnx=mysql.connector.connect(user="project",
        password="Mol#biol2",
        host = "127.0.0.1",
        database = "nipt",
        )

    cursor=cnx.cursor()

    sql = """INSERT INTO reagent_report (batch_name, lotnumber_veriseq, folder_name) VALUES (%s, %s, %s)"""
    val = (list_reag[0], list_reag[1], list_reag[2])
    cursor.execute(sql, val)

    cnx.commit()

    print(cursor.rowcount, "record inserted.")