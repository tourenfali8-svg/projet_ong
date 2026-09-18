<?php

namespace App\Core;

/**
 * Autoloader PSR-4 natif
 * Permet d'exécuter l'application immédiatement sans nécessiter `composer dump-autoload`
 */
class Autoloader
{
    /**
     * Enregistre l'autoloader
     */
    public static function register(): void
    {
        spl_autoload_register([__CLASS__, 'autoload']);
    }

    /**
     * Charge une classe selon le standard PSR-4
     */
    public static function autoload(string $class): void
    {
        $prefix = 'App\\';
        $baseDir = dirname(__DIR__) . DIRECTORY_SEPARATOR;

        // Vérifie si la classe utilise le namespace de base
        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) !== 0) {
            return;
        }

        // Récupère le nom relatif de la classe
        $relativeClass = substr($class, $len);

        // Remplace les séparateurs de namespace par des séparateurs de dossier
        $file = $baseDir . str_replace('\\', DIRECTORY_SEPARATOR, $relativeClass) . '.php';

        // Si le fichier existe, le charger
        if (file_exists($file)) {
            require_once $file;
        }
    }
}
