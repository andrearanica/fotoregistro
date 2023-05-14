<!DOCTYPE html>
<html lang='it'>
    <head>
        <meta charset='UTF-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Abilita account | Fotoregistro</title>
    </head>
    <body>
        <?php

        if (isset($_GET['result'])) {
            if ($_GET['result'] == 'success') {
                echo '<h4>Operazione avvenuta con successo<br><h1>Benvenuto sul fotoregistro!</h1></h4>';
            } else {
                echo '<h4>Dati di attivazione non validi<br> Controlla il link che hai ricevuto per email</h4>';
            }
        } else {
            require_once '../app/views/404.php';
        }

        ?>
    </body>
</html>