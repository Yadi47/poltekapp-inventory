import express from "express";
const fs = require("fs");
var datetime = require("node-datetime");

const app = express(),
  bodyParser = require("body-parser");

var server = require("http").Server(app);
var io = require("socket.io")(server, {
  cors: {
    origin: "*",
  },
});

const Router = require("express-group-router");
var morgan = require("morgan");
var cors = require("cors");

let router = new Router({
  options: { mergeParams: true },
});
var corsOptions = {
  origin: "*",
  methods: "GET,HEAD,PUT,PATCH,POST,DELETE",
  preflightContinue: false,
  optionsSuccessStatus: 204,
};
// app.use(morgan("tiny"));
app.use(cors(corsOptions));

// support parsing of application/json type post data
app.use(bodyParser.json());
//support parsing of application/x-www-form-urlencoded post data
app.use(bodyParser.json({limit: '50mb'}));
app.use(bodyParser.urlencoded({limit: '50mb', extended: true}));


const port = 8010;
import Route from "./route";
import Websocket from "./websocket";
import * as cons from "./Config/Const";

/*
Init swagger & all route 
*/
Route.swagger(app);
Route.init(router);
Websocket.init(io, router, cons);
app.use(router.init());


/**
 * WEBSOCKET AREA
 *
 */



server.listen(port, function (err: any) {
  if (err) {
    return console.log(err);
  } else {
    console.log(
      `${cons.CONSOLE_TEXT.EXPRESS} Server started on http://localhost:${port}`
    );
    console.log("[WEBSOCKET] Websocket Start ON Port 8080");
    // Or
     var dt = datetime.create();
     var formatted = dt.format("Y-m-d H:M:S");
      // fs.writeFile("myFile.txt","Last Start : "+ formatted, function () {
      //   // Deal with possible error here.
      // });
      fs.appendFile("log.txt", "Last Start : " + formatted+'\n', function () {
        if (err) {
          // append failed
        } else {
          // done
        }
      });
  }
});
