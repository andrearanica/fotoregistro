<?php

$data_url = $_POST['image'];

list($type, $data) = explode(';', $data_url);
list(, $data) = explode(',', $data);

?>