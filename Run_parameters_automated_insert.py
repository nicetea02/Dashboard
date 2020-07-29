import os
import sys
import fnmatch
import xml.etree.ElementTree as ET
import glob

nipt_input = "C:\\Users\\jens_\\Desktop\\Bioinformatica\\Project\\NIPT_Input"
os.chdir(nipt_input)
###Connection with mysql db
import mysql.connector
cnx=mysql.connector.connect(user="project",
    password="Mol#biol2",
    host = "127.0.0.1",
    database = "nipt",
    )
###Get all already inserted flowcell_serials out of the mysql db
cur = cnx.cursor()
result_mysql = cur.execute("SELECT flowcell_serial FROM run_parameters")
my_result = list(cur.fetchall())
print(my_result)
my_list = [row[0] for row in my_result]
print(my_list)
###Get list of folders out of NIPT_output directory
nipt_input = "C:\\Users\\jens_\\Desktop\\Bioinformatica\\Project\\NIPT_Input"
os.chdir(nipt_input)
folder_list = os.listdir(nipt_input)
flowcell_list = []
for i in folder_list:
    serial = i[-9:]
    flowcell_list.append(serial)
print(flowcell_list)
###Compare flowcell serials present in MySQL DB and serials in NIPT_Input to create a list of the 
###serials present in the NIPT_output but not yet in MySQL db
diff_list = []
for item in flowcell_list:
    if item not in my_list:
        diff_list.append(item)
print(diff_list)
###Navigating in each folder of the previous generated list to get data and write to the mysql db
for flowcell in diff_list:
    try:
        folder = glob.glob("C:\\Users\\jens_\\Desktop\\Bioinformatica\\Project\\NIPT_Input\\*{}".format(flowcell))
        print(folder)
        os.chdir(folder[0])
        tree = ET.parse("RunParameters.xml")
        root = tree.getroot()
        for child in root:
            print(child.tag, child.attrib)
        print(root[11][2].text)
        seq = root[4].text
        lotFC = root[11][2].text
        lotNS = root[12][2].text
        FCserial = root[11][0].text
        Exp_name = root[18].text
        folder_name = os.path.basename(nipt_input)
        NSlist = [lotNS, lotFC, FCserial, seq, Exp_name, folder_name]
        print(NSlist)

        import mysql.connector
        cnx=mysql.connector.connect(user="project",
            password="Mol#biol2",
            host = "127.0.0.1",
            database = "nipt",
            )

        cursor=cnx.cursor()

        sql = """INSERT INTO run_parameters (lot_nsreagens, lot_flowcell, flowcell_serial, instrument, experiment_name, foldername) VALUES (%s, %s, %s, %s, %s, %s)"""
        val = (NSlist[0], NSlist[1], NSlist[2], NSlist[3], NSlist[4], NSlist[5])
        cursor.execute(sql, val)

        cnx.commit()

        print(cursor.rowcount, "record inserted.")
    except EOFError:
        print("File not found")