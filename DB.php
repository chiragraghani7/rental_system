<?php
class DB {
    private $host = 'localhost';
    private $username = 'root';
    private $password = 'Chirag@99';
    private $database = 'rental_management_system';

    private $connection;

    public function __construct() {
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);

        if ($this->connection->connect_error) {
            die('Connection failed: ' . $this->connection->connect_error);
        }
    }

    public function getConnection() {
        return $this->connection;
    }

    public function closeConnection() {
        $this->connection->close();
    }

    public function prepare($query){
        $stmt = $this->connection->prepare($query);
        return $stmt;
    }

    public function executeQuery($query, $params = array()) {
        try {
            $stmt = $this->connection->prepare($query);
            
            if (!empty($params)) {
                $stmt->bind_param(str_repeat('s', count($params)), ...$params);
            }
    
            $stmt->execute();
            $result = $stmt->get_result();
    
            if ($result === false) {
                throw new Exception("Query execution failed: " . $stmt->error);
            }
    
            $stmt->close();
            return $result;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
    
}
?>
