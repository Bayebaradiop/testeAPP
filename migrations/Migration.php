<?php

require_once __DIR__ . '/../vendor/autoload.php'; 

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__)); 
$dotenv->load();

$dsn = $_ENV['dsn'] ?? $_ENV['DSN'];
$user = $_ENV['DB_USERNAME'];
$pass = $_ENV['DB_PASSWORD'];

$driver = '';
if (stripos($dsn, 'pgsql:host') === 0) {
    $driver = 'pgsql';
} elseif (stripos($dsn, 'mysql:host') === 0) {
    $driver = 'mysql';
}

preg_match('/dbname=([^;]+)/', $dsn, $matches);
$dbName = $matches[1] ?? null;

if ($driver === 'pgsql' && $dbName) {
    $dsnDefault = preg_replace('/dbname=([^;]+)/', 'dbname=postgres', $dsn);
    try {
        $pdo = new PDO($dsnDefault, $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec("CREATE DATABASE \"$dbName\"");
        echo "Base de données \"$dbName\" créée ou déjà existante.\n";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'already exists') === false) {
            die("Erreur création base: " . $e->getMessage());
        }
    }
}
if ($driver === 'mysql' && $dbName) {
    $dsnDefault = preg_replace('/dbname=([^;]+)/', '', $dsn);
    try {
        $pdo = new PDO($dsnDefault, $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        echo "Base de données `$dbName` créée ou déjà existante.\n";
    } catch (PDOException $e) {
        die("Erreur création base: " . $e->getMessage());
    }
}

class Migration
{
    private static ?\PDO $pdo = null;
    private static string $driver = '';

    private static function connect()
    {
        global $dsn, $user, $pass, $driver;
        if (self::$pdo === null) {
            self::$pdo = new \PDO($dsn, $user, $pass);
            self::$driver = $driver;
        }
    }

    private static function type($type)
    {
        // Adapte les types selon le SGBD
        $map = [
            'id' => [
                'pgsql' => 'SERIAL PRIMARY KEY',
                'mysql' => 'INT AUTO_INCREMENT PRIMARY KEY'
            ],
            'date' => [
                'pgsql' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
                'mysql' => 'DATETIME DEFAULT CURRENT_TIMESTAMP'
            ]
        ];
        return $map[$type][self::$driver] ?? $type;
    }

    public static function up()
    {
        self::connect();

        $queries = [
     "CREATE TABLE IF NOT EXISTS citoyen (
            id " . self::type('id') . ",
            nci VARCHAR(50) NOT NULL UNIQUE,
            nom VARCHAR(100) NOT NULL,
            prenom VARCHAR(100) NOT NULL,
            date_naissance DATE NOT NULL,
            lieu_naissance VARCHAR(100) NOT NULL,
            url_carte_recto TEXT,
            url_carte_verso TEXT
        )",

        "CREATE TABLE IF NOT EXISTS recherche_log (
            id " . self::type('id') . ",
            nci VARCHAR(50) NOT NULL,
            date_recherche " . self::type('date') . ",
            localisation VARCHAR(100),
            ip VARCHAR(45),
            statut VARCHAR(10) CHECK (statut IN ('success', 'error')),
            message TEXT
        )",
  
        ];

        foreach ($queries as $sql) {
            self::$pdo->exec($sql);
        }

        echo "Migration terminée avec succès pour le SGBD : " . self::$driver . "\n";
    }
}

Migration::up();