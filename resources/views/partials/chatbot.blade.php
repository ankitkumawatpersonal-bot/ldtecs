<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    {{-- LDTECS AI Chatbot Popup: merged design + Laravel integration --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    :root {
        --ld-bg: #0a0a0f;
        --ld-surface: #13131a;
        --ld-border: #29283a;
        --ld-accent: #24a19c;
        --ld-accent-glow: rgba(36, 161, 156, .25);
        --ld-accent-soft: rgba(36, 161, 156, .13);
        --ld-text: #e8e6f0;
        --ld-muted: #9995aa;
        --ld-user: #173a39;
        --ld-bot: #171720;
        --ld-green: #4ade80;
    }

    #ld-chat-button {
        position: fixed;
        right: 24px;
        bottom: 24px;
        width: 60px;
        height: 60px;
        border: 0;
        border-radius: 50%;
        background: var(--ld-accent);
        color: #fff;
        font-size: 26px;
        cursor: pointer;
        z-index: 99998;
        box-shadow: 0 5px 24px var(--ld-accent-glow);
        transition: transform .2s, box-shadow .2s;
    }
    #ld-chat-button:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 28px var(--ld-accent-glow);
    }

    #ld-chat-window {
        display: none;
        position: fixed;
        right: 24px;
        bottom: 96px;
        width: 390px;
        height: min(620px, calc(100vh - 125px));
        max-width: calc(100vw - 32px);
        background: var(--ld-bg);
        color: var(--ld-text);
        border: 1px solid var(--ld-border);
        border-radius: 18px;
        box-shadow: 0 12px 50px #0008;
        z-index: 99999;
        overflow: hidden;
        flex-direction: column;
        font-family: 'DM Mono', Consolas, monospace;
    }
    #ld-chat-window.open { display: flex; }

    #ld-chat-window *,
    #ld-chat-button { box-sizing: border-box; }

    #ld-chat-window .ld-chat-header {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 16px 18px;
        border-bottom: 1px solid var(--ld-border);
        background: #101018;
        flex-shrink: 0;
    }
    #ld-chat-window .ld-bot-avatar {
        width: 40px;
        height: 40px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: var(--ld-accent-soft);
        border: 1px solid var(--ld-accent);
        box-shadow: 0 0 20px var(--ld-accent-glow);
        color: var(--ld-accent);
        font-family: Arial, sans-serif;
        font-weight: 700;
    }
    #ld-chat-window .ld-header-info h3 {
        margin: 0;
        color: var(--ld-text);
        font-family: Arial, sans-serif;
        font-size: 15px;
        font-weight: 700;
    }
    #ld-chat-window .ld-status {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-top: 4px;
        color: var(--ld-muted);
        font-size: 10px;
    }
    #ld-chat-window .ld-status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--ld-green);
        box-shadow: 0 0 8px var(--ld-green);
        animation: ldPulse 2s ease-in-out infinite;
    }
    @keyframes ldPulse { 50% { opacity: .35; } }

    #ld-chat-close {
        margin-left: auto;
        border: 0;
        background: transparent;
        color: var(--ld-muted);
        font-size: 26px;
        line-height: 1;
        cursor: pointer;
    }
    #ld-chat-close:hover { color: #fff; }

    #ld-chat-messages {
        flex: 1;
        min-height: 0;
        overflow-y: auto;
        padding: 16px 14px;
        display: flex;
        flex-direction: column;
        gap: 14px;
        scrollbar-width: thin;
        scrollbar-color: var(--ld-border) transparent;
    }
    #ld-chat-messages::-webkit-scrollbar { width: 4px; }
    #ld-chat-messages::-webkit-scrollbar-thumb {
        background: var(--ld-border);
        border-radius: 4px;
    }

    #ld-chat-window .ld-welcome {
        text-align: center;
        padding: 26px 12px 18px;
    }
    #ld-chat-window .ld-welcome-icon {
        width: 54px;
        height: 54px;
        margin: 0 auto 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 17px;
        background: var(--ld-accent-soft);
        border: 1px solid rgba(36,161,156,.4);
        color: var(--ld-accent);
        font-size: 24px;
        box-shadow: 0 0 28px var(--ld-accent-glow);
    }
    #ld-chat-window .ld-welcome h3 {
        margin: 0 0 8px;
        color: var(--ld-text);
        font-family: Arial, sans-serif;
        font-size: 19px;
    }
    #ld-chat-window .ld-welcome p {
        margin: 0;
        color: var(--ld-muted);
        font-size: 11px;
        line-height: 1.6;
    }

    #ld-chat-window .ld-msg-row {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        animation: ldFadeUp .25s ease forwards;
    }
    #ld-chat-window .ld-msg-row.user { flex-direction: row-reverse; }
    @keyframes ldFadeUp {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: translateY(0); }
    }
    #ld-chat-window .ld-msg-avatar {
        width: 28px;
        height: 28px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 9px;
        background: var(--ld-accent-soft);
        border: 1px solid rgba(36,161,156,.35);
        color: var(--ld-accent);
        font-family: Arial, sans-serif;
        font-size: 9px;
        font-weight: 700;
    }
    #ld-chat-window .ld-msg-row.user .ld-msg-avatar {
        background: #222232;
        border-color: #39384b;
        color: #c5c1d2;
    }
    #ld-chat-window .ld-msg-bubble {
        max-width: 82%;
        padding: 10px 12px;
        border: 1px solid var(--ld-border);
        border-radius: 13px;
        background: var(--ld-bot);
        color: var(--ld-text);
        font-size: 12px;
        line-height: 1.6;
        white-space: pre-wrap;
        overflow-wrap: anywhere;
    }
    #ld-chat-window .ld-msg-row.bot .ld-msg-bubble { border-top-left-radius: 4px; }
    #ld-chat-window .ld-msg-row.user .ld-msg-bubble {
        background: var(--ld-user);
        border-color: rgba(36,161,156,.3);
        border-top-right-radius: 4px;
    }
    #ld-chat-window .ld-msg-bubble a {
        color: #66d4ce;
        text-decoration: underline;
    }
    #ld-chat-window .ld-msg-time {
        display: block;
        margin-top: 5px;
        color: var(--ld-muted);
        font-size: 9px;
    }

    #ld-chat-window .ld-typing {
        display: none;
        align-items: center;
        gap: 8px;
    }
    #ld-chat-window .ld-typing.visible { display: flex; }
    #ld-chat-window .ld-typing-dots {
        display: flex;
        gap: 4px;
        padding: 12px 14px;
        border: 1px solid var(--ld-border);
        border-radius: 12px;
        background: var(--ld-bot);
    }
    #ld-chat-window .ld-typing-dots span {
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background: var(--ld-muted);
        animation: ldBlink 1.2s infinite;
    }
    #ld-chat-window .ld-typing-dots span:nth-child(2) { animation-delay: .2s; }
    #ld-chat-window .ld-typing-dots span:nth-child(3) { animation-delay: .4s; }
    @keyframes ldBlink {
        0%, 80%, 100% { opacity: .2; transform: scale(.8); }
        40% { opacity: 1; transform: scale(1); }
    }

    #ld-chat-window .ld-input-area {
        flex-shrink: 0;
        padding: 8px 12px 12px;
        border-top: 1px solid var(--ld-border);
        background: #101018;
    }
    #ld-chat-window .ld-chips {
        display: flex;
        gap: 7px;
        overflow-x: auto;
        padding: 4px 0 11px;
        scrollbar-width: none;
    }
    #ld-chat-window .ld-chips::-webkit-scrollbar { display: none; }
    #ld-chat-window .ld-chip {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-shrink: 0;
        padding: 7px 10px;
        border: 1px solid var(--ld-border);
        border-radius: 18px;
        background: var(--ld-surface);
        color: var(--ld-text);
        font-family: Arial, sans-serif;
        font-size: 10px;
        white-space: nowrap;
        cursor: pointer;
    }
    #ld-chat-window .ld-chip:hover {
        border-color: var(--ld-accent);
        background: var(--ld-accent-soft);
    }
    #ld-chat-window .ld-chip:disabled { opacity: .45; cursor: not-allowed; }

    #ld-chat-window .ld-input-box {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 8px 8px 12px;
        border: 1px solid var(--ld-border);
        border-radius: 13px;
        background: var(--ld-surface);
    }
    #ld-chat-window .ld-input-box:focus-within {
        border-color: var(--ld-accent);
        box-shadow: 0 0 0 3px var(--ld-accent-soft);
    }
    #ld-chat-input {
        flex: 1;
        min-width: 0;
        border: 0;
        outline: 0;
        background: transparent;
        color: var(--ld-text);
        font-family: Arial, sans-serif;
        font-size: 12px;
    }
    #ld-chat-input::placeholder { color: var(--ld-muted); }
    #ld-chat-send {
        width: 35px;
        height: 35px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 0;
        border-radius: 9px;
        background: var(--ld-accent);
        color: #fff;
        cursor: pointer;
    }
    #ld-chat-send:disabled { opacity: .45; cursor: not-allowed; }
    #ld-chat-send svg { width: 16px; height: 16px; }

    @media (max-width: 480px) {
        #ld-chat-window {
            right: 10px;
            bottom: 82px;
            width: calc(100vw - 20px);
            height: min(620px, calc(100dvh - 100px));
            max-width: none;
        }
        #ld-chat-button { right: 16px; bottom: 16px; }
    }
</style>
</head>
<body>
    <button id="ld-chat-button" type="button" aria-label="Open LDTECS chatbot">💬</button>

<div id="ld-chat-window" aria-label="LDTECS AI Assistant">
    <div class="ld-chat-header">
        <div class="ld-bot-avatar">AI</div>
        <div class="ld-header-info">
            <h3>LDTECS AI Assistant</h3>
            <div class="ld-status"><span class="ld-status-dot"></span> Online &amp; ready</div>
        </div>
        <button id="ld-chat-close" type="button" aria-label="Close chatbot">×</button>
    </div>

    <div id="ld-chat-messages" aria-live="polite">
        <div class="ld-welcome" id="ld-chat-welcome">
            <div class="ld-welcome-icon">✦</div>
            <h3>How can I help?</h3>
            <p>Ask me about LDTECS products, services, or solutions.</p>
        </div>
        <div class="ld-typing" id="ld-chat-typing">
            <div class="ld-msg-avatar">AI</div>
            <div class="ld-typing-dots"><span></span><span></span><span></span></div>
        </div>
    </div>

    <div class="ld-input-area">
        <div class="ld-chips" id="ld-chat-chips"></div>
        <form class="ld-input-box" id="ld-chat-form">
            <input id="ld-chat-input" type="text" maxlength="2000"
                   placeholder="Type your message..." autocomplete="off" required>
            <button id="ld-chat-send" type="submit" aria-label="Send message">
                <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.2">
                    <line x1="22" y1="2" x2="11" y2="13"/>
                    <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                </svg>
            </button>
        </form>
    </div>
</div>

<script>
(() => {
    const panel = document.getElementById('ld-chat-window');
    if (!panel || panel.dataset.initialized === 'true') return;
    panel.dataset.initialized = 'true';

    const openButton = document.getElementById('ld-chat-button');
    const closeButton = document.getElementById('ld-chat-close');
    const messagesEl = document.getElementById('ld-chat-messages');
    const typingEl = document.getElementById('ld-chat-typing');
    const form = document.getElementById('ld-chat-form');
    const input = document.getElementById('ld-chat-input');
    const sendButton = document.getElementById('ld-chat-send');
    const chipsEl = document.getElementById('ld-chat-chips');
    const history = [];

    const questions = [
        'What is your product/service?',
        'How does it work?',
        'Do you offer support?',
        'How can I get started?'
    ];

    openButton.addEventListener('click', () => {
        panel.classList.toggle('open');
        if (panel.classList.contains('open')) input.focus();
    });
    closeButton.addEventListener('click', () => panel.classList.remove('open'));

    function getTime() {
        return new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    }

    function fillBubble(bubble, text) {
        String(text).split(/(https?:\/\/[^\s]+)/g).forEach(part => {
            if (/^https?:\/\//i.test(part)) {
                const match = part.match(/^(.*?)([.,;:!?)\]]*)$/);
                const link = document.createElement('a');
                link.href = match[1];
                link.textContent = match[1];
                link.target = '_blank';
                link.rel = 'noopener noreferrer';
                bubble.appendChild(link);
                if (match[2]) bubble.appendChild(document.createTextNode(match[2]));
            } else if (part) {
                bubble.appendChild(document.createTextNode(part));
            }
        });
    }

    function appendMessage(text, role) {
        const welcome = document.getElementById('ld-chat-welcome');
        if (welcome) welcome.remove();

        const row = document.createElement('div');
        row.className = `ld-msg-row ${role}`;

        const avatar = document.createElement('div');
        avatar.className = 'ld-msg-avatar';
        avatar.textContent = role === 'user' ? 'You' : 'AI';

        const bubble = document.createElement('div');
        bubble.className = 'ld-msg-bubble';
        fillBubble(bubble, text);

        const time = document.createElement('span');
        time.className = 'ld-msg-time';
        time.textContent = getTime();
        bubble.appendChild(time);

        row.append(avatar, bubble);
        messagesEl.insertBefore(row, typingEl);
        messagesEl.scrollTop = messagesEl.scrollHeight;
    }

    function setTyping(show) {
        typingEl.classList.toggle('visible', show);
        if (show) messagesEl.scrollTop = messagesEl.scrollHeight;
    }

    function setBusy(busy) {
        sendButton.disabled = busy;
        chipsEl.querySelectorAll('button').forEach(button => button.disabled = busy);
    }

    questions.forEach(question => {
        const chip = document.createElement('button');
        chip.type = 'button';
        chip.className = 'ld-chip';
        chip.textContent = question;
        chip.addEventListener('click', () => sendMessage(question));
        chipsEl.appendChild(chip);
    });

    chipsEl.addEventListener('wheel', event => {
        if (Math.abs(event.deltaY) > Math.abs(event.deltaX)) {
            chipsEl.scrollLeft += event.deltaY;
            event.preventDefault();
        }
    }, { passive: false });

    async function sendMessage(preset) {
        const message = (typeof preset === 'string' ? preset : input.value).trim();
        if (!message || sendButton.disabled) return;

        appendMessage(message, 'user');
        history.push({ role: 'user', content: message });
        input.value = '';
        setBusy(true);
        setTyping(true);

        try {
            const response = await fetch(@json(route('chatbot.message')), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ messages: history.slice(-10) })
            });

            const data = await response.json();
            if (!response.ok) {
                throw new Error(data.reply || data.message || 'HTTP ' + response.status);
            }

            const reply = data.reply || 'No response received.';
            appendMessage(reply, 'bot');
            history.push({ role: 'assistant', content: reply });
            if (history.length > 10) history.splice(0, history.length - 10);
        } catch (error) {
            appendMessage('Sorry, something went wrong. Please try again.', 'bot');
            console.error('LDTECS chatbot:', error);
        } finally {
            setTyping(false);
            setBusy(false);
            input.focus();
        }
    }

    form.addEventListener('submit', event => {
        event.preventDefault();
        sendMessage();
    });
})();
</script>
</body>
</html>