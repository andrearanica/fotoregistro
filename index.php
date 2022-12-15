<?php
session_start();
function clear(&$data) {
    $data = htmlspecialchars($data);
    $data = stripslashes($data);
    $data = trim($data);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <style>
            .container {
                margin: auto;
                width: 50%;
                border-radius: 9px;
                border: 2px solid black;
                padding: 80px;
                background-color: white;
            }
            body {
                background-image: url("wallpaper.jpg");
            }
        </style>
    </head>
    <body>
        <div class="container my-5 text-center">
            <h1>🎒 Fotoregistro</h1>
            <div id="form" class="my-4"></div>
            <hr>
            <button id="changeForm" class="form-control">Non sei registrato?</button>
            <?php
            
            $ip = '127.0.0.1';
            $username = 'root';
            $pwd = '';
            $database = 'test';
            $connection = new mysqli($ip, $username, $pwd, $database);
            if (isset($_POST['class'])) {
                // Signup
                $name = $_POST['name'];
                $surname = $_POST['surname'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $class = $_POST['class'];
                clear($name);
                clear($surname);
                clear($email);
                clear($password);
                clear($class);

                if ($name == "" || $surname == "" || $email == "" || $password == "") {
                    header('Location: index.php?error=emptyinput');
                }
                if (preg_match('/[1-5][A-Z][A-Z]/', $_POST['class'])) {
                    $sql = 'INSERT INTO users (name, surname, email, password, class, role) VALUES
                    ("' . $_POST['name'] .'", "' . $_POST['surname'] . '", "' . $_POST['email'] . '", "' . md5($_POST['password']) . '", "' . $_POST['class'] . '", 0);';
                    if ($connection->query($sql)) {
                        header('Location: index.php?error=none');
                    }
                } else {
                    header('Location: index.php?error=invalidclass');
                }

            } else if(isset($_POST['email'])) {
                // Login DB --> id, name, surname, email, password, class
                if ($_POST['email'] == "" || $_POST['password'] == "") {
                    header('Location: index.php?error=emptyinput');
                }
                $email = $_POST['email'];
                $password = $_POST['password'];
                clear($email);
                clear($password);
                $sql = 'SELECT * FROM users WHERE email="' . $email . '" AND password="' . md5($password) . '";';

                $response = $connection->query($sql);
                if ($response->num_rows > 0) {
                    $data = $response->fetch_array();
                    $_SESSION['name'] = $data['name'];
                    $_SESSION['surname'] = $data['surname'];
                    $_SESSION['email'] = $data['email'];
                    $_SESSION['class'] = $data['class'];
                    $_SESSION['role'] = $data['role'];
                    header('Location: dashboard.php');
                } else {
                    echo '<div class="alert alert-danger my-4">Credenziali sbagliate</div>';
                }

            } else if (isset($_GET['error'])) {
                if ($_GET['error'] == "none") {
                    echo ' <div class="alert my-4 alert-success">Registrazione effettuata con <b>successo</b></div> ';
                } else if ($_GET['error'] == 'emptyinput') {
                    echo '<div class="alert alert-danger my-4">Controlla di avere inserito <b>ogni dato</b></div>';
                } else if ($_GET['error'] == "noclass") {
                    echo '<div class="alert alert-danger my-4">La tua classe non è ancora <b>iscritta</b></div>';
                } else if ($_GET['error'] == "invalidclass") {
                    echo '<div class="alert alert-danger my-4">Formato classe non supportato, inserisci una classe del tipo <b>[A-Z][A-Z][1-5]</b></div>';
                } 
            }

            $connection->close();
            ?>
            <script src="script.js"></script>
        </div>
    </body>
</html>

<!--$sql = 'CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    surname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    class VARCHAR(255) NOT NULL
);';-->