<?php

/**
 * Secure Database Connection Class with Prepared Statements
 */
class Database
{
    private $connection;
    private $host;
    private $user;
    private $pass;
    private $dbname;

    public function __construct($host, $user, $pass, $dbname)
    {
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->dbname = $dbname;
        $this->connect();
    }

    private function connect()
    {
        try {
            // Create connection with error reporting disabled
            mysqli_report(MYSQLI_REPORT_OFF);

            $this->connection = new mysqli($this->host, $this->user, $this->pass, $this->dbname);

            if ($this->connection->connect_error) {
                error_log("Database Connection Error: " . $this->connection->connect_error);
                throw new Exception("Database connection failed");
            }

            // Set charset to UTF-8 (fallback to utf8 if utf8mb4 not supported)
            if (!$this->connection->set_charset("utf8mb4")) {
                $this->connection->set_charset("utf8");
            }
        } catch (Exception $e) {
            error_log("Database Exception: " . $e->getMessage());
            die("Koneksi database gagal. Silakan hubungi administrator.");
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Execute prepared statement SELECT query
     * @param string $query SQL query with placeholders (?)
     * @param string $types Types of parameters (s=string, i=integer, d=double, b=blob)
     * @param array $params Parameters to bind
     * @return array|false Result array or false on failure
     */
    public function select($query, $types = "", $params = array())
    {
        try {
            $stmt = $this->connection->prepare($query);

            if (!$stmt) {
                error_log("Prepare failed: " . $this->connection->error);
                return false;
            }

            if (!empty($params)) {
                // PHP 5.3+ compatible bind_param
                $bind_params = array($types);
                foreach ($params as $key => $value) {
                    $bind_params[] = &$params[$key];
                }
                call_user_func_array(array($stmt, 'bind_param'), $bind_params);
            }

            if (!$stmt->execute()) {
                error_log("Execute failed: " . $stmt->error);
                $stmt->close();
                return false;
            }

            $result = $stmt->get_result();
            $data = array();

            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }

            $stmt->close();
            return $data;
        } catch (Exception $e) {
            error_log("Select Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Execute prepared statement INSERT/UPDATE/DELETE query
     * @param string $query SQL query with placeholders (?)
     * @param string $types Types of parameters (s=string, i=integer, d=double, b=blob)
     * @param array $params Parameters to bind
     * @return bool Success status
     */
    public function execute($query, $types = "", $params = array())
    {
        try {
            $stmt = $this->connection->prepare($query);

            if (!$stmt) {
                error_log("Prepare failed: " . $this->connection->error);
                return false;
            }

            if (!empty($params)) {
                // PHP 5.3+ compatible bind_param
                $bind_params = array($types);
                foreach ($params as $key => $value) {
                    $bind_params[] = &$params[$key];
                }
                call_user_func_array(array($stmt, 'bind_param'), $bind_params);
            }

            $result = $stmt->execute();

            if (!$result) {
                error_log("Execute failed: " . $stmt->error);
            }

            $stmt->close();
            return $result;
        } catch (Exception $e) {
            error_log("Execute Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get last inserted ID
     * @return int Last insert ID
     */
    public function lastInsertId()
    {
        return $this->connection->insert_id;
    }

    /**
     * Get affected rows from last query
     * @return int Number of affected rows
     */
    public function affectedRows()
    {
        return $this->connection->affected_rows;
    }

    /**
     * Escape string (use only when prepared statements are not possible)
     * @param string $string String to escape
     * @return string Escaped string
     */
    public function escape($string)
    {
        return $this->connection->real_escape_string($string);
    }

    /**
     * Close database connection
     */
    public function close()
    {
        if ($this->connection) {
            $this->connection->close();
        }
    }

    public function __destruct()
    {
        $this->close();
    }
}
