<?php

namespace Hotel;

use PDO;
use Support\Configuration\Configuration;

Class BaseServise {

    private static $pdo;

    public function __construct() {
        $this->inisializePdo();
    }

    protected function inisializePdo() {
        //Check if pdo is already inisialize 
        if (!empty(self::$pdo)) {
            return;
        }
        
        //Load database configuration
        $config = Configuration::getInstance();
        $databaseConfig = $config->getConfig()['database'];

        //Content to database 
        try {
            self::$pdo = new PDO(sprintf('mysql:host=%s;dbname=%s;charset=UTF8', $databaseConfig['host'], $databaseConfig['dbname']), 
            $databaseConfig['username'], $databaseConfig['password'], [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"]);
        } catch (\PDOException $ex) {
            throw new \Exception (sprintf('Could not connect to database. Error: %s', $ex->getMessage()));
        }
    }

    protected function getPdo() {
        return self::$pdo;
    }

    protected function execute($sql, $parameters) {
        try {
            // Prepare statement
            $statement = $this->getPdo()->prepare($sql);
    
            // Bind parameters
            foreach ($parameters as $key => &$value) {
                $statement->bindParam($key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
            }
    
            // Execute statement
            $status = $statement->execute();
    
            // Debugging information
            // echo "SQL: " . $sql . "\n";
            // echo "Parameters: " . print_r($parameters, true) . "\n";
    
            // Return the execution status
            return $status;
        } catch (Exception $e) {
            // Add more debugging information
            echo "Error: " . $e->getMessage() . "\n";
            echo "SQL: " . $sql . "\n";
            echo "Parameters: " . print_r($parameters, true) . "\n";
            throw $e; // Rethrow the exception after debugging output
        }
    }

    // protected function fetchAll($sql, $parameters = [], $type = PDO::FETCH_ASSOC) {

    //     //Prepare statement
    //     $statement = $this->getPdo()->prepare($sql);

    //     //Bind parameters
    //     foreach ($parameters as $key => $value){
    //         $statement->bindParam($key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
    //     }

    //     //Execute statement
    //     $status = $statement->execute();

    //     if (!$status) {
    //         throw new Exception($statement->errorInfo()[2]);
    //     }

    //     //Fetch all
    //     return $statement->fetchAll($type);
    // }

    protected function fetchAll($sql, $parameters = [], $type = PDO::FETCH_ASSOC) {
        try {
            // Prepare statement
            $statement = $this->getPdo()->prepare($sql);
    
            // Bind parameters and execute statement
            $status = $statement->execute($parameters);
    
            if (!$status) {
                throw new Exception($statement->errorInfo()[2]);
            }
    
            // Fetch all
            return $statement->fetchAll($type);
        } catch (PDOException $e) {
            // Handle PDO exceptions here if needed
            throw new Exception("Database error: " . $e->getMessage());
        }
    }


    protected function fetch($sql, $parameters = [], $type = PDO::FETCH_ASSOC) {
        try {
            // Prepare statement
            $statement = $this->getPdo()->prepare($sql);
    
            // Bind parameters and execute statement
            $status = $statement->execute($parameters);
    
            if (!$status) {
                throw new Exception($statement->errorInfo()[2]);
            }
    
            // Fetch
            return $statement->fetch($type);
        } catch (PDOException $e) {
            // Handle PDO exceptions here if needed
            throw new Exception("Database error: " . $e->getMessage());
        }
    }
}