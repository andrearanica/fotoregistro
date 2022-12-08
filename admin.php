<?php
session_start();
if (isset($_SESSION['admin'])) {
    if ($_SESSION['admin'] == 0) {
        header('Location: dashboard.php');
    }
}
if (isset($_GET['class'])) {
    if (!is_dir('images/' . $_GET['class'])) {
        mkdir('images/' . $_GET['class']);
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Admin dashboard</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    </head>
    <body>
        <div class="container container my-5">
            <h1>🚧 Admin</h1>
            Benvenuto, scegli una classe per vedere il fotoregistro
            <form class="text-center">
            <?php
            foreach(scandir('images') as $class) {
                if ($class != '.' && $class != '..') {
                    echo '<input type="submit" class="btn mx-1" name="showClass" value="' . $class . '">';
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
                        echo '<div class="col my-2"><img height=400 src="images/' . $_GET['showClass'] . '/' . $img . '"><p class="my-2">' . $name . '</p></div>';
                    }
                }
                echo '</div>';
            }
            echo '<br>';    
            ?>
            <hr>
            <h4>Classi registrate</h4>
            <?php
            foreach (scandir('./images/') as $dir) {
                if ($dir != '.' && $dir != '..') {
                    echo ' ' . $dir . ' ';
                }
            }
            ?>
            <form action="admin.php" method="GET">
                <input type="text" class="form-control my-1" name="class" placeholder="Inserisci una nuova classe">
                <input type="submit" class="form-control my-1" value="Aggiungi">
            </form>
        </div>
    </body>
</html>