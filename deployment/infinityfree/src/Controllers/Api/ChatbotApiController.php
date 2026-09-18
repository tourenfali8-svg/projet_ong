<?php

namespace App\Controllers\Api;

use App\Core\Controller;
use App\Core\Request;
use App\Services\AiAssistantService;

/**
 * Contrôleur API pour l'Assistant IA / Chatbot de l'ONG (Innovation 1)
 */
class ChatbotApiController extends Controller
{
    public function message(Request $request): void
    {
        $input = $request->getJson();
        $message = trim($input['message'] ?? $request->post('message', ''));
        $sessionId = trim($input['session_id'] ?? $request->post('session_id', session_id()));

        if (empty($message)) {
            $this->json(['error' => 'Le message ne peut pas être vide.'], 400);
        }

        $aiService = new AiAssistantService();
        $reply = $aiService->reply($message, $sessionId);

        $this->json([
            'success' => true,
            'data' => $reply
        ]);
    }
}
