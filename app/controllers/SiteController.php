<?php

namespace App\Controllers;

ini_set('display_errors', 1);

class SiteController {
    public function HomePage () {
        require_once '../app/views/index.php';
    }
    public function LoginAndSignup () {
        require_once '../app/views/home.php';
    }
    public function StudentDashboard () {
        require_once '../app/views/student.php';
    }
    public function TeacherDashboard () {
        require_once '../app/views/teacher.php';
    }
    public function Class () {
        require_once '../app/views/class.php';
    }
    public function NotFound () {
        require_once '../app/views/404.php';
    }
    public function PDF () {
        require_once '../app/views/pdf.php';
    }
}

?>