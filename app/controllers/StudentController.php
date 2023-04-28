<?php

namespace App\controllers;

use App\models\StudentModel;

ini_set('display_errors', 1);

class StudentController {
    private $studentModel;

    public function __construct () {
        $this->studentModel = new StudentModel();
    }

    public function updateStudent () {
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $password = password_hash($password, PASSWORD_BCRYPT);

        $this->studentModel->updateInfo($name, $surname, $email, $password);

        echo json_encode(array('message' => 'ok'));
    }

    public function Signup () {
        ini_set('display_errors', 1);

        $id = uniqid('st_');
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // $query = "INSERT INTO $table (student_id, name, surname, email, password) VALUES ('$id', '$cleanName', '$cleanSurname', '$cleanEmail', '$cleanPassword');";

        $result = $this->studentModel->AddStudent($id, $name, $surname, $email, $password);

        $headers = "MIME-Version: 1.0" . "\r\n"; 
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 
        mail($email, 'Benvenuto su fotoregistro', "Ciao $name! Per confermare il tuo account clicca <a href='andrearanica.altervista.org/fotoregistro/public/enable-account-student?id=$id'>questo link</a>", $headers);

        if ($result) {
            $response['message'] = 'ok';
            echo json_encode($response);
        } else {
            $response['message'] = 'errore';
            $message = json_encode($response);
            echo json_encode($message);
            die;
        } 
    }

    public function Login () {
        ini_set('display_errors', 1);
        require('jwt.php');

        $email = $_POST['email'];
        $password = $_POST['password'];

        if ($this->studentModel->GetStudentByEmailAndPassword($email, $password)) {
            if ($this->studentModel->enabled) {
                $headers = array('alg' => 'HS256', 'typ' => 'JWT');
                $payload = array('id' => $this->studentModel->student_id, 'name' => $this->studentModel->name, 'surname' => $this->studentModel->surname, 'email' => $this->studentModel->email, 'photo' => $this->studentModel->photo, 'class_id' => $this->studentModel->class_id);
                $message['message'] = jwt($headers, $payload);
            } else {
                $message['message'] = 'user not enabled';   
            }
        } else {
            $message['message'] = 'user not found';
        }

        echo json_encode($message);
    }

    public function subscribeToClass () {
        include('jwt.php');

        $class_id = $_POST['class_id'];
        $student_id = $_POST['student_id'];

        $this->studentModel->subscribeToClass($student_id, $class_id);
        
        echo json_encode(array('message' => 'ok'));
    }

    public function unsubscribeFromClass () {
        $student_id = $_POST['student_id'];
        $this->studentModel->unsubscribeFromClass($student_id);
    }

    public function UploadPhoto () {
        $student_id = $_POST['student_id'];
        unlink("../app/photos/$student_id.png");
        foreach ($_FILES as $file) {
            if (UPLOAD_ERR_OK === $file['error']) {
                $fileName = "$student_id.png";
                move_uploaded_file($file['tmp_name'], "../app/photos/$fileName");
            }
        }
        
        $this->studentModel->uploadPhoto($student_id);
    
        header('Location: student');
    }

    public function savePhoto () {
        define('UPLOAD_DIR', '../app/photos/');
        $student_id = $_POST['student_id'];
        $image_parts = explode(';base64,', $_POST['photo']);
        $image_base64 = base64_decode($image_parts[1]);
        $file = UPLOAD_DIR . "$student_id.png";
        file_put_contents($file, $image_base64);
        
        $this->studentModel->uploadPhoto($student_id);
    }

    public function removePhoto () {
        require('connection.php');
        $student_id = $_POST['student_id'];
        unlink("..app/photos/$student_id.png");
        $this->studentModel->removePhoto($student_id);
    }

    public function enableAccount () {
        $id = $_GET['id'];
        $this->studentModel->enableAccount($id);
        echo 'Account correttamente abilitato. Torna alla pagina <a href="../public/index.html">Login</a>';
    }
}

?>