<?php

namespace App\Models;

use App\Core\Model;

/**
 * Modèle des Notifications Donateurs (Innovation 8)
 */
class Notification extends Model
{
    protected string $table = 'notifications';

    /**
     * Envoie une notification à un donateur
     */
    public function send(int $donorId, string $type, string $titre, string $message): int
    {
        return $this->create([
            'donateur_id' => $donorId,
            'type_notification' => $type,
            'titre' => $titre,
            'message' => $message,
            'lu' => 0
        ]);
    }

    /**
     * Récupère les notifications non lues d'un donateur
     */
    public function getUnreadForDonor(int $donorId): array
    {
        return $this->where([
            'donateur_id' => $donorId,
            'lu' => 0
        ], 'id DESC');
    }
}
