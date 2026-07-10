@extends('layouts.bk')

@section('title', 'Panggil Siswa – BK')

@section('content')
<main class="w-full px-4 md:px-6 py-6 flex-1 pb-[100px] md:pb-10">

    <div class="w-full max-w-3xl mx-auto">

        <div class="mb-8 border-b border-[#1a9488] pb-3">
            <h2 class="text-[1.3rem] md:text-[1.5rem] font-extrabold text-[#1a1a1a]">Panggil Siswa</h2>
        </div>

        <div>
            <form id="formPanggil" class="flex flex-col gap-5" method="POST" action="{{ route('bk.panggil-siswa.store') }}">
                @csrf
                <div class="relative w-full" id="searchable-select-container">
                    <input type="hidden" name="user_id" id="selected-user-id" required>
                    
                    <div class="border-[2px] border-[#1a9488] rounded-[20px] px-5 py-3.5 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all">
                        <label class="text-[0.7rem] font-bold text-[#1a9488] ml-1 mb-1 block uppercase tracking-wide">Pilih Siswa <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="text" id="search-siswa-input" autocomplete="off" placeholder="Ketik nama siswa untuk mencari..." 
                                   class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] placeholder-[#aaa] bg-transparent font-medium cursor-text pr-8">
                            <div class="absolute right-0 top-1/2 -translate-y-1/2 pointer-events-none text-[#1a9488]">
                                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </div>
                        </div>
                    </div>

                    <!-- Dropdown List -->
                    <div id="search-siswa-dropdown" class="absolute z-50 w-full mt-2 left-0 bg-white border border-[#1a9488] rounded-2xl shadow-[0_8px_30px_rgba(26,148,136,0.15)] overflow-hidden hidden transform origin-top transition-all duration-200">
                        <div class="max-h-[250px] overflow-y-auto" style="scrollbar-width: thin; scrollbar-color: #1a9488 #f9fafb;">
                            <ul class="flex flex-col py-2" id="search-siswa-list">
                                @foreach($siswas as $siswa)
                                    <li class="px-5 py-3 text-[0.95rem] hover:bg-[#e0f5f3] hover:text-[#1a9488] font-medium cursor-pointer transition-colors text-[#1a1a1a]" 
                                        data-value="{{ $siswa->id }}" data-text="{{ strtolower($siswa->name) }}">
                                        {{ $siswa->name }}
                                    </li>
                                @endforeach
                                <li id="search-no-results" class="hidden px-5 py-4 text-center text-[#777] text-sm italic">Siswa tidak ditemukan</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="border-[2px] border-[#1a9488] rounded-[20px] px-5 py-3.5 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all">
                    <label class="text-[0.7rem] font-bold text-[#1a9488] ml-1 mb-0.5 block uppercase tracking-wide">Topik Panggilan <span class="text-red-500">*</span></label>
                    <input type="text" name="topik" placeholder="cth: Evaluasi Nilai" required
                           class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] placeholder-[#aaa] bg-transparent font-medium">
                </div>

                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1 border-[2px] border-[#1a9488] rounded-[20px] px-5 py-3.5 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all">
                        <label class="text-[0.7rem] font-bold text-[#1a9488] ml-1 mb-0.5 block uppercase tracking-wide">Tanggal Panggilan <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal" required value="{{ date('Y-m-d') }}"
                               class="w-full border-none outline-none text-[0.95rem] text-[#1a1a1a] bg-transparent font-medium">
                    </div>
                    <div class="flex-1 border-[2px] border-[#1a9488] rounded-[20px] px-5 py-3.5 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all">
                        <label class="text-[0.7rem] font-bold text-[#1a9488] ml-1 mb-0.5 block uppercase tracking-wide">Jam Pelaksanaan <span class="text-red-500">*</span></label>
                        <input type="time" name="waktu" required value="{{ date('H:i') }}"
                               class="w-full border-none outline-none text-[0.95rem] text-[#1a1a1a] bg-transparent font-medium">
                    </div>
                </div>

                <div class="border-[2px] border-[#1a9488] rounded-[20px] px-5 py-4 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all">
                    <label class="text-[0.7rem] font-bold text-[#1a9488] ml-1 mb-1 block uppercase tracking-wide">Detail Pemanggilan <span class="text-red-500">*</span></label>
                    <textarea name="catatan" placeholder="Jelaskan detail alasan pemanggilan siswa ini..." rows="4" required
                              class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] placeholder-[#aaa] bg-transparent font-medium resize-none"></textarea>
                </div>
            </form>

            <div class="flex justify-end mt-4">
                <button onclick="submitForm(event)"
                        class="w-full md:w-auto px-10 py-3.5 bg-[#1a9488] text-white rounded-full text-[1rem] font-bold shadow-[0_4px_16px_rgba(26,148,136,0.35)] hover:bg-[#157a70] hover:-translate-y-0.5 transition-all active:scale-95">
                    Kirim Panggilan
                </button>
            </div>
        </div>

    </div>

</main>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const container = document.getElementById('searchable-select-container');
        const searchInput = document.getElementById('search-siswa-input');
        const dropdown = document.getElementById('search-siswa-dropdown');
        const hiddenInput = document.getElementById('selected-user-id');
        const listItems = document.querySelectorAll('#search-siswa-list li[data-value]');
        const noResults = document.getElementById('search-no-results');

        function openDropdown() {
            dropdown.classList.remove('hidden');
            setTimeout(() => {
                dropdown.classList.remove('opacity-0', 'scale-95');
                dropdown.classList.add('opacity-100', 'scale-100');
            }, 10);
        }

        function closeDropdown() {
            dropdown.classList.remove('opacity-100', 'scale-100');
            dropdown.classList.add('opacity-0', 'scale-95');
            setTimeout(() => {
                dropdown.classList.add('hidden');
            }, 200);
        }

        function filterList(query) {
            const q = query.toLowerCase().trim();
            let visibleCount = 0;
            listItems.forEach(item => {
                const name = item.getAttribute('data-text');
                if (name.includes(q)) {
                    item.classList.remove('hidden');
                    visibleCount++;
                } else {
                    item.classList.add('hidden');
                }
            });
            if (visibleCount === 0) {
                noResults.classList.remove('hidden');
            } else {
                noResults.classList.add('hidden');
            }
        }

        searchInput.addEventListener('focus', () => {
            openDropdown();
        });

        searchInput.addEventListener('input', () => {
            filterList(searchInput.value);
            if (dropdown.classList.contains('hidden')) {
                openDropdown();
            }
        });

        listItems.forEach(item => {
            item.addEventListener('click', () => {
                hiddenInput.value = item.getAttribute('data-value');
                searchInput.value = item.textContent.trim();

                listItems.forEach(li => {
                    li.classList.remove('bg-[#e0f5f3]', 'text-[#1a9488]');
                });
                item.classList.add('bg-[#e0f5f3]', 'text-[#1a9488]');

                closeDropdown();
            });
        });

        document.addEventListener('click', (e) => {
            if (!container.contains(e.target)) {
                if (!dropdown.classList.contains('hidden')) {
                    closeDropdown();
                }
            }
        });
    });

    function submitForm(e) {
        e.preventDefault();
        const tanggal = document.querySelector('[name="tanggal"]').value;
        const waktu   = document.querySelector('[name="waktu"]').value;
        if (tanggal && waktu) {
            const jadwal = new Date(tanggal + 'T' + waktu);
            if (jadwal < new Date()) {
                Swal.fire({ icon: 'error', title: 'Gagal!', text: 'Waktu penjadwalan sudah lewat. Pilih tanggal/jam yang akan datang.', confirmButtonColor: '#1a9488' });
                return;
            }
        }
        document.getElementById('formPanggil').submit();
    }

    @if(session('sukses'))
    window.addEventListener('load', () => {
        Swal.fire({ icon: 'success', title: 'Berhasil!', text: '{{ session('sukses') }}', confirmButtonColor: '#1a9488' });
    });
    @endif

    @if(session('error'))
    window.addEventListener('load', () => {
        Swal.fire({ icon: 'error', title: 'Gagal!', text: '{{ session('error') }}', confirmButtonColor: '#1a9488' });
    });
    @endif
</script>
@endpush
