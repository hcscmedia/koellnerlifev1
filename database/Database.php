<?php
/**
 * Database Connection Class
 * Singleton Pattern für sichere Datenbankverbindung
 */

class Database {
    private static $instance = null;
    private $connection;
    
    // Datenbankverbindung herstellen
    private function __construct() {
        try {
            $this->connection = new PDO(
                'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
                DB_USER,
                DB_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
                ]
            );
        } catch (PDOException $e) {
            if (DEBUG_MODE) {
                die("Datenbankverbindungsfehler: " . $e->getMessage());
            } else {
                die("Datenbankverbindung fehlgeschlagen. Bitte kontaktieren Sie den Administrator.");
            }
        }
    }
    
    // Singleton Instance
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    // Connection abrufen
    public function getConnection() {
        return $this->connection;
    }
    
    // Query ausführen
    public function query($sql, $params = []) {
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            if (DEBUG_MODE) {
                die("Query-Fehler: " . $e->getMessage());
            }
            return false;
        }
    }
    
    // Einzelnes Ergebnis abrufen
    public function fetchOne($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt ? $stmt->fetch() : false;
    }
    
    // Mehrere Ergebnisse abrufen
    public function fetchAll($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt ? $stmt->fetchAll() : [];
    }
    
    // INSERT und ID zurückgeben
    public function insert($sql, $params = []) {
        if ($this->query($sql, $params)) {
            return $this->connection->lastInsertId();
        }
        return false;
    }
    
    // UPDATE/DELETE und betroffene Zeilen zurückgeben
    public function execute($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt ? $stmt->rowCount() : false;
    }
    
    // Clone und Wakeup verhindern (Singleton)
    private function __clone() {}
    public function __wakeup() {}
}
