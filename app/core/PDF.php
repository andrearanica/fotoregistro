<?php

namespace App\core;
use App\models\ClassModel;

require_once '../app/fpdf/fpdf.php';

class PDF extends \FPDF {
    private $class_name;

    public function setClassName ($class_name) {
        $this->class_name = $class_name;
    }

    function printPage () {
        $this->AddPage();
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 6, 'Ciao', 0, 1, 'L', true);
    }
} 

?>