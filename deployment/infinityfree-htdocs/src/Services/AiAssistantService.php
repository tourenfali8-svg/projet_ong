<?php

namespace App\Services;

use App\Models\Action;
use App\Models\UrgentNeed;
use App\Models\Chatbot;

/**
 * Service de l'Assistant IA / Chatbot de l'ONG (Innovation 1)
 */
class AiAssistantService
{
    private Chatbot $chatbotModel;

    public function __construct()
    {
        $this->chatbotModel = new Chatbot();
    }

    /**
     * Traite un message utilisateur et formule une réponse intelligente adaptée
     */
    public function reply(string $userMessage, string $sessionId, ?int $donorId = null): array
    {
        $conversationId = $this->chatbotModel->getOrCreateConversation($sessionId, $donorId);

        // Enregistre la question du visiteur
        $this->chatbotModel->logMessage($conversationId, 'visiteur', $userMessage);

        $response = $this->generateSmartAnswer($userMessage);

        // Enregistre la réponse de l'assistant
        $this->chatbotModel->logMessage($conversationId, 'bot', $response['message']);

        return [
            'conversation_id' => $conversationId,
            'message' => $response['message'],
            'suggestions' => $response['suggestions'] ?? [],
            'suggested_actions' => $response['suggested_actions'] ?? []
        ];
    }

    /**
     * Moteur de compréhension contextuelle et d'orientation du visiteur
     */
    private function generateSmartAnswer(string $input): array
    {
        $clean = mb_strtolower(trim($input));
        $actionModel = new Action();
        $urgentModel = new UrgentNeed();

        // 1. Demandes de dons / soutien financier
        if (
            str_contains($clean, 'don') ||
            str_contains($clean, 'donner') ||
            str_contains($clean, 'soutenir') ||
            str_contains($clean, 'aider') ||
            str_contains($clean, 'contribuer')
        ) {
            $actions = $actionModel->getWithDetails('en_cours', 2);
            return [
                'message' => "Pour soutenir la mission de l'ONG AL HIKMAH, vous pouvez faire un don ponctuel ou récurrent. Chaque contribution aide à financer les actions de terrain, les besoins urgents et les projets de développement. Vous pouvez aussi suivre l'impact et obtenir des récompenses solidaires.",
                'suggestions' => ["Faire un don maintenant", "Voir les besoins urgents", "Comment sont utilisés les dons ?"],
                'suggested_actions' => $actions
            ];
        }

        // 2. Besoins urgents / urgences
        if (
            str_contains($clean, 'urgence') ||
            str_contains($clean, 'urgent') ||
            str_contains($clean, 'priorit') ||
            str_contains($clean, 'besoin')
        ) {
            $urgents = $urgentModel->getActiveUrgentNeeds(2);
            return [
                'message' => "Voici les situations prioritaires actuellement prises en charge par l'ONG AL HIKMAH. Votre aide peut permettre une réponse rapide sur le terrain, que ce soit pour des besoins alimentaires, médicaux, éducatifs ou de logement.",
                'suggestions' => ["Voir tous les besoins urgents", "Faire un don direct", "Devenir bénévole"],
                'suggested_actions' => $urgents
            ];
        }

        // 3. Bénévolat / missions
        if (
            str_contains($clean, 'benevole') ||
            str_contains($clean, 'bénévole') ||
            str_contains($clean, 'rejoindre') ||
            str_contains($clean, 'mission') ||
            str_contains($clean, 'postuler')
        ) {
            return [
                'message' => "L'ONG AL HIKMAH accueille des bénévoles engagés pour appuyer les missions de terrain, la communication, la logistique, l'éducation et l'accompagnement des jeunes. Vous pouvez postuler directement pour une mission ou proposer vos compétences spontanément.",
                'suggestions' => ["Découvrir les missions de bénévolat", "Postuler comme bénévole", "Contacter l'équipe"]
            ];
        }

        // 4. Nos actions / projets / programmes
        if (
            str_contains($clean, 'action') ||
            str_contains($clean, 'programme') ||
            str_contains($clean, 'projet') ||
            str_contains($clean, 'realisation') ||
            str_contains($clean, 'concret')
        ) {
            $actions = $actionModel->getWithDetails('en_cours', 3);
            return [
                'message' => "L'ONG AL HIKMAH mène plusieurs actions concrètes autour de l'éducation, des valeurs culturelles, de l'accompagnement des jeunes et des réponses aux besoins urgents. Voici quelques initiatives en cours :",
                'suggestions' => ["Voir les actions en cours", "Voir les besoins urgents", "Faire un don"],
                'suggested_actions' => $actions
            ];
        }

        // 5. Impact / résultats
        if (
            str_contains($clean, 'impact') ||
            str_contains($clean, 'resultat') ||
            str_contains($clean, 'statistique') ||
            str_contains($clean, 'suivi')
        ) {
            return [
                'message' => "L'ONG AL HIKMAH met un point d'honneur à la transparence. Les actions, les dons et les projets sont suivis avec des rapports d'impact, des photos avant/après et des indicateurs de progrès pour montrer concrètement l'effet du soutien apporté.",
                'suggestions' => ["Consulter les actions", "Voir les besoins urgents", "Faire un don"]
            ];
        }

        // 6. Contact / WhatsApp / téléphone
        if (
            str_contains($clean, 'contact') ||
            str_contains($clean, 'telephone') ||
            str_contains($clean, 'whatsapp') ||
            str_contains($clean, 'email') ||
            str_contains($clean, 'contacter')
        ) {
            return [
                'message' => "Vous pouvez contacter l'ONG AL HIKMAH directement via WhatsApp au numéro +225 0507674208, ou envoyer un message par email à alhikmah050767@gmail.com. Vous pouvez aussi remplir le formulaire de contact depuis la page À Propos.",
                'suggestions' => ["Faire un don", "Devenir bénévole", "Voir la page À Propos"]
            ];
        }

        // 7. Présentation de l'ONG
        if (
            str_contains($clean, 'qui êtes-vous') ||
            str_contains($clean, 'mission') ||
            str_contains($clean, 'ong') ||
            str_contains($clean, 'objectif') ||
            str_contains($clean, 'presentation')
        ) {
            return [
                'message' => "L'ONG AL HIKMAH est une organisation dédiée à l'éducation, à la transmission des valeurs culturelles, à l'accompagnement des jeunes et au développement durable au service des communautés.",
                'suggestions' => ["Voir nos actions", "Consulter le tableau d'impact", "Faire un don"]
            ];
        }

        // 8. Transparence et utilisation des fonds
        if (
            str_contains($clean, 'transparence') ||
            str_contains($clean, 'argent') ||
            str_contains($clean, 'justificatif') ||
            str_contains($clean, 'reçu') ||
            str_contains($clean, 'recu')
        ) {
            return [
                'message' => "La transparence est l'un des piliers de l'ONG AL HIKMAH. Les supports de collecte, les objectifs et les résultats sont accompagnés de suivis clairs afin que chaque donateur puisse voir l'impact réel de son soutien.",
                'suggestions' => ["Consulter les actions", "Voir les besoins urgents", "Faire un don"]
            ];
        }

        // Réponse par défaut bienveillante
        return [
            'message' => "Bonjour ! Je suis l'assistant virtuel de l'ONG AL HIKMAH. Je peux vous orienter vers nos actions, nos urgences, les démarches de don et les possibilités de bénévolat. Que souhaitez-vous explorer ?",
            'suggestions' => [
                "Quelles sont vos actions en cours ?",
                "Comment faire un don ?",
                "Quels sont les besoins urgents ?",
                "Comment devenir bénévole ?",
                "Comment nous contacter ?"
            ]
        ];
    }
}
