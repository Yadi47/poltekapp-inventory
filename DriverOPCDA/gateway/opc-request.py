#!C:\Python27\python.exe
import OpenOPC
import pywintypes
import datetime, threading, time
pywintypes.datetime = pywintypes.TimeType


print('connection established')
opc = OpenOPC.client()


# print(opc.servers())


opc.connect("Matrikon.OPC.Simulation.1")
print(opc.list('Configured Aliases'))
tags = [
'GROUP_1.tagku',
]
# value = opc.read(['GROUP_1.TAGINIT'])
def my_function():
    while True:
        try:
            opc.read(tags,group='TEST',update=1)
            value = opc.read(group='TEST')
            print (value)
        except OpenOPC.TimeoutError:
            print ("TimeoutError occured")
        time.sleep(1)

my_function()
  
       
