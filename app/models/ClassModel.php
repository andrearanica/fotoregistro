<?php

namespace App\models;

use mysqli_sql_exception;
use App\core\Model;

class ClassModel extends Model {

    private string $class_id;
    private string $class_name;
    
    public function setId ($id) {
        $this->class_id = $id;
    }

    public function setName ($name) {
        $this->class_name = $name;
    }

    public function getId () {
        return $this->class_id;
    }

    public function getName () {
        return $this->class_name;
    }

    public function addClass ($teacher_id): bool {
        $this->connection->begin_transaction();
        try {
            $query = "INSERT INTO classes (class_id, class_name) VALUES (?, ?);";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param('ss', $this->class_id, $this->class_name);
            $stmt->execute();
            $query = "INSERT INTO teaches (teacher_id, class_id) VALUES (?, ?);";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param('ss', $teacher_id, $this->class_id);
            $stmt->execute();
            $this->connection->commit();
            return 1;
        } catch (mysqli_sql_exception $exception) {
            $this->connection->rollback();
            return 0;
        }
    }

    public function removeClass (): bool {
        $this->connection->begin_transaction();
        try {
            $query = "DELETE FROM teaches WHERE class_id=?;";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param('s', $this->class_id);
            $stmt->execute();
            $query = "UPDATE students SET class_id=null WHERE class_id=?";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param('s', $this->class_id);
            $stmt->execute();
            $query = "DELETE FROM classes WHERE class_id=?;";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param('s', $this->class_id);
            $stmt->execute();
            $this->connection->commit();
            return 1;
        } catch (mysqli_sql_exception $exception) {
            $this->connection->rollback();
            return 0;
        }
    }

    public function editClass () {
        $this->connection->begin_transaction();
        try {
            $query = "UPDATE classes SET class_name=? WHERE class_id=?";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param('ss', $this->class_name, $this->class_id);
            $stmt->execute();
            $this->connection->commit();
            return 1;
        } catch (mysqli_sql_exception $exception) {
            $this->connection->rollback();
            return 0;
        }
    }

    public function getClassFromId (): array {
        $this->connection->begin_transaction();
        try {
            $query = "SELECT * FROM classes WHERE class_id=?";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param('s', $this->class_id);
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
            return array('message' => 'class not found');
        }
    }

    public function getStudents (): array {
        $this->connection->begin_transaction();
        try {
            $query = "SELECT * FROM students WHERE class_id=? ORDER BY surname;";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param('s', $this->class_id);
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
            return array();
        }
    }

    public function getBannedStudents (): array {
        $this->connection->begin_transaction();
        try {
            $query = "SELECT * FROM students WHERE student_id IN (SELECT student_id FROM blacklist WHERE class_id=?);";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param('s', $this->class_id);
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
            return array();
        }
    }

    public function getTeachers (): array {
        $this->connection->begin_transaction();
        try {
            $query = "SELECT * FROM teaches JOIN teachers ON teaches.teacher_id=teachers.teacher_id WHERE class_id=?";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param('s', $this->class_id);
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
            return array();
        }
    }
}

?>