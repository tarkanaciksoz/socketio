const server = require('http').createServer();
const io = require('socket.io')(server);

io.on('connection', function(socket) {
    console.log('someone connected.');

    socket.on('newMessage', function(data) {
        io.emit('messageSent', data);
    });

    socket.on('typing', function(data) {
        io.emit('userTyping', data);
    })

    socket.on('disconnect', function() {
        console.log('someone disconnected.');
    });


});

server.listen(5000);