/**
 * Widget Assistant IA de l'ONG (Innovation 1)
 */

document.addEventListener('DOMContentLoaded', () => {
    const toggleBtn = document.getElementById('chatbot-toggle-btn');
    const closeBtn = document.getElementById('chatbot-close-btn');
    const windowEl = document.getElementById('chatbot-window');
    const form = document.getElementById('chatbot-form');
    const input = document.getElementById('chatbot-input');
    const messagesContainer = document.getElementById('chatbot-messages');

    if (!toggleBtn || !windowEl) return;

    // Toggle de la fenêtre
    toggleBtn.addEventListener('click', () => {
        windowEl.classList.toggle('hidden');
        if (!windowEl.classList.contains('hidden')) {
            input.focus();
        }
    });

    closeBtn.addEventListener('click', () => {
        windowEl.classList.add('hidden');
    });

    // Envoi de message
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const text = input.value.trim();
        if (!text) return;

        appendUserMessage(text);
        input.value = '';

        try {
            const res = await fetch('/api/chatbot', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ message: text })
            });

            const data = await res.json();
            if (data.success && data.data) {
                appendBotMessage(data.data.message, data.data.suggestions, data.data.suggested_actions);
            } else {
                appendBotMessage("Désolé, je rencontre une difficulté momentanée. Veuillez réessayer dans quelques instants.");
            }
        } catch (err) {
            appendBotMessage("Impossible de joindre le serveur. Veuillez vérifier votre connexion.");
        }
    });

    // Clic sur les suggestions rapides
    document.addEventListener('click', (e) => {
        if (e.target.classList.contains('chat-suggestion-chip')) {
            const query = e.target.dataset.query || e.target.textContent;
            input.value = query;
            form.dispatchEvent(new Event('submit'));
        }
    });

    function appendUserMessage(msg) {
        const div = document.createElement('div');
        div.className = 'chat-message user';
        div.textContent = msg;
        messagesContainer.appendChild(div);
        scrollToBottom();
    }

    function appendBotMessage(msg, suggestions = [], actions = []) {
        const div = document.createElement('div');
        div.className = 'chat-message bot';
        
        let html = `<p>${escapeHtml(msg)}</p>`;

        // Actions suggérées avec lien
        if (actions && actions.length > 0) {
            html += '<div style="margin-top: 8px; font-size: 0.85rem;">';
            actions.forEach(act => {
                html += `<div style="background:#fff; border:1px solid #cbd5e1; border-radius:6px; padding:6px; margin-top:4px;">
                    <strong>${escapeHtml(act.titre)}</strong><br>
                    <a href="/actions/${act.id}" style="color:#0284c7; font-weight:600;">Voir l'action →</a>
                </div>`;
            });
            html += '</div>';
        }

        // Puces de suggestions
        if (suggestions && suggestions.length > 0) {
            html += '<div class="chat-suggestions">';
            suggestions.forEach(sug => {
                html += `<button class="chat-suggestion-chip" data-query="${escapeHtml(sug)}">${escapeHtml(sug)}</button>`;
            });
            html += '</div>';
        }

        div.innerHTML = html;
        messagesContainer.appendChild(div);
        scrollToBottom();
    }

    function scrollToBottom() {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
});
