<?php

namespace App\controllers;

use App\models\StudentModel;

ini_set('display_errors', 1);

class StudentController {
    private $studentModel;

    public function __construct () {
        $this->studentModel = new StudentModel();
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
        mail($email, 'Benvenuto su fotoregistro', "Ciao $name! Per confermare il tuo account clicca <a href='andrearanica.altervista.org/fotoregistro/public/enableAccount?id=$id'>questo link</a>", $headers);

        if ($result) {
            $response['message'] = 'ok';
            echo json_encode($response);
        } else {
            $response['message'] = 'errore';
            $message = json_encode($response);
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
}

?>