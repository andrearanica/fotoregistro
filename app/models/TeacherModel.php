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
    private $activation_code;

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

    public function getActivationCode () {
        return $this->activation_code;
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

    public function setActivationCode ($activation_code) {
        $this->activation_code = $activation_code;
    }

    public function updateInfo ($name, $surname) {
        $this->connection->begin_transaction();
        try {
            $query = "UPDATE teachers SET name='$name', surname='$surname' WHERE email='$this->email';";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            $this->connection->commit();
            return 1;
        } catch (\mysqli_sql_exception $exception) {
            $this->connection->rollback();
            return 0;
        }
    }

    public function AddTeacher (): bool {
        $this->connection->begin_transaction();
        try {
            $query = "INSERT INTO teachers (teacher_id, name, surname, email, password, activation_code) VALUES ('$this->teacher_id', '$this->name', '$this->surname', '$this->email', '$this->password', '$this->activation_code');";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            $this->connection->commit();
            return 1;
        } catch (\mysqli_sql_exception $exception) {
            $this->connection->rollback();
            return 0;
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
        $this->connection->begin_transaction();
        try {
            $query = "UPDATE teachers SET enabled=1 WHERE teacher_id='$this->teacher_id'";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            $this->connection->commit();
            return 1;
        } catch (\mysqli_sql_exception $exception) {
            $this->connection->rollback();
            return 0;
        }
    }

    public function subscribeToClass ($class_id): bool {
        $this->connection->begin_transaction();
        try {
            $query = "INSERT INTO teaches (teacher_id, class_id) VALUES ('$this->teacher_id', '$class_id');";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            $this->connection->commit();
            return 1;
        } catch (\mysqli_sql_exception $exception) {
            $this->connection->rollback();
            return 0;
        }
    }

    public function unsubscribeFromClass ($class_id): bool {
        $this->connection->begin_transaction();
        try {
            $query = "DELETE FROM teaches WHERE teacher_id='$this->teacher_id' AND class_id='$class_id';";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            $this->connection->commit();
            return 1;
        } catch (\mysqli_sql_exception $exception) {
            $this->connection->rollback();
            return 0;
        }
    }

    public function getClasses (): array {
        $this->connection->begin_transaction();
        try {
            $query = "SELECT * FROM teaches INNER JOIN classes ON classes.class_id=teaches.class_id WHERE teacher_id='$this->teacher_id'";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            $array = array();
            $n = 0;

            while ($row = $result->fetch_assoc()) {
                $array[$n] = $row;
                $n++;
            }
            return $array;
        } catch (\mysqli_sql_exception $exception) {
            $this->connection->rollback();
            return array();
        }
    }
}

?>