var express = require("express")();
var http = require("http").Server(express);

http.listen(5000, function(){
    console.log("listening on *:5000");
});

var io = require("socket.io")(http);
var clients = {};
var rooms = {};

io.on("connection", function( socket ){
    socket.on( "subscribe", function( userID ) {
        clients[userID] = socket;
    });

    socket.on("notify", function( data ) {
        var obj = JSON.parse( data );
        var from = clients[obj.data.from];

        for( var i=0; i<obj.data.to.length; i++ ) {
            var to = clients[obj.data.to[i]];

            if( to ) {
                if( !rooms.hasOwnProperty( obj.data.crID ) ) {
                    console.log(to.id + " join room " + obj.data.crID);
                    console.log("event " + obj.data.event);

                    rooms[obj.data.crID] = 1;
                    from.join( obj.data.crID );
                    to.join( obj.data.crID );
                }
                io.to( obj.data.crID).emit( obj.data.event, data  );
                //io.to(to).emit( obj.data.notifyEvent, data );
            }
        }
    });
});