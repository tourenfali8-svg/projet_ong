<?php

namespace App\Core;

use PDO;
use PDOException;
use RuntimeException;

/**
 * Gestionnaire de connexion Singleton à la base de données MySQL
 */
class Database
{
    private static ?PDO $instance = null;

    /**
     * Empêche l'instanciation directe
     */
    private function __construct() {}
    private function __clone() {}

    /**
     * Retourne l'instance unique de PDO
     */
    public static function getConnection(): PDO
    {
        if (self::$instance === null) {
            $config = require dirname(__DIR__, 2) . '/config/database.php';

            $dsn = sprintf(
                '%s:host=%s;port=%s;dbname=%s;charset=%s',
                $config['driver'],
                $config['host'],
                $config['port'],
                $config['database'],
                $config['charset']
            );

            try {
                self::$instance = new PDO(
                    $dsn,
                    $config['username'],
                    $config['password'],
                    $config['options']
                );
            } catch (PDOException $e) {
                // Log de l'erreur dans un fichier de logs
                $logFile = dirname(__DIR__, 2) . '/storage/logs/database.log';
                @file_put_contents(
                    $logFile,
                    sprintf("[%s] Erreur BDD: %s\n", date('Y-m-d H:i:s'), $e->getMessage()),
                    FILE_APPEND
                );

                throw new RuntimeException(
                    "Impossible de se connecter à la base de données. Veuillez vérifier que MySQL est lancé et que la base '{$config['database']}' existe. Détail : " . $e->getMessage()
                );
            }
        }

        return self::$instance;
    }

    /**
     * Permet de réinitialiser la connexion si nécessaire (ex: tests/scripts)
     */
    public static function reset(): void
    {
        self::$instance = null;
    }
}
