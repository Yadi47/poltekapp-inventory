#!C:\Python27\python.exe
import OpenOPC
import pywintypes
import datetime, threading, time
pywintypes.datetime = pywintypes.TimeType


print('connection established')
opc = OpenOPC.client()

opc.connect('Matrikon.OPC.Simulation.1')
tags = [
'TS-01.T301.Tank Name',
'TS-01.T301.Product Name',
'TS-01.T301.Product Level',
'TS-01.T301.Product Temperature',
'TS-01.T301.Observed Density',
'TS-01.T301.Total Observed Volume',
'TS-01.T301.Product Mass',
'TS-01.T301.Free Water Level',

'TS-01.T302.Tank Name',
'TS-01.T302.Product Name',
'TS-01.T302.Product Level',
'TS-01.T302.Product Temperature',
'TS-01.T302.Observed Density',
'TS-01.T302.Total Observed Volume',
'TS-01.T302.Product Mass',
'TS-01.T302.Free Water Level',


'TS-01.T303.Tank Name',
'TS-01.T303.Product Name',
'TS-01.T303.Product Level',
'TS-01.T303.Product Temperature',
'TS-01.T303.Observed Density',
'TS-01.T303.Total Observed Volume',
'TS-01.T303.Product Mass',
'TS-01.T303.Free Water Level',

'TS-01.T304.Tank Name',
'TS-01.T304.Product Name',
'TS-01.T304.Product Level',
'TS-01.T304.Product Temperature',
'TS-01.T304.Observed Density',
'TS-01.T304.Total Observed Volume',
'TS-01.T304.Product Mass',
'TS-01.T304.Free Water Level',

]

    # tags = opc.list('TS-01.Devie')
# print(tags)
while True:
    try:
        value = opc.read(tags,group='GROUP1',update=1)
        print (value)
        print('\n\n')
    except OpenOPC.TimeoutError:
        print ("TimeoutError occured")
    time.sleep(2)
     
