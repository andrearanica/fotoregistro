<?php

namespace App\core;

use mysqli;

class Database {
    protected static mysqli $connectionIstance;
    
    private function __construct () {
        self::$connectionIstance = new mysqli($_ENV['DB_HOST'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], $_ENV['DB_NAME']);
    }

    public static function getConnection(): mysqli {
        if (!isset(self::$connectionIstance)) {
            new Database;
        }
        return self::$connectionIstance;
    }
}

?>