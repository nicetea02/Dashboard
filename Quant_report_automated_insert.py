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
###Connection with mysql db and creating list of present folder names
cur = cnx.cursor()
result_mysql = cur.execute("SELECT folder_name FROM reagent_report")
my_result = list(cur.fetchall())
print(my_result)
my_list_reagent = [row[0] for row in my_result]
print(my_list_reagent)

cur = cnx.cursor()
result_mysql = cur.execute("SELECT folder_name FROM quant_report")
my_result = list(cur.fetchall())
print(my_result)
my_list_quant = [row[0] for row in my_result]
print(my_list_quant)

nipt_output = "C:\\Users\\jens_\\Desktop\\Bioinformatica\\Project\\NIPT_Output"
os.chdir(nipt_output)
###Comparing the folder names present in the quant_report table and reagent_report table.
###Knowing which folders are not present will enable us to insert the correct data.
diff_list = []
for item in my_list_reagent:
    if item not in my_list_quant:
        diff_list.append(item)
print(diff_list)
###Use the info of the present folder names to gather data out of the correct files
###and insert it into 
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
        if fnmatch.fnmatch(file, '*library_quant_report*.tab'):
            print(file)
            quant = file
    print(quant)
    parameter = []
    with open (quant, 'r') as f:
        next(f)
        reader = csv.reader(f, delimiter='\t')
        for parameter in reader:
            parameter.append(parameter)
    print(parameter)
    list_quant = []
    index_list = [0, 3, 5, 0]
    index = 0
    for i in index_list:
        list_quant.append(parameter[index_list[index]])
        index = index + 1
    print(list_quant)


    import mysql.connector
    cnx=mysql.connector.connect(user="project",
        password="Mol#biol2",
        host = "127.0.0.1",
        database = "nipt",
        )

    cursor=cnx.cursor()

    sql = """INSERT INTO quant_report (batch_name, std_rsquared, std_slope, folder_name) VALUES (%s, %s, %s, %s)"""
    val = (list_quant[0], list_quant[1], list_quant[2], list_quant[3])
    cursor.execute(sql, val)

    cnx.commit()

    print(cursor.rowcount, "record inserted.")