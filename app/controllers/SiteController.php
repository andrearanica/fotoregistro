<?php

namespace App\controllers;

ini_set('display_errors', 1);

class SiteController {
    public function LoginAndSignup () {
        require_once '../app/views/home.php';
    }
    public function StudentDashboard () {
        require_once '../app/views/student.php';
    }
    public function TeacherDashboard () {
        require_once '../app/views/teacher.php';
    }
    public function NotFound () {
        echo 'Notfound';
    }
    public function UploadPhoto () {
        require('connection.php');
        $student_id=$_POST['student_id'];
        unlink("../photos/$student_id.png");
        foreach ($_FILES as $file) {
            if (UPLOAD_ERR_OK === $file['error']) {
                $fileName = "$student_id.png";
                move_uploaded_file($file['tmp_name'], "../app/photos/$fileName");
            }
        }
        $query = "UPDATE students SET photo=1 WHERE student_id='$student_id';";
        $stmt = $connection->prepare($query);
        $stmt->execute();
    
        header('Location: student');
    }
    public function EnableAccount () {
        ini_set('display_errors', 1);
        $id = $_GET['id'];
        require('connection.php');
        $query = "UPDATE students SET enabled=1 WHERE student_id='$id'";
        $connection->query($query);
        $query = "UPDATE teachers SET enabled=1 WHERE teacher_id='$id'";
        $connection->query($query);
        echo 'Account correttamente abilitato. Torna alla pagina <a href="../public/index.html">Login</a>';
    }
}

?>