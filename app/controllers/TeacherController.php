<?php

namespace App\controllers;

use App\models\TeacherModel;
use App\utilities\Jwt;

ini_set('display_errors', 1);

class TeacherController {
    private $teacherModel;

    public function __construct () {
        $this->teacherModel = new TeacherModel();
    }

    public function updateTeacher () {
        $headers = getallheaders();
        $token = explode(' ', $headers['Authorization'])[1];
        if (!Jwt::checkToken($token)) {
            echo json_encode(array('message' => 'token not valid'));
            return;
        }

        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $email = $_POST['email'];

        // $password = password_hash($password, PASSWORD_BCRYPT);
        $this->teacherModel->setEmail($email);
        $this->teacherModel->updateInfo($name, $surname);

        echo json_encode(array('message' => 'ok'));
    }

    public function Signup () {
        $id = uniqid('tc_');
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password = password_hash($password, PASSWORD_BCRYPT);

        // $query = "INSERT INTO $table (student_id, name, surname, email, password) VALUES ('$id', '$cleanName', '$cleanSurname', '$cleanEmail', '$cleanPassword');";

        $this->teacherModel->setId($id);
        $this->teacherModel->setName($name);
        $this->teacherModel->setSurname($surname);
        $this->teacherModel->setEmail($email);
        $this->teacherModel->setPassword($password);
        $this->teacherModel->setActivationCode(uniqid());
        $result = $this->teacherModel->AddTeacher();
        $activation_code = $this->teacherModel->getActivationCode();

        $headers = "MIME-Version: 1.0" . "\r\n"; 
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 
        // mail($email, 'Benvenuto su fotoregistro', "Ciao $name! Per confermare il tuo account clicca <a href='andrearanica.altervista.org/fotoregistro/public/enable-account-teacher?id=$id&activation_code=$activation_code'>questo link</a>", $headers);

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

        $email = $_POST['email'];
        $password = $_POST['password'];

        $this->teacherModel->setEmail($email);
        $this->teacherModel->setPassword($password);

        if ($this->teacherModel->GetTeacherByEmailAndPassword()) {
            if ($this->teacherModel->getEnabled()) {
                $headers = array('alg' => 'HS256', 'typ' => 'JWT');
                $payload = array('id' => $this->teacherModel->getId(), 'name' => $this->teacherModel->getName(), 'surname' => $this->teacherModel->getSurname(), 'email' => $this->teacherModel->getEmail());
                $message['message'] = Jwt::createToken($headers, $payload);
            } else {
                $message['message'] = 'user not enabled';   
            }
        } else {
            $message['message'] = 'user not found';
        }

        echo json_encode($message);
    }

    public function enableAccount () {
        $id = $_GET['id'];
        $this->teacherModel->setId($id);
        $this->teacherModel->enableAccount();
        echo 'Account correttamente abilitato. Torna alla pagina <a href="../public/index.html">Login</a>';
    }

    public function subscribeToClass () {
        $headers = getallheaders();
        $token = explode(' ', $headers['Authorization'])[1];
        if (!Jwt::checkToken($token)) {
            echo json_encode(array('message' => 'token not valid'));
            return;
        }

        $this->teacherModel->setId($_POST['teacher_id']);
        if ($this->teacherModel->subscribeToClass($_POST['class_id'])) {
            $message = json_encode(array('message' => 'ok'));
        } else {
            $message = json_encode(array('message' => 'error'));
        }
        echo $message;
    }

    public function unsubscribeFromClass () {
        $headers = getallheaders();
        $token = explode(' ', $headers['Authorization'])[1];
        if (!Jwt::checkToken($token)) {
            echo json_encode(array('message' => 'token not valid'));
            return;
        }

        $this->teacherModel->setId($_POST['teacher_id']);
        if ($this->teacherModel->unsubscribeFromClass($_POST['class_id'])) {
            $message = json_encode(array('message' => 'ok'));
        } else {
            $message = json_encode(array('message' => 'error'));
        }
        echo $message;
    }

    public function getClasses () {
        $headers = getallheaders();
        $token = explode(' ', $headers['Authorization'])[1];
        if (!Jwt::checkToken($token)) {
            echo json_encode(array('message' => 'token not valid'));
            return;
        }
        
        $this->teacherModel->setId($_POST['teacher_id']);
        $result = $this->teacherModel->getClasses();
        echo json_encode($result);
    }
}

?>