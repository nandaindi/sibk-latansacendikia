@extends('layouts.bk')

@section('title', 'Konseling Online – BK')

@section('content')
<div class="flex flex-col flex-1 w-full pb-[80px] md:pb-0" style="height: calc(100vh - 72px);">

    <!-- Header -->
    <div class="px-4 md:px-6 pt-4 pb-3 border-b border-[#e5e7eb] bg-white flex items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            <a href="{{ route('bk.detail-sesi', ['id' => $konseling->id]) }}" class="text-[#1a9488] hover:text-[#12635a] transition-colors mr-1">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h2 class="text-[1.1rem] font-extrabold text-[#1a9488] border-b-2 border-[#1a9488] pb-0.5 inline-block">Konseling Online</h2>
                <div class="text-[0.78rem] text-[#777] mt-0.5">dengan {{ $konseling->user->name }}</div>
            </div>
        </div>
        <div class="flex items-center gap-2">
            @if($konseling->link_meet)
            <a href="{{ $konseling->link_meet }}" target="_blank"
               class="hidden md:flex items-center gap-1.5 text-[0.8rem] font-semibold px-3 py-1.5 rounded-xl bg-blue-50 text-blue-600 border border-blue-200 hover:bg-blue-100 transition-all no-underline">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 10l4.553-2.069A1 1 0 0121 8.882v6.236a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                Buka Meet
            </a>
            <button onclick="bagikanLink()" class="hidden md:flex items-center gap-1.5 text-[0.8rem] font-semibold px-3 py-1.5 rounded-xl bg-[#e0f5f3] text-[#1a9488] border border-[#c7ece8] hover:bg-[#1a9488] hover:text-white transition-all">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
                Bagikan Link
            </button>
            @endif
            <button id="btnSelesai" onclick="selesaiSesi()"
                class="flex items-center gap-1.5 text-[0.8rem] font-semibold px-3 py-1.5 rounded-xl bg-[#fff3cd] text-[#c97a00] border border-[#ffeeba] hover:bg-[#c97a00] hover:text-white transition-all">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                Selesai
            </button>
        </div>
    </div>

    <!-- Chat Area -->
    <div id="chatArea" class="flex-1 overflow-y-auto px-4 md:px-6 py-5 flex flex-col gap-3 bg-[#f9fbfb]">
        <div id="chatLoading" class="flex justify-center items-center py-10 text-[#aaa] text-sm gap-2">
            <svg class="animate-spin w-5 h-5 text-[#1a9488]" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
            </svg>
            <span>Memuat percakapan…</span>
        </div>
    </div>

    <!-- Input Bar -->
    <div class="sticky bottom-0 md:relative px-4 md:px-6 py-3 bg-[#d4e9e7] border-t border-[#c5dbd9]">
        <div class="flex items-center gap-3">
            @if($konseling->link_meet)
            <a href="{{ $konseling->link_meet }}" target="_blank"
               class="md:hidden flex items-center justify-center w-9 h-9 rounded-full bg-blue-100 text-blue-600 shrink-0" title="Buka Meeting">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 10l4.553-2.069A1 1 0 0121 8.882v6.236a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
            </a>
            @endif
            <input id="chatInput" type="text" placeholder="Ketik pesan…"
                class="flex-1 bg-transparent border-none outline-none text-[0.97rem] text-[#555] placeholder-[#90a8a6] font-medium"
                onkeydown="if(event.key==='Enter') sendMessage()"/>
            <button onclick="sendMessage()" class="text-[#1a9488] hover:text-[#12635a] transition-colors p-1">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
            </button>
        </div>
    </div>

</div>

<!-- Modal Konfirmasi Selesaikan Sesi (menggantikan native confirm()) -->
<div id="modalSelesai" class="fixed inset-0 bg-black/50 z-[200] flex items-center justify-center p-4 opacity-0 invisible transition-all duration-300">
    <div id="modalSelesaiBox" class="relative w-full max-w-[400px] translate-y-4 transition-all duration-300 ease-[cubic-bezier(0.34,1.56,0.64,1)]">
        <!-- Header Floating -->
        <div class="flex items-center gap-3 mb-2 pl-2">
            <svg width="30" height="30" viewBox="0 0 24 24" fill="#fcd34d" class="drop-shadow-md">
                <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.63-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.64 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/>
            </svg>
            <h3 class="text-[1.1rem] font-extrabold text-white tracking-wide uppercase drop-shadow-md">SELESAIKAN SESI</h3>
        </div>
        <!-- White Box -->
        <div class="bg-white rounded-[10px] border-[2px] border-[#0F766E] w-full p-5 md:p-6 relative shadow-[0_10px_40px_rgba(0,0,0,0.3)]">
            <!-- Close (X) -->
            <button onclick="tutupModalSelesai()" class="absolute -top-4 -right-4 w-9 h-9 bg-white rounded-full border-[3px] border-red-600 flex items-center justify-center text-red-600 hover:bg-red-50 transition-colors focus:outline-none z-10">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" class="stroke-current stroke-[3]" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
            <!-- Isi -->
            <p class="text-[0.97rem] text-[#1a1a1a] font-medium leading-relaxed mb-1">
                Yakin ingin menyelesaikan sesi konseling ini?
            </p>
            <p class="text-[0.82rem] text-[#777] mb-5">Laporan akan dibuat otomatis setelah sesi selesai.</p>
            <!-- Tombol -->
            <div class="flex gap-3 justify-end">
                <button onclick="tutupModalSelesai()"
                    class="px-5 py-2 rounded-full border border-[#e5e7eb] text-[#555] text-[0.88rem] font-semibold hover:bg-gray-50 transition-colors">
                    Batal
                </button>
                <button id="btnKonfirmasiSelesai" onclick="konfirmasiSelesai()"
                    class="px-6 py-2 rounded-full bg-[#1a9488] text-white text-[0.88rem] font-bold hover:bg-[#157a70] transition-colors shadow-md">
                    Ya, Selesaikan
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
/* ───────────── CONFIG ───────────── */
const KONSELING_ID = {{ $konseling->id }};
const CURRENT_USER = {{ auth()->id() }};
const SEND_URL     = '{{ route("bk.chat.send") }}';
const FETCH_URL    = '{{ route("bk.chat.fetch") }}';
const FINISH_URL   = '{{ route("bk.selesai-sesi") }}';
const CSRF         = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';
const LINK_MEET    = @json($konseling->link_meet ?? '');

/* ───────────── HELPERS ───────────── */
function escHtml(s){ return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }
function linkify(t){ return escHtml(t).replace(/(https?:\/\/[^\s]+)/g, u=>`<a href="${u}" target="_blank" class="underline opacity-90 break-all">${u}</a>`); }
function fmtTime(iso){ try{ return new Date(iso).toLocaleTimeString('id-ID',{hour:'2-digit',minute:'2-digit'}); }catch(e){return '';} }
function scrollBottom(){ const a=document.getElementById('chatArea'); if(a) a.scrollTop = a.scrollHeight; }

/* ───────────── BUBBLE RENDER ───────────── */
// BK (saya) → KANAN teal | Siswa → KIRI putih
function renderBubble(msg){
    const isMine = Number(msg.user_id) === Number(CURRENT_USER);
    const bubble = document.createElement('div');
    const t = msg.created_at ? `<div class="text-[0.65rem] mt-0.5 opacity-55 text-right">${fmtTime(msg.created_at)}</div>` : '';
    if(isMine){
        bubble.className = 'flex justify-end';
        bubble.innerHTML = `<div class="bg-[#1a9488] text-white px-4 py-2.5 rounded-[18px] rounded-tr-[4px] text-[0.93rem] max-w-[72%] shadow-sm">${linkify(msg.pesan)}${t}</div>`;
    } else {
        bubble.className = 'flex items-end gap-2';
        bubble.innerHTML = `
            <div class="w-7 h-7 rounded-full border-2 border-[#1a9488] flex items-center justify-center shrink-0 mb-0.5 bg-white">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#1a9488" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </div>
            <div class="bg-white border border-[#e0e0e0] text-[#1a1a1a] px-4 py-2.5 rounded-[18px] rounded-tl-[4px] text-[0.93rem] max-w-[72%] shadow-sm">${linkify(msg.pesan)}<div class="text-[0.65rem] mt-0.5 opacity-55">${fmtTime(msg.created_at??'')}</div></div>`;
    }
    const area = document.getElementById('chatArea');
    if(area){ area.appendChild(bubble); scrollBottom(); }
}

/* ───────────── LOAD HISTORY  ← dipanggil PERTAMA ───────────── */
async function loadHistory(){
    const loader = document.getElementById('chatLoading');
    try {
        const res  = await fetch(`${FETCH_URL}?konseling_id=${KONSELING_ID}`, {
            headers:{ 'X-Requested-With':'XMLHttpRequest', 'Accept':'application/json' }
        });
        if(!res.ok) throw new Error(`HTTP ${res.status}`);
        const data = await res.json();
        if(data.pesans && data.pesans.length > 0){
            data.pesans.forEach(m => renderBubble(m));
        }
    } catch(err){
        console.warn('loadHistory error:', err);
        // Tampilkan info error di chat jika fetch benar-benar gagal
        const errDiv = document.createElement('div');
        errDiv.className = 'text-center py-4 text-[0.8rem] text-red-400';
        errDiv.textContent = 'Gagal memuat riwayat. Coba refresh halaman.';
        document.getElementById('chatArea')?.appendChild(errDiv);
    } finally {
        if(loader) loader.remove(); // ← SELALU hapus spinner
    }
}

/* ───────────── SEND ───────────── */
async function sendMessage(){
    const input = document.getElementById('chatInput');
    const text  = (input?.value || '').trim();
    if(!text) return;
    input.value = '';
    renderBubble({ user_id: CURRENT_USER, pesan: text, created_at: new Date().toISOString() });
    try {
        await fetch(SEND_URL, {
            method:'POST',
            headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF},
            body: JSON.stringify({ konseling_id: KONSELING_ID, pesan: text }),
        });
    } catch(e){ console.warn('send error:', e); }
}

/* ───────────── BAGIKAN LINK ───────────── */
function bagikanLink(){
    if(!LINK_MEET){ 
        Swal.fire({
            icon: 'warning',
            title: 'Link Meet Belum Ada',
            text: 'Link meeting belum diatur oleh Anda.',
            confirmButtonColor: '#1a9488'
        });
        return; 
    }
    const inp = document.getElementById('chatInput');
    if(inp){ inp.value = `🎥 Link Meeting: ${LINK_MEET}`; inp.focus(); }
}

/* ───────────── MODAL SELESAI SESI ───────────── */
function selesaiSesi(){
    const m   = document.getElementById('modalSelesai');
    const box = document.getElementById('modalSelesaiBox');
    m.classList.remove('opacity-0','invisible');
    box.classList.remove('translate-y-4');
}
function tutupModalSelesai(){
    const m   = document.getElementById('modalSelesai');
    const box = document.getElementById('modalSelesaiBox');
    m.classList.add('opacity-0','invisible');
    box.classList.add('translate-y-4');
}
async function konfirmasiSelesai(){
    const btn = document.getElementById('btnKonfirmasiSelesai');
    if(btn){ btn.disabled=true; btn.textContent='Menyelesaikan…'; }
    try {
        const res  = await fetch(FINISH_URL,{
            method:'POST',
            headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF},
            body: JSON.stringify({ konseling_id: KONSELING_ID }),
        });
        const data = await res.json();
        if(data.ok) window.location.href = '{{ url("bk/form-konseling-online") }}/' + data.id;
        else { tutupModalSelesai(); if(btn){btn.disabled=false;btn.textContent='Ya, Selesaikan';} }
    } catch(e){
        tutupModalSelesai();
        if(btn){btn.disabled=false;btn.textContent='Ya, Selesaikan';}
    }
}

/* ───────────── INIT — loadHistory SEBELUM Echo ───────────── */
loadHistory();   // ← SELALU jalan, tidak bergantung Echo

/* ───────────── ECHO — dibungkus try/catch terpisah ───────────── */
try {
    if(window.Echo){
        window.Echo.private(`chat.${KONSELING_ID}`)
            .listen('PesanChatTerkirim', e => renderBubble(e));
    }
} catch(echoErr){
    console.warn('Echo setup gagal (chat tetap bisa kirim/terima via refresh):', echoErr);
}
</script>
@endpush
