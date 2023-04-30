<?php

namespace App\models;

class TeacherModel {
    private $connection;

    private $teacher_id;
    private $name;
    private $surname;
    private $email;
    private $password;
    private $enabled;

    public function __construct () {
        $this->connection = new \mysqli('127.0.0.1', 'root', '', 'my_andrearanica');
    }

    public function getId () {
        return $this->teacher_id;
    }

    public function getName () {
        return $this->name;
    }

    public function getSurname () {
        return $this->surname;
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
        $this->teacher_id = $id;
    }

    public function setName ($name) {
        $this->name = $name;
    }

    public function setSurname ($surname) {
        $this->surname = $surname;
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
        $query = "UPDATE teachers SET name='$name', surname='$surname', password='$password' WHERE email='$this->email';";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
    }

    public function AddTeacher (): bool {
        $id = uniqid('st_');
        $password = password_hash($this->password, PASSWORD_BCRYPT);
        $query = "INSERT INTO teachers (teacher_id, name, surname, email, password) VALUES ('$this->teacher_id', '$this->name', '$this->surname', '$this->email', '$this->password');";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        if ($stmt->error) {
            return 0;
        } else {
            return 1;
        }
    }

    public function GetTeacherByEmailAndPassword (): bool {
        $query = "SELECT * FROM teachers WHERE email='$this->email';";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if (password_verify($this->password, $row['password'])) {
                    $this->teacher_id = $row['teacher_id'];
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

    public function enableAccount () {
        $query = "UPDATE teachers SET enabled=1 WHERE teacher_id='$this->teacher_id'";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
    }

    public function subscribeToClass ($class_id) {
        $query = "INSERT INTO teaches (teacher_id, class_id) VALUES ('$this->teacher_id', '$class_id');";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        if ($stmt->error) {
            return 1;
        } else {
            return 0;
        }
    }
}

?>