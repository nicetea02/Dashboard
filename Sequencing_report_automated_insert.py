import os
import sys
import fnmatch
import csv
import mysql.connector
cnx=mysql.connector.connect(user="project",
    password="Mol#biol2",
    host = "127.0.0.1",
    database = "nipt",
    )
###Connection with MySQL db and getting previous entered foldernames out of db
cur = cnx.cursor()
result_mysql = cur.execute("SELECT foldername FROM sequencing_report")
my_result = list(cur.fetchall())
print(my_result)
my_list = [row[0] for row in my_result]
print(my_list)

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
###Gathering data out of file locations and inserting in the correct db table
for folder in diff_list:
    nipt = "C:\\Users\\jens_\\Desktop\\Bioinformatica\\Project\\NIPT_Output\\{}".format(folder)
    print(nipt)
    nipt_seq_report = os.path.join(nipt, "ProcessLogs")
    print(os.getcwd())
    os.chdir(nipt_seq_report)
    file_list = []
    for file in os.listdir("."):
        if fnmatch.fnmatch(file, '*sequencing_report*.tab'):
            print(file)
            file_list.append(file)
    print(file_list)
    for file in file_list:
        sequencing = []
        with open (file, 'r') as f:
            next(f)
            reader = csv.reader(f, delimiter='\t')
            for parameter in reader:
                sequencing.append(parameter)
        print(sequencing)
        sequencing = sequencing[0]
        print(sequencing)
        list_seq = []
        index_list = [0, 1, 2, 3, 9, 10, 12, 13, 0]
        index = 0
        for i in index_list:
            list_seq.append(sequencing[index_list[index]])
            index = index + 1
            print(list_seq)


    import mysql.connector
    cnx=mysql.connector.connect(user="project",
        password="Mol#biol2",
        host = "127.0.0.1",
        database = "nipt",
        )

    cursor=cnx.cursor()
    try:
        sql = """INSERT INTO sequencing_report (batch_name, pool_barcode, instrument, flowcell_serial, cluster_density, Q30, phasing, prephasing, foldername) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)"""
        val = (list_seq[0], list_seq[1], list_seq[2], list_seq[3], list_seq[4], list_seq[5], list_seq[6], list_seq[7], list_seq[8])
        cursor.execute(sql, val)
        
        cnx.commit()

        print(cursor.rowcount, "record inserted.")
    except:
        print("Record already present, skipping to next")

