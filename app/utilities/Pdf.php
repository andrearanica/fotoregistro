<?php

namespace App\utilities;

use App\models\ClassModel;

require_once '../app/fpdf/fpdf.php';

class Pdf extends \FPDF {
    private $classModel;

    public function __constructor () {
        $this->classModel = new ClassModel();
    }

    public function setClassModel ($classModel) {
        $this->classModel = $classModel;
    }

    private function getClassName () {
        $this->classModel->setName($this->classModel->getClassFromId()[0]['class_name']);
    }

    private function title () {
        $this->SetFont('Arial', 'B', 20); 
        $this->getClassName();
        $className = $this->classModel->getName();
        $this->Cell(190, 25, "CLASSE $className", 1, 0, 'C');
        $this->Ln(40);
    }

    private function printStudents () {
        $this->SetFont('Arial', '', 10);
        $i = 0; $x = 10; $y = 45;
        foreach ($this->classModel->getStudents() as $student) {
            $id = $student['student_id']; $name = $student['name']; $surname = $student['surname']; $photo_type = $student['photo_type'];
            if ($student['photo'] == 1 || $_GET['display'] == 'all'){
                if ($student['photo'] == 1) {
                    $this->Image("../app/photos/$id.$photo_type", $x, $y, 0, 35);
                } else {
                    $this->Image("../app/photos/user.png", $x, $y, 0, 35);
                }
                $this->Text($x, $y + 40, "$name $surname");
                $this->Ln(50);
                $i++;

                $x += 40;
                
                if ($x == 250) {
                    $x = 10;
                    $y += 55;
                }
            }
        }
    }

    public function print () {
        $this->AddPage();
        $this->title();
        $this->printStudents();
        $this->Output();
    }
}

?>