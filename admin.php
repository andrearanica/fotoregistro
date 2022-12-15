<?php

session_start();
function clear(&$data) {
    $data = htmlspecialchars($data);
    $data = stripslashes($data);
    $data = trim($data);
}

if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 0) {
        header('Location: dashboard.php');
    } else if ($_SESSION['role'] == 2) {
        header('Location: teacher.php');
    }
} else {
    header('Location: index.php');
}

if (isset($_GET['class'])) {
    if (!is_dir('images/' . $_GET['class']) && preg_match('/[1-5][A-Z][A-Z]/', $_GET['class'])) {
        mkdir('images/' . $_GET['class']);
        header('Location: admin.php?classError=none');
    } else {
        header('Location: admin.php?classError=class');
    }
}

if (isset($_GET['delete']) && isset($_GET['class']) && isset($_SESSION['role'])) {
    $name = str_replace(' ', '_', $_GET['delete']) . '.jpg';
    unlink('images/' . $_GET['class'] . '/' . $name);
    header('Location: admin.php?showClass=' . $_GET['class']);
}

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Dashboard admin</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    </head>
    <body>
        <div class="container container my-5">
            <h1>🚧 Dashboard Admin</h1>
            Benvenuto, scegli una classe per vedere il fotoregistro
            <form class="text-center my-2">
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
            <form action="admin.php" method="GET">
                <input type="text" class="form-control my-1" name="class" placeholder="Inserisci una nuova classe">
                <input type="submit" class="form-control my-1 btn btn-primary" value="Aggiungi">
            </form>

            <?php

            if (isset($_GET['classError'])) {
                if ($_GET['classError'] == 'none') {
                    echo '<div class="alert alert-success my-2">Classe aggiunta <b>correttamente</b></div>';
                } else {
                    echo '<div class="alert alert-danger my-2">Formato classe <b>non valido</b>: [A-Z][A-Z][1-5]</div>';
                }
            }

            ?>
            
            <hr>
            <h4>Inserisci un insegnante</h4>
            <form action="admin.php" method="POST">
                <input type="text"      name="teacherName"     placeholder="Nome"      class="form-control my-1">
                <input type="text"      name="teacherSurname"  placeholder="Cognome"   class="form-control my-1">
                <input type="email"     name="teacherEmail"    placeholder="Email"     class="form-control my-1">
                <input type="password"  name="teacherPassword" placeholder="Password"  class="form-control my-1">
                <input type="text"      name="teacherClasses"  placeholder="Classi"    class="form-control my-1">
                <input type="submit" class="form-control btn btn-primary">
            </form>

            <?php
            
            if (isset($_POST['teacherPassword'])) {
                if ($_POST['teacherName'] != "" && $_POST['teacherSurname'] != "" && $_POST['teacherEmail'] != "" && $_POST['teacherPassword'] != "") {
                    $name = $_POST['teacherName'];
                    $surname = $_POST['teacherSurname'];
                    $email = $_POST['teacherEmail'];
                    $password = $_POST['teacherPassword'];
                    $classes = $_POST['teacherClasses'];
                    clear($name);
                    clear($surname);
                    clear($email);
                    clear($password);
                    clear($classes);

                    $ip = '127.0.0.1';
                    $username = 'root';
                    $pwd = '';
                    $database = 'test';
                    $connection = new mysqli($ip, $username, $pwd, $database);

                    $connection->query('INSERT INTO users (name, surname, email, password, class, role) VALUES 
                    ("' . $name . '", "' . $surname . '", "' . $email . '", "' . md5($password) . '", "' . $classes . '", "2");');

                    $connection->close();

                    header('Location: admin.php?error=none');
                } else {
                    echo '<div class="alert alert-danger my-2">Dati inseriti <b>non correttamente</b>, controlla di avere compilato tutti i campi</div>';
                }
            }

            ?>
            <?php

            if (isset($_GET['error'])) {
                if ($_GET['error'] == 'none') {
                    echo '<div class="alert alert-success my-2">Dati aggiornati <b>correttamente</b></div>';
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