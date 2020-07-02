import mysql.connector
import codecs
from codecs import open
from mysql.connector import Error
import re
##Making connection to the server
cnx=mysql.connector.connect(user="project",
    password="Mol#biol2",
    host = "127.0.0.1",
    )
cursor=cnx.cursor()
sql_file = "database_NIPT.sql"

def exec_sql_file(cursor, sql_file):
    print ("\[INFO] Processing SQL file: '%s' "% (sql_file))
    statement = ""

    for line in open(sql_file):
        if re.match(r'--', line):
            continue
        if not re.search(r';$', line):
            statement = statement + line
        else:
            statement = statement + line
            #print "\n\n[DEBUG] Executing SQL statement:\n%s" % (statement)
            try:
                cursor.execute(statement) 
            except (Error) as e:
                print("\n[WARN] MySQLError during execute statement \n\tArgs: '%s'" % (str(e.args)))
            
            statement = ""

exec_sql_file(cursor, sql_file)
cnx.close()