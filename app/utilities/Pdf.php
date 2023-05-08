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
        $i = 0; $x = 10; $y = 60;
        foreach ($this->classModel->getStudents() as $student) {
            $id = $student['student_id']; $name = $student['name']; $surname = $student['surname'];
            if ($student['photo'] == 1){
                $this->Image("../app/photos/$id.png", $x, $y, 30); 
            }
            $this->Text($x, $y + 35, "$name $surname");
            $this->Ln(0);
            $i++;

            if ($x == 170) {
                $x = 10;
                $y += 10;
            }
            $x += 80;
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