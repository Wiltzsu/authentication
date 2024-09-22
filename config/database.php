<?php
require_once __DIR__ . '/config/config.php';

class Database
{
    /**
     * Database connection variable.
     */
    private $connection;

    /**
     * Database constructor.
     */
    public function __construct()
    {
        $conn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
        $this->connection = new PDO($conn, DB_USER, DB_PASSWORD);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    /**
     * Get the database connection.
     * 
     * @return PDO
     */
    public function getConnection()
    {
        return $this->connection;
    }
}