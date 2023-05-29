<?php

namespace App\models;

use mysqli_sql_exception;
use App\core\Model;

class TeacherModel extends Model {
    private $teacher_id;
    private $name;
    private $surname;
    private $email;
    private $password;
    private $enabled;
    private $activation_code;

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
            $query = "UPDATE teachers SET name=?, surname=? WHERE email=?;";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param('sss', $name, $surname, $this->email);
            $stmt->execute();
            $this->connection->commit();
            return 1;
        } catch (mysqli_sql_exception $exception) {
            $this->connection->rollback();
            return 0;
        }
    }

    public function editPassword (): bool {
        $this->connection->begin_transaction();
        try {
            $query = "UPDATE teachers SET password=? WHERE email=?;";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param('ss', $this->password, $this->email);
            $stmt->execute();
            $this->connection->commit();
            return 1;
        } catch (mysqli_sql_exception $exception) {
            $this->connection->rollback();
            return 0;
        }
    }

    public function AddTeacher (): bool {
        $this->connection->begin_transaction();
        try {
            $query = "INSERT INTO teachers (teacher_id, name, surname, email, password, activation_code) VALUES (?, ?, ?, ?, ?, ?);";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param('ssssss', $this->teacher_id, $this->name, $this->surname, $this->email, $this->password, $this->activation_code);
            $stmt->execute();
            $this->connection->commit();
            return 1;
        } catch (mysqli_sql_exception $exception) {
            $this->connection->rollback();
            return 0;
        }
    }

    public function GetTeacherByEmailAndPassword (): bool {
        $query = "SELECT * FROM teachers WHERE email=?;";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('s', $this->email);
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

    public function getTeacherById () {
        $this->connection->begin_transaction();
        try {
            $query = "SELECT * FROM teachers WHERE teacher_id=?;";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param('s', $this->teacher_id);
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
        } catch (mysqli_sql_exception $exception) {
            $this->connection->rollback();
            return array();
        }
    }

    public function enableAccount () {
        $this->connection->begin_transaction();
        try {
            $query = "UPDATE teachers SET enabled=1 WHERE teacher_id=?";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param('s', $this->teacher_id);
            $stmt->execute();
            $this->connection->commit();
            return 1;
        } catch (mysqli_sql_exception $exception) {
            $this->connection->rollback();
            return 0;
        }
    }

    public function subscribeToClass ($class_id): bool {
        $this->connection->begin_transaction();
        try {
            $query = "INSERT INTO teaches (teacher_id, class_id) VALUES (?, ?);";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param('ss', $this->teacher_id, $class_id);
            $stmt->execute();
            $this->connection->commit();
            return 1;
        } catch (mysqli_sql_exception $exception) {
            $this->connection->rollback();
            return 0;
        }
    }

    public function unsubscribeFromClass ($class_id): bool {
        $this->connection->begin_transaction();
        try {
            $query = "DELETE FROM teaches WHERE teacher_id=? AND class_id=?;";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param('ss', $this->teacher_id, $class_id);
            $stmt->execute();
            $this->connection->commit();
            return 1;
        } catch (mysqli_sql_exception $exception) {
            $this->connection->rollback();
            return 0;
        }
    }

    public function getClasses (): array {
        $this->connection->begin_transaction();
        try {
            $query = "SELECT * FROM teaches INNER JOIN classes ON classes.class_id=teaches.class_id WHERE teacher_id=?";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param('s', $this->teacher_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $array = array();
            $n = 0;

            while ($row = $result->fetch_assoc()) {
                $array[$n] = $row;
                $n++;
            }
            return $array;
        } catch (mysqli_sql_exception $exception) {
            $this->connection->rollback();
            return array();
        }
    }
}

?>