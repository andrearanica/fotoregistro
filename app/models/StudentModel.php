<?php

namespace App\models;

class StudentModel {
    private $connection;

    public $student_id;
    public $name;
    public $surname;
    public $photo;
    public $class_id;
    public $email;
    public $enabled;

    public function __construct () {
        $this->connection = new \mysqli('127.0.0.1', 'root', '', 'my_andrearanica');
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
        } else {
            return 0;
        }
    }
}

?>