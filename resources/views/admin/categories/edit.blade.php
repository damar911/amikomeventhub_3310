@extends('layouts.admin')
@section('title', 'Edit Kategori - Admin')
@section('page_title', 'Edit Kategori')
@section('page_subtitle', 'Perbarui informasi kategori event.')

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
        <span class="text-slate-600 font-semibold">Edit Kategori</span>
    </nav>

    {{-- Card Form --}}
    <div class="max-w-xl">
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">

            {{-- Header Card --}}
            <div class="px-8 pt-8 pb-6 border-b border-slate-100">
                <div class="flex items-center gap-4">
                    {{-- Avatar inisial kategori --}}
                    <div class="w-12 h-12 rounded-2xl bg-amber-100 flex items-center justify-center flex-shrink-0">
                        <span class="text-amber-600 font-black text-lg">
                            {{ strtoupper(substr($category->name, 0, 1)) }}
                        </span>
                    </div>
                    <div>
                        <h2 class="text-lg font-black text-slate-800">{{ $category->name }}</h2>
                        <p class="text-sm text-slate-400 mt-0.5 font-mono">
                            slug: {{ $category->slug }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Form --}}
            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST"
                class="px-8 py-8">
                @csrf
                @method('PUT')

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
                        value="{{ old('name', $category->name) }}"
                        placeholder="Nama kategori"
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

                {{-- Preview Slug Baru --}}
                <div class="mb-8">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                        Preview Slug Baru
                    </label>
                    <div class="space-y-2">
                        {{-- Slug lama --}}
                        <div class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider w-12 flex-shrink-0">
                                Lama
                            </span>
                            <span class="text-sm font-mono text-slate-400 line-through">
                                {{ $category->slug }}
                            </span>
                        </div>
                        {{-- Slug baru (live preview) --}}
                        <div class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-indigo-50 border border-indigo-200">
                            <span class="text-[10px] font-bold text-indigo-400 uppercase tracking-wider w-12 flex-shrink-0">
                                Baru
                            </span>
                            <span id="slug-preview" class="text-sm font-mono text-indigo-600">
                                {{ \Illuminate\Support\Str::slug($category->name) }}
                            </span>
                        </div>
                    </div>
                    <p class="mt-2 text-xs text-slate-400">
                        Slug akan diperbarui otomatis mengikuti nama baru.
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
                        class="flex-1 px-5 py-3 rounded-xl bg-amber-500 text-white text-sm font-bold
                               shadow-lg shadow-amber-100 hover:bg-amber-600 active:scale-95 transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        {{-- Meta info --}}
        <div class="mt-4 flex items-center gap-4 px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl text-xs text-slate-400">
            <span>
                Dibuat:
                <strong class="text-slate-600">
                    {{ \Carbon\Carbon::parse($category->created_at)->format('d M Y, H:i') }}
                </strong>
            </span>
            <span class="text-slate-200">|</span>
            <span>
                Diperbarui:
                <strong class="text-slate-600">
                    {{ \Carbon\Carbon::parse($category->updated_at)->format('d M Y, H:i') }}
                </strong>
            </span>
        </div>
    </div>

    <script>
        const nameInput   = document.getElementById('name');
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
            slugPreview.textContent = slug || '...';
        });
    </script>

@endsection