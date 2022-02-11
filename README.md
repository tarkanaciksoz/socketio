# socketio

npm init -y

# version 2.3.0 kullanıyoruz çünkü php'de version 3 kütüphanesini bulamadım :/
npm install socket.io@2.3.0

# pm2'yi global olarak kuruyoruz.
npm install pm2 -g

# socket.io kütüphanesini composer ile çağırıyoruz.
composer require wisembly/elephant.io

# server'ı başlat
pm2 start app.js

# logları gör
pm2 logs
