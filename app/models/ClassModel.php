<?php

namespace App\models;

class ClassModel {
    private $connection;

    private $class_id;
    private $class_name;

    public function __construct () {
        $this->connection = new \mysqli('127.0.0.1', 'root', '', 'my_andrearanica');
    }
    
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
            $query = "INSERT INTO classes (class_id, class_name) VALUES ('$this->class_id', '$this->class_name');";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            $query = "INSERT INTO teaches (teacher_id, class_id) VALUES ('$teacher_id', '$this->class_id');";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            $this->connection->commit();
            return 1;
        } catch (\mysqli_sql_exception $exception) {
            $this->connection->rollback();
            return 0;
        }
    }

    public function removeClass (): bool {
        $this->connection->begin_transaction();
        try {
            $query = "DELETE FROM teaches WHERE class_id='$this->class_id';";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            $query = "DELETE FROM classes WHERE class_id='$this->class_id';";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            $this->connection->commit();
            return 1;
        } catch (\mysqli_sql_exception $exception) {
            $this->connection->rollback();
            return 0;
        }
    }

    public function getClassFromId (): array {
        $this->connection->begin_transaction();
        try {
            $query = "SELECT * FROM classes WHERE class_id='$this->class_id'";
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
            return array('message' => 'class not found');
        }
    }

    public function getStudents (): array {
        $this->connection->begin_transaction();
        try {
            $query = "SELECT * FROM students WHERE class_id='$this->class_id' ORDER BY surname;";
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
            return array();
        }
    }
}

?>