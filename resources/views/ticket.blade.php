@php
    use SimpleSoftwareIO\QrCode\Facades\QrCode;
@endphp
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Ticket - AmikomEventHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        @media print {
            body {
                background: white !important;
                padding: 0;
            }
            .no-print {
                display: none !important;
            }
            .ticket-card {
                box-shadow: none !important;
                border: 1px solid #e2e8f0;
            }
        }
    </style>
</head>

<body class="bg-indigo-600 text-white min-h-screen flex items-center justify-center p-6">

    <div class="max-w-md w-full">

        {{-- SUCCESS BANNER --}}
        <div class="text-center mb-8 no-print">
            <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 border-4 border-white">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-black">Pembayaran Berhasil!</h1>
            <p class="text-indigo-100 mt-2">Tiket Anda telah terbit dan siap digunakan.</p>
        </div>

        {{-- TICKET CARD --}}
        <div class="ticket-card bg-white text-slate-900 rounded-[2.5rem] overflow-hidden shadow-2xl relative">

            {{-- TICKET HEADER --}}
            <div class="p-8 bg-indigo-50 border-b-4 border-dashed border-indigo-100 text-center relative">
                <p class="text-indigo-600 font-bold uppercase tracking-widest text-xs mb-2">E-Ticket Resmi</p>
                <h2 class="text-2xl font-black leading-tight">
                    {{ $transaction->event->title ?? 'AmikomEventHub' }}
                </h2>
                @if($transaction->event->location ?? false)
                    <p class="text-slate-500 text-sm mt-1">{{ $transaction->event->location }}</p>
                @endif

                {{-- Dekorasi lubang tiket --}}
                <div class="absolute -left-4 -bottom-4 w-8 h-8 bg-indigo-600 rounded-full"></div>
                <div class="absolute -right-4 -bottom-4 w-8 h-8 bg-indigo-600 rounded-full"></div>
            </div>

            {{-- TICKET BODY --}}
            <div class="p-8 space-y-8">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-slate-400 text-xs font-bold uppercase mb-1">Nama Pembeli</p>
                        <p class="font-bold text-lg leading-tight">{{ $transaction->customer_name }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400 text-xs font-bold uppercase mb-1">Tanggal Event</p>
                        <p class="font-bold text-lg leading-tight">
                            @if($transaction->event->date ?? false)
                                {{ \Carbon\Carbon::parse($transaction->event->date)->translatedFormat('d M Y') }}
                            @else
                                -
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-slate-400 text-xs font-bold uppercase mb-1">Order ID</p>
                        <p class="font-bold font-mono text-sm">{{ $transaction->order_id }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400 text-xs font-bold uppercase mb-1">Total Bayar</p>
                        <p class="font-bold text-indigo-600">
                            Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-slate-400 text-xs font-bold uppercase mb-1">Email</p>
                        <p class="font-bold text-sm break-all">{{ $transaction->customer_email }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400 text-xs font-bold uppercase mb-1">Status</p>
                        <span class="inline-block px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-black uppercase">
                            ✓ Lunas
                        </span>
                    </div>
                </div>

                {{-- QR CODE AREA --}}
                <div class="bg-slate-50 p-6 rounded-3xl flex flex-col items-center border border-slate-100">
                    <p class="text-slate-400 text-xs font-bold uppercase mb-4 tracking-widest">
                        Scan QR untuk Check-in
                    </p>

                    {{-- QR Mock (pakai order_id sebagai seed visual) --}}
                    <div class="w-48 h-48 bg-white p-3 rounded-2xl shadow-inner border border-slate-200 flex items-center justify-center">
                        {{-- 
                            Jika ingin QR asli, install: composer require simplesoftwareio/simple-qrcode
                            Lalu ganti blok ini dengan: {!! QrCode::size(160)->generate($transaction->order_id) !!}
                        --}}
                        {!! QrCode::size(160)->generate($transaction->order_id) !!}
                    </div>

                    <p class="mt-4 font-mono font-bold text-slate-700 text-sm tracking-widest">
                        {{ strtoupper(substr(md5($transaction->order_id), 0, 10)) }}
                    </p>
                    <p class="text-xs text-slate-400 mt-1">Tunjukkan QR ini saat check-in</p>
                </div>
            </div>

            {{-- FOOTER TIKET --}}
            <div class="px-8 pb-8 space-y-3">
                <button
                    onclick="window.print()"
                    class="no-print w-full py-4 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg hover:bg-indigo-700 active:scale-95 transition-all flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Cetak / Simpan PDF
                </button>

                <a href="{{ route('welcome') }}"
                    class="no-print block text-center py-3 text-slate-500 font-bold hover:text-indigo-600 transition">
                    ← Kembali ke Beranda
                </a>
            </div>
        </div>

        {{-- INFO TAMBAHAN --}}
        <div class="no-print mt-6 bg-white/10 rounded-3xl p-6 text-sm text-indigo-100 space-y-2">
            <p class="font-bold text-white">📧 Cek Email Anda</p>
            <p>Konfirmasi tiket dikirim ke <span class="font-bold text-white">{{ $transaction->customer_email }}</span></p>
            <p class="text-xs text-indigo-200 mt-2">Simpan halaman ini sebagai PDF atau screenshot sebagai cadangan tiket Anda.</p>
        </div>

    </div>

</body>
</html>