<?php

namespace App\controllers;
class AjaxController {
    public function HandleRequest () {
        $request = $_GET['request'];
        switch ($request) {
            case 'login':
                ini_set('display_errors', 1);
                require('./clearInput.php');

                require('connection.php');
                require('jwt.php');

                if ($connection) {
                    
                } else {
                    die;
                }

                $email = $_POST['email'];
                $password = $_POST['password'];

                $cleanEmail = clean($email);
                $cleanPassword = clean($password);

                if ($_GET['type'] == 'students') {
                    $table = 'students';    
                } else {
                    $table = 'teachers';
                }

                $query = "SELECT * FROM $table WHERE email='$cleanEmail';";

                $stmt = $connection->prepare($query);
                $stmt->execute();

                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        if (password_verify($cleanPassword, $row['password'])) {
                            if ($row['enabled'] == true) {
                                $headers = array('alg' => 'HS256', 'typ' => 'JWT');
                                if ($_GET['type'] == 'students') {
                                    $payload = array('id' => $row['student_id'], 'name' => $row['name'], 'surname' => $row['surname'], 'email' => $row['email'], 'photo' => $row['photo'], 'class_id' => $row['class_id']);
                                } else {
                                    $payload = array('id' => $row['teacher_id'], 'name' => $row['name'], 'surname' => $row['surname'], 'email' => $row['email']);
                                }
                                $message['message'] = jwt($headers, $payload);
                            } else {
                                $message['message'] = 'user not enabled';   
                            }
                            echo json_encode($message);
                        } else {
                            $message['message'] = 'user not found'; 
                            echo json_encode($message); 
                        }
                    }
                } else {
                    $response['message'] = 'user not found';
                    echo json_encode($response);
                }
                break;
            case 'signup':
                ini_set('display_errors', 1);
                require('./clearInput.php');

                require('connection.php');

                if ($connection) {

                } else {
                    die;
                }

                $name = $_POST['name'];
                $surname = $_POST['surname'];
                $email = $_POST['email'];
                $password = $_POST['password'];

                $id = '0';

                $cleanName = clean($name);
                $cleanSurname = clean($surname);
                $cleanEmail = clean($email);
                $cleanPassword = clean($password);

                $cleanPassword = password_hash($cleanPassword, PASSWORD_BCRYPT);

                if ($_GET['type'] == 'students') {
                    $id = uniqid('st_');
                    $table = 'students';
                    $query = "INSERT INTO $table (student_id, name, surname, email, password) VALUES ('$id', '$cleanName', '$cleanSurname', '$cleanEmail', '$cleanPassword');";
                } else {
                    $id = uniqid('tc_');
                    $table = 'teachers';
                    $query = "INSERT INTO $table (teacher_id, name, surname, email, password) VALUES ('$id', '$cleanName', '$cleanSurname', '$cleanEmail', '$cleanPassword');";
                }



                // $query = "INSERT INTO $table (student_id, name, surname, email, password) VALUES ('$id', '$cleanName', '$cleanSurname', '$cleanEmail', '$cleanPassword');";

                $result = $connection->query($query);

                $headers = "MIME-Version: 1.0" . "\r\n"; 
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 
                // mail($email, 'Benvenuto su fotoregistro', "Ciao $name! Per confermare il tuo account clicca <a href='andrearanica.altervista.org/fotoregistro/php/enableAccount.php?id=$id'>questo link</a>", $headers);

                if ($result) {
                    $response['message'] = 'ok';
                    echo json_encode($response);
                } else {
                    $response['message'] = 'errore';
                    $message = json_encode($response);
                    die;
                } 
                break;
            case 'infoFromJwt':
                require_once 'jwt.php';
                break;
            case 'class':
                require('connection.php');
                require('checkToken.php');

                if ($connection) {
                    
                } else {
                    die;
                }

                if (isset($_GET['students'])) {
                    $classId = $_GET['class_id'];
                    $query = "SELECT * FROM students WHERE class_id='$classId' ORDER BY surname ASC;";
                } else if (isset($_GET['teacher_id'])) {  
                    $teacherId = $_GET['teacher_id'];
                    $query = "SELECT * FROM teaches INNER JOIN classes ON classes.class_id=teaches.class_id WHERE teacher_id='$teacherId'";
                } else if (isset($_GET['class_id'])) {
                    $classId = $_GET['class_id'];
                    $query = "SELECT * FROM classes WHERE class_id='$classId'";  
                } else {
                    $query = "SELECT * FROM classes";
                }
                $stmt = $connection->prepare($query);
                $stmt->execute();
                $result = $stmt->get_result();

                // var_dump($result);

                $array = array();
                $n = 0;

                while ($row = $result->fetch_assoc()) {
                    $array[$n] = $row;
                    $n++;
                }

                if (isset($_GET['class_id'])) {
                    $class_id = $_GET['class_id'];
                    $query = "SELECT * FROM teachers JOIN teaches ON teachers.teacher_id=teaches.teacher_id WHERE teaches.class_id='$class_id';";
                    $stmt = $connection->prepare($query);
                    $stmt->execute();
                    $row = $result->fetch_assoc();
                }

                echo json_encode($array);
                break;
            case 'remove-image':
                require('connection.php');
                $student_id = $_POST['student_id'];
                $query = "UPDATE students SET photo=0 WHERE student_id='$student_id';";
                $stmt = $connection->prepare($query);
                $stmt->execute();
                unlink("..app/photos/$student_id.png");
                break;
            case 'save-photo':
                define('UPLOAD_DIR', '../app/photos/');
                require('connection.php');
                $student_id = $_POST['student_id'];
                $image_parts = explode(';base64,', $_POST['photo']);
                $image_type_aux = explode('image/', $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $file = UPLOAD_DIR . "$student_id.png";
                file_put_contents($file, $image_base64);
                
                $query = "UPDATE students SET photo=1 WHERE student_id='$student_id';";
                $stmt = $connection->prepare($query);
                $stmt->execute();
                break;
            case 'subscribe':
                include('connection.php');
                include('jwt.php');
                include('checkToken.php');

                $classId = $_POST['classId'];
                $studentId = $_POST['studentId'];

                $query = "UPDATE students SET class_id='$classId' WHERE student_id='$studentId'";
                $stmt = $connection->prepare($query);
                $stmt->execute();

                $query = "SELECT * FROM classes WHERE class_id='$classId';";
                $stmt = $connection->prepare($query);
                $stmt->execute();

                $result = $stmt->get_result();

                echo json_encode(array('message' => 'ok', 'info' => $result->fetch_assoc()));
                break;
            case 'unsubscribe':
                require('connection.php');
                require('checkToken.php');

                $student_id = $_POST['student_id'];

                $query = "UPDATE students SET class_id=null WHERE student_id='$student_id';";
                $stmt = $connection->prepare($query);
                $stmt->execute();
                break;
            case 'new-class':
                ini_set('display_errors', 1);

                require('connection.php');

                $teacherId = $_POST['teacherId'];
                $classId = uniqid('cl_');
                $className = $_POST['className'];
                $classAccessType = $_POST['classAccessType'];

                $query = "INSERT INTO classes (class_id, class_name, access_type) VALUES ('$classId', '$className', $classAccessType);";
                $stmt = $connection->prepare($query);

                $stmt->execute();
                $result = $stmt->get_result();

                $query = "INSERT INTO teaches (teacher_id, class_id) VALUES ('$teacherId', '$classId');";

                $stmt = $connection->prepare($query);
                $stmt->execute();



                echo json_encode(array('message' => 'class created')); 
                break;
            case 'add-teacher-to-class':
                ini_set('display_errors', 1);
                include('connection.php');

                $teacher_id = $_POST['teacher_id'];
                $class_id = $_POST['class_id'];

                $query = "INSERT INTO teaches VALUES ('$class_id', '$teacher_id')";
                $stmt = $connection->prepare($query);
                $stmt->execute();

                echo json_encode(array('message' => 'ok'));
                break;   
            case 'update-account':
                require('connection.php');
                require('checkToken.php');

                $table = $_POST['type'];

                $name = $_POST['name'];
                $surname = $_POST['surname'];
                $email = $_POST['email'];
                $password = $_POST['password'];

                $password = password_hash($password, PASSWORD_BCRYPT);

                $query = "UPDATE $table SET name='$name', surname='$surname', password='$password' WHERE email='$email';";
                $stmt = $connection->prepare($query);
                $stmt->execute();

                echo json_encode(array('message' => 'ok'));    
                break;
            case 'student':
                $student_id = $_GET['student_id'];

                require('connection.php');
                require('checkToken.php');

                $query = "SELECT * FROM students WHERE student_id='$student_id'";
                $stmt = $connection->prepare($query);
                $stmt->execute();

                $result = $stmt->get_result();
                $result = $result->fetch_assoc();

                echo json_encode($result);
        }
    }
}

?>