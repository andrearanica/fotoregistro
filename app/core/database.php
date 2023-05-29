<?php

namespace App\core;

use mysqli;

class Database {
    protected static mysqli $connectionIstance;
    
    public function __construct () {
        self::$connectionIstance = new mysqli('localhost', 'root', '', 'my_andrearanica');
    }

    public static function getConnection(): mysqli {
        if (!isset(self::$connectionIstance)) {
            new Database;
        }
        return self::$connectionIstance;
    }
}

?>