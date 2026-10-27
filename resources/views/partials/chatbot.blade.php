<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

<style>
#ld-chat-button {
    position: fixed; right: 24px; bottom: 24px;
    width: 60px; height: 60px; border: 0;
    border-radius: 50%; background: #24a19c;
    color: white; font-size: 26px; cursor: pointer;
    z-index: 99999;
}
#ld-chat-window {
    display: none; position: fixed; right: 24px;
    bottom: 96px; width: 350px; height: 450px;
    max-width: calc(100vw - 32px);
    background: white; color: #191b19;
    border-radius: 14px; box-shadow: 0 5px 30px #0003;
    z-index: 99999; overflow: hidden;
    flex-direction: column; font-family: Arial, sans-serif;
}
#ld-chat-window.open { display: flex; }
.ld-head {
    background: #24a19c; color: white; padding: 15px;
    display: flex; justify-content: space-between;
}
#ld-chat-close {
    border: 0; background: none; color: white;
    font-size: 24px; cursor: pointer;
}
#ld-chat-messages {
    flex: 1; overflow-y: auto; padding: 12px;
    background: #f6f8f8;
}
.ld-msg {
    padding: 10px; border-radius: 10px;
    margin-bottom: 10px; max-width: 85%;
    white-space: pre-wrap; overflow-wrap: anywhere;
    font-size: 14px; line-height: 1.5;
}
.ld-bot { background: #e4eeee; }
.ld-user {
    background: #24a19c; color: white; margin-left: auto;
}
#ld-chat-form {
    display: flex; gap: 6px; padding: 10px;
}
#ld-chat-input {
    flex: 1; min-width: 0; padding: 10px;
    border: 1px solid #ccc; border-radius: 8px;
}
#ld-chat-send {
    border: 0; border-radius: 8px; padding: 10px;
    background: #24a19c; color: white; cursor: pointer;
}
@media(max-width:480px) {
    #ld-chat-window { right: 10px; bottom: 80px; width: calc(100vw - 20px); }
    #ld-chat-button { right: 16px; bottom: 16px; }
}
</style>
</head>
<body>
    



<button id="ld-chat-button" type="button" aria-label="Open chatbot">💬</button>

<div id="ld-chat-window">
    <div class="ld-head">
        <strong>LDTECS AI Assistant</strong>
        <button id="ld-chat-close" type="button">×</button>
    </div>

    <div id="ld-chat-messages" aria-live="polite">
        <div class="ld-msg ld-bot">
            Hello! Welcome to LDTECS.
            Namaste! Aap kya jaanna chahte hain?
        </div>
    </div>

    <form id="ld-chat-form">
        <input id="ld-chat-input" maxlength="2000"
            placeholder="Type a message..." required>
        <button id="ld-chat-send" type="submit">Send</button>
    </form>
</div>

<script>
(() => {
    const panel = document.getElementById('ld-chat-window');
    const button = document.getElementById('ld-chat-button');
    const close = document.getElementById('ld-chat-close');
    const box = document.getElementById('ld-chat-messages');
    const form = document.getElementById('ld-chat-form');
    const input = document.getElementById('ld-chat-input');
    const send = document.getElementById('ld-chat-send');

    const history = [];

    button.addEventListener('click', () => {
        panel.classList.toggle('open');
    });

    close.addEventListener('click', () => {
        panel.classList.remove('open');
    });

    function addMessage(text, role) {
        const el = document.createElement('div');
        el.className = 'ld-msg ' +
            (role === 'user' ? 'ld-user' : 'ld-bot');
        el.textContent = text;
        box.appendChild(el);
        box.scrollTop = box.scrollHeight;
        return el;
    }

    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        const message = input.value.trim();
        if (!message || send.disabled) return;

        addMessage(message, 'user');
        history.push({ role: 'user', content: message });

        input.value = '';
        send.disabled = true;

        const loading = addMessage('Reply aa raha hai...', 'assistant');

        try {
            const response = await fetch(
                @json(route('chatbot.message')),
                {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector(
                            'meta[name="csrf-token"]'
                        ).content
                    },
                    body: JSON.stringify({
                        messages: history.slice(-10)
                    })
                }
            );

            const data = await response.json();

            if (!response.ok) {
                throw new Error(
                    data.reply || data.message || 'HTTP ' + response.status
                );
            }

            loading.textContent = data.reply || 'No response received.';
            history.push({
                role: 'assistant',
                content: loading.textContent
            });

            if (history.length > 10) {
                history.splice(0, history.length - 10);
            }
        } catch (error) {
            loading.textContent = 'Error: ' + error.message;
            console.error('LDTECS chatbot:', error);
        } finally {
            send.disabled = false;
            input.focus();
        }
    });
})();
</script>

</body>
</html>