<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Výběr sedadla – {{ $screening->movie->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="mb-6 text-center">
                    <h3 class="text-lg font-bold">{{ $screening->movie->title }}</h3>
                    <p class="text-sm text-gray-600">
                        Sál: {{ $screening->hall->name }} | 
                        Čas: {{ \Carbon\Carbon::parse($screening->starts_at)->format('d.m.Y H:i') }} | 
                        Cena: <strong>{{ number_format($screening->price, 0) }} Kč</strong>
                    </p>
                </div>

                <div class="w-full bg-gray-300 text-center py-2 mb-8 font-bold text-gray-700 tracking-widest uppercase rounded">
                    PLÁTNO
                </div>

                <form action="{{ route('reservations.store', $screening) }}" method="POST">
                    @csrf
                    
                    <div class="flex flex-col items-center gap-3 mb-8">
                        @foreach($screening->hall->seats->groupBy('row_number') as $rowNumber => $seats)
                            <div class="flex items-center gap-2">
                                <span class="w-8 text-right font-bold text-gray-500 mr-2">Řada {{ $rowNumber }}</span>
                                <div class="flex gap-2">
                                    @foreach($seats as $seat)
                                        @php
                                            $isReserved = in_array($seat->id, $reservedSeatIds);
                                        @endphp
                                        
                                        @if($isReserved)
                                            <button type="button" disabled class="w-10 h-10 bg-red-500 text-white font-bold rounded cursor-not-allowed opacity-60 flex items-center justify-center">
                                                {{ $seat->seat_number }}
                                            </button>
                                        @else
                                            <label class="cursor-pointer">
                                                <input type="radio" name="seat_id" value="{{ $seat->id }}" class="hidden peer" required>
                                                <span class="w-10 h-10 bg-green-500 hover:bg-green-600 peer-checked:bg-blue-600 text-white font-bold rounded flex items-center justify-center transition">
                                                    {{ $seat->seat_number }}
                                                </span>
                                            </label>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="flex justify-center gap-6 mb-8 text-sm">
                        <div class="flex items-center gap-2">
                            <div class="w-4 h-4 bg-green-500 rounded"></div> Volno
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-4 h-4 bg-blue-600 rounded"></div> Váš výběr
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-4 h-4 bg-red-500 rounded"></div> Obsazeno
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-lg text-lg shadow">
                            Pokračovat k platbě
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>