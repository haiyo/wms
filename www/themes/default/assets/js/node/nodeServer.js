var express = require("express")();
var httpProxy = require("http-proxy");
var http = require("http");
//var app = http.Server(express);

//create proxy template object with websockets enabled
var proxy = httpProxy.createProxyServer({ws: true});

//create node server on port 80 and proxy to ports accordingly
http.createServer(function (req, res) {
    proxy.web(req, res, { target: 'http://localhost:5000' });
}).listen(5000, function(){
    console.log("listening on *:5000");
});

/*
ProxyRequests Off
RewriteEngine On
RewriteCond %{HTTP:Upgrade} websocket [NC]
RewriteRule /(.*) ws://localhost:5000/$1 [P,L]

RewriteCond %{REQUEST_URI}  ^/socket.io [NC]
RewriteCond %{QUERY_STRING} transport=polling [NC]
RewriteRule /(.*) http://localhost:5000/$1 [P,L]

ProxyPass /ws/ http://localhost:5000/
ProxyPassReverse /ws/ http://localhost:5000/
* */


/*app.listen(5000, function(){
    console.log("listening on *:5000");
});*/

var io = require("socket.io")(http);
var clients = {};
var rooms = {};

io.on("connection", function( socket ) {
    var address = socket.handshake.address;
    console.log(address)

    socket.on( "subscribe", function( userID ) {
        clients[userID] = socket;
        console.log(userID + " Subscribed!")
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
                io.to( obj.data.crID).emit( obj.data.event, data );
            }
        }
    });
});