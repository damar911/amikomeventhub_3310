<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - AmikomEventHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        @keyframes bounce-in {
            0% {
                transform: scale(0.9);
                opacity: 0;
            }
            70% {
                transform: scale(1.05);
                opacity: 1;
            }
            100% {
                transform: scale(1);
            }
        }

        .animate-bounce-in {
            animation: bounce-in 0.4s ease-out forwards;
        }
    </style>
</head>

<body class="bg-indigo-50/30 text-slate-900">

    {{-- NAVBAR --}}
    <nav class="bg-white border-b border-slate-100 sticky top-0 z-40">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="{{ route('welcome') }}" class="flex items-center gap-3">
                <div class="w-9 h-9 bg-indigo-600 rounded-xl flex items-center justify-center text-white font-black text-sm">AH</div>
                <span class="font-extrabold text-lg">AmikomEventHub</span>
            </a>
            <div class="flex items-center gap-8 text-sm font-semibold text-slate-600">
                <a href="{{ route('welcome') }}" class="text-indigo-600 font-bold">Jelajahi</a>
                <a href="#" class="hover:text-indigo-600 transition">Kategori</a>
                <a href="#" class="hover:text-indigo-600 transition">Tentang Kami</a>
            </div>
        </div>
    </nav>

    <main class="max-w-3xl mx-auto px-6 py-16">

        {{-- HEADER --}}
        <div class="mb-10">
            <a href="{{ route('events.show', $event) }}"
                class="text-indigo-600 font-bold flex items-center gap-2 mb-6 hover:gap-3 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Event
            </a>
            <h1 class="text-4xl font-extrabold">Checkout</h1>
            <p class="text-slate-500 mt-2">Lengkapi data Anda untuk mendapatkan tiket.</p>
        </div>

        {{-- ERROR MESSAGE --}}
        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 rounded-2xl px-6 py-4 font-semibold">
                ⚠️ {{ session('error') }}
            </div>
        @endif

        {{-- VALIDATION ERRORS --}}
        @if($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 rounded-2xl px-6 py-4">
                <p class="font-bold mb-2">Mohon perbaiki kesalahan berikut:</p>
                <ul class="list-disc list-inside text-sm space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 gap-8">

            {{-- SUMMARY CARD --}}
            <div class="bg-white rounded-3xl border border-slate-200 p-8 shadow-sm">
                <h3 class="text-xl font-bold mb-6 border-b pb-4">Pesanan Anda</h3>
                <div class="flex gap-6 items-start">
                    @if($event->image)
                        <img src="{{ asset('storage/' . $event->image) }}"
                            alt="{{ $event->title }}"
                            class="w-24 h-24 rounded-2xl object-cover flex-shrink-0">
                    @else
                        <div class="w-24 h-24 rounded-2xl bg-indigo-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-10 h-10 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    @endif
                    <div>
                        <h4 class="font-extrabold text-lg leading-tight">{{ $event->title }}</h4>
                        <p class="text-slate-500 mt-1">
                            {{ \Carbon\Carbon::parse($event->date)->translatedFormat('d F Y') }}
                            @if($event->location)
                                • {{ $event->location }}
                            @endif
                        </p>
                        <p class="text-indigo-600 font-bold mt-2">
                            1 x Rp {{ number_format($event->price, 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t space-y-3">
                    <div class="flex justify-between text-slate-500">
                        <span>Harga Tiket</span>
                        <span>Rp {{ number_format($event->price, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-slate-500">
                        <span>Biaya Layanan</span>
                        <span>Rp 5.000</span>
                    </div>
                    <div class="flex justify-between text-2xl font-black mt-4 pt-4 border-t">
                        <span>Total Bayar</span>
                        <span class="text-indigo-600">
                            Rp {{ number_format($event->price + 5000, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- FORM CARD --}}
            <div class="bg-white rounded-3xl border border-slate-200 p-8 shadow-sm">
                <h3 class="text-xl font-bold mb-6 italic text-indigo-600 underline underline-offset-8">
                    📦 Data Pemesan (Tanpa Login)
                </h3>

                <form action="{{ route('checkout.store', $event) }}" method="POST" class="space-y-6">
                    @csrf

                    {{-- NAMA LENGKAP --}}
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">
                            Nama Lengkap
                        </label>
                        <input
                            type="text"
                            name="customer_name"
                            value="{{ old('customer_name') }}"
                            placeholder="Masukkan nama sesuai identitas"
                            class="w-full px-5 py-4 bg-white border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium
                                   {{ $errors->has('customer_name') ? 'border-red-400' : '' }}"
                            required>
                        @error('customer_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- EMAIL & WHATSAPP --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">
                                Email Aktif
                            </label>
                            <input
                                type="email"
                                name="customer_email"
                                value="{{ old('customer_email') }}"
                                placeholder="contoh@gmail.com"
                                class="w-full px-5 py-4 bg-white border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium
                                       {{ $errors->has('customer_email') ? 'border-red-400' : '' }}"
                                required>
                            <p class="text-[10px] text-slate-400 mt-2 font-bold uppercase tracking-tighter">
                                *E-Ticket akan dikirim ke email ini
                            </p>
                            @error('customer_email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">
                                No. WhatsApp
                            </label>
                            <input
                                type="tel"
                                name="customer_phone"
                                value="{{ old('customer_phone') }}"
                                placeholder="08xxxxxxx"
                                class="w-full px-5 py-4 bg-white border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium
                                       {{ $errors->has('customer_phone') ? 'border-red-400' : '' }}"
                                required>
                            @error('customer_phone')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- SUBMIT BUTTON --}}
                    <button
                        type="submit"
                        class="w-full py-5 bg-indigo-600 text-white rounded-2xl font-black text-xl shadow-xl shadow-indigo-200 hover:bg-indigo-700 active:scale-95 transition-all">
                        Lanjut Pembayaran
                    </button>

                    <p class="text-center text-xs text-slate-400">
                        Dengan menekan tombol di atas, Anda menyetujui Syarat & Ketentuan kami.
                    </p>
                </form>
            </div>

        </div>
    </main>

    {{-- MODAL MIDTRANS DUMMY --}}
    @isset($transaction)
    <div id="midtrans-overlay"
        class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-6">
        <div class="bg-white w-full max-w-sm rounded-[2rem] overflow-hidden shadow-2xl animate-bounce-in">

            {{-- HEADER MODAL --}}
            <div class="bg-slate-50 p-6 flex justify-between items-center border-b">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 bg-blue-600 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <span class="font-black text-slate-800 text-sm">Midtrans Payment</span>
                </div>
                <a href="{{ route('checkout.create', $event) }}"
                    class="p-2 hover:bg-slate-200 rounded-full transition">
                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </a>
            </div>

            {{-- BODY MODAL --}}
            <div class="p-8 text-center">
                <p class="text-slate-500 font-medium text-sm">Total Tagihan</p>
                <h2 class="text-3xl font-black text-indigo-700 my-2">
                    Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                </h2>
                <p class="text-xs text-slate-400 bg-slate-50 inline-block px-3 py-1 rounded-full">
                    Order ID: <span class="font-bold text-slate-600">{{ $transaction->order_id }}</span>
                </p>
                <p class="text-xs text-slate-400 mt-1">{{ $transaction->customer_name }}</p>

                {{-- PILIHAN PEMBAYARAN --}}
                <div class="mt-8 space-y-3 text-left">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Pilih Metode Pembayaran</p>

                    {{-- GoPay / QRIS (aktif) --}}
                    <a href="{{ route('ticket.show') }}?order_id={{ $transaction->order_id }}"
                        class="w-full py-4 border-2 border-indigo-100 rounded-2xl flex justify-between items-center px-6 hover:border-indigo-600 hover:bg-indigo-50 transition group block">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                                    <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="font-bold group-hover:text-indigo-600 transition">GoPay / QRIS</span>
                        </div>
                        <span class="text-indigo-400 font-bold">→</span>
                    </a>

                    {{-- Virtual Account (nonaktif) --}}
                    <div class="w-full py-4 border-2 border-slate-100 rounded-2xl flex justify-between items-center px-6 opacity-40 cursor-not-allowed">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-slate-100 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm3 5a1 1 0 000 2h6a1 1 0 100-2H7z"/>
                                </svg>
                            </div>
                            <span class="font-bold">Virtual Account (BNI, BRI)</span>
                        </div>
                        <span class="text-slate-300 font-bold">→</span>
                    </div>

                    {{-- Kartu Kredit (nonaktif) --}}
                    <div class="w-full py-4 border-2 border-slate-100 rounded-2xl flex justify-between items-center px-6 opacity-40 cursor-not-allowed">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-slate-100 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="font-bold">Kartu Debit / Kredit</span>
                        </div>
                        <span class="text-slate-300 font-bold">→</span>
                    </div>
                </div>

                {{-- FOOTER MODAL --}}
                <div class="mt-8 flex items-center justify-center gap-2 text-xs text-slate-400 font-bold uppercase tracking-widest">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                            clip-rule="evenodd"/>
                    </svg>
                    Secure Checkout by Midtrans
                </div>
            </div>
        </div>
    </div>
    @endisset

</body>
</html>