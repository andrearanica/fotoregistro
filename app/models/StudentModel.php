<?php

namespace App\Models;

use App\Core\User;
use mysqli_sql_exception;

class StudentModel extends User {
    private $student_id;
    private $photo;    
    private $photo_type;
    private $class_id;

    /**
     * Returns the student_id of the student
     * 
     * @return string
     */
    public function getId () {
        return $this->student_id;
    }

    /**
     * Returns if the student has uploaded his photo
     * 
     * @return bool
     */
    public function getPhoto () {
        return $this->photo;
    }

    /**
     * Get the type of file of the student's image
     * 
     * @return string
     */
    public function getPhotoType () {
        return $this->photo_type;
    }

    /**
     * Get the class_id of the student
     * 
     * @return string
     */
    public function getClassId () {
        return $this->class_id;
    }

    /**
     * Sets the student_id of the student
     * 
     * @return void
     */
    public function setId ($id) {
        $this->student_id = $id;
    }

    /**
     * Sets if the student has uploaded his photo
     * 
     * @return void
     */
    public function setPhoto ($photo) {
        $this->photo = $photo;
    }

    /**
     * Sets the student's photo type
     * 
     * @return void
     */
    public function setPhotoType ($photo_type) {
        $this->photo_type = $photo_type;
    }

    /**
     * Sets the class_id of the student
     * 
     * @return void
     */
    public function setClassId ($class_id) {
        $this->class_id = $class_id;
    } 

    /**
     * Updates the student's info (name and surname)
     * 
     * @return bool
     */
    public function updateInfo ($name, $surname): bool {
        $this->connection->begin_transaction();
        try {
            $query = "UPDATE students SET name='$name', surname='$surname' WHERE email='$this->email';";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            $this->connection->commit();
            return 1;
        } catch (mysqli_sql_exception $exception) {
            $this->connection->rollback();
            return 0;
        }
        
    }

    /**
     * Edits the student's password
     * 
     * @return bool
     */
    public function editPassword (): bool {
        $this->connection->begin_transaction();
        try {
            $query = "UPDATE students SET password=? WHERE email=?;";
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
     * Inserts a new student in the DataBase
     * 
     * @return bool
     */
    public function addStudent (): bool {
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
        } catch (mysqli_sql_exception $exception) {
            $this->connection->rollback();
            return 0;
        }
    }

    /**
     * Inserts a new student using Google Auth
     * 
     * @return bool
     */
    public function addStudentWithGoogle (): bool {
        $this->connection->begin_transaction();
        try {
            $id = uniqid('st_');
            $password = password_hash($this->password, PASSWORD_BCRYPT);
            $query = "INSERT INTO students (student_id, name, surname, email, password, activation_code, google) VALUES (?, ?, ?, ?, ?, ?, 1);";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param('ssssss', $this->student_id, $this->name, $this->surname, $this->email, $this->password, $this->activation_code);
            $stmt->execute();
            $this->connection->commit();
            return 1;
        } catch (mysqli_sql_exception $exception) {
            $this->connection->rollback();
            return 0;
        }
    }

    /**
     * Sets model's params by email and password
     * 
     * @return bool
     */
    public function getStudentByEmailAndPassword (): bool {
        $query = "SELECT * FROM students WHERE email=? AND google=0;";
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

    /**
     * Subscribes the student to a class_id
     * 
     * @return bool
     */
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
        } catch (mysqli_sql_exception $exception) {
            $this->connection->rollback();
            return -1;
        }
    }

    /**
     * Unsubscribe a student from a class
     * 
     * @return bool
     */
    public function unsubscribeFromClass (): bool {
        $this->connection->begin_transaction();
        try {
            $query = "UPDATE students SET class_id=null WHERE student_id=?;";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param('s', $this->student_id);
            $stmt->execute();
            $this->connection->commit();
            return 1;
        } catch (mysqli_sql_exception $exception) {
            $this->connection->rollback();
            return 0;
        }
    }

    /**
     * Updates student's photo
     * 
     * @return bool
     */
    public function uploadPhoto () {
        $this->connection->begin_transaction();
        try {
            $query = "UPDATE students SET photo=1, photo_type=? WHERE student_id=?;";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param('ss', $this->photo_type, $this->student_id);
            $stmt->execute();
            $this->connection->commit();
            return 1;
        } catch (mysqli_sql_exception $exception) {
            $this->connection->rollback();
            return 0;
        }
    }

    /**
     * Remove student's photo
     * 
     * @return bool
     */
    public function removePhoto (): bool {
        $this->connection->begin_transaction();
        try {
            $query = "UPDATE students SET photo=0 WHERE student_id=?;";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param('s', $this->student_id);
            $stmt->execute();
            $this->connection->commit();
            return 1;
        } catch (mysqli_sql_exception $exception) {
            $this->connection->rollback();
            return 0;
        }
        
    }

    /**
     * Enables a student
     * 
     * @return bool
     */
    public function enableAccount (): bool {
        $this->connection->begin_transaction();
        try {
            $query = "UPDATE students SET enabled=1 WHERE student_id=? AND activation_code=?;";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param('ss', $this->student_id, $this->activation_code);
            $stmt->execute();
            $this->connection->commit();
            return 1;
        } catch (mysqli_sql_exception $exception) {
            return 0;
        }
    }

    /**
     * Sets model's attributes by student_id
     * 
     * @return array
     */
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
        } catch (mysqli_sql_exception $exception) {
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
        } catch (mysqli_sql_exception $exception) {
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
        } catch (mysqli_sql_exception $exception) {
            echo $exception;
            $this->connection->rollback();
            return 0;
        }
    }
    
    public function checkMail () {
        $query = "SELECT * FROM students WHERE email=? AND google=1;";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('s', $this->email);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function getStudentByEmailWithGoogle () {
        $query = "SELECT * FROM students WHERE email=? AND google=1;";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('s', $this->email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->student_id = $row['student_id'];
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