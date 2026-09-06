<!-- AI Assistant Floating Button -->
<div id="ai-assistant-toggle" class="ai-assistant-toggle">
    <div class="ai-assistant-icon">
        <i class="fa-solid fa-robot"></i>
    </div>
    <span class="ai-assistant-label">Tanya AI</span>
</div>

<!-- AI Assistant Chat Interface -->
<div id="ai-assistant-chat" class="ai-assistant-chat">
    <!-- Header -->
    <div class="ai-assistant-header">
        <div class="ai-assistant-avatar">
            <i class="fa-solid fa-robot"></i>
        </div>
        <div class="ai-assistant-header-content">
            <h3 class="ai-assistant-title">Asisten AI MindMap</h3>
            <p class="ai-assistant-subtitle">Siap membantu belajar kamu!</p>
        </div>
        <button id="ai-assistant-close" class="ai-assistant-close">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    <!-- Chat Messages -->
    <div id="ai-assistant-messages" class="ai-assistant-messages">
        <!-- Welcome message from AI -->
        <div class="ai-message ai-message-assistant">
            <div class="ai-message-avatar"><i class="fa-solid fa-robot"></i></div>
            <div class="ai-message-body">
                <div class="ai-message-content">
                    <p>Halo! 👋<br>Saya Asisten AI MindMap. Ada yang bisa saya bantu terkait materi &ldquo;Membaca Teks Sederhana&rdquo;?</p>
                </div>
                <div class="ai-message-time">07:42</div>
            </div>
        </div>
    </div>

    <!-- Input Area -->
    <div class="ai-assistant-input">
        <div class="ai-input-wrapper">
            <button id="ai-attach-btn" class="ai-attach-btn" type="button">
                <i class="fa-solid fa-paperclip"></i>
            </button>
            <input
                type="text"
                id="ai-message-input"
                class="ai-message-input"
                placeholder="Tulis pesan..."
                autocomplete="off"
            >
            <button id="ai-send-btn" class="ai-send-btn" type="button">
                <i class="fa-solid fa-paper-plane"></i>
            </button>
        </div>
    </div>
</div>

<style>
:root {
    --ai-primary: #7C815D;
    --ai-primary-dark: #656A49;
    --ai-primary-light: #EEF0E6;
    --ai-bg: #FAFAF7;
    --ai-bubble-assistant: #EFEFEC;
    --ai-text: #33352A;
    --ai-text-muted: #8B8D7E;
    --ai-border: #E7E7E0;
}

/* Floating toggle button */
.ai-assistant-toggle {
    position: fixed;
    bottom: 30px;
    right: 30px;
    width: auto;
    min-width: 60px;
    height: 60px;
    border-radius: 30px;
    background: var(--ai-primary);
    box-shadow: 0 8px 20px rgba(124, 129, 93, 0.45);
    cursor: pointer;
    z-index: 99999;
    display: none; /* Hidden by default, shown via CSS class */
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 0 20px;
    transition: transform 0.25s ease, box-shadow 0.25s ease, background 0.25s ease;
    pointer-events: auto;
    -webkit-tap-highlight-color: transparent;
    user-select: none;
}

.ai-assistant-toggle.visible {
    display: flex;
}

.ai-assistant-toggle:hover {
    transform: scale(1.08);
    box-shadow: 0 10px 24px rgba(124, 129, 93, 0.6);
    background: var(--ai-primary-dark);
}

.ai-assistant-icon {
    color: white;
    font-size: 26px;
}

.ai-assistant-label {
    color: white;
    font-size: 15px;
    font-weight: 600;
    white-space: nowrap;
}

/* Chat window */
.ai-assistant-chat {
    position: fixed;
    bottom: 100px;
    right: 30px;
    width: 380px;
    max-width: calc(100vw - 60px);
    height: 620px;
    max-height: calc(100vh - 130px);
    background: var(--ai-bg);
    border-radius: 22px;
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.18);
    z-index: 9998;
    display: none; /* Hidden by default */
    flex-direction: column;
    overflow: hidden;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
}

.ai-assistant-chat.active {
    display: flex !important;
}

/* Header */
.ai-assistant-header {
    background: var(--ai-primary);
    padding: 18px 18px;
    display: flex;
    align-items: center;
    gap: 12px;
    color: white;
}

.ai-assistant-avatar {
    width: 40px;
    height: 40px;
    min-width: 40px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.18);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    color: white;
}

.ai-assistant-header-content {
    flex: 1;
    min-width: 0;
}

.ai-assistant-header-content h3 {
    margin: 0;
    font-size: 16px;
    font-weight: 700;
    line-height: 1.2;
    color: white;
}

.ai-assistant-header-content p {
    margin: 3px 0 0 0;
    font-size: 12.5px;
    opacity: 0.85;
    color: white;
}

.ai-assistant-close {
    background: transparent;
    border: none;
    color: white;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
    opacity: 0.9;
    transition: background 0.2s, opacity 0.2s;
}

.ai-assistant-close:hover {
    background: rgba(255, 255, 255, 0.18);
    opacity: 1;
}

/* Messages */
.ai-assistant-messages {
    flex: 1;
    overflow-y: auto;
    padding: 20px 16px;
    background: var(--ai-bg);
    display: flex;
    flex-direction: column;
    gap: 16px;
    overscroll-behavior: contain;
    -webkit-overflow-scrolling: touch;
}

.ai-message {
    display: flex;
    gap: 10px;
    max-width: 100%;
}

.ai-message-assistant {
    align-self: flex-start;
    flex-direction: row;
}

.ai-message-user {
    align-self: flex-end;
    flex-direction: row-reverse;
}

.ai-message-avatar {
    width: 30px;
    height: 30px;
    min-width: 30px;
    border-radius: 50%;
    background: var(--ai-primary);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    margin-top: 2px;
}

.ai-message-body {
    display: flex;
    flex-direction: column;
    max-width: 78%;
}

.ai-message-user .ai-message-body {
    align-items: flex-end;
}

.ai-message-content {
    padding: 12px 15px;
    border-radius: 16px;
    font-size: 14px;
    line-height: 1.55;
}

.ai-message-content p {
    margin: 0 0 10px 0;
}

.ai-message-content p:last-child {
    margin-bottom: 0;
}

.ai-message-content h1,
.ai-message-content h2,
.ai-message-content h3,
.ai-message-content h4,
.ai-message-content h5,
.ai-message-content h6 {
    margin: 12px 0 8px 0;
    font-weight: 600;
    line-height: 1.3;
}

.ai-message-content h1 { font-size: 18px; }
.ai-message-content h2 { font-size: 16px; }
.ai-message-content h3 { font-size: 15px; }
.ai-message-content h4 { font-size: 14px; }

.ai-message-content ol,
.ai-message-content ul {
    margin: 8px 0;
    padding-left: 20px;
}

.ai-message-content li {
    margin-bottom: 6px;
    line-height: 1.5;
}

.ai-message-content ul {
    list-style-type: disc;
}

.ai-message-content ol {
    list-style-type: decimal;
}

.ai-message-content code {
    background: rgba(0, 0, 0, 0.06);
    padding: 2px 6px;
    border-radius: 4px;
    font-family: 'Courier New', monospace;
    font-size: 13px;
}

.ai-message-content pre {
    background: rgba(0, 0, 0, 0.06);
    padding: 12px;
    border-radius: 8px;
    overflow-x: auto;
    margin: 10px 0;
}

.ai-message-content pre code {
    background: none;
    padding: 0;
}

.ai-message-content blockquote {
    border-left: 3px solid var(--ai-primary);
    padding-left: 12px;
    margin: 10px 0;
    color: var(--ai-text-muted);
    font-style: italic;
}

.ai-message-content table {
    width: 100%;
    border-collapse: collapse;
    margin: 10px 0;
    font-size: 12px;
    table-layout: auto;
}

.ai-message-content th,
.ai-message-content td {
    border: 1px solid var(--ai-border);
    padding: 6px 8px;
    text-align: left;
    max-width: 150px;
    word-wrap: break-word;
    hyphens: auto;
}

.ai-message-content th {
    background: var(--ai-primary-light);
    font-weight: 600;
    white-space: nowrap;
}

.ai-message-content td {
    white-space: normal;
}

/* Table wrapper for horizontal scrolling */
.ai-message-content .table-wrapper {
    overflow-x: auto;
    margin: 10px 0;
    border-radius: 8px;
    border: 1px solid var(--ai-border);
    max-width: 100%;
    -webkit-overflow-scrolling: touch;
}

.ai-message-content .table-wrapper table {
    margin: 0;
    border: none;
    min-width: 100%;
}

/* Custom scrollbar for table wrapper */
.ai-message-content .table-wrapper::-webkit-scrollbar {
    height: 6px;
}

.ai-message-content .table-wrapper::-webkit-scrollbar-track {
    background: var(--ai-bg);
    border-radius: 3px;
}

.ai-message-content .table-wrapper::-webkit-scrollbar-thumb {
    background: var(--ai-text-muted);
    border-radius: 3px;
}

.ai-message-content .table-wrapper::-webkit-scrollbar-thumb:hover {
    background: var(--ai-primary);
}

.ai-message-content strong {
    font-weight: 600;
}

.ai-message-content em {
    font-style: italic;
}

.ai-message-content a {
    color: var(--ai-primary);
    text-decoration: underline;
}

.ai-message-content hr {
    border: none;
    border-top: 1px solid var(--ai-border);
    margin: 12px 0;
}

.ai-message-assistant .ai-message-content {
    background: var(--ai-bubble-assistant);
    color: var(--ai-text);
    border-top-left-radius: 4px;
}

.ai-message-user .ai-message-content {
    background: var(--ai-primary);
    color: white;
    border-top-right-radius: 4px;
}

.ai-message-time {
    font-size: 11px;
    color: var(--ai-text-muted);
    margin-top: 5px;
    padding: 0 4px;
}

/* Input */
.ai-assistant-input {
    padding: 14px 16px 16px;
    background: var(--ai-bg);
}

.ai-input-wrapper {
    display: flex;
    align-items: center;
    gap: 8px;
    background: white;
    border: 1px solid var(--ai-border);
    border-radius: 999px;
    padding: 6px 6px 6px 16px;
}

.ai-attach-btn {
    background: none;
    border: none;
    cursor: pointer;
    color: var(--ai-text-muted);
    font-size: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: color 0.2s;
}

.ai-attach-btn:hover {
    color: var(--ai-primary);
}

.ai-message-input {
    flex: 1;
    border: none;
    background: transparent;
    outline: none;
    font-size: 14px;
    color: var(--ai-text);
    min-width: 0;
}

.ai-message-input::placeholder {
    color: #b7b9a9;
}

.ai-send-btn {
    background: var(--ai-primary);
    border: none;
    color: white;
    width: 36px;
    height: 36px;
    min-width: 36px;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    transition: background 0.2s, transform 0.15s;
}

.ai-send-btn:hover {
    background: var(--ai-primary-dark);
    transform: scale(1.05);
}

/* Typing indicator */
.ai-typing-indicator {
    display: flex;
    gap: 4px;
    padding: 12px 16px;
    background: var(--ai-bubble-assistant);
    border-radius: 16px;
    border-top-left-radius: 4px;
    width: fit-content;
}

.ai-typing-indicator span {
    width: 7px;
    height: 7px;
    background: var(--ai-text-muted);
    border-radius: 50%;
    animation: ai-typing 1.4s infinite;
}

.ai-typing-indicator span:nth-child(2) { animation-delay: 0.2s; }
.ai-typing-indicator span:nth-child(3) { animation-delay: 0.4s; }

@keyframes ai-typing {
    0%, 60%, 100% { transform: translateY(0); }
    30% { transform: translateY(-4px); }
}

/* Responsive */
@media (max-width: 480px) {
    .ai-assistant-chat {
        width: calc(100vw - 40px);
        right: 20px;
        bottom: 100px;
        height: calc(100vh - 200px);
    }
    .ai-assistant-toggle {
        bottom: 20px;
        right: 20px;
        padding: 0 15px;
    }
    .ai-assistant-label {
        font-size: 14px;
    }
    .ai-message-body { max-width: 85%; }
}
</style>

<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Configure marked.js for better markdown parsing
    marked.setOptions({
        breaks: true,
        gfm: true,
        sanitize: false,
        smartLists: true,
        smartypants: false
    });

    // Custom renderer to wrap tables in scrollable container
    const renderer = new marked.Renderer();
    const originalTableRenderer = renderer.table.bind(renderer);

    renderer.table = function(header, body) {
        return '<div class="table-wrapper"><table>' + header + body + '</table></div>';
    };

    marked.setOptions({ renderer: renderer });
    const aiToggle = document.getElementById('ai-assistant-toggle');
    const aiChat = document.getElementById('ai-assistant-chat');
    const aiClose = document.getElementById('ai-assistant-close');
    const aiInput = document.getElementById('ai-message-input');
    const aiSendBtn = document.getElementById('ai-send-btn');
    const aiMessages = document.getElementById('ai-assistant-messages');

    // Check if elements exist before adding event listeners
    if (aiToggle && aiChat) {
        aiToggle.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            aiChat.classList.toggle('active');
            if (aiChat.classList.contains('active')) aiInput.focus();
        });
    }

    aiClose.addEventListener('click', function () {
        aiChat.classList.remove('active');
    });

    function formatTime() {
        return new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
    }

    function addMessage(content, type) {
        const wrap = document.createElement('div');
        wrap.className = `ai-message ai-message-${type}`;

        const avatar = type === 'assistant'
            ? `<div class="ai-message-avatar"><i class="fa-solid fa-robot"></i></div>`
            : '';

        // Parse markdown for assistant messages
        const parsedContent = type === 'assistant'
            ? marked.parse(content)
            : content;

        wrap.innerHTML = `
            ${avatar}
            <div class="ai-message-body">
                <div class="ai-message-content">${parsedContent}</div>
                <div class="ai-message-time">${formatTime()}</div>
            </div>
        `;
        aiMessages.appendChild(wrap);

        // Scroll behavior based on message type
        if (type === 'user') {
            // For user messages, scroll to bottom to show their message
            aiMessages.scrollTop = aiMessages.scrollHeight;
        } else if (type === 'assistant') {
            // For assistant messages, scroll to the top of the AI message
            // so user sees the beginning of the response
            wrap.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }

    function showTyping() {
        const div = document.createElement('div');
        div.className = 'ai-message ai-message-assistant';
        div.id = 'ai-typing';
        div.innerHTML = `
            <div class="ai-message-avatar"><i class="fa-solid fa-robot"></i></div>
            <div class="ai-typing-indicator"><span></span><span></span><span></span></div>
        `;
        aiMessages.appendChild(div);
        aiMessages.scrollTop = aiMessages.scrollHeight;
    }

    function removeTyping() {
        const t = document.getElementById('ai-typing');
        if (t) t.remove();
    }

    function sendMessage(message) {
        if (!message.trim()) return;
        addMessage(message, 'user');
        aiInput.value = '';
        aiInput.blur(); // Close keyboard on mobile after sending
        showTyping();

        // Check if user is authenticated
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        console.log('CSRF Token:', csrfToken ? 'Present' : 'Missing');

        if (!csrfToken) {
            removeTyping();
            addMessage('Maaf, terjadi kesalahan dengan CSRF token. Silakan refresh halaman.', 'assistant');
            return;
        }

        // Get material content from the page
        const materialContentElement = document.getElementById('material-content');
        let materialContent = '';

        if (materialContentElement) {
            const materialTitle = materialContentElement.getAttribute('data-material-title') || '';
            const materialDescription = materialContentElement.getAttribute('data-material-description') || '';
            const materialContentText = materialContentElement.getAttribute('data-material-content') || '';

            // Build material context string
            materialContent = `Judul Materi: ${materialTitle}\nDeskripsi: ${materialDescription}\nKonten Materi: ${materialContentText}`;

            // Also add kontenMateri if available
            if (typeof window.kontenMateri !== 'undefined' && Array.isArray(window.kontenMateri)) {
                const kontenMateriText = window.kontenMateri.map(item => {
                    if (item.type === 'heading') {
                        return `${'#'.repeat(item.level || 2)} ${item.content}`;
                    } else if (item.type === 'paragraph') {
                        return item.content;
                    } else if (item.type === 'list' && Array.isArray(item.content)) {
                        return item.content.map(li => `- ${li}`).join('\n');
                    } else if (item.type === 'code') {
                        return `Contoh Kode:\n${item.content}`;
                    } else if (item.type === 'image') {
                        return `[Gambar: ${item.content}]`;
                    }
                    return '';
                }).join('\n\n');

                materialContent += `\n\nKonten Detail:\n${kontenMateriText}`;
            }

            console.log('Material content found:', materialContent.substring(0, 100) + '...');
        } else {
            console.log('Material content element not found');
        }

        fetch('/api/ai/chat', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
            body: JSON.stringify({ message: message, material_content: materialContent, history: [] })
        })
        .then(response => {
            console.log('Response status:', response.status);
            console.log('Response ok:', response.ok);

            // Handle authentication errors
            if (response.status === 401) {
                removeTyping();
                addMessage('Maaf, Anda perlu login untuk menggunakan fitur AI assistant.', 'assistant');
                return Promise.reject('Unauthorized');
            }
            // Handle rate limit errors
            if (response.status === 429) {
                removeTyping();
                addMessage('Maaf, limit penggunaan AI harian telah tercapai. Silakan coba lagi nanti.', 'assistant');
                return Promise.reject('Rate limit exceeded');
            }
            // Handle server errors
            if (!response.ok) {
                removeTyping();
                return response.text().then(text => {
                    console.error('Server error response:', text);
                    addMessage('Maaf, terjadi kesalahan server (' + response.status + '). Silakan coba lagi.', 'assistant');
                    return Promise.reject('Server error: ' + text);
                });
            }
            return response.json();
        })
        .then(data => {
            removeTyping();

            // Debug: log the response structure
            console.log('API Response:', data);

            // Handle different response structures
            let messageContent = '';

            if (typeof data === 'string') {
                messageContent = data;
            } else if (data && typeof data === 'object') {
                // Try different possible message fields
                messageContent = data.message || data.response || data.content || data.text || data.answer || '';

                // If message is an object, convert to string
                if (typeof messageContent === 'object' && messageContent !== null) {
                    messageContent = JSON.stringify(messageContent);
                }
            }

            if (messageContent && typeof messageContent === 'string') {
                addMessage(messageContent, 'assistant');
            } else if (data && data.error) {
                addMessage('Maaf, ' + data.error, 'assistant');
            } else {
                addMessage('Maaf, terjadi kesalahan. Silakan coba lagi.', 'assistant');
            }
        })
        .catch(error => {
            if (error === 'Unauthorized' || error === 'Rate limit exceeded' || error.startsWith('Server error')) {
                // Error already handled in the .then() block
                return;
            }
            removeTyping();
            console.error('API Error:', error);
            addMessage('Maaf, terjadi kesalahan koneksi. Silakan coba lagi.', 'assistant');
        });
    }

    aiSendBtn.addEventListener('click', () => sendMessage(aiInput.value));
    aiInput.addEventListener('keypress', (e) => { if (e.key === 'Enter') sendMessage(aiInput.value); });

    // Show keyboard when user taps on input field
    aiInput.addEventListener('focus', function() {
        // On mobile, this will automatically show the keyboard
        // No additional action needed as focus() triggers keyboard
    });

    // Prevent scroll propagation from AI assistant to main page
    aiChat.addEventListener('wheel', function(e) {
        e.stopPropagation();
    }, { passive: false });

    aiChat.addEventListener('touchmove', function(e) {
        e.stopPropagation();
    }, { passive: false });

    // Handle scroll within messages container
    aiMessages.addEventListener('wheel', function(e) {
        const scrollTop = aiMessages.scrollTop;
        const scrollHeight = aiMessages.scrollHeight;
        const clientHeight = aiMessages.clientHeight;
        const delta = e.deltaY;

        // Allow normal scroll within messages, but prevent at boundaries
        if ((scrollTop <= 0 && delta < 0) || (scrollTop + clientHeight >= scrollHeight && delta > 0)) {
            e.preventDefault();
        }
    }, { passive: false });

    aiMessages.addEventListener('touchstart', function(e) {
        this.touchStartY = e.touches[0].clientY;
    }, { passive: true });

    aiMessages.addEventListener('touchmove', function(e) {
        const touchStartY = this.touchStartY || 0;
        const touchEndY = e.touches[0].clientY;
        const deltaY = touchStartY - touchEndY;

        const scrollTop = aiMessages.scrollTop;
        const scrollHeight = aiMessages.scrollHeight;
        const clientHeight = aiMessages.clientHeight;

        // Allow normal scroll within messages, but prevent at boundaries
        if ((scrollTop <= 0 && deltaY < 0) || (scrollTop + clientHeight >= scrollHeight && deltaY > 0)) {
            e.preventDefault();
        }
    }, { passive: false });

    document.addEventListener('click', function (e) {
        if (aiChat && aiToggle && !aiChat.contains(e.target) && !aiToggle.contains(e.target)) {
            aiChat.classList.remove('active');
        }
    });
});
</script>