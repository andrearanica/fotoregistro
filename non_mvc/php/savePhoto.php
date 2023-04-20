<?php

$data_url = $_POST['image'];
require('checkToken.php');

list($type, $data) = explode(';', $data_url);
list(, $data) = explode(',', $data);

?>