<?php
session_start();

if (!isset($_SESSION['email'])) {
    header('Location: index.php');
}
if (isset($_SESSION['admin'])) {
    if ($_SESSION['admin'] == '1') {    
        header('Location: admin.php'); 
    } else {
        if (!is_dir('images/' . $_SESSION['class'])) {
            header('Location: index.php?error=noclass');
        }
    }
}
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Dashboard</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    </head>
    <body>
        <div class="container my-5">
            <h1>👨🏻‍🏫 Fotoregistro <?php echo $_SESSION['class'] ?></h1>
            <p>Benvenuto <?php echo $_SESSION['name'] ?>, scegli un'immagine da caricare</p>
            <?php
                echo '<div class="row text-center">';
                    foreach (scandir('./images/' . $_SESSION['class']) as $img) {
                        if ($img != '.' && $img != '..') {
                            $name = str_replace('_', ' ', explode('.', $img)[0]);
                            echo '<div class="col my-2"><img height="400" src=images/' . $_SESSION['class'] . '/' . $img . '><br>';
                            if ($img == $_SESSION['name'] . '_' . $_SESSION['surname'] . '.jpg') {
                                echo '<form class="my-3" method="GET" action="dashboard.php"><input name="delete" class="btn btn-danger" type="submit" value="' . $name .'"></form>';
                            } else {
                                echo '<p class="my-3">' . $name . '</p>';
                            }
                            echo '</div>';
                        }
                    }
                echo '</div>';
            ?>
            <?php
            if (!array_search($_SESSION['name'] . '_' . $_SESSION['surname'] . '.jpg', scandir('./images/' . $_SESSION['class'] . '/'))) {
                echo '
                <form class="text-center my-4" action="dashboard.php" method="post" enctype="multipart/form-data">
                    <input type="file" name="file">
                    <input type="submit" name="upload" value="Carica file">
                </form>
                ';
            } else {
                echo '<div class="text-center alert alert-warning my-4">Hai già caricato un\'immagine: se vuoi cambiarla elimina prima quella precedente</div>';
            }
            ?>
            <?php
                if (isset($_GET['error'])) {
                    if ($_GET['error'] != 'null') {
                        echo '<div class="text-center alert alert-danger my-4">C\'è stato un errore</div>';
                    }
                }                        
                if (isset($_GET['delete'])) {
                    $fileName = str_replace(' ', '_', $_GET['delete']) . '.jpg';
                    if ($_GET['delete'] != 'null' && file_exists('images/' . $_SESSION['class'] . '/' . $fileName)) {
                        echo $_GET['delete'];
                        unlink('images/' . $_SESSION['class'] . '/' . $fileName);
                        header('Location: dashboard.php');
                    }
                }
            ?>
            <form class="text-center" method="GET" action="dashboard.php">
                <input type="submit" class="btn btn-info" name="logout" value="Logout">
            </form>
        </div>
        <?php
            $dir = __DIR__ . '/images/' . $_SESSION['class'];

            foreach ($_FILES as $file) {
                if (UPLOAD_ERR_OK === $file['error']) {
                    $fileName = basename($_SESSION['name'] . '_' . $_SESSION['surname'] . '.jpg');
                    move_uploaded_file($file['tmp_name'], $dir.DIRECTORY_SEPARATOR.$fileName);    
                    header('Location: dashboard.php?error=null');
                } else {
                    header('Location: dashboard.php?error=error');
                }
            }
        ?>
    </body>
</html>