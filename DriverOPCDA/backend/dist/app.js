"use strict";
var __createBinding = (this && this.__createBinding) || (Object.create ? (function(o, m, k, k2) {
    if (k2 === undefined) k2 = k;
    Object.defineProperty(o, k2, { enumerable: true, get: function() { return m[k]; } });
}) : (function(o, m, k, k2) {
    if (k2 === undefined) k2 = k;
    o[k2] = m[k];
}));
var __setModuleDefault = (this && this.__setModuleDefault) || (Object.create ? (function(o, v) {
    Object.defineProperty(o, "default", { enumerable: true, value: v });
}) : function(o, v) {
    o["default"] = v;
});
var __importStar = (this && this.__importStar) || function (mod) {
    if (mod && mod.__esModule) return mod;
    var result = {};
    if (mod != null) for (var k in mod) if (k !== "default" && Object.prototype.hasOwnProperty.call(mod, k)) __createBinding(result, mod, k);
    __setModuleDefault(result, mod);
    return result;
};
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
const express_1 = __importDefault(require("express"));
const fs = require("fs");
var datetime = require("node-datetime");
const app = express_1.default(), bodyParser = require("body-parser");
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
app.use(bodyParser.json({ limit: '50mb' }));
app.use(bodyParser.urlencoded({ limit: '50mb', extended: true }));
const port = 8010;
const route_1 = __importDefault(require("./route"));
const websocket_1 = __importDefault(require("./websocket"));
const cons = __importStar(require("./Config/Const"));
/*
Init swagger & all route
*/
route_1.default.swagger(app);
route_1.default.init(router);
websocket_1.default.init(io, router, cons);
app.use(router.init());
/**
 * WEBSOCKET AREA
 *
 */
server.listen(port, function (err) {
    if (err) {
        return console.log(err);
    }
    else {
        console.log(`${cons.CONSOLE_TEXT.EXPRESS} Server started on http://localhost:${port}`);
        console.log("[WEBSOCKET] Websocket Start ON Port 8080");
        // Or
        var dt = datetime.create();
        var formatted = dt.format("Y-m-d H:M:S");
        // fs.writeFile("myFile.txt","Last Start : "+ formatted, function () {
        //   // Deal with possible error here.
        // });
        fs.appendFile("log.txt", "Last Start : " + formatted + '\n', function () {
            if (err) {
                // append failed
            }
            else {
                // done
            }
        });
    }
});
