<?php
require __DIR__ . '/db.php';

$sql = "SELECT * FROM socket_messages ORDER BY date_sent ASC;";
$messages = $db->query($sql)->fetchAll(PDO::FETCH_OBJ);
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Socket.io</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js" integrity="sha512-v8ng/uGxkge3d1IJuEo6dJP8JViyvms0cly9pnbfRxT6/31c3dRWxIiwGnMSWwZjHKOuY3EVmijs7k1jz/9bLA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        var socket = io('http://localhost:5000', { transports : ['websocket'] });
    </script>
</head>
<body>
<div style="margin-left: 33%;">
    <div id="messageBox" style="width: 400px ; height: 600px; border: black solid 2px;">
        <?php foreach($messages as $message) {
            echo $message->name . ' : ' . $message->message . ' - ' . $message->date_sent . '<br>';
        } ?>

    </div>
    <div id="typingArea" style="text-align: left; width: 400px; border:black solid 2px;">

    </div>
        İsminiz : <input  type="text" id="name" style="width: 344px; height: 40px; border: black solid 2px;" > <br>
        Mesajınız : <input  type="text" id="message" style="width: 329px; height: 40px; border: black solid 2px;" > <br>
        <button style="color: deeppink" id="submit">Gönder</button>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>

    const submit = $('#submit');
    const name = $('#name');
    const message = $('#message');
    const messageBox = $('#messageBox');

    submit.click(function() {
        $.ajax({
            method: 'POST',
            url: "socket.php",
            data: {
                name: name.val(),
                message: message.val()
            }, success: function(){
                $('#typingArea').html('');
            }
        });
    });

    message.keypress(function(){
        socket.emit('typing', {
            'name': name.val(),
            'status': 1
        });
    });

    message.keydown(function() {
        socket.emit('typing', {
            'name': name.val(),
            'status': 0
        });
    });

    socket.on('userTyping', function(data) {
        if(data.status > 0) {
            $('#typingArea').html(data.name + ' yazıyor...');
        }else {
            $('#typingArea').html('');
        }
    });

    socket.on('messageSent', function(data) {
        var newMessage = data.name + ' : ' + data.message + ' - ' + data.date + '<br>';
        messageBox.append(newMessage);
    });
</script>
</body>
</html>