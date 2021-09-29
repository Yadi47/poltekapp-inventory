# Python 3 server example
from http.server import BaseHTTPRequestHandler, HTTPServer
import time

#!C:\Python27\python.exe
import json
import OpenOPC
import pywintypes
import datetime, threading
import psycopg2
import sys

import datetime, threading, time
pywintypes.datetime = pywintypes.TimeType


hostName = "localhost"
serverPort = 8080

class MyServer(BaseHTTPRequestHandler):
    def do_GET(self):
        # self.wfile.write(bytes("<html><head><title>https://pythonbasics.org</title></head>", "utf-8"))
        # self.wfile.write(bytes("<p>Request: %s</p>" % self.path, "utf-8"))
        # self.wfile.write(bytes("<body>", "utf-8"))
        # self.wfile.write(bytes("<p>This is an example web server.</p>", "utf-8"))
        # self.wfile.write(bytes("</body></html>", "utf-8"))
        self.send_response(200)
        self.send_header("Access-Control-Allow-Origin", "*")
        self.send_header('Content-Type', 'text')
        self.end_headers()
        print(self.path)
        if self.path =='/getServers':
            opc = OpenOPC.client()

            # a Python object (dict):
            resp = {
            "data":opc.servers()
            }
            # convert into JSON:
            parsed = json.dumps(resp)

          
            self.wfile.write(parsed.encode(encoding='utf_8'))
            
        if self.path =='/getTags':
            opc = OpenOPC.client()

            # a Python object (dict):
            resp = {
                "data":opc.servers()
            }

            # convert into JSON:
            parsed = json.dumps(resp)
            self.send_response(200)
            self.send_header('Content-Type', 'text')
            self.end_headers()
            self.wfile.write(parsed.encode(encoding='utf_8'))

        if self.path =='/getValues':
            opc = OpenOPC.client()
            opc.connect('Matrikon.OPC.Simulation.1')
            tags = [
            'TANK-01.Status',
            'TANK-01.Tank Name'
            ]
           

            try:
                value = opc.read(tags,group='GROUP1',update=1)
                # a Python object (dict):
                resp = {
                    "data":value
                }
                # convert into JSON:
                parsed = json.dumps(resp)
                self.send_response(200)
                self.send_header('Content-Type', 'text')
                self.end_headers()
                self.wfile.write(parsed.encode(encoding='utf_8'))


            except OpenOPC.TimeoutError:
                print ("TimeoutError occured")

          
            



if __name__ == "__main__":        
    webServer = HTTPServer((hostName, serverPort), MyServer)
    print("Server started http://%s:%s" % (hostName, serverPort))

    try:
        webServer.serve_forever()
    except KeyboardInterrupt:
        pass

    webServer.server_close()
    print("Server stopped.")