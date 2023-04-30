<?php

namespace App\controllers;

use App\models\ClassModel;

ini_set('display_errors', 1);

class ClassController {
    private $classModel;

    public function __construct () {
        $this->classModel = new ClassModel();
    }

    public function newClass () {
        $teacher_id = $_POST['teacher_id'];
    }
}

?>