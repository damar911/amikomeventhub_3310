@extends('layouts.admin')
@section('title', 'Edit Partner - Admin')
@section('page_title', 'Edit Partner')
@section('page_subtitle', 'Perbarui data partner event.')

@section('content')

    {{-- Breadcrumb --}}
    <div class="mb-6 flex items-center gap-2 text-sm text-slate-400">
        <a href="{{ route('admin.partners.index') }}" class="hover:text-indigo-600 transition font-semibold">Partner</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-slate-600 font-semibold">Edit — {{ $partner->name }}</span>
    </div>

    <div class="max-w-2xl">
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-8">

            <form action="{{ route('admin.partners.update', $partner->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="space-y-6">

                    {{-- Nama Partner --}}
                    <div>
                        <label class="block text-sm font-black text-slate-700 mb-2">
                            Nama Partner <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name', $partner->name) }}" placeholder=""
                            class="w-full px-4 py-3 rounded-2xl border @error('name') border-rose-400 bg-rose-50 @else border-slate-200 @enderror
                                text-sm text-slate-700 placeholder-slate-400 focus:outline-none
                                focus:ring-2 focus:ring-indigo-300 focus:border-indigo-400 transition" />
                        @error('name')
                            <p class="mt-1.5 text-xs text-rose-500 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Slug --}}
                    <div>
                        <label class="block text-sm font-black text-slate-700 mb-2">
                            Slug
                            <span class="text-slate-400 font-normal">(otomatis dari nama jika dikosongkan)</span>
                        </label>
                        <input type="text" name="slug" value="{{ old('slug', $partner->slug) }}" placeholder=""
                            class="w-full px-4 py-3 rounded-2xl border @error('slug') border-rose-400 bg-rose-50 @else border-slate-200 @enderror
                                text-sm text-slate-700 placeholder-slate-400 font-mono focus:outline-none
                                focus:ring-2 focus:ring-indigo-300 focus:border-indigo-400 transition" />
                        @error('slug')
                            <p class="mt-1.5 text-xs text-rose-500 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tipe --}}
                    <div>
                        <label class="block text-sm font-black text-slate-700 mb-2">
                            Tipe Partner <span class="text-rose-500">*</span>
                        </label>
                        <select name="type"
                            class="w-full px-4 py-3 rounded-2xl border @error('type') border-rose-400 bg-rose-50 @else border-slate-200 @enderror
                                text-sm text-slate-700 bg-white focus:outline-none
                                focus:ring-2 focus:ring-indigo-300 focus:border-indigo-400 transition appearance-none">
                            @foreach ($types as $value => $label)
                                <option value="{{ $value }}"
                                    {{ old('type', $partner->type) === $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('type')
                            <p class="mt-1.5 text-xs text-rose-500 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <label class="block text-sm font-black text-slate-700 mb-2">Deskripsi</label>
                        <textarea name="deskripsi" rows="3" placeholder="Deskripsi singkat tentang partner ini..."
                            class="w-full px-4 py-3 rounded-2xl border @error('deskripsi') border-rose-400 bg-rose-50 @else border-slate-200 @enderror
                                text-sm text-slate-700 placeholder-slate-400 focus:outline-none
                                focus:ring-2 focus:ring-indigo-300 focus:border-indigo-400 transition resize-none">{{ old('deskripsi', $partner->description) }}</textarea>
                        @error('deskripsi')
                            <p class="mt-1.5 text-xs text-rose-500 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Logo Upload --}}
                    <div>
                        <label class="block text-sm font-black text-slate-700 mb-2">Logo Partner</label>

                        {{-- Logo saat ini --}}
                        @if ($partner->logo_url)
                            <div id="current-logo"
                                class="mb-3 p-4 bg-slate-50 rounded-2xl border border-slate-100
                                                        flex items-center gap-4">
                                <img src="{{ $partner->logo_url }}" alt="Logo saat ini"
                                    class="w-16 h-16 object-contain rounded-xl border border-slate-200 p-1 bg-white">
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-bold text-slate-600">Logo saat ini</p>
                                    <p class="text-xs text-slate-400 font-mono truncate">{{ basename($partner->logo) }}</p>
                                </div>
                                <label
                                    class="flex items-center gap-2 text-xs text-rose-500 font-bold cursor-pointer select-none">
                                    <input type="checkbox" name="remove_logo" value="1" id="remove-logo-cb"
                                        onchange="toggleRemoveLogo(this)"
                                        class="w-4 h-4 rounded border-slate-300 text-rose-500 focus:ring-rose-300">
                                    Hapus logo
                                </label>
                            </div>
                        @endif

                        {{-- Drop zone upload baru --}}
                        <div id="drop-zone"
                            class="relative border-2 border-dashed border-slate-200 rounded-2xl p-8
                                flex flex-col items-center justify-center gap-3 cursor-pointer
                                hover:border-indigo-400 hover:bg-indigo-50/30 transition group">
                            <div id="preview-container" class="hidden flex-col items-center gap-2 w-full">
                                <img id="logo-preview" src="" alt="Preview"
                                    class="max-h-24 max-w-full object-contain rounded-xl border border-slate-200 p-2">
                                <p id="preview-name" class="text-xs text-slate-500 font-mono truncate max-w-xs"></p>
                                <button type="button" onclick="clearPreview()"
                                    class="text-xs text-rose-500 hover:text-rose-700 font-semibold transition">
                                    Batal ganti logo
                                </button>
                            </div>
                            <div id="upload-placeholder" class="flex flex-col items-center gap-2">
                                <div
                                    class="w-12 h-12 rounded-2xl bg-indigo-100 flex items-center justify-center
                                            group-hover:bg-indigo-200 transition">
                                    <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14
                                                m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <p class="text-sm font-semibold text-slate-500">
                                    {{ $partner->logo_url ? 'Ganti logo — klik atau seret file' : 'Klik atau seret logo ke sini' }}
                                </p>
                                <p class="text-xs text-slate-400">JPG, PNG, WebP, SVG · Maks 2 MB</p>
                            </div>
                            <input type="file" name="logo" id="logo-input" accept="image/*"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                onchange="previewLogo(event)" />
                        </div>
                        @error('logo')
                            <p class="mt-1.5 text-xs text-rose-500 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Status Aktif --}}
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <div>
                            <p class="text-sm font-black text-slate-700">Status Aktif</p>
                            <p class="text-xs text-slate-400 mt-0.5">Partner aktif akan tampil di halaman publik</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1" class="sr-only peer"
                                {{ old('is_active', $partner->is_active) ? 'checked' : '' }}>
                            <div
                                class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer
                                        peer-checked:after:translate-x-full peer-checked:after:border-white
                                        after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                                        after:bg-white after:border-slate-300 after:border after:rounded-full
                                        after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600">
                            </div>
                        </label>
                    </div>

                </div>

                {{-- Action Buttons --}}
                <div class="mt-8 flex gap-3">
                    <a href="{{ route('admin.partners.index') }}"
                        class="flex-1 px-5 py-3 rounded-xl border border-slate-200 text-slate-600 text-sm
                            font-semibold hover:bg-slate-50 transition text-center">
                        Batal
                    </a>
                    <button type="submit"
                        class="flex-1 px-5 py-3 rounded-xl bg-indigo-600 text-white text-sm font-bold
                            shadow-lg shadow-indigo-100 hover:bg-indigo-700 active:scale-95 transition">
                        Perbarui Partner
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewLogo(event) {
            const file = event.target.files[0];
            if (!file) return;

            // Uncheck "hapus logo" jika user pilih file baru
            const cb = document.getElementById('remove-logo-cb');
            if (cb) cb.checked = false;

            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('logo-preview').src = e.target.result;
                document.getElementById('preview-name').textContent = file.name;
                document.getElementById('preview-container').classList.remove('hidden');
                document.getElementById('preview-container').classList.add('flex');
                document.getElementById('upload-placeholder').classList.add('hidden');
            };
            reader.readAsDataURL(file);
        }

        function clearPreview() {
            document.getElementById('logo-input').value = '';
            document.getElementById('logo-preview').src = '';
            document.getElementById('preview-container').classList.add('hidden');
            document.getElementById('preview-container').classList.remove('flex');
            document.getElementById('upload-placeholder').classList.remove('hidden');
        }

        function toggleRemoveLogo(checkbox) {
            const dropZone = document.getElementById('drop-zone');
            if (checkbox.checked) {
                dropZone.classList.add('opacity-40', 'pointer-events-none');
                clearPreview();
            } else {
                dropZone.classList.remove('opacity-40', 'pointer-events-none');
            }
        }
    </script>

@endsection
