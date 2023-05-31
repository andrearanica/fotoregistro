<?php

namespace App\controllers;

use App\models\ClassModel;
use App\utilities\Jwt;
use App\utilities\Pdf;

class ClassController {
    private $classModel;

    public function __construct () {
        $this->classModel = new ClassModel();
    }

    /**
     * Inserts a new class on the database
     * 
     * @return void
     */
    public function newClass (): void {
        $headers = getallheaders();
        $token = explode(' ', $headers['Authorization'])[1];
        if (!Jwt::checkToken($token)) {
            echo json_encode(array('message' => 'token not valid'));
            return;
        }

        $this->classModel->setName(htmlspecialchars($_POST['class_name']));
        $this->classModel->setId(uniqid('cl_'));
        
        if ($this->classModel->addClass(htmlspecialchars($_POST['teacher_id']))) {
            echo json_encode(array('message' => 'ok'));
        } else {
            echo json_encode(array('message' => 'error'));
        }
    }

    public function editClass () {
        $headers = getallheaders();
        $token = explode(' ', $headers['Authorization'])[1];
        if (!Jwt::checkToken($token)) {
            echo json_encode(array('message' => 'token not valid'));
            return;
        }

        $this->classModel->setId(htmlspecialchars($_POST['class_id']));
        $this->classModel->setName(htmlspecialchars($_POST['class_name']));
        
        if ($this->classModel->editClass()) {
            echo json_encode(array('message' => 'ok'));
        } else {
            echo json_encode(array('message' => 'error'));
        }
    }

    public function removeClass () {
        $headers = getallheaders();
        $token = explode(' ', $headers['Authorization'])[1];
        if (!Jwt::checkToken($token)) {
            echo json_encode(array('message' => 'token not valid'));
            return;
        }

        $this->classModel->setId(htmlspecialchars($_POST['class_id']));
        if ($this->classModel->removeClass()) {
            $return = json_encode(array('message' => 'ok'));
        } else {
            $return = json_encode(array('message' => 'ok'));
        }
        echo $return;
    }

    public function getClassFromId () {
        $headers = getallheaders();
        $token = explode(' ', $headers['Authorization'])[1];
        if (!Jwt::checkToken($token)) {
            echo json_encode(array('message' => 'token not valid'));
            return;
        }

        $this->classModel->setId(htmlspecialchars($_POST['class_id']));
        $response = $this->classModel->getClassFromId();
        echo json_encode($response);
    }

    public function getStudents () {
        $headers = getallheaders();
        $token = explode(' ', $headers['Authorization'])[1];
        if (!Jwt::checkToken($token)) {
            echo json_encode(array('message' => 'token not valid'));
            return;
        }

        $this->classModel->setId(htmlspecialchars($_POST['class_id']));
        $response = $this->classModel->getStudents();
        echo json_encode($response);
    }

    public function getBannedStudents () {
        $headers = getallheaders();
        $token = explode(' ', $headers['Authorization'])[1];
        if (!Jwt::checkToken($token)) {
            echo json_encode(array('message' => 'token not valid'));
            return;
        }

        $this->classModel->setId(htmlspecialchars($_POST['class_id']));
        $response = $this->classModel->getBannedStudents();
        echo json_encode($response);
    }

    public function getTeachers () {
        $headers = getallheaders();
        $token = explode(' ', $headers['Authorization'])[1];
        if (!Jwt::checkToken($token)) {
            echo json_encode(array('message' => 'token not valid'));
            return;
        }

        $this->classModel->setId(htmlspecialchars($_POST['class_id']));
        $response = $this->classModel->getTeachers();
        echo json_encode($response);
    }
}

?>