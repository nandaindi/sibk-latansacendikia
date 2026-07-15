@extends('layouts.siswa')

@section('title', 'Konseling Online – BK')

@section('content')
<div class="flex flex-col flex-1 w-full pb-[80px] md:pb-0" style="height: calc(100dvh - 72px);">

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

    <!-- Input Bar / Feedback Form -->
    <div class="sticky bottom-0 md:relative px-4 md:px-6 py-4 bg-[#d4e9e7] border-t border-[#c5dbd9] z-10">
        @if($konseling->status === 'disetujui')
            {{-- Baris Input Chat --}}
            <div class="flex items-end gap-2">
                <div class="flex-1 flex items-end bg-white rounded-3xl border border-[#c5dbd9] shadow-sm px-2 py-1.5 transition-all focus-within:border-[#1a9488] focus-within:ring-2 focus-within:ring-[#1a9488]/20">
                    <label for="chatInput" class="sr-only">Tulis pesan</label>
                    <textarea id="chatInput" rows="1" maxlength="5000" placeholder="Ketik pesan…"
                        aria-describedby="chatInputHint chatStatus"
                        class="flex-1 max-h-32 resize-none overflow-y-auto bg-transparent border-none outline-none text-[0.95rem] leading-[1.5] text-[#333] placeholder-[#8da8a5] px-3 py-2 focus:ring-0"></textarea>
                    
                    <button id="chatSendButton" type="button" onclick="sendMessage()" aria-label="Kirim pesan"
                        class="w-10 h-10 shrink-0 inline-flex items-center justify-center text-white bg-[#1a9488] hover:bg-[#12635a] shadow-sm disabled:cursor-not-allowed disabled:opacity-50 transition-colors border-none cursor-pointer rounded-full mb-0.5 mr-0.5">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="translate-x-[-1px] translate-y-[1px]"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                    </button>
                </div>
            </div>
            <div id="chatInputHint" class="mt-1.5 text-[0.72rem] text-[#496763]">Enter untuk kirim · Shift + Enter untuk baris baru</div>
            <div id="chatStatus" class="sr-only" role="status" aria-live="polite"></div>
        @else
            {{-- Sesi Selesai - Tampilkan Form Feedback --}}
            <div class="bg-white/80 backdrop-blur-md rounded-2xl p-5 border border-[#1a9488]/30 shadow-lg -mt-10 mb-4 animate-[fadeInUp_0.4s_ease-out]">
                <div class="flex items-center gap-2 mb-4 text-[#1a9488]">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    <h3 class="font-bold text-[1.05rem]">Sesi Telah Selesai</h3>
                </div>
                <p class="text-[0.88rem] text-[#555] mb-5 leading-relaxed italic">"Bimbingan hari ini telah berakhir. Sebelum kembali ke dashboard, silakan isi kesimpulan dan saran kamu untuk sesi ini."</p>
                
                <form action="{{ route('siswa.konseling.feedback') }}" method="POST" class="flex flex-col gap-4">
                    @csrf
                    <input type="hidden" name="konseling_id" value="{{ $konseling->id }}">
                    
                    <div class="flex flex-col gap-3 mb-2">
                        <label class="text-[0.85rem] font-bold text-[#1a9488] uppercase tracking-wide border-b border-[#1a9488]/20 pb-1">Penilaian Kepuasan Layanan</label>
                        
                        <style>
                            .emoji-radio input[type="radio"] { display: none; }
                            .emoji-radio label { cursor: pointer; opacity: 0.5; transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1); transform: scale(0.9); border: 2px solid transparent; border-radius: 50%; padding: 4px; }
                            .emoji-radio input[type="radio"]:hover + label { opacity: 0.8; transform: scale(1.05); }
                            .emoji-radio input[type="radio"]:checked + label { opacity: 1; transform: scale(1.15); border-color: currentColor; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
                            
                            /* Colors */
                            .emoji-radio .label-kurang { color: #ef4444; }
                            .emoji-radio input[value="Kurang Memuaskan"]:checked + label { background: #fef2f2; }
                            
                            .emoji-radio .label-cukup { color: #f59e0b; }
                            .emoji-radio input[value="Memuaskan"]:checked + label { background: #fffbeb; }
                            
                            .emoji-radio .label-sangat { color: #10b981; }
                            .emoji-radio input[value="Sangat Memuaskan"]:checked + label { background: #ecfdf5; }
                        </style>

                        @php
                            $kepuasanItems = [
                                'kepuasan_penerimaan' => 'Penerimaan guru bimbingan dan konseling atau konselor terhadap kehadiran Anda',
                                'kepuasan_kemudahan' => 'Kemudahan guru bimbingan dan konseling atau konselor untuk diajak curhat',
                                'kepuasan_kepercayaan' => 'Kepercayaan Anda terhadap guru bimbingan dan konseling atau konselor dalam layanan konseling',
                                'kepuasan_pelayanan' => 'Pelayanan pemecahan masalah tercapai melalui konseling individual'
                            ];
                        @endphp

                        @foreach($kepuasanItems as $name => $label)
                        <div class="bg-[#f9fbfb] border border-[#1a9488]/20 rounded-xl p-3 flex flex-col gap-3">
                            <div class="text-[0.85rem] text-[#333] font-medium leading-tight text-center">{{ $label }}</div>
                            <div class="flex justify-center items-center gap-6 emoji-radio">
                                <!-- Kurang Memuaskan -->
                                <div class="flex flex-col items-center gap-1">
                                    <input type="radio" name="{{ $name }}" id="{{ $name }}_kurang" value="Kurang Memuaskan" required>
                                    <label for="{{ $name }}_kurang" class="text-3xl label-kurang" title="Kurang Memuaskan">
                                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M16 16s-1.5-2-4-2-4 2-4 2"></path><line x1="9" y1="9" x2="9.01" y2="9"></line><line x1="15" y1="9" x2="15.01" y2="9"></line></svg>
                                    </label>
                                    <span class="text-[0.6rem] text-gray-500 font-bold uppercase tracking-tighter">Kurang</span>
                                </div>
                                <!-- Memuaskan -->
                                <div class="flex flex-col items-center gap-1">
                                    <input type="radio" name="{{ $name }}" id="{{ $name }}_cukup" value="Memuaskan" required>
                                    <label for="{{ $name }}_cukup" class="text-3xl label-cukup" title="Memuaskan">
                                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="8" y1="15" x2="16" y2="15"></line><line x1="9" y1="9" x2="9.01" y2="9"></line><line x1="15" y1="9" x2="15.01" y2="9"></line></svg>
                                    </label>
                                    <span class="text-[0.6rem] text-gray-500 font-bold uppercase tracking-tighter">Cukup</span>
                                </div>
                                <!-- Sangat Memuaskan -->
                                <div class="flex flex-col items-center gap-1">
                                    <input type="radio" name="{{ $name }}" id="{{ $name }}_sangat" value="Sangat Memuaskan" required>
                                    <label for="{{ $name }}_sangat" class="text-3xl label-sangat" title="Sangat Memuaskan">
                                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M8 14s1.5 2 4 2 4-2 4-2"></path><line x1="9" y1="9" x2="9.01" y2="9"></line><line x1="15" y1="9" x2="15.01" y2="9"></line></svg>
                                    </label>
                                    <span class="text-[0.6rem] text-gray-500 font-bold uppercase tracking-tighter">Sangat</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label class="text-[0.82rem] font-bold text-[#1a9488] uppercase tracking-wide">Kesimpulan Kamu</label>
                        <textarea name="kesimpulan_siswa" rows="2" required placeholder="Apa yang kamu simpulkan dari bimbingan ini?"
                                  class="w-full bg-[#f9fbfb] border-2 border-[#1a9488]/20 rounded-xl px-4 py-2.5 text-[0.93rem] outline-none focus:border-[#1a9488] transition-colors resize-none"></textarea>
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label class="text-[0.82rem] font-bold text-[#1a9488] uppercase tracking-wide">Saran Untuk Guru BK</label>
                        <textarea name="saran_siswa" rows="2" required placeholder="Berikan saran jika ada..."
                                  class="w-full bg-[#f9fbfb] border-2 border-[#1a9488]/20 rounded-xl px-4 py-2.5 text-[0.93rem] outline-none focus:border-[#1a9488] transition-colors resize-none"></textarea>
                    </div>

                    <button type="submit" class="w-full bg-[#1a9488] text-white py-3 rounded-xl font-bold text-[0.95rem] shadow-md hover:brightness-105 active:scale-95 transition-all mt-2 border-none cursor-pointer">
                        Selesaikan & Simpan
                    </button>
                </form>
            </div>
        @endif
    </div>
    @endif

</div>

<style>
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
@endsection

@push('scripts')
@if($konseling)
<script type="module">
/* ───────────── CONFIG ───────────── */
const KONSELING_ID = {{ $konseling->id }};
const CURRENT_USER = {{ auth()->id() }};
const SEND_URL     = '{{ route("siswa.chat.send") }}';
const FETCH_URL    = '{{ route("siswa.chat.fetch") }}';
const CSRF         = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';

/* ───────────── HELPERS ───────────── */
function escHtml(s){ return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/'/g,'&#039;'); }
function linkify(t){ return escHtml(t).replace(/(https?:\/\/[^\s]+)/g, u=>`<a href="${u}" target="_blank" rel="noopener noreferrer" class="underline opacity-90 break-all">${u}</a>`); }
function fmtTime(iso){ try{ return new Date(iso).toLocaleTimeString('id-ID',{hour:'2-digit',minute:'2-digit'}); }catch(e){return '';} }
function scrollBottom(){ const a=document.getElementById('chatArea'); if(a) a.scrollTop = a.scrollHeight; }
function announce(message){ const status = document.getElementById('chatStatus'); if(status) status.textContent = message; }
function resizeChatInput(){
    const input = document.getElementById('chatInput');
    if(!input) return;
    input.style.height = 'auto';
    input.style.height = `${Math.min(input.scrollHeight, 120)}px`;
}

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
    return bubble;
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
let isSending = false;
window.sendMessage = async function(){
    const input = document.getElementById('chatInput');
    const sendButton = document.getElementById('chatSendButton');
    const text  = (input?.value || '').trim();
    if(!text || isSending) return;
    isSending = true;
    sendButton.disabled = true;
    input.value = '';
    resizeChatInput();
    const pendingBubble = renderBubble({ user_id: CURRENT_USER, pesan: text, created_at: new Date().toISOString() });
    announce('Mengirim pesan');
    try {
        const headers = {
            'Content-Type':'application/json',
            'X-CSRF-TOKEN':CSRF
        };
        if (window.Echo && window.Echo.socketId()) {
            headers['X-Socket-Id'] = window.Echo.socketId();
        }
        
        const response = await fetch(SEND_URL, {
            method:'POST',
            headers: headers,
            body: JSON.stringify({ konseling_id: KONSELING_ID, pesan: text }),
        });
        if (!response.ok) throw new Error(`HTTP ${response.status}`);
        announce('Pesan terkirim');
    } catch(e){
        console.warn('send error:', e);
        pendingBubble?.remove();
        input.value = text;
        resizeChatInput();
        input.focus();
        announce('Pesan gagal dikirim. Pesan dikembalikan ke kolom penulisan.');
        window.showToast('Pesan belum terkirim. Periksa koneksi lalu coba lagi.', 'error');
    } finally {
        isSending = false;
        sendButton.disabled = false;
    }
}

document.getElementById('chatInput')?.addEventListener('input', resizeChatInput);
document.getElementById('chatInput')?.addEventListener('keydown', (event) => {
    if (event.key === 'Enter' && !event.shiftKey) {
        event.preventDefault();
        window.sendMessage();
    }
});
resizeChatInput();

/* ───────────── INIT — loadHistory SEBELUM Echo ───────────── */
loadHistory();   // ← JALAN PERTAMA, tidak bergantung Echo

/* ───────────── ECHO — dibungkus try/catch TERPISAH ───────────── */
try {
    if(window.Echo){
        window.Echo.private(`chat.${KONSELING_ID}`)
            .listen('.PesanChatTerkirim', e => renderBubble(e));
    }
} catch(echoErr){
    console.warn('Echo setup gagal:', echoErr);
}
</script>
@endif
@endpush
