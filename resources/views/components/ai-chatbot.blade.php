<button type="button" class="ai-fab" id="ai-chat-toggle" aria-label="Buka Asisten AI MAZSEH">
    <div class="ai-fab-icon">
        <x-icon name="spark" style="--od-icon-size: 16px;" />
    </div>
    <span>Tanya AI MAZSEH</span>
    <span class="ai-fab-dot"></span>
</button>

<div class="ai-window" id="ai-chat-window" hidden>
    <div class="ai-header">
        <div class="ai-header-title">
            <div class="ai-fab-icon" style="width:28px;height:28px;">
                <x-icon name="spark" style="--od-icon-size: 16px;" />
            </div>
            <div>
                <strong>Asisten AI MAZSEH</strong>
                <span><span class="ai-fab-dot"></span> Siap melayani 24/7</span>
            </div>
        </div>
        <button type="button" class="ai-close-btn" id="ai-chat-close" aria-label="Tutup jendela chat">
            <x-icon name="close" />
        </button>
    </div>

    <div class="ai-whatsapp-bar">
        <span>Butuh bantuan staf langsung?</span>
        <a href="https://wa.me/6281234567890?text=Halo%20Admin%20MAZSEH,%20saya%20ingin%20konsultasi%20sewa%20mobil." target="_blank" rel="noopener">
            <x-icon name="phone" style="--od-icon-size: 14px;" />
            <span>WhatsApp Admin</span>
        </a>
    </div>

    <div class="ai-body" id="ai-chat-body">
        <div class="ai-bubble bot">
            Halo! Saya Asisten Cerdas MAZSEH. Silakan tanyakan rekomendasi armada, cek ketersediaan unit, atau persyaratan sewa mobil Anda.
            <span class="ai-bubble-time">{{ date('H:i') }}</span>
        </div>

        <div class="ai-quick-prompts" id="ai-quick-prompts">
            <button type="button" class="ai-prompt-btn" data-prompt="Rekomendasi mobil untuk perjalanan keluarga">Rekomendasi mobil keluarga</button>
            <button type="button" class="ai-prompt-btn" data-prompt="Apa saja syarat sewa lepas kunci?">Syarat sewa lepas kunci</button>
            <button type="button" class="ai-prompt-btn" data-prompt="Berapa tarif sewa Toyota Fortuner dan Innova Zenix?">Tarif Fortuner & Zenix</button>
            <button type="button" class="ai-prompt-btn" data-prompt="Hubungkan saya dengan admin via WhatsApp">Chat Admin WhatsApp</button>
        </div>
    </div>

    <form class="ai-footer" id="ai-chat-form">
        @csrf
        <input type="text" class="ai-input" id="ai-chat-input" placeholder="Ketik pertanyaan Anda..." autocomplete="off" required>
        <button type="submit" class="ai-send-btn" aria-label="Kirim pesan">
            <x-icon name="arrow" style="--od-icon-size: 18px;" />
        </button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.getElementById('ai-chat-toggle');
    const closeBtn = document.getElementById('ai-chat-close');
    const windowEl = document.getElementById('ai-chat-window');
    const form = document.getElementById('ai-chat-form');
    const input = document.getElementById('ai-chat-input');
    const body = document.getElementById('ai-chat-body');
    const quickPrompts = document.querySelectorAll('.ai-prompt-btn');

    if (!toggle || !windowEl) return;

    toggle.addEventListener('click', () => {
        const isHidden = windowEl.hasAttribute('hidden');
        if (isHidden) {
            windowEl.removeAttribute('hidden');
            input.focus();
        } else {
            windowEl.setAttribute('hidden', '');
        }
    });

    closeBtn.addEventListener('click', () => {
        windowEl.setAttribute('hidden', '');
    });

    quickPrompts.forEach(btn => {
        btn.addEventListener('click', () => {
            const promptText = btn.getAttribute('data-prompt');
            if (promptText) {
                input.value = promptText;
                form.dispatchEvent(new Event('submit'));
            }
        });
    });

    form.addEventListener('submit', async function (e) {
        e.preventDefault();
        const text = input.value.trim();
        if (!text) return;

        // Append user bubble
        appendBubble(text, 'user');
        input.value = '';
        input.disabled = true;

        // Append loading bubble
        const loadingId = 'ai-loading-' + Date.now();
        const loadingEl = document.createElement('div');
        loadingEl.className = 'ai-bubble bot';
        loadingEl.id = loadingId;
        loadingEl.innerHTML = '<em>Sedang mengetik...</em>';
        body.appendChild(loadingEl);
        body.scrollTop = body.scrollHeight;

        try {
            const resp = await fetch('{{ route("ai-chat.send") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ message: text })
            });

            const data = await resp.json();
            const loadingBubble = document.getElementById(loadingId);
            if (loadingBubble) loadingBubble.remove();

            if (data && data.reply) {
                appendBubble(data.reply, 'bot');
                if (data.status === 'dialihkan_ke_wa' && data.whatsapp_url) {
                    appendWhatsappAction(data.whatsapp_url);
                }
            } else {
                appendBubble('Maaf, sistem sedang sibuk. Silakan hubungi tim kami via WhatsApp.', 'bot');
            }
        } catch (err) {
            const loadingBubble = document.getElementById(loadingId);
            if (loadingBubble) loadingBubble.remove();
            appendBubble('Koneksi terputus. Silakan coba kembali atau hubungi WhatsApp kami.', 'bot');
        } finally {
            input.disabled = false;
            input.focus();
        }
    });

    function appendBubble(text, role) {
        const div = document.createElement('div');
        div.className = 'ai-bubble ' + role;
        const now = new Date();
        const timeStr = String(now.getHours()).padStart(2, '0') + ':' + String(now.getMinutes()).padStart(2, '0');
        div.innerHTML = escapeHtml(text).replace(/\n/g, '<br>') + `<span class="ai-bubble-time">${timeStr}</span>`;
        body.appendChild(div);
        body.scrollTop = body.scrollHeight;
    }

    function appendWhatsappAction(url) {
        const div = document.createElement('div');
        div.style.marginTop = '4px';
        div.innerHTML = `<a href="${url}" target="_blank" rel="noopener" class="btn btn-primary btn-small wfull" style="background:#16a34a;color:white;display:inline-flex;gap:6px;justify-content:center;">Hubungi via WhatsApp Langsung</a>`;
        body.appendChild(div);
        body.scrollTop = body.scrollHeight;
    }

    function escapeHtml(str) {
        const p = document.createElement('p');
        p.textContent = str;
        return p.innerHTML;
    }
});
</script>
