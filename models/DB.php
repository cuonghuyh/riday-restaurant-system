<?php
require_once __DIR__ . '/../config.php';

class DB
{
    /** @var PDO */
    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance === null) {
            // Check if we're on Render (production) or localhost
            $isProduction = isset($_SERVER['RENDER']) || !empty($_SERVER['RENDER_SERVICE_NAME']);
            
            if ($isProduction) {
                // Use SQLite for production
                $dbPath = __DIR__ . '/../database/restaurant.db';
                $dsn = 'sqlite:' . $dbPath;
                try {
                    $pdo = new PDO($dsn, null, null, [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false,
                    ]);
                    self::$instance = $pdo;
                } catch (PDOException $e) {
                    throw new RuntimeException('SQLite connection failed: ' . $e->getMessage());
                }
            } else {
                // Use MySQL for localhost
                $dsn = sprintf('mysql:host=%s;dbname=%s;charset=%s', DB_HOST, DB_NAME, DB_CHARSET);
                try {
                    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false,
                    ]);
                    self::$instance = $pdo;
                } catch (PDOException $e) {
                    throw new RuntimeException('Database connection failed: ' . $e->getMessage());
                }
            }
        }

        return self::$instance;
    }
}
