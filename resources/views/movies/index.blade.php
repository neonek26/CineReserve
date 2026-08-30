<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Aktuální nabídka filmů
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($movies as $movie)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start">
                                <span class="text-xs font-bold text-indigo-600 uppercase tracking-widest">{{ $movie->genre }}</span>
                                
                                @if(Auth::check() && Auth::user()->is_admin)
                                    <form action="{{ route('movies.destroy', $movie) }}" method="POST" onsubmit="return confirm('Opravdu chcete smazat tento film?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 font-bold text-xs uppercase">
                                            Smazat
                                        </button>
                                    </form>
                                @endif
                            </div>

                            <h3 class="text-2xl font-bold text-gray-900 mt-1 mb-2">{{ $movie->title }}</h3>
                            <p class="text-sm text-gray-500 mb-4">Délka: {{ $movie->duration }} minut</p>
                            <p class="text-gray-700 text-sm mb-6">{{ $movie->description }}</p>
                        </div>

                        <div>
                            <h4 class="font-bold text-sm text-gray-800 mb-2 border-b pb-1">Nadcházející promítání:</h4>
                            @if($movie->screenings->isEmpty())
                                <p class="text-xs text-gray-400">Žádné plánované termíny.</p>
                            @else
                                <div class="flex flex-col gap-2">
                                    @foreach($movie->screenings as $screening)
                                        <a href="{{ route('reservations.create', $screening) }}" 
                                           class="flex justify-between items-center bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-bold px-3 py-2 rounded transition">
                                            <span>{{ \Carbon\Carbon::parse($screening->starts_at)->format('d.m. H:i') }} ({{ $screening->hall->name }})</span>
                                            <span>{{ number_format($screening->price, 0) }} Kč &rarr;</span>
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>