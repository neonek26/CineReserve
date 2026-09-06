<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Lístek #{{ $reservation->id }} - {{ $reservation->screening->movie->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">

    <div class="max-w-md w-full bg-white rounded-2xl shadow-2xl overflow-hidden border border-gray-200">
        <div class="bg-indigo-600 text-white p-6 text-center">
            <h1 class="text-2xl font-black uppercase tracking-widest">CineReserve</h1>
            <p class="text-xs text-indigo-200 mt-1">Vstupenka do kina</p>
        </div>

        <div class="p-6 space-y-4">
            <div class="border-b pb-4">
                <p class="text-xs text-gray-500 uppercase font-bold">Film</p>
                <h2 class="text-xl font-bold text-gray-800">{{ $reservation->screening->movie->title }}</h2>
            </div>

            <div class="grid grid-cols-2 gap-4 border-b pb-4">
                <div>
                    <p class="text-xs text-gray-500 uppercase font-bold">Datum a čas</p>
                    <p class="font-semibold text-gray-800">{{ \Carbon\Carbon::parse($reservation->screening->starts_at)->format('d.m.Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase font-bold">Sál</p>
                    <p class="font-semibold text-gray-800">{{ $reservation->screening->hall->name }}</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 border-b pb-4">
                <div>
                    <p class="text-xs text-gray-500 uppercase font-bold">Řada / Sedadlo</p>
                    <p class="font-semibold text-gray-800">Řada {{ $reservation->seat->row_number }}, Sedadlo {{ $reservation->seat->seat_number }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase font-bold">Držitel lístku</p>
                    <p class="font-semibold text-gray-800">{{ $reservation->user->name }}</p>
                </div>
            </div>

            <div class="pt-2 text-center">
                <div class="bg-gray-100 p-4 rounded-xl inline-block border border-dashed border-gray-300">
                    <p class="text-xs text-gray-400 font-mono mb-1">KÓD VSTUPENKY</p>
                    <p class="text-lg font-black tracking-widest text-indigo-600 font-mono">CR-{{ str_pad($reservation->id, 6, '0', STR_PAD_LEFT) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-gray-50 p-4 border-t text-center space-x-2">
            <button onclick="window.print()" class="bg-indigo-600 text-white font-bold py-2 px-6 rounded-lg text-sm shadow hover:bg-indigo-700">
                Vytisknout / Uložit PDF
            </button>
            <a href="{{ route('reservations.index') }}" class="text-gray-600 font-bold text-sm px-4 py-2">Zpět</a>
        </div>
    </div>

</body>
</html>