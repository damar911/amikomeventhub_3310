@extends('layouts.admin')
@section('title', 'Kelola Partner - Admin')
@section('page_title', 'Kelola Partner Event')
@section('page_subtitle', 'Atur sponsor, media partner, dan komunitas yang terlibat dalam event.')

@section('content')

    {{-- Flash Messages --}}
    @if(session('success'))
        <div id="flash-success"
            class="mb-6 flex items-center gap-3 px-5 py-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl shadow-sm">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <span class="font-semibold text-sm">{{ session('success') }}</span>
            <button onclick="document.getElementById('flash-success').remove()"
                class="ml-auto text-emerald-400 hover:text-emerald-600 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div id="flash-error"
            class="mb-6 flex items-center gap-3 px-5 py-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl shadow-sm">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="font-semibold text-sm">{{ session('error') }}</span>
            <button onclick="document.getElementById('flash-error').remove()"
                class="ml-auto text-rose-400 hover:text-rose-600 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    @endif

    {{-- Top Bar: Search + Tambah --}}
    <div class="mb-5 flex flex-col sm:flex-row gap-3 items-stretch sm:items-center justify-between">

        {{-- Search --}}
        <form method="GET" action="{{ route('admin.partners.index') }}" class="flex-1 max-w-md">
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                    </svg>
                </span>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari partner..."
                    class="w-full pl-11 pr-10 py-3 rounded-2xl border border-slate-200 bg-white text-sm
                           text-slate-700 placeholder-slate-400 shadow-sm focus:outline-none
                           focus:ring-2 focus:ring-indigo-300 focus:border-indigo-400 transition"
                />
                @if(request('search'))
                    <a href="{{ route('admin.partners.index') }}"
                        class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </a>
                @endif
            </div>
        </form>

        {{-- Tombol Tambah --}}
        <a href="{{ route('admin.partners.create') }}"
            class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold
                   shadow-lg shadow-indigo-100 hover:bg-indigo-700 active:scale-95 transition whitespace-nowrap">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Partner
        </a>
    </div>

    {{-- Info hasil pencarian --}}
    @if(request('search'))
        <div class="mb-4 flex items-center gap-2 text-sm text-slate-500">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Menampilkan hasil untuk
            <span class="font-bold text-indigo-600">"{{ request('search') }}"</span>
            — {{ $partners->total() }} partner ditemukan
        </div>
    @endif

    {{-- Tabel Partner --}}
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                    <tr>
                        <th class="px-8 py-4 w-16">No</th>
                        <th class="px-8 py-4">Partner</th>
                        <th class="px-8 py-4 w-40">Tipe</th>
                        <th class="px-8 py-4 w-28 text-center">Status</th>
                        <th class="px-8 py-4 w-36 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y border-t">
                    @forelse($partners as $index => $partner)
                        <tr class="hover:bg-slate-50/50 transition">

                            {{-- No --}}
                            <td class="px-8 py-5 font-bold text-slate-400">
                                {{ $partners->firstItem() + $index }}
                            </td>

                            {{-- Partner: logo + nama + slug --}}
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-3">
                                    {{-- Logo atau Inisial --}}
                                    <div class="w-10 h-10 rounded-xl bg-indigo-50 border border-indigo-100
                                                flex items-center justify-center flex-shrink-0 overflow-hidden">
                                        @if($partner->logo_url)
                                            <img src="{{ $partner->logo_url }}" alt="{{ $partner->name }}"
                                                 class="w-full h-full object-contain p-1">
                                        @else
                                            <span class="text-indigo-600 font-black text-sm">
                                                {{ strtoupper(substr($partner->name, 0, 1)) }}
                                            </span>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-800">{{ $partner->name }}</p>
                                        <div class="flex items-center gap-2 mt-0.5">
                                            <p class="text-xs text-slate-400 font-mono">{{ $partner->slug }}</p>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- Tipe --}}
                            <td class="px-8 py-5">
                                @php
                                    $typeColors = [
                                        'sponsor'   => 'bg-amber-50 text-amber-700 border-amber-200',
                                        'media'     => 'bg-sky-50 text-sky-700 border-sky-200',
                                        'community' => 'bg-violet-50 text-violet-700 border-violet-200',
                                        'other'     => 'bg-slate-100 text-slate-600 border-slate-200',
                                    ];
                                    $color = $typeColors[$partner->type] ?? $typeColors['other'];
                                @endphp
                                <span class="inline-flex px-3 py-1 rounded-full text-xs font-bold border {{ $color }}">
                                    {{ $partner->type_label }}
                                </span>
                            </td>

                            {{-- Status Aktif --}}
                            <td class="px-8 py-5 text-center">
                                @if($partner->is_active)
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold
                                                 bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold
                                                 bg-slate-100 text-slate-500 border border-slate-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                        Nonaktif
                                    </span>
                                @endif
                            </td>

                            {{-- Aksi --}}
                            <td class="px-8 py-5">
                                <div class="flex items-center justify-center gap-2">

                                    {{-- Edit --}}
                                    <a href="{{ route('admin.partners.edit', $partner->id) }}"
                                        class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl
                                               hover:bg-indigo-600 hover:text-white transition"
                                        title="Edit partner">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5
                                                   m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>

                                    {{-- Hapus --}}
                                    <button
                                        onclick="openDeleteModal({{ $partner->id }}, '{{ addslashes($partner->name) }}')"
                                        class="p-2.5 bg-rose-50 text-rose-600 rounded-xl
                                               hover:bg-rose-600 hover:text-white transition"
                                        title="Hapus partner">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0
                                                   01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1
                                                   0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-16 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center">
                                        <svg class="w-7 h-7 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857
                                                   M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857
                                                   m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </div>
                                    <p class="text-slate-400 font-semibold text-sm">
                                        @if(request('search'))
                                            Tidak ada partner yang cocok dengan "{{ request('search') }}"
                                        @else
                                            Belum ada partner yang ditambahkan.
                                        @endif
                                    </p>
                                    @if(request('search'))
                                        <a href="{{ route('admin.partners.index') }}"
                                            class="text-indigo-500 text-xs hover:underline">
                                            Tampilkan semua partner
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($partners->hasPages())
            <div class="px-8 py-5 bg-slate-50/50 border-t">
                {{ $partners->appends(request()->query())->links() }}
            </div>
        @endif
    </div>


    {{-- =============================== --}}
    {{-- MODAL: HAPUS PARTNER            --}}
    {{-- =============================== --}}
    <div id="modal-hapus"
        class="fixed inset-0 z-50 hidden items-center justify-center p-4"
        role="dialog" aria-modal="true">
        <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm"
             onclick="closeModal('modal-hapus')"></div>

        <div class="relative w-full max-w-sm bg-white rounded-3xl shadow-2xl p-8 animate-modal">
            <div class="flex flex-col items-center text-center gap-4 mb-6">
                <div class="w-16 h-16 rounded-2xl bg-rose-100 flex items-center justify-center">
                    <svg class="w-8 h-8 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0
                               01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1
                               0 00-1 1v3M4 7h16"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-black text-slate-800">Hapus Partner?</h2>
                    <p class="text-sm text-slate-500 mt-1">
                        Anda akan menghapus partner
                        <span id="hapus-name" class="font-bold text-slate-700"></span>.
                        Logo dan data akan terhapus permanen.
                    </p>
                </div>
            </div>

            <form id="form-hapus" action="" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex gap-3">
                    <button type="button" onclick="closeModal('modal-hapus')"
                        class="flex-1 px-5 py-3 rounded-xl border border-slate-200 text-slate-600 text-sm
                               font-semibold hover:bg-slate-50 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 px-5 py-3 rounded-xl bg-rose-500 text-white text-sm font-bold
                               shadow-lg shadow-rose-100 hover:bg-rose-600 active:scale-95 transition">
                        Ya, Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .animate-modal {
            animation: modalIn 0.2s cubic-bezier(0.34, 1.56, 0.64, 1) both;
        }
        @keyframes modalIn {
            from { opacity: 0; transform: scale(0.92) translateY(16px); }
            to   { opacity: 1; transform: scale(1) translateY(0); }
        }
    </style>

    <script>
        function openDeleteModal(id, name) {
            document.getElementById('hapus-name').textContent = `"${name}"`;
            document.getElementById('form-hapus').action = `/admin/partners/${id}`;
            const modal = document.getElementById('modal-hapus');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.classList.add('overflow-hidden');
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            modal.classList.remove('flex');
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeModal('modal-hapus');
        });
    </script>

@endsection