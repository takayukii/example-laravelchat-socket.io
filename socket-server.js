require('dotenv').config({
  path: __dirname +'/.env'
});

const env = process.env;
const port = env.NODE_SERVER_PORT;

const _ = require('lodash');
const redis = require('ioredis');
const redisClient = new redis();
const redisBroadcast = new redis();
const cookie = require('cookie');
const crypto = require('crypto');
const PHPUnserialize = require('php-unserialize');

const server = require('http').createServer();
console.log('Server on Port : ' + port);
server.listen(port);
const io = require('socket.io')(server);

io.use(middlewareAuthCheck);

io.on('connection', (socket) => {
  socket.on('user', (user) => {
    user = JSON.parse(user);
    console.log('user', user);
    // mark with userId
    socket.userId = user.id;
  });

  socket.on('disconnect', () => {
    console.log('disconnect..');
  });
});

redisBroadcast.psubscribe('*', (err, count) => {
});

redisBroadcast.on('pmessage', (subscribed, channel, event) => {
  event = JSON.parse(event);
  console.log('pmessage', channel, event);

  const _sockets = _.toArray(io.sockets.connected);
  event.data.destinations.forEach((userId) => {
    const socket = _.find(_sockets, (_socket) => {
      if (+userId === +_socket.userId) {
        return true;
      }
    });
    if (socket) {
      console.log('emit', socket.id, userId);
      io.to(socket.id).emit('chat', event.data.message);
    }
  });
});

function middlewareAuthCheck(socket, next) {

  try{

    var _cookie = socket.request.headers.cookie;
    if(!_cookie){
      throw new Error('No cookie');
    }
    _cookie = cookie.parse(_cookie);
    if(!_cookie || !_cookie['laravel_session']){
      throw new Error('No valid cookie');
    }

    const sessionId = decryptCookie(_cookie['laravel_session']);
    console.log('sessionId', sessionId);

    redisClient.get('laravel:' + sessionId, (err, session) => {

      if (err) {
        next(err);
      } else if (session) {
        next();
      } else {
        next(new Error('No session in redis'));
      }

    });

  }catch(err){
    console.log('Skip this socket since an error occurred', err);
    next(err);
  }

};

function decryptCookie(cookie) {
  console.log('cookie', cookie);
  const parsedCookie = JSON.parse(new Buffer(cookie, 'base64'));

  const iv = new Buffer(parsedCookie.iv, 'base64');
  const value = new Buffer(parsedCookie.value, 'base64');

  var appKey = env.APP_KEY;

  if (/base64/.test(env.APP_KEY)) {
    const matches = /base64:(.+)/.exec(appKey);
    console.log('appKey', matches[1]);
    appKey = new Buffer(matches[1], 'base64').toString();
    console.log('appKey', appKey);
    // TODO: Error in crypto.createDecipheriv if appKey is encoded in base64
    // appKey seems to be binary
    // https://github.com/laravel/framework/commit/370ae34d41362c3adb61bc5304068fb68e626586
  }

  const decipher = crypto.createDecipheriv('aes-256-cbc', appKey, iv);
  const resultSerialized = Buffer.concat([
    decipher.update(value),
    decipher.final()
  ]);

  return PHPUnserialize.unserialize(resultSerialized);
};
