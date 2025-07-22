<?php

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$dsn = $_ENV['dsn'] ?? $_ENV['DSN'];
$user = $_ENV['DB_USERNAME'];
$pass = $_ENV['DB_PASSWORD'];

class Seeder {
    public static function seed() {
        $pdo = new PDO($GLOBALS['dsn'], $GLOBALS['user'], $GLOBALS['pass']);

        // Seed citoyens
        $citoyens = [
            [
                'nci' => '1456789012345',
                'nom' => 'Wane',
                'prenom' => 'Mamadou',
                'date_naissance' => '1990-01-01',
                'lieu_naissance' => 'Dakar',
                'url_carte_recto' => 'https://cloud.example.com/recto1.jpg',
                'url_carte_verso' => 'https://cloud.example.com/verso1.jpg'
            ],
            [
                'nci' => '1098765432123',
                'nom' => 'Diop',
                'prenom' => 'Awa',
                'date_naissance' => '1992-05-10',
                'lieu_naissance' => 'Thiès',
                'url_carte_recto' => 'https://cloud.example.com/recto2.jpg',
                'url_carte_verso' => 'https://cloud.example.com/verso2.jpg'
            ],
            [
                'nci' => '1234567890987',
                'nom' => 'Ba',
                'prenom' => 'Moussa',
                'date_naissance' => '1988-09-15',
                'lieu_naissance' => 'Saint-Louis',
                'url_carte_recto' => 'https://cloud.example.com/recto3.jpg',
                'url_carte_verso' => 'https://cloud.example.com/verso3.jpg'
            ]
        ];

        $sqlCitoyen = "INSERT INTO citoyen (nci, nom, prenom, date_naissance, lieu_naissance, url_carte_recto, url_carte_verso)
                       VALUES (:nci, :nom, :prenom, :date_naissance, :lieu_naissance, :url_carte_recto, :url_carte_verso)";
        $stmtCitoyen = $pdo->prepare($sqlCitoyen);

        foreach ($citoyens as $citoyen) {
            $stmtCitoyen->execute($citoyen);
        }

        echo count($citoyens) . " citoyens seedés avec succès.\n";

        // Seed logs de recherche
        $logs = [
            [
                'nci' => 'CNI20250001',
                'date_recherche' => date('Y-m-d H:i:s'),
                'localisation' => 'Dakar',
                'ip' => '127.0.0.1',
                'statut' => 'success',
                'message' => 'Recherche réussie'
            ],
            [
                'nci' => 'CNI20250004',
                'date_recherche' => date('Y-m-d H:i:s'),
                'localisation' => 'Thiès',
                'ip' => '127.0.0.2',
                'statut' => 'error',
                'message' => 'Numéro non trouvé'
            ]
        ];

        $sqlLog = "INSERT INTO recherche_log (nci, date_recherche, localisation, ip, statut, message)
                   VALUES (:nci, :date_recherche, :localisation, :ip, :statut, :message)";
        $stmtLog = $pdo->prepare($sqlLog);

        foreach ($logs as $log) {
            $stmtLog->execute($log);
        }

        echo count($logs) . " logs de recherche seedés avec succès.\n";
    }
}

Seeder::seed();