<?php
abstract class Model {

    private static $db;
    private $cost;

    // GETTERS 

    protected function getDb() {
        if (self::$db == null) {
            self::setDb();
        }

        return self::$db;
    }

    //SETTERS
    private static function setDb() {
        try {
            //charset utf8mb4 enables the storage of emoji (may not use it)
            self::$db = new PDO("mysql:host=localhost;dbname=nihon;charset=utf8mb4", "root", "");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    // Function to get the optimal hashing for a password
    // based on the connexion to the server
    public function setCost($timeTarget) {
        // By default the hashing is 10
        $cost = 10;

        do {
            //So try hashing the password with a ++ value
            $cost++;
            $start = microtime(true); // we start a timer (timestamp)
            password_hash("test", PASSWORD_BCRYPT, ["cost" => $cost]);
            $end = microtime(true);                  // we stop the timer (timestamp)
        } while (($end - $start) < $timeTarget); // so while the timer is less than our timeTarget

        $this->cost = $cost;
        return $cost; // then we return the cost so we can hash accordingly
    }
}