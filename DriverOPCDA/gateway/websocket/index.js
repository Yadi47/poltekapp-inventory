var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server, {
    cors: {
        origin: '*',
    }
});
var cors = require('cors')
app.use(cors({
    "origin": "*",
}))

const TestController = require('./controller/TestController')

app.get('/', TestController.Test);

io.on('connection', function (socket) {
    console.log({'name':123})

    socket.on('opc_values', (data) => {
        console.log(data)
        io.emit('realtime', data);
    })

    
    io.sockets.emit('stats', { data: 'some data' });


});


server.listen(8080,function(err){
    console.log("Websocket Start ON Port 8080")
});