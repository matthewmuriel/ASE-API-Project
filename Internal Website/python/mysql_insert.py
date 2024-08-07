from functions import *
import os

parts = os.listdir('/home/ubuntu/final/')
path = '/home/ubuntu/final/'

load_serial_numbers_dictionary()

#create error log directory if it doesn't exist
if not os.path.exists('logs'):
    os.makedirs('logs')

for file in parts:
    process_part(path + file)

