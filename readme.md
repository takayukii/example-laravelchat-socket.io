# Example Laravel Chat

This chat example is using Broadcasting events which was introduced in Laravel 5.1. This feature is intended to integrate with Pub-Sub functionality such as Pusher / Redis and Socket.io through Laravel Event.

[Broadcasting Events in Laravel 5.1 - laracasts](https://laracasts.com/lessons/broadcasting-events-in-laravel-5-1)

In real world applications, we need not only broadcasting messages/notifications but also private messages/notifications. This example app is my feasibility study to prove Laravel and Socket.io can be well integrated.

* Share user's session between Laravel and Socket.io/Node.js
* Push message to specified user by Laravel Event through Redis and Socket.io

## Useful Links

* [Easy Socket.IO + BroadCasting in Laravel - LukePOLO](https://lukepolo.com/blog/view/laravel-socket.io-broadcast)

## Prerequisites 

This example application has been tested in the environment below.

* Laravel 5.2
* PHP7
* Node.js v4 or above
* MySQL
* Redis

## Preparation

Install dependencies.

```
$ composer install
$ npm install
```

Migrate.

```
$ php artisan migrate
```

Review envrionment parameters in `.env`, you may need to change SOCKTIO_ENDPOINT.

Build js.

```
$ gulp
``` 

## Run the example application

* Ensure mysql is running
* Ensure redis is running
* Ensure nginx/php aritisan serve is running

Run socket.io server

```
$ node socket-server.js
```

1. Access to http://\<YOUR_ENDPOINT\>/, and create two users and logged in with different browsers. 
2. Access to http://\<YOUR_ENDPOINT\>/home, you can chat using two browsers. 

## TODO

* Test
