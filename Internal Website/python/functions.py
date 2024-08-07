import mysql.connector
import time
import csv
import re
from enum import Enum

# global variables
line_number = 1
clean_data = 0
commit_count = 0

# error counters
total_error_count = 0
duplicate_count = 0
missing_device_type = 0
missing_serial_number = 0
missing_Manufacturer = 0
empty_Entry = 0
offset_Entry = 0
additional_comma = 0
manufacturer_typo = 0
device_type_typo = 0

# Dictionarys to store serial numbers and manufacturers
duplicates = {}
manufacturers = {}
device_types = {}

class Manufacturers(Enum):
    Microsoft = 100
    Samsung = 101
    Google = 102
    LG = 103
    IBM = 104
    Nissan = 105
    Nokia = 106
    Panasonic = 107
    Apple = 108
    Hisense = 109
    OnePlus = 110
    TCL = 111
    Sony = 112
    KIA = 113
    HP = 114
    Hyundai = 115
    Ford = 116
    Huawei = 117
    Vizio = 118
    Chevorlet = 119
    GM = 120
    Toyota = 121
    Dell = 122
    Motorola = 123

class Devices(Enum):
    computer = 1
    laptop = 2
    smartwatch = 3
    vehicle = 4
    tablet = 5
    phone = 6
    television = 7


"""
Mechanic Functions
Functions to be used by the main program to perform specific setup or tracking tasks:

- load_serial_numbers_dictionary
- db_connect
- insert_Querry
- write_to_error_logs
- write_file_statistics
"""

#loads the serial numbers dictionary from the duplicates.txt file
#duplicates.txt contains rows from the dataset that share the same serial number
#duplicates.txt was obtained by running a separate program on a seperate machine to compile the serial numbers
def load_serial_numbers_dictionary():
    global duplicates
    fp = open('duplicates.txt', 'r')
    for line in fp:
        #add the serial number to the dictionary and set its value to false, will be set to true on the first occurance
        duplicates[line.strip()] = False
    fp.close()

#connects to the database and returns the connection
def db_connect(db):
    username = 'pyuser'
    pw = '.Ja-HatyUa7qW]aP'
    dblink = mysql.connector.connect(user=username, password=pw, database=db)
    return dblink

#takes a list of clean data and bulk inserts it into the serials table
def insert_Querry(data):
    cnx = db_connect('equipment')
    cursor = cnx.cursor(buffered=True)
    global commit_count

    try:
        query = "INSERT INTO serials (device_id, manufacturer_id, serial_number) VALUES (%s, %s, %s)"
        cursor.executemany(query, data)
        cnx.commit()
        commit_count += 1
        print('Commit ' + str(commit_count) + ' complete!')
    except mysql.connector.Error as err:
        print("Error: {}".format(err))
    
    cursor.close()
    cnx.close()

#writes the error to the error log files
def write_to_error_logs(error, line):
    global line_number

    #write to specific error log file depending on the error
    if error == 'Duplicate Serial Number':
        with open('logs/duplicate_log.txt', 'a') as file:
            file.write(str(line_number) + ': ' + line + '\n')
    elif error == 'Missing device type':
        with open('logs/missing_device_type_log.txt', 'a') as file:
            file.write(str(line_number) + ': ' + line + '\n')
    elif error == 'Missing Manufacturer':
        with open('logs/missing_manufacturer_log.txt', 'a') as file:
            file.write(str(line_number) + ': ' + line + '\n')
    elif error == 'Missing serial number':
        with open('logs/missing_serial_number_log.txt', 'a') as file:
            file.write(str(line_number) + ': ' + line + '\n')
    elif error == 'Empty Entry':
        with open('logs/empty_entry_log.txt', 'a') as file:
            file.write(str(line_number) + ': ' + line + '\n')
    elif error == 'Offset Entry':
        with open('logs/offset_entry_log.txt', 'a') as file:
            file.write(str(line_number) + ': ' + line + '\n')
    elif error == 'Additional comma':
        with open('logs/additional_comma_log.txt', 'a') as file:
            file.write(str(line_number) + ': ' + line + '\n')

    with open('logs/error_log.txt', 'a') as file:
        file.write(str(line_number) + ': ' + error + ':' + line + '\n')

#writes the file statistics to the file_statistics.txt file
def write_file_statistics(start, end): 
    global total_error_count, duplicate_count, missing_device_type, missing_serial_number, missing_Manufacturer, empty_Entry, offset_Entry, additional_comma, clean_data, manufacturer_typo, device_type_typo
    global duplicates, manufacturers, device_types

    #calculate the runtime of the program
    seconds = end - start
    execution_time = seconds/60
    rowsPerSecond = clean_data/seconds

    #print the device type statistics
    print('Device type statistics:')
    for key, value in device_types.items():
        print(key + ': ' + str(value))
    print('\n')

    #print the manufacturer statistics
    print('Manufacturer statistics:')
    for key, value in manufacturers.items():
        print(key + ': ' + str(value))
    print('\n')

    #print the error statistics
    print('Total errors: ' + str(total_error_count))
    print('Duplicate errors: ' + str(duplicate_count))
    print('Missing device type errors: ' + str(missing_device_type))
    print('Missing serial number errors: ' + str(missing_serial_number))
    print('Missing Manufacturer errors: ' + str(missing_Manufacturer))
    print('Empty Entry errors: ' + str(empty_Entry))
    print('Offset Entry errors: ' + str(offset_Entry))
    print('Additional comma errors: ' + str(additional_comma))
    print('Manufacturer typos: ' + str(manufacturer_typo))
    print('Device type typos: ' + str(device_type_typo) + '\n')

    #print the runtime statistics
    print('Program execution time: ' + str(execution_time) + ' minutes or ' + str(seconds) + ' seconds')
    print('Insert Rate: ' + str(rowsPerSecond) + ' rows per second\n')

    print('Clean data: ' + str(clean_data))    

    #write the statistics to the file_statistics.txt file
    with open('logs/file_statistics.txt', 'w') as file:
        #device type statistics
        file.write('Device type statistics:\n')
        for key, value in device_types.items():
            file.write(key + ': ' + str(value) + '\n')
        
        #Manufacturer statistics
        file.write('Manufacturer statistics:\n')
        for key, value in manufacturers.items():
            file.write(key + ': ' + str(value) + '\n')
        file.write('\n')

        #Error statistics
        file.write('Total errors: ' + str(total_error_count) + '\n')
        file.write('Duplicate errors: ' + str(duplicate_count) + '\n')
        file.write('Missing device type errors: ' + str(missing_device_type) + '\n')
        file.write('Missing serial number errors: ' + str(missing_serial_number) + '\n')
        file.write('Missing Manufacturer errors: ' + str(missing_Manufacturer) + '\n')
        file.write('Empty Entry errors: ' + str(empty_Entry) + '\n')
        file.write('Offset Entry errors: ' + str(offset_Entry) + '\n')
        file.write('Additional comma errors: ' + str(additional_comma) + '\n')
        file.write('Manufacturer typos: ' + str(manufacturer_typo) + '\n')
        file.write('Device type typos: ' + str(device_type_typo) + '\n\n')

        #Runtime statistics
        file.write('Program execution time: ' + str(execution_time) + ' minutes or ' + str(seconds) + ' seconds\n')
        file.write('Insert Rate: ' + str(rowsPerSecond) + ' rows per second\n\n')

        file.write('Clean data: ' + str(clean_data) + '\n')

"""
Data Processing Functions:
Functions to be used by the main program to process the data:

- serial_number_check
- manufacturer_tracking
- detect_Manufacturer
- data_check
- process_data_in_chunks
"""
#checks the serial number dictionary to see if the serial number is already in the dictionary
def serial_number_check(serial_number):
    global duplicates

    #check if the serial number is in the dictionary then checks to see if it is the first occurance of the serial number
    if serial_number in duplicates:
        if not duplicates[serial_number]:
            duplicates[serial_number] = True
            return True
        else:
            return False
    else:
        return True

#tracks the manufacturer of the device
def manufacturer_tracking(manufacturer):
    global manufacturers

    if manufacturer in manufacturers:
        manufacturers[manufacturer] += 1
    else:
        manufacturers[manufacturer] = 1

#tracks the amount of each device type
def device_type_tracking(device_type):
    global device_types

    if device_type in device_types:
        device_types[device_type] += 1
    else:
        device_types[device_type] = 1

#checks the device type for typos and removes the last character if it is a typo
#adds the device type to the devices table if it is not already in the table
#returns the auto_id of the device type from the devices table
def check_device_type(device_type):
    cnx = db_connect('equipment')
    cursor = cnx.cursor(buffered=True)
    auto_id = None
    global device_types, device_type_typo
    pattern = r"\w+'$"
    selectQuery = "SELECT auto_id FROM devices WHERE name = %s"
    insertQuery = "INSERT INTO devices (name) VALUES (%s)"

    #clean the device type if it is a typo
    if re.search(pattern, device_type):
        device_type_typo += 1
        device_type = device_type[:-1]
    
    device_type_tracking(device_type)


    #check if the device type is in the devices table

    try:
        cursor.execute(selectQuery, (device_type,))
        result = cursor.fetchone()
        #if the device type is in the table then return the auto_id
        if result:
            auto_id = result[0]
        #if the device type is not in the table then add it to the table
        else:
            cursor.execute(insertQuery, (device_type,))
            cnx.commit()
            auto_id = cursor.lastrowid
    except:
        print('Error: {}'.format(err))

    cursor.close()
    cnx.close()

    return auto_id

def check_device_type_enum(device_type):
    pattern = r"\w+'$"

    if re.search(pattern, device_type):
        device_type = device_type[:-1]

    if device_type == 'computer':
        return Devices.computer.value
    elif device_type == 'laptop':
        return Devices.laptop.value
    elif device_type == 'smart watch':
        return Devices.smartwatch.value
    elif device_type == 'vehicle':
        return Devices.vehicle.value
    elif device_type == 'tablet':
        return Devices.tablet.value
    elif device_type == 'mobile phone':
        return Devices.phone.value
    elif device_type == 'television':
        return Devices.television.value

def check_manufacturer_enum(manufacturer):
    pattern = r"\w+'$"

    if re.search(pattern, manufacturer):
        manufacturer = manufacturer[:-1]

    if manufacturer == 'Microsoft':
        return Manufacturers.Microsoft.value
    elif manufacturer == 'Samsung':
        return Manufacturers.Samsung.value
    elif manufacturer == 'Google':
        return Manufacturers.Google.value
    elif manufacturer == 'LG':
        return Manufacturers.LG.value
    elif manufacturer == 'IBM':
        return Manufacturers.IBM.value
    elif manufacturer == 'Nissan':
        return Manufacturers.Nissan.value
    elif manufacturer == 'Nokia':
        return Manufacturers.Nokia.value
    elif manufacturer == 'Panasonic':
        return Manufacturers.Panasonic.value
    elif manufacturer == 'Apple':
        return Manufacturers.Apple.value
    elif manufacturer == 'Hisense':
        return Manufacturers.Hisense.value
    elif manufacturer == 'OnePlus':
        return Manufacturers.OnePlus.value
    elif manufacturer == 'TCL':
        return Manufacturers.TCL.value
    elif manufacturer == 'Sony':
        return Manufacturers.Sony.value
    elif manufacturer == 'KIA':
        return Manufacturers.KIA.value
    elif manufacturer == 'HP':
        return Manufacturers.HP.value
    elif manufacturer == 'Hyundai':
        return Manufacturers.Hyundai.value
    elif manufacturer == 'Ford':
        return Manufacturers.Ford.value
    elif manufacturer == 'Huawei':
        return Manufacturers.Huawei.value
    elif manufacturer == 'Vizio':
        return Manufacturers.Vizio.value
    elif manufacturer == 'Chevorlet':
        return Manufacturers.Chevorlet.value
    elif manufacturer == 'GM':
        return Manufacturers.GM.value
    elif manufacturer == 'Toyota':
        return Manufacturers.Toyota.value
    elif manufacturer == 'Dell':
        return Manufacturers.Dell.value
    elif manufacturer == 'Motorola':
        return Manufacturers.Motorola.value

#checks the manufacturer for typos and removes the last character if it is a typo
#adds the manufacturer to the manufacturers table if it is not already in the table
#returns the auto_id of the manufacturer from the manufacturers table
def check_manufacturer(manufacturer):
    cnx = db_connect('equipment')
    cursor = cnx.cursor(buffered=True)
    auto_id = None
    global manufacturers, manufacturer_typo
    pattern = r"\w+'$"
    selectQuery = "SELECT auto_id FROM manufacturers WHERE name = %s"
    insertQuery = "INSERT INTO manufacturers (name) VALUES (%s)"

    #clean the manufacturer if it is a typo
    if re.search(pattern, manufacturer):
        manufacturer_typo += 1
        manufacturer = manufacturer[:-1]

    manufacturer_tracking(manufacturer)

    #check if the manufacturer is in the manufacturers table
    try:
        cursor.execute(selectQuery, (manufacturer,))
        result = cursor.fetchone()
        #if the manufacturer is in the table then return the auto_id
        if result:
            auto_id = result[0]
        #if the manufacturer is not in the table then add it to the table
        else:
            cursor.execute(insertQuery, (manufacturer,))
            cnx.commit()
            auto_id = cursor.lastrowid
    except:
        print('Error: {}'.format(err))
    
    cursor.close()
    cnx.close()

    return auto_id

#checks the data for errors and returns true if the data is clean and false if it is not
def data_check(data, line):
    global total_error_count, missing_device_type, missing_Manufacturer, missing_serial_number, empty_Entry, offset_Entry, clean_data, duplicate_count, additional_comma

    #if the length of the data is 4 then it is one of the following errors
    if len(data) == 4:
        #if all the entries are empty then it is an empty entry error
        if not data[0] and not data[1] and not data[2] and not data[3]:
            empty_Entry += 1
            total_error_count += 1
            write_to_error_logs('Empty Entry', line)
        #if the first entry is empty and the rest are not then it is an offset entry error
        elif not data[0] and data[1] and data[2] and data[3]:
            offset_Entry += 1
            total_error_count += 1
            write_to_error_logs('Offset Entry', line)
        #if the last entry is empty and the rest are not then it is an additional comma error
        else:
            additional_comma += 1
            total_error_count += 1
            write_to_error_logs('Additional comma', line)
        return False
    #if any of the three entries are empty then it is one of the following errors
    elif not data[0] or not data[1] or not data[2]:
        #if device type is empty then it is a missing device type error
        if not data[0]:
            missing_device_type += 1
            total_error_count += 1
            write_to_error_logs('Missing device type', line)
        #if manufacturer is empty then it is a missing manufacturer error
        elif not data[1]:
            missing_Manufacturer += 1
            total_error_count += 1
            write_to_error_logs('Missing Manufacturer', line)
        #if serial number is empty then it is a missing serial number error
        elif not data[2]:
            missing_serial_number += 1
            total_error_count += 1
            write_to_error_logs('Missing serial number', line)
        return False
    #if the serial number is already in the dictionary then it is a duplicate error
    elif not serial_number_check(data[2]):
        duplicate_count += 1
        total_error_count += 1
        write_to_error_logs('Duplicate Serial Number', line)
        return False
    #if none of the above errors are present then the data is clean
    else:
        return True    

#generator function to read the file in 10000 line chunks
def process_data_in_chunks(file_path, chunk_size):
    with open(file_path, 'r') as file:
        csv_reader = csv.reader(file)
        chunk = []
        for i , row in enumerate(csv_reader):
            chunk.append(row)
            if i > 0 and i % chunk_size == 0:
                yield chunk
                chunk = []
        if chunk:
            yield chunk

"""
Technicaly the main function of the program
Gets called by mysql_insert.py:

- process_part
"""
def process_part(path):
    global clean_data, line_number
    insert_data = []

    chunk_size = 10000

    time_start = time.time()

    print('Processing ' + path + '...')

    for chunk in process_data_in_chunks(path, chunk_size):
        for line in chunk:
            #check the data for errors
            if data_check(line, ','.join(line)):
                #if the data is clean then add it to the clean data list\
                line[0] = check_device_type_enum(line[0])
                line[1] = check_manufacturer_enum(line[1])
                print(line)
                insert_data.append((line[0], line[1], line[2]))
                clean_data += 1
            line_number += 1
        #insert the clean data into the database
        insert_Querry(insert_data)
        insert_data = []
        chunk = None

    print('Finished processing ' + path + '!')

    time_end = time.time()
    
    write_file_statistics(time_start, time_end)
