@extends('layouts.siswa')

@section('title', 'Pusat Notifikasi')

@section('content')
<main class="w-full px-4 md:px-6 py-6 md:py-10 flex-1">
    <div class="max-w-4xl mx-auto">
        <!-- Header Halaman -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-[#1a1a1a]">Pusat Notifikasi</h1>
                <p class="text-sm md:text-base text-[#777] mt-1">Pantau seluruh riwayat aktivitas dan pemberitahuan kamu di sini.</p>
            </div>
            @if($notifications->total() > 0)
            <form action="{{ route('siswa.notifications.mark-as-read') }}" method="POST">
                @csrf
                <button type="submit" class="hidden md:flex items-center gap-2 px-5 py-2.5 bg-white border border-[#eaeaea] text-[#1a9488] font-bold text-sm rounded-xl hover:bg-[#f0f9f8] transition-all shadow-sm">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    Tandai Semua Dibaca
                </button>
            </form>
            @endif
        </div>

        <!-- List Notifikasi -->
        <div class="bg-white rounded-[24px] border border-[#edf2f1] shadow-[0_10px_40px_rgba(0,0,0,0.03)] overflow-hidden">
            @forelse($notifications as $notif)
                @php
                    $isConseling = isset($notif->problem_type); // Cara sederhana membedakan model
                    $isUnread = !$notif->is_read;
                    $url = '#';

                    if ($isConseling) {
                        if ($notif->status === 'selesai') {
                            $url = route('siswa.detail-laporan', $notif->id);
                        } elseif ($notif->status === 'disetujui') {
                            $url = ($notif->jenis == 'online') ? route('siswa.mulai-konseling') : route('siswa.konseling-offline');
                        }
                    } else {
                        $url = route('siswa.detail-panggilan', $notif->id);
                    }
                @endphp

                <a href="{{ $url }}" class="block p-5 md:p-6 border-b border-[#f5f5f5] hover:bg-[#fcfdfd] transition-all no-underline group relative {{ $isUnread ? 'bg-[#f0fdf9]/30' : '' }}">
                    <div class="flex items-start gap-4">
                        <!-- Icon Column -->
                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0 
                            {{ $isConseling ? 'bg-[#e0f5f3] text-[#1a9488]' : 'bg-red-50 text-red-500' }}">
                            @if($isConseling)
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                </svg>
                            @else
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                                    <line x1="12" y1="9" x2="12" y2="13"></line>
                                    <line x1="12" y1="17" x2="12.01" y2="17"></line>
                                </svg>
                            @endif
                        </div>

                        <!-- Content Column -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-2 mb-1">
                                <span class="text-[0.75rem] font-bold uppercase tracking-wider {{ $isConseling ? 'text-[#1a9488]' : 'text-red-500' }}">
                                    {{ $isConseling ? 'Konseling ' . ucfirst($notif->jenis) : 'Panggilan Pelanggaran' }}
                                </span>
                                <span class="text-[0.7rem] text-[#aaa] font-medium whitespace-nowrap">
                                    {{ ($notif->updated_at ?? $notif->created_at)->diffForHumans() }}
                                </span>
                            </div>
                            
                            <h3 class="text-base md:text-lg font-bold text-[#1a1a1a] mb-1 group-hover:text-[#1a9488] transition-colors">
                                @if($isConseling)
                                    {{ $notif->status === 'selesai' ? 'Laporan Konseling Tersedia' : 'Jadwal Konseling Disetujui' }}
                                @else
                                    Pemanggilan Guru BK
                                @endif
                            </h3>
                            
                            <p class="text-sm text-[#555] line-clamp-2 md:line-clamp-none">
                                @if($isConseling)
                                    Sesi bimbingan kamu tentang "{{ $notif->problem_type }}" yang dilaksanakan pada {{ \Carbon\Carbon::parse($notif->tanggal)->translatedFormat('d M Y') }}.
                                @else
                                    Kamu diminta untuk menemui Guru BK ({{ $notif->bk->name ?? 'BK' }}) pada tanggal {{ \Carbon\Carbon::parse($notif->tanggal)->translatedFormat('d M Y') }} pukul {{ \Carbon\Carbon::parse($notif->waktu)->format('H:i') }}.
                                @endif
                            </p>
                        </div>

                        <!-- Indicator -->
                        @if($isUnread)
                            <div class="w-2.5 h-2.5 rounded-full bg-[#1a9488] mt-2 shadow-[0_0_8px_rgba(26,148,136,0.5)]"></div>
                        @endif
                    </div>
                </a>
            @empty
                <div class="py-20 flex flex-col items-center justify-center text-center px-4">
                    <div class="w-20 h-20 bg-[#f9fafb] rounded-full flex items-center justify-center mb-4">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#ddd" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-[#1a1a1a]">Belum Ada Notifikasi</h3>
                    <p class="text-sm text-[#777] max-w-xs mt-1">Seluruh riwayat pemberitahuan kamu akan muncul di halaman ini.</p>
                </div>
            @endforelse

            @if($notifications->hasPages())
                <div class="px-6 py-4 bg-[#fcfdfd] border-t border-[#f5f5f5]">
                    {{ $notifications->links() }}
                </div>
            @endif
        </div>
    </div>
</main>
@endsection
