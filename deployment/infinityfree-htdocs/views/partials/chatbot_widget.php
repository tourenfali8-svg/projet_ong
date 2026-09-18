<!-- Widget Assistant IA de l'ONG (Innovation 1) -->
<div id="ong-chatbot-widget" class="chatbot-container">
    <button id="chatbot-toggle-btn" class="chatbot-toggle-btn" title="Discuter avec notre Assistant IA">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
        </svg>
        <span class="chatbot-badge">IA 24/7</span>
    </button>

    <div id="chatbot-window" class="chatbot-window hidden">
        <div class="chatbot-header">
            <div class="chatbot-header-title">
                <span class="status-dot"></span>
                <strong>Assistant Virtuel ONG</strong>
            </div>
            <button id="chatbot-close-btn" class="chatbot-close-btn">&times;</button>
        </div>

        <div id="chatbot-messages" class="chatbot-messages">
            <div class="chat-message bot">
                <p>Bonjour ! Je suis l'assistant virtuel de l'ONG. Comment puis-je vous aider aujourd'hui ?</p>
                <div class="chat-suggestions">
                    <button class="chat-suggestion-chip" data-query="Comment faire un don ?">Faire un don</button>
                    <button class="chat-suggestion-chip" data-query="Quelles sont vos actions en cours ?">Nos actions</button>
                    <button class="chat-suggestion-chip" data-query="Quels sont les besoins urgents ?">Besoins urgents</button>
                    <button class="chat-suggestion-chip" data-query="Comment devenir bénévole ?">Devenir bénévole</button>
                    <button class="chat-suggestion-chip" data-query="Comment nous contacter ?">Contact</button>
                    <button class="chat-suggestion-chip" data-query="Quelle est votre mission ?">À propos</button>
                </div>
            </div>
        </div>

        <form id="chatbot-form" class="chatbot-input-area">
            <input type="text" id="chatbot-input" placeholder="Posez votre question..." autocomplete="off" required>
            <button type="submit" id="chatbot-send-btn">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="22" y1="2" x2="11" y2="13"></line>
                    <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                </svg>
            </button>
        </form>
    </div>
</div>
