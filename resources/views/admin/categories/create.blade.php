@extends('layouts.admin')
@section('title', 'Tambah Kategori - Admin')
@section('page_title', 'Tambah Kategori')
@section('page_subtitle', 'Buat kategori event baru.')

@section('content')

    {{-- Breadcrumb --}}
    <nav class="mb-6 flex items-center gap-2 text-sm text-slate-400">
        <a href="{{ route('admin.categories.index') }}"
            class="hover:text-indigo-600 font-semibold transition">
            Kelola Kategori
        </a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-slate-600 font-semibold">Tambah Kategori</span>
    </nav>

    {{-- Card Form --}}
    <div class="max-w-xl">
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">

            {{-- Header Card --}}
            <div class="px-8 pt-8 pb-6 border-b border-slate-100">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010
                                   2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-black text-slate-800">Kategori Baru</h2>
                        <p class="text-sm text-slate-400 mt-0.5">
                            Isi form di bawah untuk menambah kategori event.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Form --}}
            <form action="{{ route('admin.categories.store') }}" method="POST" class="px-8 py-8">
                @csrf

                {{-- Nama Kategori --}}
                <div class="mb-6">
                    <label for="name"
                        class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                        Nama Kategori <span class="text-rose-400">*</span>
                    </label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        value="{{ old('name') }}"
                        placeholder="Contoh: Seminar IT"
                        autofocus
                        class="w-full px-4 py-3 rounded-xl border text-sm text-slate-700 placeholder-slate-400
                               focus:outline-none focus:ring-2 transition
                               {{ $errors->has('name')
                                    ? 'border-rose-300 bg-rose-50 focus:ring-rose-200'
                                    : 'border-slate-200 focus:ring-indigo-300 focus:border-indigo-400' }}"
                    />
                    @error('name')
                        <p class="mt-2 text-xs text-rose-500 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Preview Slug --}}
                <div class="mb-8">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                        Preview Slug
                    </label>
                    <div class="flex items-center gap-2 px-4 py-3 rounded-xl bg-slate-50 border border-slate-200">
                        <svg class="w-4 h-4 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101
                                   m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                        </svg>
                        <span id="slug-preview" class="text-sm font-mono text-slate-500 italic">
                            slug akan muncul di sini...
                        </span>
                    </div>
                    <p class="mt-1.5 text-xs text-slate-400">
                        Slug dibuat otomatis dari nama kategori dan tidak dapat diubah manual.
                    </p>
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.categories.index') }}"
                        class="flex-1 text-center px-5 py-3 rounded-xl border border-slate-200 text-slate-600
                               text-sm font-semibold hover:bg-slate-50 transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="flex-1 px-5 py-3 rounded-xl bg-indigo-600 text-white text-sm font-bold
                               shadow-lg shadow-indigo-100 hover:bg-indigo-700 active:scale-95 transition">
                        Simpan Kategori
                    </button>
                </div>
            </form>
        </div>

        {{-- Info box --}}
        <div class="mt-4 flex items-start gap-3 px-5 py-4 bg-indigo-50 border border-indigo-100 rounded-2xl">
            <svg class="w-4 h-4 text-indigo-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-xs text-indigo-600 leading-relaxed">
                Kategori yang dibuat akan langsung tersedia saat membuat atau mengedit event.
                Pastikan nama kategori jelas dan tidak duplikat.
            </p>
        </div>
    </div>

    <script>
        // Live preview slug dari input nama
        const nameInput  = document.getElementById('name');
        const slugPreview = document.getElementById('slug-preview');

        function generateSlug(text) {
            return text
                .toLowerCase()
                .trim()
                .replace(/[\s_]+/g, '-')
                .replace(/[^a-z0-9\-]/g, '')
                .replace(/\-\-+/g, '-')
                .replace(/^-+|-+$/g, '');
        }

        nameInput.addEventListener('input', function () {
            const slug = generateSlug(this.value);
            slugPreview.textContent = slug || 'slug akan muncul di sini...';
            slugPreview.classList.toggle('italic', !slug);
        });

        // Jika ada old value (setelah validasi gagal), generate slug-nya
        if (nameInput.value) {
            slugPreview.textContent = generateSlug(nameInput.value);
            slugPreview.classList.remove('italic');
        }
    </script>

@endsection