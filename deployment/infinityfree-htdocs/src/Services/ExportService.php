<?php

namespace App\Services;

use App\Core\Database;

/**
 * Service de génération d'exports de données (CSV) pour le CRM
 */
class ExportService
{
    /**
     * Génère un fichier CSV à partir de données et l'envoie en téléchargement
     */
    public static function outputCsv(string $filename, array $headers, array $rows): void
    {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $output = fopen('php://output', 'w');
        // Ajout du BOM UTF-8 pour ouverture correcte dans Microsoft Excel
        fputs($output, "\xEF\xBB\xBF");

        // En-têtes
        fputcsv($output, $headers, ';');

        // Lignes
        foreach ($rows as $row) {
            fputcsv($output, $row, ';');
        }

        fclose($output);
        exit;
    }

    /**
     * Enregistre l'historique de l'export dans exports_logs
     */
    public static function logExport(int $userId, string $typeExport, string $format = 'csv'): void
    {
        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("
                INSERT INTO exports_logs (utilisateur_id, type_export, format, date_export)
                VALUES (:uid, :type, :format, NOW())
            ");
            $stmt->execute([
                'uid' => $userId,
                'type' => $typeExport,
                'format' => $format
            ]);
        } catch (\Exception $e) {
            // Silencieux si échec de log
        }
    }
}
