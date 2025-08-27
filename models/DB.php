<?php
require_once __DIR__ . '/../config.php';

class DB
{
    /** @var PDO */
    private static $instance = null;
    private static $lastError = null;

    public static function getInstance()
    {
        if (self::$instance === null) {
            try {
                // Support both MySQL and PostgreSQL
                $dbType = defined('DB_TYPE') ? DB_TYPE : 'mysql';
                
                if ($dbType === 'pgsql') {
                    $dsn = sprintf('pgsql:host=%s;port=%s;dbname=%s', 
                        DB_HOST, DB_PORT, DB_NAME);
                } else {
                    $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=%s', 
                        DB_HOST, DB_PORT, DB_NAME, DB_CHARSET);
                }
                
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::ATTR_TIMEOUT => 10, // 10 second timeout
                ];

                // Add charset for MySQL only
                if ($dbType === 'mysql') {
                    $options[PDO::MYSQL_ATTR_INIT_COMMAND] = "SET NAMES " . DB_CHARSET;
                }

                self::$instance = new PDO($dsn, DB_USER, DB_PASS, $options);
                self::$lastError = null;
                
                // Test connection
                self::$instance->query('SELECT 1');
                
            } catch (PDOException $e) {
                self::$lastError = $e->getMessage();
                error_log('Database connection failed: ' . $e->getMessage());
                
                // In production, don't expose database errors
                if (isProduction()) {
                    throw new Exception('Database service temporarily unavailable. Please try again later.');
                } else {
                    throw new Exception('Database connection failed: ' . $e->getMessage());
                }
            }
        }
        return self::$instance;
    }

    /**
     * Get last database error
     */
    public static function getLastError()
    {
        return self::$lastError;
    }

    /**
     * Test database connection
     */
    public static function testConnection()
    {
        try {
            $pdo = self::getInstance();
            $stmt = $pdo->query('SELECT 1 as test');
            $result = $stmt->fetch();
            return ['success' => true, 'test_result' => $result['test']];
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Close connection (for cleanup)
     */
    public static function closeConnection()
    {
        self::$instance = null;
    }
}
?>
