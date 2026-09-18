<?php

namespace App\Models;

use App\Core\Model;

/**
 * Modèle pour l'historique et les messages du Chatbot IA (Innovation 1)
 */
class Chatbot extends Model
{
    protected string $table = 'conversations_chatbot';

    /**
     * Recherche ou démarre une conversation pour une session donnée
     */
    public function getOrCreateConversation(string $sessionId, ?int $donorId = null): int
    {
        $existing = $this->findFirst(['session_id' => $sessionId]);
        if ($existing) {
            return (int)$existing['id'];
        }

        return $this->create([
            'session_id' => $sessionId,
            'donateur_id' => $donorId
        ]);
    }

    /**
     * Enregistre un message dans une conversation
     */
    public function logMessage(int $conversationId, string $emetteur, string $contenu): int
    {
        $stmt = $this->db->prepare("
            INSERT INTO messages_chatbot (conversation_id, emetteur, contenu, date_envoi)
            VALUES (:conversation_id, :emetteur, :contenu, NOW())
        ");
        $stmt->execute([
            'conversation_id' => $conversationId,
            'emetteur' => $emetteur,
            'contenu' => $contenu
        ]);
        return (int)$this->db->lastInsertId();
    }

    /**
     * Récupère les derniers messages d'une conversation
     */
    public function getMessages(int $conversationId, int $limit = 30): array
    {
        $stmt = $this->db->prepare("
            SELECT * FROM messages_chatbot 
            WHERE conversation_id = :cid 
            ORDER BY id ASC 
            LIMIT {$limit}
        ");
        $stmt->execute(['cid' => $conversationId]);
        return $stmt->fetchAll();
    }
}
