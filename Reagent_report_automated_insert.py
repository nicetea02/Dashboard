import os
import sys
import fnmatch
import csv
import mysql.connector
###Connection with mysql db
cnx=mysql.connector.connect(user="project",
    password="Mol#biol2",
    host = "127.0.0.1",
    database = "nipt",
    )
###Get all already inserted foldernames out of the mysql db
cur = cnx.cursor()
result_mysql = cur.execute("SELECT folder_name FROM reagent_report")
my_result = list(cur.fetchall())
print(my_result)
my_list = [row[0] for row in my_result]
print(my_list)
###Get list of folders out of NIPT_output directory
nipt_output = "C:\\Users\\jens_\\Desktop\\Bioinformatica\\Project\\NIPT_Output"
os.chdir(nipt_output)
folder_list = os.listdir(nipt_output)
print(folder_list)
###Compare folder names present in MySQL DB and folders in NIPT_Output to create a list of the 
###folders present in the NIPT_output but not yet in MySQL db
diff_list = []
for item in folder_list:
    if item not in my_list:
        diff_list.append(item)
print(diff_list)

###Navigating in each folder of the previous generated list to get data and write to the mysql db
for folder in diff_list:
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