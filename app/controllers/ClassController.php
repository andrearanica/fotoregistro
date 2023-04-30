<?php

namespace App\controllers;

use App\models\ClassModel;

class ClassController {
    private $classModel;

    public function __construct () {
        $this->classModel = new ClassModel();
    }

    public function newClass () {
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
        $class_id = $_POST['class_id'];
        $this->classModel->setId($class_id);
        if ($this->classModel->removeClass()) {
            $return = json_encode(array('message' => 'ok'));
        } else {
            $return = json_encode(array('message' => 'ok'));
        }
        echo $return;
    }
}

?>