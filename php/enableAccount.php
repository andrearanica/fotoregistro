<?php

ini_set('display_errors', 1);

$id = $_GET['id'];

require('connection.php');

$query = "UPDATE students SET enabled=1 WHERE student_id='$id'";

$connection->query($query);

$query = "UPDATE teachers SET enabled=1 WHERE teacher_id='$id'";

$connection->query($query);

echo 'Account correttamente abilitato. Torna alla pagina <a href="../public/index.html">Login</a>';

?>