<?php

namespace App\Controllers;

use App\Models\TeacherModel;
use App\Utilities\Jwt;

ini_set('display_errors', 1);

class TeacherController {
    private $teacherModel;

    public function __construct () {
        $this->teacherModel = new TeacherModel();
    }

    public function getInfoFromJwt () {
        $payload = Jwt::getInfo($_POST['token']);
        $id = str_replace("\\", "", explode('"', explode('_', $payload)[1])[0]);
        // echo "tc_$id";
        $this->teacherModel->setId("tc_$id");
        echo json_encode($this->teacherModel->getTeacherById());
    }

    public function updateTeacher () {
        $headers = getallheaders();
        $token = explode(' ', $headers['Authorization'])[1];
        if (!Jwt::checkToken($token)) {
            echo json_encode(array('message' => 'token not valid'));
            return;
        }

        $name = htmlspecialchars($_POST['name']);
        $surname = htmlspecialchars($_POST['surname']);
        $email = htmlspecialchars($_POST['email']);

        // $password = password_hash($password, PASSWORD_BCRYPT);
        $this->teacherModel->setEmail($email);
        $this->teacherModel->updateInfo($name, $surname);

        echo json_encode(array('message' => 'ok'));
    }

    public function editPassword () {
        $headers = getallheaders();
        $token = explode(' ', $headers['Authorization'])[1];
        if (!Jwt::checkToken($token)) {
            echo json_encode(array('message' => 'token not valid'));
            return;
        }

        $email = htmlspecialchars($_POST['email']);
        $password = password_hash(htmlspecialchars($_POST['password']), PASSWORD_BCRYPT);

        /*$this->studentModel->setPassword($password);
        $this->studentModel->setEmail($email);

        if ($this->studentModel->GetStudentByEmailAndPassword()) {
            
        }*/

        $this->teacherModel->setEmail($email);
        $this->teacherModel->setPassword($password);
        if ($this->teacherModel->editPassword()) {
            echo json_encode(array('message' => 'ok'));
        } else {
            echo json_encode(array('message' => 'error'));
        }
    }

    public function Signup () {
        $id = uniqid('tc_');
        $name = htmlspecialchars($_POST['name']);
        $surname = htmlspecialchars($_POST['surname']);
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        $password = password_hash($password, PASSWORD_BCRYPT);

        // $query = "INSERT INTO $table (student_id, name, surname, email, password) VALUES ('$id', '$cleanName', '$cleanSurname', '$cleanEmail', '$cleanPassword');";

        $this->teacherModel->setId($id);
        $this->teacherModel->setName($name);
        $this->teacherModel->setSurname($surname);
        $this->teacherModel->setEmail($email);
        $this->teacherModel->setPassword($password);
        $this->teacherModel->setActivationCode(uniqid());
        $result = $this->teacherModel->addTeacher();
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

        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);

        $this->teacherModel->setEmail($email);
        $this->teacherModel->setPassword($password);

        if ($this->teacherModel->getTeacherByEmailAndPassword()) {
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
        if (isset($_GET['id']) && isset($_GET['activation_code'])) {
            $id = htmlspecialchars($_GET['id']);
            $activation_code = htmlspecialchars($_GET['activation_code']);
            $this->teacherModel->setId($id);
            $this->teacherModel->setActivationCode($activation_code);
            if ($this->teacherModel->enableAccount()) {
                echo '<h4>Operazione avvenuta con successo</h4>';
            } else {
                echo '<h4>ID e/o Codice di attivazione non validi</h4>';
            }
        } else {
            echo '<h4>Dati di attivazione non validi<br>Controlla il link sulla tua mail</h4>';
        }
    }

    public function subscribeToClass () {
        $headers = getallheaders();
        $token = explode(' ', $headers['Authorization'])[1];
        if (!Jwt::checkToken($token)) {
            echo json_encode(array('message' => 'token not valid'));
            return;
        }

        $this->teacherModel->setId(htmlspecialchars($_POST['teacher_id']));
        if ($this->teacherModel->subscribeToClass(htmlspecialchars($_POST['class_id']))) {
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

        $this->teacherModel->setId(htmlspecialchars($_POST['teacher_id']));
        if ($this->teacherModel->unsubscribeFromClass(htmlspecialchars($_POST['class_id']))) {
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
        
        $this->teacherModel->setId(htmlspecialchars($_POST['teacher_id']));
        $result = $this->teacherModel->getClasses();
        echo json_encode($result);
    }
}

?>