<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/db.php';
use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;

if(!empty($_POST)) {
    $name = $_POST['name'];
    $message = $_POST['message'];
    $dateSent = date('Y-m-d H:i:s');

    $sql = "INSERT INTO socket_messages (name, message, date_sent) VALUES (:name, :message, :date_sent)";
    $stmt = $db->prepare($sql);

    $check = $stmt->execute([
        'name' => $name,
        'message' => $message,
        'date_sent' => $dateSent
    ]);

    if($check) {
        $client = new Client(new Version2X('http://localhost:5000'));

        $client->initialize();
        $client->emit('newMessage', [
            'id' => $db->lastInsertId(),
            'name' => $name,
            'message' => $message,
            'date' => $dateSent
        ]);
        $client->close();
    }
}
