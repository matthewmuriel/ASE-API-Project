import os

if __name__ == '__main__':
    directory = '/home/ubuntu/parts/'
    files = os.listdir(directory)
    for file in files:
        os.system('python3 mysql_insert.py ' + file)
        print("Finished Processing: " + file + "\n")
        