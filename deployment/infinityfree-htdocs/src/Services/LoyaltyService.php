<?php

namespace App\Services;

use App\Core\Database;
use App\Models\Donor;

/**
 * Service de fidélisation, calcul des points et attribution des badges (Innovation 6)
 */
class LoyaltyService
{
    /**
     * Calcule et attribue les points suite à un don confirmé
     * Règle : 1 point par tranche de 100 FCFA
     */
    public function processDonationPoints(int $donorId, float $montant): array
    {
        $db = Database::getConnection();
        $donorModel = new Donor();
        $donor = $donorModel->find($donorId);

        if (!$donor) {
            return [];
        }

        $pointsGagnes = (int)floor($montant / 100);
        $nouveauxPoints = (int)$donor['points_fidelite'] + $pointsGagnes;

        // Détermination du nouveau niveau de fidélité
        $stmt = $db->prepare("
            SELECT id, nom, seuil_points 
            FROM niveaux_fidelite 
            WHERE seuil_points <= :points 
            ORDER BY seuil_points DESC 
            LIMIT 1
        ");
        $stmt->execute(['points' => $nouveauxPoints]);
        $niveau = $stmt->fetch();
        $nouveauNiveauId = $niveau ? (int)$niveau['id'] : $donor['niveau_id'];

        // Mise à jour du donateur
        $donorModel->update($donorId, [
            'points_fidelite' => $nouveauxPoints,
            'niveau_id' => $nouveauNiveauId
        ]);

        // Vérification et attribution des badges
        $badgesDebloques = $this->checkAndAwardBadges($donorId, $nouveauxPoints);

        return [
            'points_gagnes' => $pointsGagnes,
            'total_points' => $nouveauxPoints,
            'niveau' => $niveau['nom'] ?? 'Bronze',
            'badges_debloques' => $badgesDebloques
        ];
    }

    /**
     * Vérifie et attribue des badges symboliques au donateur
     */
    private function checkAndAwardBadges(int $donorId, int $totalPoints): array
    {
        $db = Database::getConnection();
        $debloques = [];

        // 1. Badge "Premier Pas" (Premier don effectué)
        $this->awardBadgeIfEligible($donorId, 'Premier Geste Solidaire', 'Félicitations pour votre premier don en faveur de nos actions.', 'badge-star.svg', $debloques);

        // 2. Badge "Cœur Généreux" si > 500 points
        if ($totalPoints >= 500) {
            $this->awardBadgeIfEligible($donorId, 'Cœur Généreux', 'Plus de 500 points de solidarité cumulés.', 'badge-heart.svg', $debloques);
        }

        // 3. Badge "Grand Mécène" si > 2000 points
        if ($totalPoints >= 2000) {
            $this->awardBadgeIfEligible($donorId, 'Bâtisseur d\'Avenir', 'Engagement exceptionnel pour les actions de l\'ONG.', 'badge-shield.svg', $debloques);
        }

        return $debloques;
    }

    /**
     * Assigne un badge à un donateur s'il ne le possède pas déjà
     */
    private function awardBadgeIfEligible(int $donorId, string $badgeNom, string $description, string $icone, array &$debloques): void
    {
        $db = Database::getConnection();

        // Vérifie si le badge existe dans la table
        $stmt = $db->prepare("SELECT id FROM badges WHERE nom = :nom LIMIT 1");
        $stmt->execute(['nom' => $badgeNom]);
        $badgeId = $stmt->fetchColumn();

        if (!$badgeId) {
            $insertBadge = $db->prepare("INSERT INTO badges (nom, description, icone) VALUES (:nom, :desc, :icone)");
            $insertBadge->execute(['nom' => $badgeNom, 'desc' => $description, 'icone' => $icone]);
            $badgeId = $db->lastInsertId();
        }

        // Assigne le badge s'il n'est pas déjà détenu
        $check = $db->prepare("SELECT COUNT(*) FROM donateur_badges WHERE donateur_id = :did AND badge_id = :bid");
        $check->execute(['did' => $donorId, 'bid' => $badgeId]);

        if ((int)$check->fetchColumn() === 0) {
            $assign = $db->prepare("INSERT INTO donateur_badges (donateur_id, badge_id, date_obtenu) VALUES (:did, :bid, NOW())");
            $assign->execute(['did' => $donorId, 'bid' => $badgeId]);
            $debloques[] = $badgeNom;
        }
    }
}
