
<?php

class Database
{
    private static $instance = null;
    private $pdo;

    private function __construct()
    {
        $envFile = __DIR__ . '/../app/core/.env';
        $config = parse_ini_file($envFile, false, INI_SCANNER_RAW);

        if ($config === false) {
            throw new RuntimeException(".env gagal dibaca");
        }

        $host = $config['DB_HOST'] ?? '127.0.0.1';
        $port = $config['DB_PORT'] ?? '3307';
        $name = $config['DB_NAME'] ?? 'db_inventory';
        $user = $config['DB_USER'] ?? 'root';
        $pass = $config['DB_PASS'] ?? '';

        $dsn = "mysql:host=$host;port=$port;dbname=$name;charset=utf8mb4";

        $this->pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->pdo;
    }
}
