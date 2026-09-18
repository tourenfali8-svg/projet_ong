<?php

namespace App\Models;

use App\Core\Model;

/**
 * Modèle des Bénévoles et de leurs Candidatures (Innovation 10)
 */
class Volunteer extends Model
{
    protected string $table = 'benevoles';

    /**
     * Recherche ou crée un bénévole
     */
    public function findOrCreate(array $data): array
    {
        $existing = null;
        if (!empty($data['email'])) {
            $existing = $this->findFirst(['email' => $data['email']]);
        }
        if (!$existing && !empty($data['telephone'])) {
            $existing = $this->findFirst(['telephone' => $data['telephone']]);
        }

        if ($existing) {
            return $existing;
        }

        $id = $this->create([
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'email' => $data['email'] ?? null,
            'telephone' => $data['telephone'] ?? null,
            'competences' => $data['competences'] ?? null
        ]);

        return $this->find($id);
    }

    /**
     * Postule à une mission de bénévolat
     */
    public function applyForMission(int $volunteerId, int $missionId): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO candidatures_benevolat (benevole_id, mission_id, statut, date_candidature)
            VALUES (:benevole_id, :mission_id, 'en_attente', NOW())
            ON DUPLICATE KEY UPDATE date_candidature = NOW()
        ");
        return $stmt->execute([
            'benevole_id' => $volunteerId,
            'mission_id' => $missionId
        ]);
    }

    /**
     * Récupère les candidatures avec détails sur le bénévole et la mission
     */
    public function getAllApplications(): array
    {
        $sql = "
            SELECT cb.*, 
                   b.nom AS benevole_nom, b.prenom AS benevole_prenom, b.email AS benevole_email, b.telephone AS benevole_telephone, b.competences,
                   m.titre AS mission_titre, m.lieu AS mission_lieu, m.date_debut AS mission_debut
            FROM candidatures_benevolat cb
            JOIN benevoles b ON b.id = cb.benevole_id
            JOIN missions_benevolat m ON m.id = cb.mission_id
            ORDER BY cb.date_candidature DESC
        ";
        return $this->rawQuery($sql);
    }
}
