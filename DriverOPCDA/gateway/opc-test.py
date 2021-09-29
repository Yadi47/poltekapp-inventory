#!C:\Python27\python.exe
import OpenOPC
import pywintypes
import threading, time,requests,json,os,sys
pywintypes.datetime = pywintypes.TimeType
from datetime import datetime
import threading
import os

# print('connection established')
# opc = OpenOPC.client()
# connection = {}
# connection['simulation1'] = opc
# connection['simulation1'].connect('Matrikon.OPC.Simulation.1')
# connection['simulation2'] = opc
# connection['simulation2'].connect('Matrikon.OPC.Simulation.1')
# tags = [
# 'TS-01.T301.Tank Name',
# 'TS-01.T301.Product Name',
# 'TS-01.T301.Product Level',
# 'TS-01.T301.Product Temperature',
# 'TS-01.T301.Observed Density',
# 'TS-01.T301.Total Observed Volume',
# 'TS-01.T301.Product Mass',
# 'TS-01.T301.Free Water Level',

# # 'TS-01.T302.Tank Name',
# # 'TS-01.T302.Product Name',
# # 'TS-01.T302.Product Level',
# # 'TS-01.T302.Product Temperature',
# # 'TS-01.T302.Observed Density',
# # 'TS-01.T302.Total Observed Volume',
# # 'TS-01.T302.Product Mass',
# # 'TS-01.T302.Free Water Level',


# # 'TS-01.T303.Tank Name',
# # 'TS-01.T303.Product Name',
# # 'TS-01.T303.Product Level',
# # 'TS-01.T303.Product Temperature',
# # 'TS-01.T303.Observed Density',
# # 'TS-01.T303.Total Observed Volume',
# # 'TS-01.T303.Product Mass',
# # 'TS-01.T303.Free Water Level',

# # 'TS-01.T304.Tank Name',
# # 'TS-01.T304.Product Name',
# # 'TS-01.T304.Product Level',
# # 'TS-01.T304.Product Temperature',
# # 'TS-01.T304.Observed Density',
# # 'TS-01.T304.Total Observed Volume',
# # 'TS-01.T304.Product Mass',
# # 'TS-01.T304.Free Water Level',

# ]

# tags2 = [
#     'TS-01.T302.Tank Name',
#     'TS-01.T302.Product Name',
#     'TS-01.T302.Product Level',
#     'TS-01.T302.Product Temperature',
#     'TS-01.T302.Observed Density',
#     'TS-01.T302.Total Observed Volume',
#     'TS-01.T302.Product Mass',
#     'TS-01.T302.Free Water Level',
# ]

#     # tags = opc.list('TS-01.Devie')
# # print(tags)
# connection['simulation1'].read(tags,group='simulation1')
# url = "http://localhost:8010/gateway-values"

# def extractValue1(x):
#     return {
#         "TagName":x[0],
#         "TagAddress":x[0],
#         "TagValue":x[1],
#         "TagStatusRead":x[2],
#         "TagTstampOpc":x[3]
#     }
# while True:
#     try:
#         value1 = connection['simulation1'].read(group='simulation1')
#         # data to be sent to api
#         value1 = list(map(extractValue1,value1))
        
#         payload={'values':json.dumps(value1)}
#         headers = {}
#         print(payload)
#         try:
#             response = requests.request("POST", url, headers=headers, data=payload)
#             print(response.text)
#         except:
#             print("An exception occurred")

#         print('\n\n')
#     except OpenOPC.TimeoutError:
#         print ("TimeoutError occured")
#     time.sleep(1)
     
import socketio
sio = socketio.Client()

opc = OpenOPC.client()
url = "http://localhost:8010"

tagGroups = [
    {
        'server':'Matrikon.OPC.Simulation.1',
        'servername':'simulation1',
        'tags':[
            'TS-01.T301.Tank Name',
            'TS-01.T301.Product Name',
            'TS-01.T301.Product Level',
            'TS-01.T301.Product Temperature',
            'TS-01.T301.Observed Density',
            'TS-01.T301.Total Observed Volume',
            'TS-01.T301.Product Mass',
            'TS-01.T301.Free Water Level'
        ]
    },
    {
        'server':'Matrikon.OPC.Simulation.1',
        'servername':'simulation2',
        'tags':[
            'TS-01.T302.Tank Name',
            'TS-01.T302.Product Name',
            'TS-01.T302.Product Level',
            'TS-01.T302.Product Temperature',
            'TS-01.T302.Observed Density',
            'TS-01.T302.Total Observed Volume',
            'TS-01.T302.Product Mass',
            'TS-01.T302.Free Water Level'
        ]
    }
]



def readtag(n):
    # if n['StaticValue'] <= 0:
        # return n['TagAddress']
    return n['TagAddress']

def extractValue1(x,y):
    dttime = datetime.today().strftime('%Y-%m-%d %H:%M:%S')
    if x[0] == y['TagAddress']:
        if y['StaticValue'] < 0:
            return {
                "TagName":y['TagName'],
                "TagAddress":x[0],
                "TagColumn":y['ColumnName'],
                "TagValue":dttime,
                "TagValue":dttime,
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
def assignValue(tag,y,dttime):
    for val in y:
        if tag['TagAddress'] == val[0]:
            if tag['StaticValue'] < 0:
                value = {
                    "TagName":tag['TagName'],
                    "TagAddress":val[0],
                    "TagColumn":tag['ColumnName'],
                    "TagValue":dttime,
                    "TagStaticValue":tag['StaticValue'],
                    "TagStatus":tag['Status'],
                    "TagStatusRead":"Good",
                    "TagTstampOpc":val[3],
                }
            elif tag['StaticValue'] > 0:
                value = {
                    "TagName":tag['TagName'],
                    "TagAddress":val[0],
                    "TagColumn":tag['ColumnName'],
                    "TagValue":tag['StaticValue'],
                    "TagStaticValue":tag['StaticValue'],
                    "TagStatus":tag['Status'],
                    "TagStatusRead":"Good",
                    "TagTstampOpc":val[3],
                }
            else:
                value =  {
                    "TagName":tag['TagName'],
                    "TagAddress":val[0],
                    "TagColumn":tag['ColumnName'],
                    "TagValue":val[1],
                    "TagStaticValue":tag['StaticValue'],
                    "TagStatus":tag['Status'],
                    "TagStatusRead":val[2],
                    "TagTstampOpc":val[3],
                }
    return value
def extractValue2(x,y):
    valueNya = []
    for tag in x:
        dttime = datetime.today().strftime('%Y-%m-%d %H:%M:%S')
        value = {}
        value = assignValue(tag,y,dttime)
        valueNya.append(value)
    return valueNya



        
def connectOPC(tagGroups):
    connection = {}
    tagInConnect = {}
    # connection['bundle'] = []

    for tg in tagGroups:
        connecttags = tg['tags']
        tagReads = list(map(readtag,connecttags))
        
        # mengumpulkan semua tag jika servernya sama
        if tg['TagGroupServer'] in tagInConnect:
            tagInConnect[tg['TagGroupServer']].extend(tg['tags'])
        else:
            tagInConnect[tg['TagGroupServer']] = tg['tags']

        # membuat koneksi
        if tg['TagGroupServer'] in connection:
            print("Koneksi "+tg['TagGroupServer']+" Sudah Ada")
            # connection[tg['TagGroupServer']].read(tagReads,group=tg['TagGroupName'])
        else:
            print("Koneksi "+tg['TagGroupServer']+" Dibuat")
            connection[tg['TagGroupServer']] = opc
            connection[tg['TagGroupServer']].connect(tg['TagGroupServer'])

            
    connection['bundle'] = tagInConnect
    connection['servers'] = opc.servers()

    # buat group read
    for server,tagsgr in connection['bundle'].items():
        tagReads = list(map(readtag,tagsgr))
        val = connection[server].read(tagReads)
    return connection


# current date and time
# now = datetime.now()
# timestamp = datetime.timestamp(now)
# dt_object = datetime.fromtimestamp(timestamp)



    # instantiating process with arguments
    

# def readOPC(connection,server,group,tags):
#     values = connection[server].read(group=group)
#     extractValues = list(map(extractValue1,values,tags))
#     return extractValues



if __name__ == "__main__":
    try:
        response = requests.request("get", url+'/gateway-tag-groups')
        respNya = json.loads(response.text)
        respNya2 = respNya
        connection = connectOPC(respNya['data'])

        # di request lagi karena ada error
        response = requests.request("get", url+'/gateway-tag-groups')
        respNya = json.loads(response.text)
        while True:
            # is restart
            # print()
            try:
                response = requests.request("GET", url=url+'/gateway-restart')
                isRestart = json.loads(response.text)
                if isRestart['status']:
                    print('Restarting...')
                    response = requests.request("get", url+'/gateway-tag-groups')
                    respNya = json.loads(response.text)
                    respNya2 = respNya
                    connection = connectOPC(respNya['data'])

                    # di request lagi karena ada error
                    response = requests.request("get", url+'/gateway-tag-groups')
                    respNya = json.loads(response.text)
                    # exit()
            except Exception as e:
                    print('1 '+str(e))
            # start
            try:
                servers = {}
                for server,tags in connection['bundle'].items():
                    tagReads = list(map(readtag,tags))
                    reslt = connection[server].read(tagReads)
                    servers[server] = reslt

                allValues = []
                for rtg in respNya['data']:
                    # extractValues = list(map(extractValue1,servers[rtg['TagGroupServer']],rtg['tags']))
                    extractValues = extractValue2(rtg['tags'],servers[rtg['TagGroupServer']])
                    tagGroup = {
                        "TagGroupId":rtg['id'],
                        "TagGroupName":rtg['TagGroupName'],
                        "tagGroupServer":rtg['TagGroupServer'],
                        "tagTableName":rtg['TagTableName'],
                        "tags":rtg['tags'],
                        "values":extractValues
                    }
                    allValues.append(tagGroup)
                    # kirim api
                    payload={'values':json.dumps(tagGroup)}
                    headers = {}
                    # print(payload)
                    try:
                        response = requests.request("POST", url=url+'/gateway-value', headers=headers, data=payload)
                        # print(response.text)
                    except Exception as e:
                         print('1 '+str(e))

                try:
                    payload={'values':json.dumps(allValues),'servers':connection['servers']}
                    headers = {}
                    response = requests.request("POST", url=url+'/gateway-values', headers=headers, data=payload)
                    # print(response.text)
                except Exception as e:
                        print(str(e))
            except Exception as e:
                print(str(e))
            time.sleep(1)
    except Exception as e:
        print(str(e))
        print("Restarting...")
        # os.system("python opc-test.py")
   

    
    # baca realtimenya
    
    
         

    # while True:
    #     dttime = datetime.today().strftime('%Y-%m-%d %H:%M:%S')
    #     print(dttime)
    #     try:
    #         # jobs = []
    #         # for rtg in resp['data']:
    #         #     # readOPC()
    #         #     p = multiprocessing.Process(target=readOPC, args=(rtg['TagGroupServer'],rtg['TagGroupName'],rtg['tags']))
    #         #     jobs.append(p)
    #         #     p.start()

    #         for rtg in resp['data']:
    #             values = readOPC(connection,rtg['TagGroupServer'],rtg['TagGroupName'],rtg['tags'])
    #             print('------------')
    #             # print(values)
    #             # print(extractValues)
    #         print('====================\n')
             
    #     except Exception as e:
    #         print(str(e))
    #     time.sleep(1)

