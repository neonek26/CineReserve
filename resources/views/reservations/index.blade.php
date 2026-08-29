<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Moje rezervace
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if($reservations->isEmpty())
                    <p class="text-gray-500">Zatím nemáte žádné rezervace.</p>
                @else
                    <div class="space-y-4">
                        @foreach($reservations as $reservation)
                            <div class="border rounded-lg p-4 flex justify-between items-center">
                                <div>
                                    <h4 class="font-bold text-lg">{{ $reservation->screening->movie->title }}</h4>
                                    <p class="text-sm text-gray-600">
                                        {{ \Carbon\Carbon::parse($reservation->screening->starts_at)->format('d.m.Y H:i') }} |
                                        {{ $reservation->screening->hall->name }} (Řada {{ $reservation->seat->row_number }}, Sedadlo {{ $reservation->seat->seat_number }})
                                    </p>
                                </div>
                                <div class="text-right">
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-bold {{ $reservation->status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ $reservation->status === 'paid' ? 'Zaplaceno' : 'Čeká na platbu' }}
                                    </span>
                                    <div class="font-bold mt-1">{{ number_format($reservation->total_price, 0) }} Kč</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>