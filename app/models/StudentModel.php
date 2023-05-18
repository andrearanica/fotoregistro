<?php

namespace App\models;

class StudentModel {
    private $connection;

    private $student_id;
    private $name;
    private $surname;
    private $photo;    
    private $photo_type;
    private $class_id;
    private $email;
    private $password;
    private $enabled;
    private $activation_code;

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

    public function getPhotoType () {
        return $this->photo_type;
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

    public function getActivationCode () {
        return $this->activation_code;
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

    public function setPhotoType ($photo_type) {
        $this->photo_type = $photo_type;
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

    public function setActivationCode ($activation_code) {
        $this->activation_code = $activation_code;
    }

    public function updateInfo ($name, $surname): bool {
        $this->connection->begin_transaction();
        try {
            $query = "UPDATE students SET name='$name', surname='$surname' WHERE email='$this->email';";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            $this->connection->commit();
            return 1;
        } catch (\mysqli_sql_exception $exception) {
            $this->connection->rollback();
            return 0;
        }
        
    }

    public function editPassword (): bool {
        $this->connection->begin_transaction();
        try {
            $query = "UPDATE students SET password=? WHERE email=?;";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param('ss', $this->password, $this->email);
            $stmt->execute();
            $this->connection->commit();
            return 1;
        } catch (\mysqli_sql_exception $exception) {
            $this->connection->rollback();
            return 0;
        }
    }

    public function AddStudent (): bool {
        $this->connection->begin_transaction();
        try {
            $id = uniqid('st_');
            $password = password_hash($this->password, PASSWORD_BCRYPT);
            $query = "INSERT INTO students (student_id, name, surname, email, password, activation_code) VALUES (?, ?, ?, ?, ?, ?);";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param('ssssss', $this->student_id, $this->name, $this->surname, $this->email, $this->password, $this->activation_code);
            $stmt->execute();
            $this->connection->commit();
            return 1;
        } catch (\mysqli_sql_exception $exception) {
            $this->connection->rollback();
            return 0;
        }
    }

    public function GetStudentByEmailAndPassword (): bool {
        $query = "SELECT * FROM students WHERE email=?;";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('s', $this->email);
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

    public function subscribeToClass ($class_id): int {
        $this->connection->begin_transaction();
        try {
            $query = "SELECT student_id FROM blacklist WHERE student_id=? AND class_id=?";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param('ss', $this->student_id, $class_id);
            $stmt->execute();
            if ($stmt->get_result()->num_rows > 0) {
                $this->connection->rollback();
                return 2;
            }
            $query = "UPDATE students SET class_id=? WHERE student_id=?";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param('ss', $class_id, $this->student_id);
            $stmt->execute();
            $this->connection->commit();
            return 1;
        } catch (\mysqli_sql_exception $exception) {
            $this->connection->rollback();
            return -1;
        }
    }

    public function unsubscribeFromClass (): bool {
        $this->connection->begin_transaction();
        try {
            $query = "UPDATE students SET class_id=null WHERE student_id=?;";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param('s', $this->student_id);
            $stmt->execute();
            $this->connection->commit();
            return 1;
        } catch (\mysqli_sql_exception $exception) {
            $this->connection->rollback();
            return 0;
        }
    }

    public function uploadPhoto () {
        $this->connection->begin_transaction();
        try {
            $query = "UPDATE students SET photo=1, photo_type=? WHERE student_id=?;";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param('ss', $this->photo_type, $this->student_id);
            $stmt->execute();
            $this->connection->commit();
            return 1;
        } catch (\mysqli_sql_exception $exception) {
            $this->connection->rollback();
            return 0;
        }
    }

    public function removePhoto (): bool {
        $this->connection->begin_transaction();
        try {
            $query = "UPDATE students SET photo=0 WHERE student_id=?;";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param('s', $this->student_id);
            $stmt->execute();
            $this->connection->commit();
            return 1;
        } catch (\mysqli_sql_exception $exception) {
            $this->connection->rollback();
            return 0;
        }
        
    }

    public function enableAccount (): bool {
        $this->connection->begin_transaction();
        try {
            $query = "SELECT * FROM students WHERE student_id=? AND activation_code=?;";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param('ss', $this->student_id, $this->activation_code);
            $stmt->execute();
            if ($stmt->get_result()->num_rows == 0) {
                $this->connection->rollback();
                return 0;
            }
            $query = "UPDATE students SET enabled=1 WHERE student_id=? AND activation_code=?;";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param('ss', $this->student_id, $this->activation_code);
            $this->connection->commit();
            return 1;
        } catch (\mysqli_sql_exception $exception) {
            return 0;
        }
    }

    public function getStudentById (): array {
        $this->connection->begin_transaction();
        try {
            $query = "SELECT * FROM students WHERE student_id=?;";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param('s', $this->student_id);
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

    public function addToBlacklist (): bool {
        if ($this->class_id == null) {
            return 0;
        }
        $this->connection->begin_transaction();
        try {
            $query = "INSERT INTO blacklist(student_id, class_id) VALUES (?, ?);";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param('ss', $this->student_id, $this->class_id);
            $stmt->execute();
            $query = "UPDATE students SET class_id=null WHERE student_id='$this->student_id';";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            $this->connection->commit();
            return 1;
        } catch (\mysqli_sql_exception $exception) {
            $this->connection->rollback();
            return 0;
        }
    }

    public function removeFromBlacklist (): bool {
        if ($this->class_id == null) {
            return 0;
        }
        $this->connection->begin_transaction();
        try {
            $query = "DELETE FROM blacklist WHERE student_id=? AND class_id=?;";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param('ss', $this->student_id, $this->class_id);
            $stmt->execute();
            $this->connection->commit();
            return 1;
        } catch (\mysqli_sql_exception $exception) {
            echo $exception;
            $this->connection->rollback();
            return 0;
        }
    }
}

?>  