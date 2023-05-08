<?php

namespace App\controllers;


use App\utilities\Jwt;
use App\models\StudentModel;

ini_set('display_errors', 1);

class StudentController {
    private $studentModel;

    public function __construct () {
        $this->studentModel = new StudentModel();
    }

    public function updateStudent () {
        $headers = getallheaders();
        $token = explode(' ', $headers['Authorization'])[1];
        if (!Jwt::checkToken($token)) {
            echo json_encode(array('message' => 'token not valid'));
            return;
        }
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $password = password_hash($password, PASSWORD_BCRYPT);
        $this->studentModel->setEmail($email);
        $this->studentModel->updateInfo($name, $surname, $password);

        echo json_encode(array('message' => 'ok'));
    }

    public function Signup () {
        $id = uniqid('st_');
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password = password_hash($password, PASSWORD_BCRYPT);

        // $query = "INSERT INTO $table (student_id, name, surname, email, password) VALUES ('$id', '$cleanName', '$cleanSurname', '$cleanEmail', '$cleanPassword');";

        $this->studentModel->setId($id);
        $this->studentModel->setName($name);
        $this->studentModel->setSurname($surname);
        $this->studentModel->setEmail($email);
        $this->studentModel->setPassword($password);
        $result = $this->studentModel->AddStudent();

        $headers = "MIME-Version: 1.0" . "\r\n"; 
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 
        // mail($email, 'Benvenuto su fotoregistro', "Ciao $name! Per confermare il tuo account clicca <a href='andrearanica.altervista.org/fotoregistro/public/enable-account-student?id=$id'>questo link</a>", $headers);

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

        $this->studentModel->setEmail($email);
        $this->studentModel->setPassword($password);

        if ($this->studentModel->GetStudentByEmailAndPassword()) {
            if ($this->studentModel->getEnabled()) {
                $headers = array('alg' => 'HS256', 'typ' => 'JWT');
                $payload = array('id' => $this->studentModel->getId(), 'name' => $this->studentModel->getName(), 'surname' => $this->studentModel->getSurname(), 'email' => $this->studentModel->getEmail(), 'photo' => $this->studentModel->getPhoto(), 'class_id' => $this->studentModel->getClassId());
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
        $headers = getallheaders();
        $token = explode(' ', $headers['Authorization'])[1];
        if (!Jwt::checkToken($token)) {
            echo json_encode(array('message' => 'token not valid'));
            return;
        }

        $class_id = $_POST['class_id'];
        $student_id = $_POST['student_id'];

        $this->studentModel->setId($student_id);
        $this->studentModel->subscribeToClass($class_id);
        
        echo json_encode(array('message' => 'ok'));
    }

    public function unsubscribeFromClass () {
        $headers = getallheaders();
        $token = explode(' ', $headers['Authorization'])[1];
        if (!Jwt::checkToken($token)) {
            echo json_encode(array('message' => 'token not valid'));
            return;
        }

        $student_id = $_POST['student_id'];
        $this->studentModel->setId($student_id);
        $this->studentModel->unsubscribeFromClass();
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
        
        $this->studentModel->setId($student_id);
        $this->studentModel->uploadPhoto();
    
        header('Location: student');
    }

    public function savePhoto () {
        $headers = getallheaders();
        $token = explode(' ', $headers['Authorization'])[1];
        if (!Jwt::checkToken($token)) {
            echo json_encode(array('message' => 'token not valid'));
            return;
        }

        define('UPLOAD_DIR', '../app/photos/');
        $student_id = $_POST['student_id'];
        $image_parts = explode(';base64,', $_POST['photo']);
        $image_base64 = base64_decode($image_parts[1]);
        $file = UPLOAD_DIR . "$student_id.png";
        file_put_contents($file, $image_base64);
        
        $this->studentModel->setId($student_id);
        $this->studentModel->uploadPhoto();
    }

    public function removePhoto () {
        $headers = getallheaders();
        $token = explode(' ', $headers['Authorization'])[1];
        if (!Jwt::checkToken($token)) {
            echo json_encode(array('message' => 'token not valid'));
            return;
        }

        $student_id = $_POST['student_id'];
        unlink("..app/photos/$student_id.png");
        $this->studentModel->setId($student_id);
        $this->studentModel->removePhoto();
    }

    public function enableAccount () {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $this->studentModel->setId($id);
            $this->studentModel->enableAccount();
            echo '
            <div class="container my-5 text-center">
                <h1>Account correttamente abilitato</h1>
                <p>Ritorna alla pagina di <a href="/">login</a></p>
            </div>
            ';
        } else {
            echo '
            <div class="">
                <h1>Link non valido, torna alla pagina di <a href="./">login</a></h1>
            </div>
            ';
        }
    }

    public function getStudentById () {
        $headers = getallheaders();
        $token = explode(' ', $headers['Authorization'])[1];
        if (!Jwt::checkToken($token)) {
            echo json_encode(array('message' => 'token not valid'));
            return;
        }

        $this->studentModel->setId($_POST['student_id']);
        $result = $this->studentModel->getStudentById();
        echo json_encode($result);
    }
}

?>