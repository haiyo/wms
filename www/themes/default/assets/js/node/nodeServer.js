var express = require("express")();
var http = require("http").Server(express);

http.listen(5000, function(){
    console.log("listening on *:5000");
});

var io = require("socket.io")(http);
var clients = {};

io.on("connection", function( socket ){
    socket.on( "subscribe", function( userID ) {
        clients[userID] = socket.id;
    });

    socket.on("notify", function( data ) {
        var obj = JSON.parse( data );

        for( var i=0; i<obj.data.notifyUserIDs.length; i++ ) {
            var to = clients[obj.data.notifyUserIDs[i]];

            if( to ) {
                if( obj.data.notifyType == "broadcast" ) {
                    // Broadcast to everyone else except for the socket that starts it.
                    socket.broadcast.emit( obj.data.notifyEvent, data );
                }
                else {
                    // Normal request to individual
                    io.to(to).emit( obj.data.notifyEvent, data );
                }
            }
        }
    });
});
