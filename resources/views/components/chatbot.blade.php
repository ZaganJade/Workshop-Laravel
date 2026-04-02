{{-- ==========================================
     FLOATING AI CHATBOT COMPONENT
     Kimi K2.5 Turbo (via Fireworks AI)
     ========================================== --}}

{{-- Floating Button --}}
<div id="chatbot-button" style="
    position: fixed; bottom: 80px; right: 28px; z-index: 9999;
    transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
">
    <button id="chatbot-toggle-btn" onclick="toggleChatbot()" title="Buka Kimi AI" style="
        width: 60px; height: 60px; border-radius: 50%; border: none; cursor: pointer;
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        color: white; display: flex; align-items: center; justify-content: center;
        box-shadow: 0 8px 24px rgba(79, 70, 229, 0.45);
        transition: all 0.3s ease; position: relative;
    " onmouseover="this.style.transform='scale(1.1)'; this.style.boxShadow='0 12px 32px rgba(79,70,229,0.55)'"
       onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 8px 24px rgba(79,70,229,0.45)'">
        {{-- Chat Icon --}}
        <svg id="chat-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" width="26" height="26">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 0 1 .778-.332 48.294 48.294 0 0 0 5.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
        </svg>
        {{-- Close Icon --}}
        <svg id="close-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="26" height="26" style="display: none;">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
        </svg>
        {{-- Pulse ring --}}
        <span id="chatbot-pulse" style="
            position: absolute; inset: -4px; border-radius: 50%;
            border: 2px solid rgba(79, 70, 229, 0.5);
            animation: pulse-ring 1.8s ease-out infinite;
        "></span>
    </button>
    {{-- Tooltip label --}}
    <div id="chatbot-label" style="
        position: absolute; bottom: 70px; right: 0;
        background: #1e1b4b; color: white; font-size: 12px; font-weight: 600;
        padding: 5px 10px; border-radius: 8px; white-space: nowrap;
        pointer-events: none; opacity: 0; transform: translateY(4px);
        transition: all 0.2s ease;
    ">Kimi AI Chat</div>
</div>

{{-- Chat Window --}}
<div id="chatbot-window" style="
    position: fixed; bottom: 156px; right: 28px; z-index: 9998;
    width: min(400px, calc(100vw - 40px));
    transform: scale(0) translateY(20px); opacity: 0; pointer-events: none;
    transform-origin: bottom right;
    transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0,0,0,0.18), 0 4px 20px rgba(79,70,229,0.15);
">
    {{-- Chat Container --}}
    <div style="background: white; border: 1px solid rgba(79,70,229,0.1);">

        {{-- Header --}}
        <div style="
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            padding: 16px 20px; display: flex; align-items: center; gap: 12px; justify-content: space-between;
        ">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="position: relative;">
                    <div style="
                        width: 42px; height: 42px; border-radius: 50%;
                        background: rgba(255,255,255,0.15); border: 2px solid rgba(255,255,255,0.3);
                        display: flex; align-items: center; justify-content: center;
                        font-size: 1.3rem;
                    ">🤖</div>
                    <span style="
                        position: absolute; bottom: 1px; right: 1px;
                        width: 11px; height: 11px; border-radius: 50%;
                        background: #22c55e; border: 2px solid white;
                    "></span>
                </div>
                <div>
                    <div style="color: white; font-weight: 700; font-size: 0.95rem; line-height: 1.2;">Workshop AI</div>
                    <div style="color: rgba(255,255,255,0.7); font-size: 0.72rem;">Kimi K2.5 Turbo · DB Connected</div>
                </div>
            </div>
            <button onclick="toggleChatbot()" style="
                background: rgba(255,255,255,0.15); border: none; cursor: pointer;
                color: white; border-radius: 50%; width: 30px; height: 30px;
                display: flex; align-items: center; justify-content: center;
                transition: background 0.2s;
            " onmouseover="this.style.background='rgba(255,255,255,0.25)'"
               onmouseout="this.style.background='rgba(255,255,255,0.15)'">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="16" height="16">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Messages Area --}}
        <div id="chatbot-messages" style="
            height: 360px; overflow-y: auto; background: #f8f7ff;
            padding: 16px; display: flex; flex-direction: column; gap: 12px;
        ">
            {{-- Welcome Message --}}
            <div style="display: flex; align-items: flex-start; gap: 8px;">
                <div style="
                    width: 32px; height: 32px; border-radius: 50%; flex-shrink: 0;
                    background: linear-gradient(135deg, #ede9fe, #ddd6fe);
                    display: flex; align-items: center; justify-content: center; font-size: 0.85rem;
                ">🤖</div>
                <div style="
                    background: white; border-radius: 16px; border-top-left-radius: 4px;
                    padding: 10px 14px; font-size: 0.85rem; color: #374151; max-width: 80%;
                    box-shadow: 0 1px 4px rgba(0,0,0,0.06); border: 1px solid #ede9fe; line-height: 1.5;
                ">
                    Halo! Saya <strong>Kimi AI</strong>. Saya telah terhubung ke database Anda 🗄️<br><br>
                    Tanya saya tentang <strong>stok buku</strong>, <strong>kategori</strong>, atau <strong>daftar barang</strong>!
                </div>
            </div>
        </div>

        {{-- Typing Indicator --}}
        <div id="typing-indicator" style="display: none; padding: 8px 16px;">
            <div style="display: flex; align-items: center; gap: 4px;">
                <div style="
                    width: 32px; height: 32px; border-radius: 50%; flex-shrink: 0;
                    background: linear-gradient(135deg, #ede9fe, #ddd6fe);
                    display: flex; align-items: center; justify-content: center; font-size: 0.85rem;
                ">🤖</div>
                <div style="
                    background: white; border-radius: 16px; border-top-left-radius: 4px;
                    padding: 10px 16px; box-shadow: 0 1px 4px rgba(0,0,0,0.06); border: 1px solid #ede9fe;
                    display: flex; gap: 4px; align-items: center;
                ">
                    <span class="dot-bounce" style="width: 7px; height: 7px; border-radius: 50%; background: #7c3aed; animation: bounce-dot 1.2s infinite;"></span>
                    <span class="dot-bounce" style="width: 7px; height: 7px; border-radius: 50%; background: #7c3aed; animation: bounce-dot 1.2s infinite 0.2s;"></span>
                    <span class="dot-bounce" style="width: 7px; height: 7px; border-radius: 50%; background: #7c3aed; animation: bounce-dot 1.2s infinite 0.4s;"></span>
                </div>
            </div>
        </div>

        {{-- Input Area --}}
        <div style="background: white; padding: 14px 16px; border-top: 1px solid #f0ebff;">
            <form id="chatbot-form" onsubmit="handleChatSubmit(event)" style="display: flex; gap: 8px; align-items: center;">
                <input type="text" id="chat-input" placeholder="Tanyakan sesuatu..." autocomplete="off" style="
                    flex: 1; border: 1.5px solid #e8e2ff; border-radius: 50px;
                    padding: 9px 16px; font-size: 0.875rem; outline: none;
                    background: #fafaff; transition: all 0.2s; color: #374151;
                " onfocus="this.style.borderColor='#7c3aed'; this.style.background='#fff'; this.style.boxShadow='0 0 0 3px rgba(124,58,237,0.1)'"
                   onblur="this.style.borderColor='#e8e2ff'; this.style.background='#fafaff'; this.style.boxShadow='none'">
                <button type="submit" title="Kirim" style="
                    width: 40px; height: 40px; border-radius: 50%; border: none; cursor: pointer;
                    background: linear-gradient(135deg, #4f46e5, #7c3aed); color: white;
                    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
                    transition: all 0.2s; box-shadow: 0 3px 10px rgba(79,70,229,0.3);
                " onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="18" height="18">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.126A59.768 59.768 0 0 1 21.485 12 59.77 59.77 0 0 1 3.27 20.876L5.999 12Zm0 0h7.5" />
                    </svg>
                </button>
            </form>
            <p style="margin: 8px 0 0; text-align: center; font-size: 10px; color: #a78bfa;">
                ⚡ Powered by Kimi K2.5 Turbo via Fireworks AI
            </p>
        </div>
    </div>
</div>

{{-- Styles --}}
<style>
    @keyframes pulse-ring {
        0%   { transform: scale(1); opacity: 0.8; }
        100% { transform: scale(1.6); opacity: 0; }
    }
    @keyframes bounce-dot {
        0%, 80%, 100% { transform: translateY(0); }
        40%            { transform: translateY(-6px); }
    }
    #chatbot-messages::-webkit-scrollbar { width: 4px; }
    #chatbot-messages::-webkit-scrollbar-thumb { background: rgba(124, 58, 237, 0.2); border-radius: 10px; }
    #chatbot-messages::-webkit-scrollbar-thumb:hover { background: rgba(124, 58, 237, 0.4); }
    .msg-user .bubble { background: linear-gradient(135deg, #4f46e5, #7c3aed); color: white; border-top-right-radius: 4px !important; border-top-left-radius: 16px !important; }
    .msg-bot .bubble  { background: white; color: #374151; border: 1px solid #ede9fe; border-top-left-radius: 4px !important; }
    .msg-user { flex-direction: row-reverse; }
</style>

{{-- Script --}}
<script>
    let isChatOpen = false;

    // Show tooltip on hover
    const chatBtn = document.getElementById('chatbot-button');
    if (chatBtn) {
        chatBtn.addEventListener('mouseenter', () => {
            const lbl = document.getElementById('chatbot-label');
            if (!isChatOpen && lbl) { lbl.style.opacity = '1'; lbl.style.transform = 'translateY(0)'; }
        });
        chatBtn.addEventListener('mouseleave', () => {
            const lbl = document.getElementById('chatbot-label');
            if (lbl) { lbl.style.opacity = '0'; lbl.style.transform = 'translateY(4px)'; }
        });
    }

    function toggleChatbot() {
        const win = document.getElementById('chatbot-window');
        const iconChat = document.getElementById('chat-icon');
        const iconClose = document.getElementById('close-icon');
        const pulse = document.getElementById('chatbot-pulse');
        const lbl = document.getElementById('chatbot-label');

        isChatOpen = !isChatOpen;

        if (isChatOpen) {
            win.style.transform = 'scale(1) translateY(0)';
            win.style.opacity = '1';
            win.style.pointerEvents = 'auto';
            iconChat.style.display = 'none';
            iconClose.style.display = 'block';
            if (pulse) pulse.style.animationPlayState = 'paused';
            if (lbl) { lbl.style.opacity = '0'; lbl.style.transform = 'translateY(4px)'; }
            setTimeout(() => { const inp = document.getElementById('chat-input'); if (inp) inp.focus(); }, 350);
        } else {
            win.style.transform = 'scale(0) translateY(20px)';
            win.style.opacity = '0';
            win.style.pointerEvents = 'none';
            iconChat.style.display = 'block';
            iconClose.style.display = 'none';
            if (pulse) pulse.style.animationPlayState = 'running';
        }
    }

    async function handleChatSubmit(event) {
        event.preventDefault();
        const input = document.getElementById('chat-input');
        const message = input.value.trim();
        if (!message) return;

        addMessage(message, 'user');
        input.value = '';

        const typing = document.getElementById('typing-indicator');
        typing.style.display = 'block';
        scrollToBottom();

        try {
            const response = await fetch('{{ route('chatbot.chat') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ message })
            });

            if (!response.ok) throw new Error('API Error');
            const data = await response.json();

            typing.style.display = 'none';
            addMessage(data.success ? data.message : 'Maaf, terjadi kesalahan atau API Key belum diatur.', 'bot');
        } catch (error) {
            console.error('Chat Error:', error);
            document.getElementById('typing-indicator').style.display = 'none';
            addMessage('Maaf, koneksi ke server AI gagal. Silakan coba lagi.', 'bot');
        }
    }

    function addMessage(text, type) {
        const container = document.getElementById('chatbot-messages');
        const wrap = document.createElement('div');
        wrap.style.cssText = 'display:flex; align-items:flex-start; gap:8px;';
        if (type === 'user') wrap.style.flexDirection = 'row-reverse';

        const avatarHtml = type === 'user'
            ? `<div style="width:32px;height:32px;border-radius:50%;flex-shrink:0;background:linear-gradient(135deg,#4f46e5,#7c3aed);display:flex;align-items:center;justify-content:center;color:white;font-size:0.75rem;font-weight:700;">U</div>`
            : `<div style="width:32px;height:32px;border-radius:50%;flex-shrink:0;background:linear-gradient(135deg,#ede9fe,#ddd6fe);display:flex;align-items:center;justify-content:center;font-size:0.85rem;">🤖</div>`;

        const bubbleStyle = type === 'user'
            ? 'background:linear-gradient(135deg,#4f46e5,#7c3aed);color:white;border-radius:16px;border-top-right-radius:4px;'
            : 'background:white;color:#374151;border:1px solid #ede9fe;border-radius:16px;border-top-left-radius:4px;';

        wrap.innerHTML = `
            ${avatarHtml}
            <div style="max-width:80%;${bubbleStyle}padding:10px 14px;font-size:0.85rem;line-height:1.55;box-shadow:0 1px 4px rgba(0,0,0,0.06);">
                ${formatMessage(text)}
            </div>
        `;

        container.appendChild(wrap);
        scrollToBottom();
    }

    function formatMessage(text) {
        return text
            .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
            .replace(/^\s*-\s+(.*)$/gm, '<li style="margin-left:16px;">$1</li>')
            .replace(/(<li.*<\/li>)+/g, '<ul style="margin:6px 0;padding:0;">$&</ul>')
            .replace(/\n\n/g, '<br><br>')
            .replace(/\n/g, '<br>');
    }

    function scrollToBottom() {
        const container = document.getElementById('chatbot-messages');
        if (container) container.scrollTo({ top: container.scrollHeight, behavior: 'smooth' });
    }
</script>
