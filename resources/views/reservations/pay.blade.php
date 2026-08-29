<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Platba rezervace
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                <h3 class="text-xl font-bold mb-4">Potvrzení platby</h3>
                
                <div class="bg-gray-50 p-4 rounded-lg mb-6 text-left space-y-2">
                    <p><strong>Film:</strong> {{ $reservation->screening->movie->title }}</p>
                    <p><strong>Sál:</strong> {{ $reservation->screening->hall->name }}</p>
                    <p><strong>Sedadlo:</strong> Řada {{ $reservation->seat->row_number }}, Sedadlo {{ $reservation->seat->seat_number }}</p>
                    <p><strong>Čas:</strong> {{ \Carbon\Carbon::parse($reservation->screening->starts_at)->format('d.m.Y H:i') }}</p>
                    <p class="text-lg font-bold text-indigo-600 border-t pt-2 mt-2">
                        Celkem k úhradě: {{ number_format($reservation->total_price, 0) }} Kč
                    </p>
                </div>

                <form action="{{ route('reservations.processPayment', $reservation) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg shadow">
                        Zaplatit kartou (Simulace)
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>