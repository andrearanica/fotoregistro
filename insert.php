<?php

$ip = '127.0.0.1';
$username = 'root';
$password = '';
$database = "test";

$connessione = new mysqli($ip, $username, $password, $database);

if($connessione === false) {
    die('Errore di connessione: ' . $connessione);
}

$sql = "UPDATE persone SET email='mariorossi@gmail.com' WHERE id=1";
if ($connessione->query($sql) === true) {
    echo 'Riga aggiornata';
} else {
    echo 'C\'è stato un errore';
}

$connessione->close();

?>