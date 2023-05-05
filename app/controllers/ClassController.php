<?php

namespace App\controllers;

use App\models\ClassModel;
use App\utilities\Jwt;

class ClassController {
    private $classModel;

    public function __construct () {
        $this->classModel = new ClassModel();
    }

    public function newClass () {
        $headers = getallheaders();
        $token = explode(' ', $headers['Authorization'])[1];
        if (!Jwt::checkToken($token)) {
            echo json_encode(array('message' => 'token not valid'));
            return;
        }

        $class_name = $_POST['class_name'];
        $this->classModel->setName($class_name);
        $this->classModel->setId(uniqid('cl_'));
        
        $teacher_id = $_POST['teacher_id'];
        if ($this->classModel->addClass($teacher_id)) {
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

        $class_id = $_POST['class_id'];
        $this->classModel->setId($class_id);
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

        $this->classModel->setId($_POST['class_id']);
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

        $this->classModel->setId($_POST['class_id']);
        $response = $this->classModel->getStudents();
        echo json_encode($response);
    }

    public function printPdf () {
        $headers = getallheaders();
        $token = explode(' ', $headers['Authorization'])[1];
        if (!Jwt::checkToken($token)) {
            echo json_encode(array('message' => 'token not valid'));
            return;
        }
        
        require('../app/fpdf/fpdf.php');
        $pdf = new \FPDF();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(100, 0, 'ciao');
        $pdf->Output();
    }
}

?>