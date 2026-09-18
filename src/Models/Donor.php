<?php

namespace App\Models;

use App\Core\Model;

/**
 * Modèle Donateur & Fidélisation
 */
class Donor extends Model
{
    protected string $table = 'donateurs';

    /**
     * Recherche ou crée un donateur par numéro de téléphone
     */
    public function findOrCreate(array $donorData): array
    {
        $telephone = trim($donorData['telephone'] ?? '');
        $existing = $this->findFirst(['telephone' => $telephone]);

        if ($existing) {
            // Mise à jour de l'email ou de l'adresse si renseignés
            $updateData = [];
            if (!empty($donorData['email']) && empty($existing['email'])) {
                $updateData['email'] = $donorData['email'];
            }
            if (!empty($donorData['nom']) && $existing['nom'] !== $donorData['nom']) {
                $updateData['nom'] = $donorData['nom'];
            }
            if (!empty($donorData['prenom']) && $existing['prenom'] !== $donorData['prenom']) {
                $updateData['prenom'] = $donorData['prenom'];
            }
            if (!empty($updateData)) {
                $this->update($existing['id'], $updateData);
                $existing = array_merge($existing, $updateData);
            }
            return $existing;
        }

        // Création avec niveau Bronze par défaut (id 1)
        $id = $this->create([
            'nom' => $donorData['nom'] ?? 'Anonyme',
            'prenom' => $donorData['prenom'] ?? '',
            'telephone' => $telephone,
            'email' => $donorData['email'] ?? null,
            'adresse' => $donorData['adresse'] ?? null,
            'points_fidelite' => 0,
            'niveau_id' => 1
        ]);

        return $this->find($id);
    }

    /**
     * Récupère la liste complète des donateurs avec leurs niveaux et montants cumulés
     */
    public function getAllWithSummary(): array
    {
        $sql = "
            SELECT d.*, 
                   nf.nom AS niveau_nom,
                   COUNT(dn.id) AS total_dons,
                   COALESCE(SUM(CASE WHEN t.statut = 'confirme' THEN dn.montant ELSE 0 END), 0) AS total_montant_donne
            FROM donateurs d
            LEFT JOIN niveaux_fidelite nf ON nf.id = d.niveau_id
            LEFT JOIN dons dn ON dn.donateur_id = d.id
            LEFT JOIN transactions t ON t.don_id = dn.id
            GROUP BY d.id
            ORDER BY d.id DESC
        ";
        return $this->rawQuery($sql);
    }

    /**
     * Récupère le profil complet d'un donateur avec badges et historique
     */
    public function getProfileWithBadges(int $donorId): ?array
    {
        $donor = $this->find($donorId);
        if (!$donor) {
            return null;
        }

        // Niveau de fidélité
        if (!empty($donor['niveau_id'])) {
            $stmt = $this->db->prepare("SELECT * FROM niveaux_fidelite WHERE id = :id");
            $stmt->execute(['id' => $donor['niveau_id']]);
            $donor['niveau'] = $stmt->fetch() ?: null;
        }

        // Badges obtenus
        $badgeStmt = $this->db->prepare("
            SELECT b.*, db.date_obtenu
            FROM badges b
            JOIN donateur_badges db ON db.badge_id = b.id
            WHERE db.donateur_id = :id
            ORDER BY db.date_obtenu DESC
        ");
        $badgeStmt->execute(['id' => $donorId]);
        $donor['badges'] = $badgeStmt->fetchAll();

        // Historique des dons
        $donStmt = $this->db->prepare("
            SELECT d.*, a.titre AS action_titre, t.statut AS statut_transaction, 
                   t.operateur_paiement, t.reference_transaction, t.date_transaction
            FROM dons d
            LEFT JOIN actions a ON a.id = d.action_id
            LEFT JOIN transactions t ON t.don_id = d.id
            WHERE d.donateur_id = :id
            ORDER BY d.date_don DESC
        ");
        $donStmt->execute(['id' => $donorId]);
        $donor['dons'] = $donStmt->fetchAll();

        return $donor;
    }

    /** Récupère les donateurs réguliers sans dépendre d'une vue SQL. */
    public function getRegularDonors(): array
    {
        $sql = "
            SELECT d.id AS donateur_id, d.nom, d.prenom, d.telephone, d.email,
                   COUNT(dn.id) AS nombre_dons, COALESCE(SUM(dn.montant), 0) AS montant_total
            FROM donateurs d
            JOIN dons dn ON dn.donateur_id = d.id
            GROUP BY d.id, d.nom, d.prenom, d.telephone, d.email
            HAVING COUNT(dn.id) >= 3
            ORDER BY montant_total DESC
        ";
        return $this->rawQuery($sql);
    }

    /** Récupère les donateurs inactifs depuis 6 mois sans dépendre d'une vue SQL. */
    public function getInactiveDonors(): array
    {
        return $this->rawQuery("
            SELECT d.id, d.nom, d.prenom, MAX(dn.date_don) AS dernier_don
            FROM donateurs d
            LEFT JOIN dons dn ON dn.donateur_id = d.id
            GROUP BY d.id, d.nom, d.prenom
            HAVING dernier_don IS NULL OR dernier_don < DATE_SUB(NOW(), INTERVAL 6 MONTH)
            ORDER BY dernier_don ASC
        ");
    }
}
