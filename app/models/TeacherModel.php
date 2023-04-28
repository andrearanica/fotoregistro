<?php

namespace App\models;

class StudentModel {
    private $connection;

    public $teacher_id;
    public $name;
    public $surname;
    public $email;
    public $enabled;

    public function __construct () {
        $this->connection = new \mysqli('127.0.0.1', 'root', '', 'my_andrearanica');
    }

    public function updateInfo ($name, $surname, $email, $password) {
        $query = "UPDATE students SET name='$name', surname='$surname', password='$password' WHERE email='$email';";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
    }

    public function AddStudent ($id, $name, $surname, $email, $password): bool {
        $password = password_hash($password, PASSWORD_BCRYPT);
        $query = "INSERT INTO students (student_id, name, surname, email, password) VALUES ('$id', '$name', '$surname', '$email', '$password');";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        if ($stmt->error) {
            return 0;
        } else {
            return 1;
        }
    }

    public function GetStudentByEmailAndPassword ($email, $password): bool {
        $query = "SELECT * FROM students WHERE email='$email';";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if (password_verify($password, $row['password'])) {
                    $this->student_id = $row['student_id'];
                    $this->name = $row['name'];
                    $this->surname = $row['surname'];
                    $this->email = $row['email'];
                    $this->enabled = $row['enabled'];
                    return 1;
                } else {
                    return 0;
                }
            }
        } 
        return 0;
    }

    public function subscribeToClass ($student_id, $class_id) {
        $query = "UPDATE students SET class_id='$class_id' WHERE student_id='$student_id'";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
    }

    public function unsubscribeFromClass ($student_id) {
        $query = "UPDATE students SET class_id=null WHERE student_id='$student_id';";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
    }

    public function uploadPhoto ($student_id) {
        $query = "UPDATE students SET photo=1 WHERE student_id='$student_id';";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
    }

    public function removePhoto ($student_id) {
        $query = "UPDATE students SET photo=0 WHERE student_id='$student_id';";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
    }

    public function enableAccount ($student_id) {
        $query = "UPDATE students SET enabled=1 WHERE student_id='$student_id'";
        $this->connection->query($query);
        $query = "UPDATE teachers SET enabled=1 WHERE teacher_id='$student_id'";
        $this->connection->query($query);
    }
}

?>