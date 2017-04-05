Setup:

Install laravel-echo-server https://github.com/tlaverdure/laravel-echo-server
- npm install -g laravel-echo-server

Start server using included laravel-echo-server.json or update as needed
- laravel-echo-server start

Install dependencies
- npm install
- composer install

Setup .env

- BROADCAST_DRIVER=pusher
- PUSHER_APP_ID={ID from laravel-echo-server.json}
- PUSHER_APP_KEY={Key from laravel-echo-server.json}
- PUSHER_APP_SECRET=

Review Chat.vue

All chat messages are sent to User 2 