"use strict";
var __awaiter = (this && this.__awaiter) || function (thisArg, _arguments, P, generator) {
    function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
const schedule = require("node-schedule");
const socket_io_client_1 = __importDefault(require("socket.io-client"));
const DatabasePostgre_1 = __importDefault(require("./Database/DatabasePostgre"));
var datetime = require("node-datetime");
// init socket client connect
const socket = socket_io_client_1.default.io("http://localhost:8010");
// function insert opc
function insert(data, dttime) {
    return __awaiter(this, void 0, void 0, function* () {
        let table = data.tagTableName, columns, values;
        // console.log(data);
        try {
            columns = data.values.map((val, i) => {
                if (val.TagStatus) {
                    return `"` + val.TagColumn + `"`;
                }
                else {
                    return false;
                }
            }).filter(function (val) {
                if (val != false) {
                    return val;
                }
            });
            values = data.values.map((val, i) => {
                // if(val.TagStatus){
                //   if (typeof val.TagValue === "string") {
                //     // if(data.TagStatus){
                //     return "'" + val.TagValue.replace("'", "''") + "'";
                //     // }
                //   } else {
                //     // if(val.TagValue === null){
                //     //   return "null";
                //     // }else{
                //       return val.TagValue;
                //     // }
                //   }
                // }else{
                //   return val.TagStatus;
                // }
                if (val.TagStatus) {
                    if (val.TagStaticValue < 0) {
                        return "'" + dttime + "'";
                    }
                    if (typeof val.TagValue === "string") {
                        return "'" + val.TagValue.replace("'", "''") + "'";
                    }
                    else {
                        if (val.TagValue === null) {
                            return '0';
                        }
                        else {
                            return val.TagValue;
                            return val.TagValue + '(' + val.TagName + ')';
                        }
                    }
                }
            });
            // values = values.map((v:any)=>{
            //   if (typeof v != 'undefined') {
            //     return v;
            //   }
            // })
            values = values.filter(function (element) {
                return element !== undefined;
            });
            // console.log(values);
            let query = `INSERT INTO ${table} (${columns.join()}) values (${values.join()})`;
            try {
                let execPG = yield DatabasePostgre_1.default
                    .query(query, {
                    type: DatabasePostgre_1.default.QueryTypes.INSERT,
                })
                    .then(function (clientInsertId) {
                    console.log("[POSTGRES] " + dttime + ":" + data.TagGroupName + " Insert Success !");
                });
            }
            catch (error) {
                console.error(data.TagGroupName + "Failed Insert database : " + error.message);
                console.log(data.TagGroupName + ' - ' + query);
                // console.log('\n');
            }
        }
        catch (error) {
            console.log("ERROR DI LINE 95");
            console.log(error);
        }
    });
}
function selectTable() {
    return __awaiter(this, void 0, void 0, function* () {
        let query = `select * from bulkinfo`;
        try {
            DatabasePostgre_1.default
                .query(query, {
                type: DatabasePostgre_1.default.QueryTypes.INSERT,
            })
                .then(function (clientInsertId) {
                // console.log("Insert Success !");
                console.log(clientInsertId);
            });
        }
        catch (error) {
            console.error("Failed Insert database :", error);
        }
    });
}
// socket client on connect
socket.on("connect", () => {
    // schedule websocket
    // const job = schedule.scheduleJob("*/20 * * * * *", async function () {
    //     var dt = datetime.create();
    //     var formatted = dt.format("Y-m-d H:M:S");
    //     const resp = await TagGroup.findAll({
    //       include: [
    //         {
    //           model: Tag,
    //           as: "tags",
    //         },
    //       ],
    //     });
    //     socket.emit("toServerScheduledValues", resp, formatted);
    // });
});
// send schedule to database
// socket.on("toClientScheduledValuesResult", (data) => {
//   insert(data);
//   // selectTable();
// });
const init = (io, router, cons) => {
    io.on("connection", function (socket) {
        console.log(`${cons.CONSOLE_TEXT.EXPRESS} Client Connected`);
        socket.on("opc_values", (data) => {
            io.emit("realtime", data);
        });
        io.sockets.emit("stats", { data: "some data" });
        socket.on("toServerTags", (data) => {
            // console.log(data);
            io.sockets.emit("toClientTags", data);
        });
        socket.on("toServerServers", (data = {}) => {
            // console.log(data);
            io.sockets.emit("toClientServers", data);
        });
        socket.on("toServerValues", (data) => {
            io.sockets.emit("toClientValues", data);
        });
        socket.on("toServerValueWillInsert", (data) => {
            // console.log(data);
            io.sockets.emit("toClientValueWillInsert", data);
        });
        socket.on("scheduledValues", (data) => {
            io.sockets.emit("getValues", data);
        });
        socket.on("toServerScheduledValues", (data, dateTime) => {
            io.sockets.emit("getScheduledValues", data, dateTime);
        });
        socket.on("toServerScheduledValuesResult", (data) => {
            io.sockets.emit("toClientScheduledValuesResult", data);
        });
        // socket.on("toServerFromFrontendRealtime", async (data: any) => {
        //   var dt = datetime.create();
        //   var formatted = dt.format("Y-m-d H:M:S");
        //   const resp = await TagGroup.findAll({
        //     include: [
        //       {
        //         model: Tag,
        //         as: "tags",
        //       },
        //     ],
        //   });
        //   io.sockets.emit("getRealtimeValues", resp, formatted);
        // });
        socket.on("toServerFromOpcRealtime", (data) => {
            io.sockets.emit("toClientRealtimeValuesResult", data);
        });
    });
    router.get("/websocket/getTags", (req, res) => {
        io.sockets.emit("getTags");
        res.send({});
    });
    router.get("/websocket/getServers", (req, res) => {
        io.sockets.emit("getServers");
        res.send({});
    });
    router.post("/websocket/getValues/:id", (req, res) => {
        // console.log(req.body);
        io.sockets.emit("getValues", req.body);
        res.send({});
    });
    // SHCEDULED
    var allValues = [];
    var servers = [];
    const jobDatabase = schedule.scheduleJob("*/5 * * * * *", function () {
        return __awaiter(this, void 0, void 0, function* () {
            var dt = datetime.create();
            var formatted = dt.format("Y-m-d H:M:S");
            for (const val of allValues) {
                insert(val, formatted);
                // console.log(val);
            }
            // console.log("\n");
        });
    }.bind(null, allValues));
    // Push All Value to socket array
    const job = schedule.scheduleJob("*/4 * * * * *", function () {
        return __awaiter(this, void 0, void 0, function* () {
            // console.log(allValues)
            io.sockets.emit("toClientRealtimeValuesResults", allValues);
        });
    }.bind(null, allValues));
    router.post("/gateway-value", (req, res) => {
        allValues = req.body.values;
        // console.log(JSON.parse(req.body.values));
        io.sockets.emit("toClientRealtimeValuesResult", req.body.values);
        res.send("Success Value");
    });
    router.post("/gateway-values", (req, res) => {
        let data = req.body;
        allValues = JSON.parse(data.values);
        servers = data.servers;
        res.send("Success");
    });
    router.get("/gateway-servers", (req, res) => {
        // console.log(data.length);
        res.send(servers);
    });
    router.get("/gateway-restart", (req, res) => {
        // console.log(data.length);
        res.send({ 'status': 0 });
    });
};
exports.default = {
    init,
};
