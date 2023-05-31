<?php

namespace App\models;

use mysqli_sql_exception;
use App\core\User;

class TeacherModel extends User {
    private $teacher_id;

    /**
     * Returns the teacher_id of a teacher
     * 
     * @return string
     */
    public function getId (): string {
        return $this->teacher_id;
    }
    
    /**
     * Sets the teacher_id of a teacher
     * 
     * @param string $id
     * @return void
     */
    public function setId ($id) {
        $this->teacher_id = $id;
    }

    /**
     * Updates a teacher's name and surname on the database
     * 
     * @param string $name, $surname
     * @return bool
     */
    public function updateInfo ($name, $surname): bool {
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

    /**
     * Changes the password of a teacher
     * 
     * @return bool
     */
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

    /**
     * Inserts a new teacher on the DataBase
     * 
     * @return bool
     */
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

    /**
     * Inserts a new teacher using Google Auth
     * 
     * @return bool
     */
    public function AddTeacherWithGoogle (): bool {
        $this->connection->begin_transaction();
        try {
            $id = uniqid('tc_');
            $password = password_hash($this->password, PASSWORD_BCRYPT);
            $query = "INSERT INTO teachers (teacher_id, name, surname, email, password, enabled, activation_code, google) VALUES (?, ?, ?, ?, ?, 1, ?, 1);";
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

    /**
     * Sets info after checking if teacher's credentials are right
     * 
     * @return bool
     */
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

    /**
     * Returns teacher's info by teacher_id
     * 
     * @return array
     */
    public function getTeacherById (): array {
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

    /**
     * Sets the enabled field on true
     * 
     * @return bool
     */
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

    /**
     * Adds a classroom to a teacher
     * 
     * @param string $class_id
     * @return bool
     */
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

    /**
     * Adds a classroom to a teacher
     * 
     * @param string $class_id
     * @return bool
     */
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

    /**
     * Returns all the teacher's classes
     * 
     * @return array
     */
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

    /**
     * Check if the email is already used with Google Auth
     * 
     * @return bool
     */
    public function checkMail () {
        $query = "SELECT * FROM teachers WHERE email=? AND google=1;";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('s', $this->email);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * Get teacher info with Google Auth setting his info inside the model
     * 
     * @return bool
     */
    public function getTeacherByEmailWithGoogle () {
        $query = "SELECT * FROM teachers WHERE email=? AND google=1;";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('s', $this->email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->teacher_id = $row['teacher_id'];
                $this->name = $row['name'];
                $this->surname = $row['surname'];
                $this->email = $row['email'];
                $this->enabled = $row['enabled'];
                return 1;
            }
        }
        return 0;
    }
}

?>