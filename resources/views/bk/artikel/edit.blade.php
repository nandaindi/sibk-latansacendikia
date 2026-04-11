@extends('layouts.bk')

@section('title', 'Edit Artikel Edukasi')

@push('styles')
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<style>
    .ql-container { font-family: 'Inter', sans-serif; font-size: 1rem; min-height: 360px; border-radius: 0 0 16px 16px !important; border-color: transparent !important; }
    .ql-toolbar { border-radius: 16px 16px 0 0 !important; border-color: #e5e7eb !important; background: #fafafa; }
    .ql-editor { min-height: 340px; line-height: 1.8; color: #333; padding: 16px 20px; }
    .ql-editor.ql-blank::before { color: #bbb; font-style: normal; }
</style>
@endpush

@section('content')
<main class="w-full px-4 md:px-6 py-8 flex-1 flex flex-col gap-6 max-w-4xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center gap-3 mb-2">
        <a href="{{ route('bk.artikel.index') }}" class="p-2 bg-white border-[2px] border-[#eee] rounded-full text-[#777] hover:border-[#1a9488] hover:text-[#1a9488] transition-colors">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>
        </a>
        <div>
            <h2 class="text-[1.3rem] md:text-[1.5rem] font-extrabold text-[#1a1a1a]">Edit Artikel</h2>
            <p class="text-sm text-[#888] mt-0.5">Perbarui konten artikel yang sudah ada</p>
        </div>
    </div>

    @if($errors->any())
    <div class="bg-red-50 border border-red-200 rounded-2xl px-5 py-4 text-red-700 text-sm flex flex-col gap-1">
        @foreach($errors->all() as $err)<div class="flex items-start gap-2"><span class="mt-0.5">•</span> {{ $err }}</div>@endforeach
    </div>
    @endif

    <form action="{{ route('bk.artikel.update', $artikel->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-5" id="editForm">
        @csrf
        @method('PUT')

        {{-- Judul --}}
        <div>
            <label class="block text-[0.8rem] text-[#555] font-bold mb-2 uppercase tracking-wider">Judul Artikel <span class="text-red-400">*</span></label>
            <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-3.5 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all">
                <input type="text" name="judul" value="{{ old('judul', $artikel->judul) }}" required placeholder="Ketik judul yang menarik..."
                       class="w-full border-none outline-none text-[1.1rem] text-[#1a1a1a] placeholder-[#ccc] bg-transparent font-bold"/>
            </div>
        </div>

        {{-- Cover Image --}}
        <div>
            <label class="block text-[0.8rem] text-[#555] font-bold mb-2 uppercase tracking-wider">Gambar Cover</label>
            <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-4 bg-white transition-all">
                @if($artikel->gambar)
                <div class="mb-3">
                    <p class="text-xs text-[#aaa] mb-2 font-medium">Gambar saat ini:</p>
                    <img id="imgPreview" src="{{ asset('storage/' . $artikel->gambar) }}" alt="Current Cover" class="w-full max-h-[200px] object-cover rounded-xl border border-[#e0f5f3]">
                </div>
                @else
                <div id="imgPreviewWrap" class="hidden mb-3">
                    <img id="imgPreview" src="#" alt="Preview" class="w-full max-h-[200px] object-cover rounded-xl border border-[#e0f5f3]">
                </div>
                @endif
                <label for="gambarInput" class="flex items-center gap-3 cursor-pointer group">
                    <div class="w-10 h-10 rounded-full bg-[#e0f5f3] text-[#1a9488] flex items-center justify-center shrink-0 group-hover:bg-[#ceeeea] transition-colors">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-[#1a9488] group-hover:text-[#157a70]">Ganti Gambar Cover</div>
                        <div class="text-xs text-[#aaa]">JPG, PNG · Maks. 2MB · Biarkan kosong jika tidak ingin mengganti</div>
                    </div>
                </label>
                <input id="gambarInput" type="file" name="gambar" accept="image/*" class="hidden" onchange="previewImage(this)">
            </div>
        </div>

        {{-- Konten dengan Quill --}}
        <div>
            <label class="block text-[0.8rem] text-[#555] font-bold mb-2 uppercase tracking-wider">Isi Artikel <span class="text-red-400">*</span></label>
            <div class="border-[2px] border-[#1a9488] rounded-[18px] overflow-hidden bg-white shadow-sm focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all">
                <div id="quill-editor"></div>
            </div>
            <textarea name="konten" id="konten-hidden" class="hidden">{{ old('konten', $artikel->konten) }}</textarea>
        </div>

        <div class="flex justify-end mt-2 gap-3">
            <a href="{{ route('bk.artikel.index') }}" class="px-6 py-3.5 bg-white border-2 border-[#eee] text-[#777] rounded-full text-[1rem] font-semibold hover:border-[#ccc] transition-all no-underline">
                Batal
            </a>
            <button type="button" onclick="validateAndShowModal()" class="px-8 py-3.5 bg-[#1a9488] text-white rounded-full text-[1rem] font-bold shadow-[0_4px_16px_rgba(26,148,136,0.35)] hover:brightness-105 hover:-translate-y-0.5 transition-all active:scale-95 border-none cursor-pointer">
                Simpan Perubahan
            </button>
        </div>
    </form>

    {{-- ===== KONFIRMASI EDIT MODAL ===== --}}
    <div id="confirmModal" class="hidden fixed inset-0 z-50 flex items-center justify-center">
        <div class="absolute inset-0 bg-black/30 backdrop-blur-sm" onclick="hideConfirmModal()"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl w-[320px] md:w-[420px] p-8 md:p-10 flex flex-col items-center gap-6 z-10 border-[2px] border-[#1a9488]">
            <div class="h-40 w-full">
                <img src="{{ asset('img/question mark icon.svg') }}" alt="Question Mark" class="w-full h-full object-contain">
            </div>
            <p class="text-[1.1rem] md:text-[1.2rem] font-semibold text-[#1a1a1a] text-center">Apakah anda yakin ingin menyimpan perubahan artikel ini?</p>
            <div class="flex gap-5 w-full justify-center mt-2">
                <button type="button" onclick="document.getElementById('editForm').submit()" class="h-[48px] w-[90px] bg-[#1a9488] text-white rounded-full flex items-center justify-center hover:brightness-105 transition-all shadow-[0_4px_12px_rgba(26,148,136,0.3)] border-none cursor-pointer">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/>
                    </svg>
                </button>
                <button type="button" onclick="hideConfirmModal()" class="h-[48px] w-[90px] bg-[#b94040] text-white rounded-full flex items-center justify-center hover:brightness-110 transition-all shadow-[0_4px_12px_rgba(185,64,64,0.3)] border-none cursor-pointer">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
    const quill = new Quill('#quill-editor', {
        theme: 'snow',
        placeholder: 'Tuliskan isi artikel edukasi di sini...',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'align': [] }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'indent': '-1' }, { 'indent': '+1' }],
                ['blockquote', 'code-block'],
                ['link', 'image'],
                ['clean']
            ]
        }
    });

    // Pre-fill konten yang sudah ada
    const existingKonten = document.getElementById('konten-hidden').value;
    if (existingKonten) {
        quill.root.innerHTML = existingKonten;
    }

    // Sync ke textarea lalu munculkan modal
    function validateAndShowModal() {
        const form = document.getElementById('editForm');
        if(!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        const content = quill.root.innerHTML.trim();
        if (content === '' || content === '<p><br></p>') {
            Swal.fire({
                icon: 'warning',
                title: 'Artikel Kosong',
                text: 'Isi artikel tidak boleh kosong.',
                confirmButtonColor: '#1a9488'
            });
            return;
        }
        document.getElementById('konten-hidden').value = quill.root.innerHTML;
        
        document.getElementById('confirmModal').classList.remove('hidden');
        document.getElementById('confirmModal').classList.add('flex');
    }

    function hideConfirmModal() {
        document.getElementById('confirmModal').classList.add('hidden');
        document.getElementById('confirmModal').classList.remove('flex');
    }

    // Preview gambar
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imgPreview').src = e.target.result;
                const wrap = document.getElementById('imgPreviewWrap');
                if (wrap) wrap.classList.remove('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
