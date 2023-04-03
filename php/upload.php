<?php

ini_set('display_errors', true);

$dir = '../photos/';

foreach ($_FILES as $file) {
    if (UPLOAD_ERR_OK === $file['error']) {
        $fileName = basename("ciao.jpeg");
        move_uploaded_file($file['tmp_name'], $dir.DIRECTORY_SEPARATOR.$fileName);
        
        header('Location: ');
    } else {
        header('Location: ');
    }
}

?>