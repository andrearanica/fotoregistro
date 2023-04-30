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

    public function addClass ($teacher_id, $name): bool {
        $this->connection->begin_transaction();
        try {
            $query = "INSERT INTO teaches (teacher_id, class_id) VALUES ('$teacher_id', '$this->class_id');";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            $query = "INSERT INTO classes (class_id, name) VALUES ('$this->class_id', '$name');";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            $this->connection->commit();
            return 1;
        } catch (\mysqli_sql_exception $exception) {
            $this->connection->rollback();
            echo json_encode(array('message' => 'error'));
            return 0;
        }
    }
}

?>