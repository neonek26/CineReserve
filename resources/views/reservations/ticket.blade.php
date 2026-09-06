<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vstupenka - {{ $reservation->screening->movie->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background-color: white !important; padding: 0 !important; }
            .ticket-card { box-shadow: none !important; border: 1px solid #e5e7eb !important; }
        }
    </style>
</head>
<body class="bg-slate-900 min-h-screen flex flex-col items-center justify-center p-4 text-slate-800">

    <div class="no-print mb-6">
        <button onclick="window.print()" class="bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-2.5 px-6 rounded-lg text-sm shadow-lg transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Vytisknout / Uložit PDF
        </button>
    </div>

    <div class="ticket-card max-w-xl w-full bg-white rounded-2xl shadow-2xl overflow-hidden border border-slate-100 flex flex-col md:flex-row">
        
        <div class="p-6 md:p-8 flex-1 flex flex-col justify-between">
            <div>
                <div class="flex justify-between items-center mb-4">
                    <span class="text-xs font-black tracking-widest uppercase text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded">CineReserve</span>
                    <span class="text-xs font-mono text-slate-400">#CR-{{ str_pad($reservation->id, 6, '0', STR_PAD_LEFT) }}</span>
                </div>

                <h1 class="text-2xl font-black text-slate-900 leading-tight mb-6">
                    {{ $reservation->screening->movie->title }}
                </h1>

                <div class="grid grid-cols-2 gap-y-4 gap-x-2 text-sm">
                    <div>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Datum a čas</p>
                        <p class="font-bold text-slate-700">
                            {{ \Carbon\Carbon::parse($reservation->screening->starts_at)->format('d.m.Y') }}
                            <span class="text-indigo-600 ml-1">{{ \Carbon\Carbon::parse($reservation->screening->starts_at)->format('H:i') }}</span>
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Sál</p>
                        <p class="font-bold text-slate-700">{{ $reservation->screening->hall->name }}</p>
                    </div>

                    <div>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Místo</p>
                        <p class="font-bold text-slate-700">Řada {{ $reservation->seat->row_number }}, Sedadlo {{ $reservation->seat->seat_number }}</p>
                    </div>

                    <div>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Divák</p>
                        <p class="font-bold text-slate-700 truncate">{{ $reservation->user->name }}</p>
                    </div>
                </div>
            </div>

            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                <span>Zaplaceno online</span>
                <span class="font-bold text-slate-600">{{ number_format($reservation->screening->price ?? 0, 0) }} Kč</span>
            </div>
        </div>

        <div class="relative bg-slate-50 p-6 flex flex-col items-center justify-center border-t md:border-t-0 md:border-l border-dashed border-slate-300 w-full md:w-48 shrink-0">
            
            <div class="hidden md:block absolute -top-3 -left-3 w-6 h-6 bg-slate-900 rounded-full"></div>
            <div class="hidden md:block absolute -bottom-3 -left-3 w-6 h-6 bg-slate-900 rounded-full"></div>

            <div class="bg-white p-2 rounded-xl shadow-sm border border-slate-200 mb-3">
                <div id="qrcode"></div>
            </div>

            <p class="text-[10px] text-slate-400 font-mono text-center tracking-wider">SKENUJTE U VSTUPU</p>
        </div>

    </div>

    <div class="no-print mt-6">
        <a href="{{ route('reservations.index') }}" class="text-slate-400 hover:text-white text-sm font-semibold transition">
            ← Zpět na moje rezervace
        </a>
    </div>

    <script>
        new QRCode(document.getElementById("qrcode"), {
            text: "CineReserve | Ticket #CR-{{ str_pad($reservation->id, 6, '0', STR_PAD_LEFT) }} | {{ $reservation->screening->movie->title }} | Rada: {{ $reservation->seat->row_number }}, Sedadlo: {{ $reservation->seat->seat_number }} | {{ $reservation->user->name }}",
            width: 112,
            height: 112,
            colorDark : "#0f172a",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.H
        });
    </script>

</body>
</html>