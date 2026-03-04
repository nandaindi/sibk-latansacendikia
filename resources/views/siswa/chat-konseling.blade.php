@extends('layouts.siswa')

@section('title', 'Konseling Online – BK')

@section('content')
<div class="flex flex-col flex-1 w-full pb-[80px] md:pb-0" style="height: calc(100vh - 72px);">

    <!-- Header -->
    <div class="px-4 md:px-6 pt-4 pb-3 border-b border-[#e5e7eb] bg-white">
        <h2 class="text-[1.1rem] font-extrabold text-[#1a9488] border-b-2 border-[#1a9488] pb-0.5 inline-block">Konseling Online</h2>
        @if($konseling)
        <div class="text-[0.78rem] text-[#777] mt-0.5">Sesi aktif · {{ \Carbon\Carbon::parse($konseling->tanggal)->translatedFormat('d F Y') }}</div>
        @endif
    </div>

    @if(!$konseling)
    <div class="flex-1 flex flex-col items-center justify-center text-center px-6 gap-4">
        <div class="w-16 h-16 rounded-full bg-[#e0f5f3] flex items-center justify-center">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#1a9488" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
        </div>
        <p class="text-[#555] text-[0.95rem]">Belum ada sesi konseling online yang aktif.</p>
        <a href="{{ route('siswa.pengajuan-online') }}" class="px-5 py-2 bg-[#1a9488] text-white rounded-xl text-sm font-semibold hover:bg-[#12635a] no-underline">Ajukan Konseling</a>
    </div>
    @else

    {{-- Link meet banner --}}
    @if($konseling->link_meet)
    <div class="px-4 md:px-6 py-2 bg-blue-50 border-b border-blue-100 flex items-center gap-2">
        <svg class="shrink-0" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 10l4.553-2.069A1 1 0 0121 8.882v6.236a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
        <span class="text-[0.8rem] text-blue-700 flex-1">Link meeting tersedia</span>
        <a href="{{ $konseling->link_meet }}" target="_blank" class="text-[0.8rem] font-bold text-blue-600 hover:text-blue-800 no-underline px-3 py-1 bg-blue-100 rounded-full hover:bg-blue-200 transition-colors">Buka Meeting</a>
    </div>
    @endif

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
            <input id="chatInput" type="text" placeholder="Ketik pesan…"
                class="flex-1 bg-transparent border-none outline-none text-[0.97rem] text-[#555] placeholder-[#90a8a6] font-medium"
                onkeydown="if(event.key==='Enter') sendMessage()"/>
            <button onclick="sendMessage()" class="text-[#1a9488] hover:text-[#12635a] transition-colors p-1">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
            </button>
        </div>
    </div>
    @endif

</div>
@endsection

@push('scripts')
@if($konseling)
<script>
/* ───────────── CONFIG ───────────── */
const KONSELING_ID = {{ $konseling->id }};
const CURRENT_USER = {{ auth()->id() }};
const SEND_URL     = '{{ route("siswa.chat.send") }}';
const FETCH_URL    = '{{ route("siswa.chat.fetch") }}';
const CSRF         = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';

/* ───────────── HELPERS ───────────── */
function escHtml(s){ return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }
function linkify(t){ return escHtml(t).replace(/(https?:\/\/[^\s]+)/g, u=>`<a href="${u}" target="_blank" class="underline opacity-90 break-all">${u}</a>`); }
function fmtTime(iso){ try{ return new Date(iso).toLocaleTimeString('id-ID',{hour:'2-digit',minute:'2-digit'}); }catch(e){return '';} }
function scrollBottom(){ const a=document.getElementById('chatArea'); if(a) a.scrollTop = a.scrollHeight; }

/* ───────────── BUBBLE RENDER ───────────── */
// Siswa (saya) → KANAN teal | BK → KIRI putih
function renderBubble(msg){
    const isMine = Number(msg.user_id) === Number(CURRENT_USER);
    const bubble = document.createElement('div');
    const t = msg.created_at ? `<div class="text-[0.65rem] mt-0.5 opacity-55 text-right">${fmtTime(msg.created_at)}</div>` : '';
    if(isMine){
        // SAYA (siswa) → KANAN, teal
        bubble.className = 'flex justify-end';
        bubble.innerHTML = `<div class="bg-[#1a9488] text-white px-4 py-2.5 rounded-[18px] rounded-tr-[4px] text-[0.93rem] max-w-[72%] shadow-sm">${linkify(msg.pesan)}${t}</div>`;
    } else {
        // BK / lawan → KIRI, putih
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

/* ───────────── LOAD HISTORY ← dipanggil PERTAMA ───────────── */
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
        const errDiv = document.createElement('div');
        errDiv.className = 'text-center py-4 text-[0.8rem] text-red-400';
        errDiv.textContent = 'Gagal memuat riwayat. Coba refresh halaman.';
        document.getElementById('chatArea')?.appendChild(errDiv);
    } finally {
        if(loader) loader.remove(); // SELALU hapus spinner
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

/* ───────────── INIT — loadHistory SEBELUM Echo ───────────── */
loadHistory();   // ← JALAN PERTAMA, tidak bergantung Echo

/* ───────────── ECHO — dibungkus try/catch TERPISAH ───────────── */
try {
    if(window.Echo){
        window.Echo.private(`chat.${KONSELING_ID}`)
            .listen('PesanChatTerkirim', e => renderBubble(e));
    }
} catch(echoErr){
    console.warn('Echo setup gagal:', echoErr);
}
</script>
@endif
@endpush
