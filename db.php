<?php

try {
    $db = new PDO('mysql:host=localhost;dbname=socket', 'tarkanaciksoz', '');
} catch (PDOException $e) {
    die($e->getMessage());
}
?>