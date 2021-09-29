# Importing the modules
import threading
import sys

#!C:\Python27\python.exe
import OpenOPC
import pywintypes


import datetime, time
pywintypes.datetime = pywintypes.TimeType

import socketio
sio = socketio.Client()


  
# Custom Thread Class
class MyThread(threading.Thread):
    

    @sio.event
    def connect():
        print('connection established')
        # opc = OpenOPC.client()
        # opc.connect('Matrikon.OPC.Simulation.1')
    @sio.on('getTags')
    def on_message():
        print("getting tags")
        opc = OpenOPC.client()
        opc.connect('Matrikon.OPC.Simulation.1')
        sio.emit('toServerTags', opc.list())
        
    @sio.on('getServers')
    def on_message():
        print("getting servers")
        opc = OpenOPC.client()
        sio.emit('toServerServers', opc.servers())

    @sio.on('getRealtimeValues')
    def on_message(data,datetime):
        # function
        def extractValue1(x,y):
            if x[0] == y['TagAddress']:
                if y['StaticValue'] < 0:
                    return {
                        "TagName":y['TagName'],
                        "TagAddress":x[0],
                        "TagColumn":y['ColumnName'],
                        "TagValue":datetime,
                        "TagStatusRead":"Good",
                        "TagTstampOpc":x[3],
                    }
                else:
                    return {
                        "TagName":y['TagName'],
                        "TagAddress":x[0],
                        "TagColumn":y['ColumnName'],
                        "TagValue":x[1],
                        "TagStatusRead":x[2],
                        "TagTstampOpc":x[3],
                    }
            else:
                return {
                    "TagName":y['TagName'],
                    "TagAddress":y['TagAddress'],
                    "TagColumn":y['ColumnName'],
                    "TagValue":y['StaticValue'],
                    "TagStatusRead":"Good",
                    "TagTstampOpc":'null',
                }

        # functin
        def readtag(n):
            if n['StaticValue'] <= 0:
                return n['TagAddress']
            return ''
        def readOPC(x,datetime):
            print("getting realtime value")
            tagGroup = {
                "TagGroupId":x['id'],
                "TagGroupName":x['TagGroupName'],
                "tagGroupServer":x['TagGroupServer'],
                "tagTableName":x['TagTableName'],
                "tags":[],
                "values":[]
            }

            tags = x['tags']
            tagReads = list(map(readtag,tags))
            opc = OpenOPC.client()
            opc.connect(x['TagGroupServer'])
            try:
                values = opc.read(tagReads)
                extractValues = list(map(extractValue1,values,tags))
                tagGroup['tags'] = tags
                tagGroup['values'] = extractValues

                sio.emit('toServerFromOpcRealtime', tagGroup)
            except OpenOPC.TimeoutError:
                print ("Timeout Error occured")
        threads = []
        for x in data:
                readOPC(x,datetime)
                # t = threading.Thread(target=readOPC, args=(x,datetime))
                # threads.append(t)
                # t.join()

    @sio.on('getScheduledValues')
    def on_message(data,datetime):
        # function
        def extractValue1(x,y):
            if x[0] == y['TagAddress']:
                if y['StaticValue'] < 0:
                    return {
                        "TagName":y['TagName'],
                        "TagAddress":x[0],
                        "TagColumn":y['ColumnName'],
                        "TagValue":datetime,
                        "TagStatusRead":"Good",
                        "TagTstampOpc":x[3],
                    }
                else:
                    return {
                        "TagName":y['TagName'],
                        "TagAddress":x[0],
                        "TagColumn":y['ColumnName'],
                        "TagValue":x[1],
                        "TagStatusRead":x[2],
                        "TagTstampOpc":x[3],
                    }
            else:
                return {
                    "TagName":y['TagName'],
                    "TagAddress":y['TagAddress'],
                    "TagColumn":y['ColumnName'],
                    "TagValue":y['StaticValue'],
                    "TagStatusRead":"Good",
                    "TagTstampOpc":'null',
                }

        # functin
        def readtag(n):
            if n['StaticValue'] <= 0:
                return n['TagAddress']
            return ''
        def readOPC(x,datetime):
            print(datetime+" : getting schedule values")
            tagGroup = {
                "TagGroupId":x['id'],
                "TagGroupName":x['TagGroupName'],
                "tagGroupServer":x['TagGroupServer'],
                "tagTableName":x['TagTableName'],
                "tags":[],
                "values":[]
            }

            tags = x['tags']
            tagReads = list(map(readtag,tags))
            opc = OpenOPC.client()
            opc.connect(x['TagGroupServer'])
            try:
                values = opc.read(tagReads)
                # print(values)
                # print('\n')
                extractValues = list(map(extractValue1,values,tags))
                tagGroup['tags'] = tags
                tagGroup['values'] = extractValues
                sio.emit('toServerScheduledValuesResult', tagGroup)
            except OpenOPC.TimeoutError:
                print ("Timeout Error occured")
        threads = []
        for x in data:
                readOPC(x,datetime)
                # t = threading.Thread(target=readOPC, args=(x,datetime))
                # threads.append(t)
                # t.join()
        

        

    @sio.on('getValues')
    def on_message(data):
        def readtag(n):
            if n['StaticValue'] <= 0:
                return n['TagAddress']
            return ''

        def extractValue(x,y):
            if x[0] == y['TagAddress']:
                return {
                    "TagName":y['TagName'],
                    "TagAddress":x[0],
                    "TagColumn":y['ColumnName'],
                    "TagValue":x[1],
                    "TagStatusRead":x[2],
                    "TagTstampOpc":x[3],
                }
            else:
                return {
                    "TagName":y['TagName'],
                    "TagAddress":y['TagAddress'],
                    "TagColumn":y['ColumnName'],
                    "TagValue":y['StaticValue'],
                    "TagStatusRead":"Good",
                    "TagTstampOpc":'null',
                }
        print("getting values")
        tagGroup = {
            "TagGroupId":data['id'],
            "TagGroupName":data['TagGroupName'],
            "tagGroupServer":data['TagGroupServer'],
            "tagTableName":data['TagTableName'],
            "tags":[],
            "values":[]
        }

        tags = data['tags']
        tagReads = list(map(readtag,tags))

        opc = OpenOPC.client()
        opc.connect(data['TagGroupServer'])

        try:
            values = opc.read(tagReads,group='GROUP1',update=1)
            extractValues = list(map(extractValue,values,tags))
            tagGroup['tags'] = tags
            tagGroup['values'] = extractValues
            sio.emit('toServerValues', tagGroup)
            return "true"
        except OpenOPC.TimeoutError:
            print ("TimeoutError occured")
    sio.connect('http://localhost:8010')
    sio.wait()


# Driver function
def main():
    t = MyThread()
    t.start()
    t.join()
  
# Driver code
if __name__ == '__main__':
    main()