@extends('layouts.bk')

@section('title', 'Panggil Siswa – BK')

@section('content')
<main class="w-full px-4 md:px-6 py-6 flex-1 pb-[100px] md:pb-10">

    <div class="mb-8 border-b border-[#1a9488] pb-3">
        <h2 class="text-[1.3rem] md:text-[1.5rem] font-extrabold text-[#1a1a1a]">Panggil Siswa</h2>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">

        <div class="flex-1 w-full">
            <form id="formPanggil" class="flex flex-col gap-5" method="POST" action="{{ route('bk.panggil-siswa.store') }}">
                @csrf

                <div class="relative w-full" id="custom-select-container">
                    <input type="text" name="user_id" id="selected-user-id" required class="absolute bottom-0 left-1/2 w-0 h-0 opacity-0 pointer-events-none" tabindex="-1">
                    
                    <div id="custom-select-trigger" class="border-[2px] border-[#1a9488] rounded-full px-5 py-3.5 bg-white hover:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all flex items-center justify-between cursor-pointer group">
                        <span id="custom-select-text" class="text-[1rem] font-medium text-[#aaa]">-- Pilih Siswa --</span>
                        <div id="custom-select-arrow" class="pointer-events-none text-[#1a9488] shrink-0 ml-2 transition-transform duration-200">
                            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>

                    <div id="custom-select-dropdown" class="absolute z-50 w-full mt-2 left-0 bg-white border border-[#1a9488] rounded-2xl shadow-[0_8px_30px_rgba(26,148,136,0.15)] overflow-hidden hidden transform origin-top transition-all duration-200 opacity-0 scale-95" style="max-height: 250px; overflow-y: auto;">
                        <ul class="flex flex-col py-2" id="custom-select-list">
                            @foreach($siswas as $siswa)
                                <li class="px-5 py-2.5 text-[0.95rem] hover:bg-[#e0f5f3] hover:text-[#1a9488] font-semibold cursor-pointer transition-colors text-[#1a1a1a]" data-value="{{ $siswa->id }}" data-text="{{ $siswa->name }}">
                                    {{ $siswa->name }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="border-[2px] border-[#1a9488] rounded-full px-5 py-3.5 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all">
                    <input type="text" name="topik" placeholder="Topik Panggilan (cth: Evaluasi Nilai)" required
                           class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] placeholder-[#aaa] bg-transparent font-medium">
                </div>

                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1 border-[2px] border-[#1a9488] rounded-full px-5 py-3.5 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all">
                        <label class="text-[0.7rem] font-bold text-[#1a9488] ml-1 mb-0.5 block uppercase tracking-wide">Tanggal Panggilan</label>
                        <input type="date" name="tanggal" required value="{{ date('Y-m-d') }}"
                               class="w-full border-none outline-none text-[0.95rem] text-[#1a1a1a] bg-transparent font-medium">
                    </div>
                    <div class="flex-1 border-[2px] border-[#1a9488] rounded-full px-5 py-3.5 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all">
                        <label class="text-[0.7rem] font-bold text-[#1a9488] ml-1 mb-0.5 block uppercase tracking-wide">Jam Pelaksanaan</label>
                        <input type="time" name="waktu" required value="09:00"
                               class="w-full border-none outline-none text-[0.95rem] text-[#1a1a1a] bg-transparent font-medium">
                    </div>
                </div>

                <div class="border-[2px] border-[#1a9488] rounded-[20px] px-5 py-4 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all">
                    <textarea name="catatan" placeholder="Catatan Pemanggilan (Opsional)" rows="4"
                              class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] placeholder-[#aaa] bg-transparent font-medium resize-none"></textarea>
                </div>
            </form>

            <div class="flex justify-end mt-4">
                <button onclick="document.getElementById('formPanggil').submit()"
                        class="px-10 py-3.5 bg-[#1a9488] text-white rounded-full text-[1rem] font-bold shadow-[0_4px_16px_rgba(26,148,136,0.35)] hover:bg-[#157a70] hover:-translate-y-0.5 transition-all active:scale-95">
                    Send
                </button>
            </div>
        </div>

        <div class="hidden lg:flex flex-col gap-3 flex-1 mt-2">
            <h3 class="text-[1.1rem] font-bold text-[#1a9488] mb-1">Riwayat Panggilan Kamu</h3>

            @forelse($riwayatPanggilan as $item)
            <a href="{{ route('bk.panggil-siswa.detail', $item->id) }}" class="bg-white border-[2px] border-[#1a9488] rounded-2xl px-4 py-3 flex items-center gap-4 shadow-sm hover:translate-x-1 transition-transform no-underline">
                <div class="w-12 h-12 shrink-0 rounded-full bg-[#e0f5f3] text-[#1a9488] flex items-center justify-center font-bold text-lg border border-[#c7ece8]">
                    {{ substr($item->user->name, 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="font-semibold text-[0.95rem] text-[#1a1a1a] truncate">{{ $item->user->name }}</div>
                    <div class="text-[0.82rem] text-[#777]">
                        {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d M Y') }} · {{ \Carbon\Carbon::parse($item->waktu)->format('H:i') }}
                    </div>
                    @if($item->status == 'selesai')
                        <div class="text-[0.78rem] font-bold text-[#1a9488] mt-0.5">Selesai</div>
                    @elseif($item->status == 'menunggu')
                        <div class="text-[0.78rem] font-bold text-[#e17055] mt-0.5 animate-pulse">Menunggu Siswa</div>
                    @else
                        <div class="text-[0.78rem] font-bold text-[#aaa] mt-0.5 capitalize">{{ str_replace('_', ' ', $item->status) }}</div>
                    @endif
                </div>
            </a>
            @empty
            <div class="text-center py-10 text-[#aaa] border-2 border-dashed border-[#c5dbd9] rounded-2xl">
                <svg width="40" height="40" class="mx-auto mb-2 opacity-50" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                <p class="text-sm">Belum ada riwayat panggilan.</p>
            </div>
            @endforelse
        </div>

    </div>

</main>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const trigger = document.getElementById('custom-select-trigger');
        const dropdown = document.getElementById('custom-select-dropdown');
        const arrow = document.getElementById('custom-select-arrow');
        const text = document.getElementById('custom-select-text');
        const hiddenInput = document.getElementById('selected-user-id');
        const listItems = document.querySelectorAll('#custom-select-list li');

        function openDropdown() {
            dropdown.classList.remove('hidden');
            setTimeout(() => {
                dropdown.classList.remove('opacity-0', 'scale-95');
                dropdown.classList.add('opacity-100', 'scale-100');
                trigger.classList.add('shadow-[0_0_0_3px_rgba(26,148,136,0.15)]');
            }, 10);
            arrow.classList.add('rotate-180');
        }

        function closeDropdown() {
            dropdown.classList.remove('opacity-100', 'scale-100');
            dropdown.classList.add('opacity-0', 'scale-95');
            trigger.classList.remove('shadow-[0_0_0_3px_rgba(26,148,136,0.15)]');
            arrow.classList.remove('rotate-180');
            setTimeout(() => {
                dropdown.classList.add('hidden');
            }, 200);
        }

        trigger.addEventListener('click', (e) => {
            e.stopPropagation();
            if (dropdown.classList.contains('hidden')) {
                openDropdown();
            } else {
                closeDropdown();
            }
        });

        listItems.forEach(item => {
            item.addEventListener('click', () => {
                hiddenInput.value = item.getAttribute('data-value');
                text.textContent = item.getAttribute('data-text');
                text.classList.remove('text-[#aaa]');
                text.classList.add('text-[#1a1a1a]');
                
                listItems.forEach(li => {
                    li.classList.remove('bg-[#e0f5f3]', 'text-[#1a9488]');
                });
                item.classList.add('bg-[#e0f5f3]', 'text-[#1a9488]');
                
                closeDropdown();
            });
        });

        document.addEventListener('click', (e) => {
            if (!trigger.contains(e.target) && !dropdown.contains(e.target)) {
                if (!dropdown.classList.contains('hidden')) {
                    closeDropdown();
                }
            }
        });
    });
</script>
@endpush
