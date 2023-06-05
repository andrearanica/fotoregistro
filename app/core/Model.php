<?php

namespace App\Core;

class Model {
    protected \mysqli $connection;
    public function __construct () {
        $this->connection = Database::getConnection();
    }
}

?>