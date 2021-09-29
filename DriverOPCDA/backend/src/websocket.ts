const schedule = require("node-schedule");
import TagGroup from "./Models/TagGroup";
import Tag from "./Models/Tag";
import socketClient from "socket.io-client";
import dbPG from "./Database/DatabasePostgre";
var datetime = require("node-datetime");

// init socket client connect
const socket = socketClient.io("http://localhost:8010");


// function insert opc
async function insert(data: any, dttime: string) {
  let table = data.tagTableName,
    columns,
    values;
  // console.log(data);

  try {
    columns = data.values.map((val: any, i: any) => {
      if(val.TagStatus){
        return `"`+val.TagColumn+`"`;
      }else{
        return false;
      }
    }).filter(function(val:any){
      if(val != false){
        return val;
      }
    });
    values = data.values.map((val: any, i: any) => {
      
  
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
      if(val.TagStatus){
        if (val.TagStaticValue < 0) {
          return "'" + dttime + "'";
        }
        if (typeof val.TagValue === "string") {
          return "'" + val.TagValue.replace("'", "''") + "'";
  
        } else {
          if(val.TagValue === null){
            return '0';
          }else{
            return val.TagValue;
            return val.TagValue+'('+val.TagName+')';
          }
        }
      }
    });
  
    // values = values.map((v:any)=>{
    //   if (typeof v != 'undefined') {
    //     return v;
    //   }
    // })
  
    values = values.filter(function( element:any ) {
      return element !== undefined;
    });
   
    // console.log(values);
    let query = `INSERT INTO ${table} (${columns.join()}) values (${values.join()})`;
    try {
      let execPG = await dbPG
        .query(query, {   
          type: dbPG.QueryTypes.INSERT,
        })
        .then(function (clientInsertId: any) {
          console.log(
            "[POSTGRES] " + dttime + ":" + data.TagGroupName + " Insert Success !"
          );
        });
    }catch (error) {
      console.error(  data.TagGroupName+"Failed Insert database : "+error.message);
      console.log(data.TagGroupName + ' - '+query);
      // console.log('\n');
    }
  } catch (error) {
    console.log("ERROR DI LINE 95")
    console.log(error);
  }
  
}

async function selectTable() {
  let query = `select * from bulkinfo`;
  try {
    dbPG
      .query(query, {
        type: dbPG.QueryTypes.INSERT,
      })
      .then(function (clientInsertId: any) {
        // console.log("Insert Success !");
        console.log(clientInsertId);
      });
  } catch (error) {
    console.error("Failed Insert database :", error);
  }
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

const init = (io: any, router: any, cons: any) => {
  io.on("connection", function (socket: any) {
    console.log(`${cons.CONSOLE_TEXT.EXPRESS} Client Connected`);
    socket.on("opc_values", (data: any) => {
      io.emit("realtime", data);
    });
    io.sockets.emit("stats", { data: "some data" });

    socket.on("toServerTags", (data: any) => {
      // console.log(data);
      io.sockets.emit("toClientTags", data);
    });

    socket.on("toServerServers", (data: any = {}) => {
      // console.log(data);
      io.sockets.emit("toClientServers", data);
    });

    socket.on("toServerValues", (data: any) => {
      io.sockets.emit("toClientValues", data);
    });

    socket.on("toServerValueWillInsert", (data: any) => {
      // console.log(data);
      io.sockets.emit("toClientValueWillInsert", data);
    });

    socket.on("scheduledValues", (data: any) => {
      io.sockets.emit("getValues", data);
    });

    socket.on("toServerScheduledValues", (data: any, dateTime: string) => {
      io.sockets.emit("getScheduledValues", data, dateTime);
    });

    socket.on("toServerScheduledValuesResult", (data: any) => {
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

    socket.on("toServerFromOpcRealtime", (data: any) => {
      io.sockets.emit("toClientRealtimeValuesResult", data);
    });
  });

  router.get("/websocket/getTags", (req: any, res: any) => {
    io.sockets.emit("getTags");
    res.send({});
  });

  router.get("/websocket/getServers", (req: any, res: any) => {
    io.sockets.emit("getServers");
    res.send({});
  });

  router.post("/websocket/getValues/:id", (req: any, res: any) => {
    // console.log(req.body);
    io.sockets.emit("getValues", req.body);
    res.send({});
  });

  // SHCEDULED
  var allValues: any[] = [];
  var servers: any[] = [];
  const jobDatabase = schedule.scheduleJob(
    "*/5 * * * * *",
    async function () {
      var dt = datetime.create();
      var formatted = dt.format("Y-m-d H:M:S");
      for (const val of allValues) {
        insert(val, formatted);
        // console.log(val);
      }
      // console.log("\n");
    }.bind(null, allValues)
  );

  // Push All Value to socket array
  const job = schedule.scheduleJob(
    "*/4 * * * * *",
    async function () {
      // console.log(allValues)
     io.sockets.emit("toClientRealtimeValuesResults", allValues);
    }.bind(null, allValues)
  );
  router.post("/gateway-value", (req: any, res: any) => {
     allValues = req.body.values;
    // console.log(JSON.parse(req.body.values));
    io.sockets.emit("toClientRealtimeValuesResult", req.body.values);
    res.send("Success Value");
  });

  router.post("/gateway-values", (req: any, res: any) => {
    let data = req.body;
    allValues = JSON.parse(data.values);
    servers = data.servers
    res.send("Success");
  });
  router.get("/gateway-servers", (req: any, res: any) => {
    // console.log(data.length);
    res.send(servers);
  });
  router.get("/gateway-restart", (req: any, res: any) => {
    // console.log(data.length);
    res.send({'status':0});
  });
};

export default {
  init,
};
