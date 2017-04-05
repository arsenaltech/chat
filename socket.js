
var server = require('http').Server();

var io = require('socket.io')(server);

var Redis = require('ioredis');
var redis = new Redis();

redis.psubscribe('private-user.*');

redis.on('pmessage', function(pattern, channel, message) {
  message = JSON.parse(message);

  io.emit(channel + ':' + message.event, message.data);
});

server.listen(3000);