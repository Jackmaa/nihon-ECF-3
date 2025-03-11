<?php
abstract class Model {
    private static $db;
    private $cost;

    // Get the database connection
    protected function getDb() {
        if (self::$db == null) {
            self::setDb();
        }
        return self::$db;
    }

    // Set the database connection
    private static function setDb() {
        try {
            // Initialize the PDO connection with UTF-8 encoding
            self::$db = new PDO("mysql:host=localhost;dbname=nihon;charset=utf8mb4", "root", "");
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Enable exceptions for errors
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    // Function to get the optimal hashing cost for a password
    public function setCost($timeTarget = 0.05) {
        $cost = 10; // Default cost

        do {
            $cost++;
            $start = microtime(true); // Start timer
            password_hash("test", PASSWORD_BCRYPT, ["cost" => $cost]);
            $end = microtime(true);                  // End timer
        } while (($end - $start) < $timeTarget); // Continue until the target time is reached

        $this->cost = $cost;
        return $cost;
    }
}