<?php

namespace App\models;

class StudentModel {
    private $connection;

    private $student_id;
    private $name;
    private $surname;
    private $photo;
    private $class_id;
    private $email;
    private $password;
    private $enabled;

    public function __construct () {
        $this->connection = new \mysqli('127.0.0.1', 'root', '', 'my_andrearanica');
    }

    public function getId () {
        return $this->student_id;
    }

    public function getName () {
        return $this->name;
    }

    public function getSurname () {
        return $this->surname;
    }

    public function getPhoto () {
        return $this->photo;
    }

    public function getClassId () {
        return $this->class_id;
    }

    public function getEmail () {
        return $this->email;
    }

    public function getPassword () {
        return $this->password;
    }

    public function getEnabled () {
        return $this->enabled;
    }

    public function setId ($id) {
        $this->student_id = $id;
    }

    public function setName ($name) {
        $this->name = $name;
    }

    public function setSurname ($surname) {
        $this->surname = $surname;
    }

    public function setPhoto ($photo) {
        $this->photo = $photo;
    }

    public function setClassId ($class_id) {
        $this->class_id = $class_id;
    } 

    public function setEmail ($email) {
        $this->email = $email;
    }

    public function setPassword ($password) {
        $this->password = $password;
    }

    public function setEnabled ($enabled) {
        $this->enabled = $enabled;
    }

    public function updateInfo ($name, $surname, $password) {
        $password = password_hash($password, PASSWORD_BCRYPT);
        $query = "UPDATE students SET name='$name', surname='$surname', password='$password' WHERE email='$this->email';";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
    }

    public function AddStudent (): bool {
        $id = uniqid('st_');
        $password = password_hash($this->password, PASSWORD_BCRYPT);
        $query = "INSERT INTO students (student_id, name, surname, email, password) VALUES ('$this->student_id', '$this->name', '$this->surname', '$this->email', '$this->password');";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        if ($stmt->error) {
            return 0;
        } else {
            return 1;
        }
    }

    public function GetStudentByEmailAndPassword (): bool {
        $query = "SELECT * FROM students WHERE email='$this->email';";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if (password_verify($this->password, $row['password'])) {
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

    public function subscribeToClass ($class_id) {
        $query = "UPDATE students SET class_id='$class_id' WHERE student_id='$this->student_id'";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
    }

    public function unsubscribeFromClass () {
        $query = "UPDATE students SET class_id=null WHERE student_id='$this->student_id';";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
    }

    public function uploadPhoto () {
        $query = "UPDATE students SET photo=1 WHERE student_id='$this->student_id';";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
    }

    public function removePhoto () {
        $query = "UPDATE students SET photo=0 WHERE student_id='$this->student_id';";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
    }

    public function enableAccount (): bool {
        $this->connection->begin_transaction();
        try {
            $query = "UPDATE students SET enabled=1 WHERE student_id='$this->student_id'";
            $this->connection->query($query);
            return true;
        } catch (\mysqli_sql_exception $exception) {
            return false;
        }
    }

    public function getStudentById (): array {
        $this->connection->begin_transaction();
        try {
            $query = "SELECT * FROM students WHERE student_id='$this->student_id';";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $return = $row;
                }
            } else {
                $return = array();
            }

            $this->connection->commit();
            return $return;
        } catch (\mysqli_sql_exception $exception) {
            $this->connection->rollback();
            return array();
        }
    }
}

?>  