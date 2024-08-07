from functions import *
#connect to the database and truncate it
cnx = db_connect('test')
cursor = cnx.cursor()

cursor.execute("TRUNCATE TABLE `devices`")
cnx.commit()
cnx.close()
