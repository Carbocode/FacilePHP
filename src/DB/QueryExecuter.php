<?php

namespace FacilePHP\DB;

use Exception;
use FacilePHP\Config\Constants;
use PDO;
use PDOException;

/**
 * The Queryhandler class is responsible for establishing a connection with the database and executing queries.
 * It implements the Singleton pattern to ensure that only one instance of the database connection is created throughout the application.
 * This class provides methods for executing both raw and prepared queries, handling transactions, and retrieving the last inserted ID.
 * It is crucial to use prepared statements or sanitize inputs properly to prevent SQL injection when using methods that handle raw queries.
 */
class Queryhandler
{
    private static ?Queryhandler $instance = null;

    private readonly string $db_host;
    private readonly string $db_name;
    private readonly string $db_user;
    private readonly string $db_password;

    private PDO $connection;

    /**
     * Object constructor
     *
     * @throws Exception if there is a connection error with the Database
     */
    private function __construct($db_host, $db_name, #[\SensitiveParameter] $db_user, #[\SensitiveParameter] $db_password)
    {
        $this->db_host = $db_host;
        $this->db_name = $db_name;
        $this->db_user = $db_user;
        $this->db_password = $db_password;

        try {
            $dsn = "mysql:host=$this->db_host;dbname=$this->db_name;charset=utf8";
            $this->connection = new PDO($dsn, $this->db_user, $this->db_password);
            // Set error mode to exception
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new Exception('Connection failed: ' . $e->getMessage(), Constants::INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Initiates transaction mode to handle multiple queries in succession
     *
     * @return void
     */
    public function beginTransaction()
    {
        $this->connection->beginTransaction();
    }

    /**
     * Confirms the execution of queries performed in transaction mode
     *
     * @return void
     */
    public function commit()
    {
        $this->connection->commit();
    }

    /**
     * Cancels the execution of queries performed in transaction mode
     *
     * @return void
     */
    public function rollBack()
    {
        $this->connection->rollBack();
    }

    /**
     * Checks for an instance of the database and creates one if it doesn't exist
     *
     * @return Queryhandler
     */
    public static function getInstance($db_host, $db_name, #[\SensitiveParameter] $db_user, #[\SensitiveParameter] $db_password): Queryhandler
    {
        if (self::$instance == null) {
            self::$instance = new Queryhandler($db_host, $db_name, $db_user, $db_password);
        }

        return self::$instance;
    }

    /**
     * Prevents the object from being cloned
     *
     * @throws Exception to prevent cloning of an object using the Singleton pattern
     */
    public function __clone()
    {
        // Prevent cloning of the object
        throw new Exception('Non puoi clonare un oggetto che usa il pattern Singleton');
    }

    /**
     * Prevents object unserialization
     *
     * @throws Exception to maintain Singleton instance uniqueness
     */
    public function __wakeup()
    {
        // Prevent unserialization of the object
        throw new Exception("L'istanza Singleton deve essere unica");
    }

    public function query(string $query, string $types = null, mixed ...$params)
    {
        if (!$types) $this->exQuery($query);
        else $this->exPreparedQuery($query, $types, $params);
    }

    /**
     * handles an unprotected SQL query against the Database, vulnerable to SQL Injection
     * @param string $query SQL query string
     *
     * @return array|int result for a SELECT query or True for other query types
     * @throws Exception in case of a query error
     */
    public function exQuery(string $query): array|int
    {
        try {
            $stmt = $this->connection->query($query);

            // Controlla se il statement è di tipo SELECT per determinare come elaborare il risultato
            if ($stmt->columnCount() > 0) {
                // È una query di tipo SELECT, restituisce i risultati come array associativo
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                // Non è una query di tipo SELECT, restituisce il numero di righe influenzate
                return $stmt->rowCount();
            }
        } catch (PDOException $e) {
            throw new Exception('Query: \n' . $query . '\n Errore: \n' . $e->getMessage(), Constants::INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * handles a prepared statement for the Database
     * @param string $query SQL query string
     * @param string $types a string composed of characters corresponding to each parameter's type
     * @param array ...$params all parameters to be bound in the query
     *
     * @return array|int result for a SELECT query or number of affected rows
     * 
     * @throws Exception query issues
     */
    private function exPreparedQuery(string $query, string $types, array $params): array|int
    {

        try {
            $stmt = $this->connection->prepare($query);
            for ($i = 0; $i < count($params); $i++) {
                $stmt->bindParam($i + 1, $params[$i], $this->getPDOParamType($types[$i]));
            }
            $stmt->execute();

            if ($stmt->columnCount()) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return $stmt->rowCount();
            }
        } catch (PDOException $e) {
            throw new Exception('Query: \n' . $query . '\n Error: \n' . $e->getMessage());
        }
    }

    /**
     * Retrieves the last inserted ID
     *
     * @return int|string returns the last inserted ID
     */
    public function getLastID(): int|string
    {
        return $this->connection->lastInsertId();
    }

    private function getPDOParamType($type): int
    {
        switch ($type) {
            case 'i':
                return PDO::PARAM_INT;
            case 'd':
                return PDO::PARAM_STR;
            case 's':
                return PDO::PARAM_STR;
            case 'b':
                return PDO::PARAM_LOB;
            default:
                return PDO::PARAM_STR;
        }
    }
}
