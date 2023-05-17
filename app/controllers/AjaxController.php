<?php

namespace App\controllers;
class AjaxController {
    public function HandleRequest () {
        $request = $_GET['request'];
        switch ($request) {
            case 'infoFromJwt':
                require_once 'jwt.php';
                break;
            case 'class':
                require('connection.php');
                require('checkToken.php');

                if ($connection) {
                    
                } else {
                    die;
                }

                if (isset($_GET['students'])) {
                    $classId = $_GET['class_id'];
                    $query = "SELECT * FROM students WHERE class_id='$classId' ORDER BY surname ASC;";
                } else if (isset($_GET['teacher_id'])) {  
                    $teacherId = $_GET['teacher_id'];
                    $query = "SELECT * FROM teaches INNER JOIN classes ON classes.class_id=teaches.class_id WHERE teacher_id='$teacherId'";
                } else if (isset($_GET['class_id'])) {
                    $classId = $_GET['class_id'];
                    $query = "SELECT * FROM classes WHERE class_id='$classId'";  
                } else {
                    $query = "SELECT * FROM classes";
                }
                $stmt = $connection->prepare($query);
                $stmt->execute();
                $result = $stmt->get_result();

                // var_dump($result);

                $array = array();
                $n = 0;

                while ($row = $result->fetch_assoc()) {
                    $array[$n] = $row;
                    $n++;
                }

                if (isset($_GET['class_id'])) {
                    $class_id = $_GET['class_id'];
                    $query = "SELECT * FROM teachers JOIN teaches ON teachers.teacher_id=teaches.teacher_id WHERE teaches.class_id='$class_id';";
                    $stmt = $connection->prepare($query);
                    $stmt->execute();
                    $row = $result->fetch_assoc();
                }

                echo json_encode($array);
                break;
            case 'subscribe':
                include('connection.php');
                include('checkToken.php');

                $classId = $_POST['classId'];
                $studentId = $_POST['studentId'];

                $query = "UPDATE students SET class_id='$classId' WHERE student_id='$studentId'";
                $stmt = $connection->prepare($query);
                $stmt->execute();

                $query = "SELECT * FROM classes WHERE class_id='$classId';";
                $stmt = $connection->prepare($query);
                $stmt->execute();

                $result = $stmt->get_result();

                echo json_encode(array('message' => 'ok', 'info' => $result->fetch_assoc()));
                break;
            case 'new-class':
                ini_set('display_errors', 1);

                require('connection.php');

                $teacherId = $_POST['teacherId'];
                $classId = uniqid('cl_');
                $className = $_POST['className'];
                $classAccessType = $_POST['classAccessType'];

                $query = "INSERT INTO classes (class_id, class_name, access_type) VALUES ('$classId', '$className', $classAccessType);";
                $stmt = $connection->prepare($query);

                $stmt->execute();
                $result = $stmt->get_result();

                $query = "INSERT INTO teaches (teacher_id, class_id) VALUES ('$teacherId', '$classId');";

                $stmt = $connection->prepare($query);
                $stmt->execute();



                echo json_encode(array('message' => 'class created')); 
                break;
            case 'add-teacher-to-class':
                ini_set('display_errors', 1);
                include('connection.php');

                $teacher_id = $_POST['teacher_id'];
                $class_id = $_POST['class_id'];

                $query = "INSERT INTO teaches VALUES ('$class_id', '$teacher_id')";
                $stmt = $connection->prepare($query);
                $stmt->execute();

                echo json_encode(array('message' => 'ok'));
                break;
            case 'student':
                $student_id = $_GET['student_id'];

                require('connection.php');
                require('checkToken.php');

                $query = "SELECT * FROM students WHERE student_id='$student_id'";
                $stmt = $connection->prepare($query);
                $stmt->execute();

                $result = $stmt->get_result();
                $result = $result->fetch_assoc();

                echo json_encode($result);
        }
    }
}

?>