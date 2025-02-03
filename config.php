<?php
class Database {
    private static $instance = null;
    private $connection;

    private function __construct() {
        $this->connection =
            new mysqli("localhost", "iliyahristov",
                "eN53w98Fm2lV2wf-Aqqqmvi18364", "university");
        mysqli_set_charset($this->connection, "utf8mb4");

        if ($this->connection->connect_error) {
            die("Грешка при връзка с базата данни: " . $this->connection->connect_error);
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }

    public function __destruct() {
        if ($this->connection) {
            $this->connection->close();
        }
    }
}
?>