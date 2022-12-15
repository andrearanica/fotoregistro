<?php

session_start();
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 0) {
        header('Location: dashboard.php');
    } else if ($_SESSION['role'] == 1) {
        header('Location: admin.php');
    }
} else {
    header('Location: index.php');
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Dashboard Insegnante</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    </head>
    <body>
    <div class="container container my-5">
            <h1>🚧 Dashboard Insegnante</h1>
            Benvenuto, scegli una classe per vedere il fotoregistro
            <form class="text-center">
            <?php
            foreach(explode(',', $_SESSION['class']) as $class) {
                if (is_dir('images/' . $class) && $class != '.' && $class != '..') {
                    echo '<input type="submit" class="btn mx-1" name="showClass" value="' . $class . '">';
                } else {
                    echo '<div class="alert alert-warning my-3">La tua classe <b>' . $class . '</b> non è ancora stata iscritta</div>';
                }
            }
            ?>
            </form>
            <?php
            if (isset($_GET['showClass'])) {
                echo '<div class="row text-center">';
                foreach (scandir('images/' . $_GET['showClass'] . '/') as $img) {
                    if ($img != '.' && $img != '..') {
                        $name = str_replace('_', ' ', explode('.', $img)[0]);
                        echo '<div class="col my-2 text-center"><img height=400 src="images/' . $_GET['showClass'] . '/' . $img . '"><form action="admin.php" method="GET"><input type="submit" class="btn btn-danger my-2" name="delete" value="' . $name .'"><input name="class" value="' . $_GET['showClass'] . '" class="invisible"></form></div>';
                    }
                }
                echo '</div>';
            }
            echo '<br>';    
            ?>
            <br>
            <hr>
            <h4>Classi registrate</h4>
            <?php
            foreach (scandir('./images/') as $dir) {
                if ($dir != '.' && $dir != '..') {
                    echo ' ' . $dir . ' ';
                }
            }
            ?>

            <br><br>
            <form action="admin.php" method="GET" class="text-center">
                <input type="submit" class="btn btn-danger" name="logout" value="Logout">
            </form>
        </div>
    </body>
</html>