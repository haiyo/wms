var express = require('express')();
var http = require('http').Server(express);

http.listen(5000, function(){
    console.log('listening on *:5000');
});

var io = require('socket.io')(http);

io.on('connection', function(socket){
    console.log('a user connected');
});