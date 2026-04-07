@extends('layouts.master')
@section('title', 'Dashboard Guru')

@push('styles')
<style>
/* ── Welcome banner ── */
.guru-welcome {
    background: linear-gradient(135deg, #0d6efd 0%, #0dcaf0 100%);
    border-radius: 16px; padding: 28px 32px;
    color: #fff; position: relative; overflow: hidden; margin-bottom: 24px;
}
.guru-welcome::before {
    content: ''; position: absolute;
    width: 260px; height: 260px;
    background: rgba(255,255,255,0.07);
    border-radius: 50%; top: -80px; right: -60px; pointer-events: none;
}
.guru-welcome::after {
    content: ''; position: absolute;
    width: 140px; height: 140px;
    background: rgba(255,255,255,0.05);
    border-radius: 50%; bottom: -40px; left: 120px; pointer-events: none;
}
.guru-welcome-content { position: relative; z-index: 2; }
.guru-welcome h5 { font-size: 1.35rem; font-weight: 700; margin: 0 0 8px; }
.guru-welcome p  { font-size: 0.875rem; opacity: 0.88; margin: 0; line-height: 1.6; }
.guru-welcome-chip {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(255,255,255,0.18); border: 1px solid rgba(255,255,255,0.3);
    border-radius: 50px; padding: 4px 14px;
    font-size: 0.75rem; font-weight: 600; color: #fff;
    margin-bottom: 12px; backdrop-filter: blur(6px);
}

/* ── Stat cards ── */
.stat-cards { display: grid; grid-template-columns: repeat(4,1fr); gap: 16px; margin-bottom: 24px; }
@media (max-width: 991px) { .stat-cards { grid-template-columns: repeat(2,1fr); } }
@media (max-width: 480px)  { .stat-cards { grid-template-columns: 1fr 1fr; } }

.stat-card {
    background: #fff; border-radius: 16px;
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-sm);
    padding: 20px 18px;
    display: flex; flex-direction: column; gap: 12px;
    transition: var(--transition); position: relative; overflow: hidden;
}
.stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(13,110,253,0.12); }
.stat-card::before {
    content: ''; position: absolute;
    width: 90px; height: 90px; border-radius: 50%;
    top: -25px; right: -20px; opacity: 0.08;
}
.stat-card.green::before  { background: #198754; }
.stat-card.blue::before   { background: #0d6efd; }
.stat-card.yellow::before { background: #ffc107; }
.stat-card.red::before    { background: #dc3545; }

.stat-icon {
    width: 44px; height: 44px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.3rem; flex-shrink: 0;
}
.stat-icon.green  { background: rgba(32,201,151,0.12); color: #198754; }
.stat-icon.blue   { background: rgba(13,110,253,0.1);  color: #0d6efd; }
.stat-icon.yellow { background: rgba(255,193,7,0.15);  color: #856404; }
.stat-icon.red    { background: rgba(220,53,69,0.1);   color: #dc3545; }

.stat-label { font-size: 0.78rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.4px; }
.stat-value { font-size: 2rem; font-weight: 800; line-height: 1; margin-top: 2px; }
.stat-value.green  { color: #198754; }
.stat-value.blue   { color: #0d6efd; }
.stat-value.yellow { color: #856404; }
.stat-value.red    { color: #dc3545; }

/* skeleton shimmer */
.skeleton {
    background: linear-gradient(90deg,#f0f4ff 25%,#e2e8f7 50%,#f0f4ff 75%);
    background-size: 200% 100%;
    animation: shimmer 1.4s infinite;
    border-radius: 6px; display: inline-block; color: transparent;
}
@keyframes shimmer { 0%{background-position:200% 0} 100%{background-position:-200% 0} }

/* ── Quick links ── */
.quick-links { display: grid; grid-template-columns: repeat(3,1fr); gap: 12px; }
@media (max-width: 767px) { .quick-links { grid-template-columns: repeat(2,1fr); } }

.quick-link-card {
    background: #fff; border-radius: 14px;
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-sm);
    padding: 16px 14px;
    display: flex; align-items: center; gap: 12px;
    text-decoration: none; color: var(--text-main);
    transition: var(--transition);
}
.quick-link-card:hover {
    border-color: rgba(13,110,253,0.25);
    background: rgba(13,110,253,0.025);
    transform: translateY(-2px);
    color: var(--primary);
}
.quick-link-icon {
    width: 40px; height: 40px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem; flex-shrink: 0;
}
.quick-link-label { font-size: 0.82rem; font-weight: 600; }

.panel-card {
    background: #fff; border-radius: 16px;
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-sm);
    overflow: hidden; margin-bottom: 24px;
}
.panel-card-header {
    padding: 16px 20px; border-bottom: 1px solid var(--border-color);
    background: #f0f4ff; display: flex; align-items: center;
    gap: 8px; font-weight: 700; font-size: 0.9rem; color: var(--text-main);
}
.panel-card-header i { color: var(--primary); }
.panel-card-body { padding: 20px; }

/* ── Chatbot ── */
.chatbot-toggle {
    position: fixed; bottom: 24px; right: 24px; z-index: 9999;
    width: 56px; height: 56px;
    background: linear-gradient(135deg, #0d6efd, #0dcaf0);
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 1.4rem; cursor: pointer;
    box-shadow: 0 8px 32px rgba(13,110,253,0.4);
    transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
    backdrop-filter: blur(12px);
}
.chatbot-toggle:hover { transform: scale(1.1); box-shadow: 0 12px 40px rgba(13,110,253,0.5); }
.chatbot-toggle.active { background: linear-gradient(135deg, #198754, #20c997); transform: rotate(90deg) scale(1.05); }

.modal-overlay {
    display: none; position: fixed;
    bottom: 90px; right: 24px; z-index: 9998;
}
.modal-overlay.active { display: block; }

.modal-box {
    background: #fff;
    height: 90vh; max-height: 600px;
    width: 95vw; max-width: 500px;
    border-radius: 24px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.15);
    display: flex; flex-direction: column;
    overflow: hidden;
}
.modal-head {
    padding: 16px 20px;
    border-bottom: 1px solid #e9ecef;
    display: flex; align-items: center; justify-content: space-between;
    background: #fff;
}
.modal-head h5 { margin: 0; font-size: 1rem; font-weight: 700; }
.modal-close {
    background: none; border: none; font-size: 1.5rem;
    line-height: 1; cursor: pointer; color: #6c757d; padding: 0;
}
.modal-close:hover { color: #000; }

/* Message bubbles */
.chat-msg { margin-bottom: 16px; display: flex; gap: 12px; animation: fadeInUp 0.3s ease; }
.chat-msg.bot  { justify-content: flex-start; }
.chat-msg.user { justify-content: flex-end; }
.chat-bubble {
    max-width: 80%; padding: 12px 18px; border-radius: 20px;
    font-size: 0.88rem; line-height: 1.5;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
}
.chat-bubble.bot  { background: #e3f2fd; color: #1e3a8a; border-bottom-left-radius: 6px; }
.chat-bubble.user { background: linear-gradient(135deg, #0d6efd, #0dcaf0); color: #fff; border-bottom-right-radius: 6px; }

.typing-indicator { display: flex; align-items: center; gap: 8px; }
.typing-dots { display: flex; gap: 4px; }
.typing-dots span {
    width: 8px; height: 8px; border-radius: 50%;
    background: #ccc; animation: glow 1.4s infinite;
}
.typing-dots span:nth-child(2) { animation-delay: 0.2s; }
.typing-dots span:nth-child(3) { animation-delay: 0.4s; }

@keyframes glow    { 0%,60%,100%{transform:scale(1);opacity:0.5;} 30%{transform:scale(1.2);opacity:1;} }
@keyframes fadeInUp{ from{opacity:0;transform:translateY(20px);} to{opacity:1;transform:translateY(0);} }

#chat-messages { scroll-behavior: smooth; }

@media (max-width: 576px) {
    .chatbot-toggle { bottom: 16px; right: 16px; width: 52px; height: 52px; font-size: 1.3rem; }
    .modal-overlay  { bottom: 78px; right: 8px; left: 8px; }
    .modal-box      { width: 100%; max-width: 100%; }
}
</style>
@endpush

@section('layoutContent')

{{-- ── WELCOME BANNER ── --}}
<div class="guru-welcome">
    <div class="guru-welcome-content">
        <div class="guru-welcome-chip">
            <i class="bi bi-person-badge"></i> Panel Guru
        </div>
        <h5>Selamat datang, {{ auth()->user()->name }}! 👋</h5>
        <p>Panel guru SMA Negeri 5 Morotai.<br>Kelola mata pelajaran, soal, ujian, monitoring, dan hasil ujian Anda di sini.</p>
    </div>
</div>

{{-- ── STAT CARDS ── --}}
<div class="stat-cards">
    <div class="stat-card green">
        <div class="stat-icon green"><i class="bi bi-journal-bookmark-fill"></i></div>
        <div>
            <div class="stat-label">Mapel Saya</div>
            <div class="stat-value green skeleton" id="statMapel" style="min-width:40px;">0</div>
        </div>
    </div>
    <div class="stat-card blue">
        <div class="stat-icon blue"><i class="bi bi-archive"></i></div>
        <div>
            <div class="stat-label">Bank Soal</div>
            <div class="stat-value blue skeleton" id="statSoal" style="min-width:40px;">0</div>
        </div>
    </div>
    <div class="stat-card yellow">
        <div class="stat-icon yellow"><i class="bi bi-clipboard-plus"></i></div>
        <div>
            <div class="stat-label">Ujian Dibuat</div>
            <div class="stat-value yellow skeleton" id="statUjian" style="min-width:40px;">0</div>
        </div>
    </div>
    <div class="stat-card red">
        <div class="stat-icon red"><i class="bi bi-bar-chart-line-fill"></i></div>
        <div>
            <div class="stat-label">Hasil Ujian</div>
            <div class="stat-value red skeleton" id="statHasil" style="min-width:40px;">0</div>
        </div>
    </div>
</div>

{{-- ── QUICK LINKS ── --}}
<div class="panel-card">
    <div class="panel-card-header"><i class="bi bi-grid-3x3-gap"></i> Akses Cepat</div>
    <div class="panel-card-body">
        <div class="quick-links">
            <a class="quick-link-card" href="{{ route('guru.soal.create') }}">
                <div class="quick-link-icon" style="background:rgba(13,110,253,0.1);color:#0d6efd;"><i class="bi bi-plus-circle"></i></div>
                <span class="quick-link-label">Tambah Soal</span>
            </a>
            <a class="quick-link-card" href="{{ route('guru.soal.batch') }}">
                <div class="quick-link-icon" style="background:rgba(32,201,151,0.1);color:#198754;"><i class="bi bi-list-ol"></i></div>
                <span class="quick-link-label">Soal Batch</span>
            </a>
            <a class="quick-link-card" href="{{ route('guru.ujian.create') }}">
                <div class="quick-link-icon" style="background:rgba(255,193,7,0.12);color:#856404;"><i class="bi bi-file-earmark-plus"></i></div>
                <span class="quick-link-label">Buat Ujian</span>
            </a>
            <a class="quick-link-card" href="{{ route('guru.monitoring') }}">
                <div class="quick-link-icon" style="background:rgba(13,202,240,0.1);color:#0a9bba;"><i class="bi bi-tv"></i></div>
                <span class="quick-link-label">Monitoring</span>
            </a>
            <a class="quick-link-card" href="{{ route('guru.periksa') }}">
                <div class="quick-link-icon" style="background:rgba(111,66,193,0.1);color:#6f42c1;"><i class="bi bi-check2-square"></i></div>
                <span class="quick-link-label">Periksa Jawaban</span>
            </a>
            <a class="quick-link-card" href="{{ route('guru.hasil') }}">
                <div class="quick-link-icon" style="background:rgba(220,53,69,0.1);color:#dc3545;"><i class="bi bi-bar-chart-line"></i></div>
                <span class="quick-link-label">Hasil Ujian</span>
            </a>
        </div>
    </div>
</div>

{{-- ── CHATBOT TOGGLE BUTTON ── --}}
<div class="chatbot-toggle" id="chat-toggle">
    <i class="bi bi-chat-dots-fill"></i>
</div>

{{-- ── CHATBOT MODAL ── --}}
<div class="modal-overlay" id="chatbot-modal">
    <div class="modal-box">
        <div class="modal-head">
            <h5><i class="bi bi-robot me-2 text-primary"></i>Helper Guru</h5>
            <button class="modal-close" id="chat-close">&times;</button>
        </div>
        <div style="flex:1;overflow:auto;background:#f8f9ff;" id="chat-messages">
            <div class="p-4">
                <div class="text-center text-muted mb-4" style="font-size:0.85rem;">
                    <i class="bi bi-robot d-block mb-2 fs-1 text-primary opacity-75"></i>
                    Halo Guru! Saya ucup .<br>
                    Tanyakan: "cara buat soal", "periksa jawaban", "soal baru", ['mapel','mata pelajaran'], dll.
                </div>
            </div>
        </div>
        <div class="p-3 border-top" style="background:#fff;">
            <div class="input-group">
                <input type="text" id="chat-input" class="form-control"
                    placeholder="Ketik pertanyaan..."
                    style="border-radius:20px 0 0 20px;border-right:none;">
                <button class="btn btn-primary" id="chat-send"
                    style="border-radius:0 20px 20px 0;">
                    <i class="bi bi-send-fill"></i>
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ─── FETCH STAT CARDS ─── */
    fetch('/guru/dashboard/stats', {
        headers: { 'Accept': 'application/json' },
        credentials: 'same-origin'
    })
    .then(function (r) { return r.ok ? r.json() : {}; })
    .then(function (data) {
        document.getElementById('statMapel').textContent = data.mapel  ?? 0;
        document.getElementById('statSoal').textContent  = data.soal   ?? 0;
        document.getElementById('statUjian').textContent = data.ujian  ?? 0;
        document.getElementById('statHasil').textContent = data.hasil  ?? 0;

        ['statMapel','statSoal','statUjian','statHasil'].forEach(function (id) {
            document.getElementById(id).classList.remove('skeleton');
        });
    })
    .catch(function () {
        ['statMapel','statSoal','statUjian','statHasil'].forEach(function (id) {
            var el = document.getElementById(id);
            el.classList.remove('skeleton');
            el.textContent = '—';
        });
    });

    /* ─── CHATBOT ─── */
    var FAQS = [
        {
            q: ['cara buat soal','tambah soal','buat soal','soal baru'],
            a: 'Untuk <b>tambah soal</b>:<br>1. Klik <i class="bi bi-plus-circle"></i> <b>Tambah Soal Batch Untuk Sementara Waktu</b> di samping<br>2. Pilih kelas & mapel<br>3. Pilih Jumlah Soal Pilihan Ganda Lalu Generate<br>4. Isi opsi A/B/C/D & kunci jawaban<br>5. Simpan!<br><br>Atau gunakan <b>Soal Batch</b> untuk upload banyak sekaligus.<br>6 Harap Perhatian, jadi ketika anda sudah upload<br>Lalu tiba tiba mau tambah soal, tenang, andah bisa tambah seperti biasa, maka sistem otomatis tambah, jadi jangan panik bu/pak'
        },
        {
            q: ['buat ujian','tambah ujian','ujian baru'],
            a: 'Buat ujian baru:<br>1. Klik <b>Buat Ujian</b><br>2. Pilih kelas & mapel<br>3. Isi judul, durasi, jumlah soal<br>4. Pilih soal dari bank<br>5. Set waktu mulai/selesai<br>6. Publikasikan!'
        },
        {
            q: ['periksa jawaban','cek jawaban','nilai essay','priksa'],
            a: '<b>Periksa Jawaban:</b><br>1. Menu <b>Periksa</b><br>2. Pilih ujian<br>3. Lihat jawaban siswa<br>4. Beri nilai essay (0-100)<br>5. Total skor otomatis<br>6. Simpan & cetak laporan.'
        },
        {
            q: ['lihat hasil','hasil ujian','laporan'],
            a: 'Lihat <b>Hasil Ujian:</b><br>• Ranking siswa<br>• Skor per mata pelajaran<br>• Laporan PDF/Excel<br>• Filter per kelas/ujian<br>Menu: <b>Hasil</b>'
        },
        {
            q: ['monitoring','pantau ujian'],
            a: 'Real-time <b>Monitoring:</b><br>• Lokasi siswa GPS<br>• Waktu tersisa<br>• Deteksi kecurangan<br>• Logout paksa<br>Menu: <b>Monitoring</b>'
        },
        {
            q: ['mapel','mata pelajaran'],
            a: 'Kelola <b>Mapel:</b><br>• Lihat daftar mapel Anda<br>• Tambah/edit mapel<br>• Assign ke kelas<br>Menu: <b>Mapel</b>'
        }
    ];

    var toggleBtn = document.getElementById('chat-toggle');
    var modal     = document.getElementById('chatbot-modal');
    var closeBtn  = document.getElementById('chat-close');
    var input     = document.getElementById('chat-input');
    var sendBtn   = document.getElementById('chat-send');
    var messages  = document.getElementById('chat-messages');

    function addMessage(text, type) {
        var wrap = document.createElement('div');
        wrap.style.padding = '0 16px';

        var msg = document.createElement('div');
        msg.className = 'chat-msg ' + type;
        msg.innerHTML =
            '<div class="chat-bubble ' + type + '">' +
                text.replace(/\n/g, '<br>') +
            '</div>' +
            '<div style="font-size:0.7rem;opacity:0.6;margin-top:2px;' +
                (type === 'user' ? 'text-align:right;' : '') + '">' +
                new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }) +
            '</div>';

        wrap.appendChild(msg);
        messages.appendChild(wrap);
        messages.scrollTop = messages.scrollHeight;
    }

    function showTyping() {
        var wrap = document.createElement('div');
        wrap.style.padding = '0 16px';
        wrap.className = 'typing-wrap';

        var msg = document.createElement('div');
        msg.className = 'chat-msg bot';
        msg.innerHTML =
            '<div class="chat-bubble bot typing-indicator">' +
                '<span class="typing-dots">' +
                    '<span></span><span></span><span></span>' +
                '</span>' +
            '</div>';

        wrap.appendChild(msg);
        messages.appendChild(wrap);
        messages.scrollTop = messages.scrollHeight;
        return wrap;
    }

    function findAnswer(query) {
        query = query.toLowerCase();
        for (var i = 0; i < FAQS.length; i++) {
            var faq = FAQS[i];
            if (faq.q.some(function (kw) { return query.includes(kw); })) {
                return faq.a;
            }
        }
        return 'Maaf, saya belum paham pertanyaan itu. Coba tanya:<br>' +
               '• "cara buat soal"<br>' +
               '• "buat ujian"<br>' +
               '• "periksa jawaban"<br>' +
               '• "lihat hasil"<br>' +
               'Atau jelaskan lebih detail!';
    }

    function sendMessage() {
        var text = input.value.trim();
        if (!text) return;

        addMessage(text, 'user');
        input.value = '';

        var typingEl = showTyping();
        setTimeout(function () {
            if (typingEl.parentNode) typingEl.remove();
            addMessage(findAnswer(text), 'bot');
        }, 800 + Math.random() * 1200);
    }

    function openChatbot() {
        modal.classList.add('active');
        toggleBtn.classList.add('active');
        input.focus();
    }

    function closeChatbot() {
        modal.classList.remove('active');
        toggleBtn.classList.remove('active');
    }

    toggleBtn.addEventListener('click', function () {
        modal.classList.contains('active') ? closeChatbot() : openChatbot();
    });

    closeBtn.addEventListener('click', closeChatbot);
    sendBtn.addEventListener('click', sendMessage);
    input.addEventListener('keypress', function (e) {
        if (e.key === 'Enter') sendMessage();
    });
});
</script>
@endpush
