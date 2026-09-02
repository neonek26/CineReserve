<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Naplánovat nové promítání
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('screenings.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block font-bold mb-1">Film</label>
                        <select name="movie_id" class="w-full border-gray-300 rounded-lg shadow-sm" required>
                            <option value="">-- Vyberte film --</option>
                            @foreach($movies as $movie)
                                <option value="{{ $movie->id }}">{{ $movie->title }} ({{ $movie->duration }} min)</option>
                            @endforeach
                        </select>
                        @error('movie_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block font-bold mb-1">Sál</label>
                        <select name="hall_id" class="w-full border-gray-300 rounded-lg shadow-sm" required>
                            <option value="">-- Vyberte sál --</option>
                            @foreach($halls as $hall)
                                <option value="{{ $hall->id }}">{{ $hall->name }}</option>
                            @endforeach
                        </select>
                        @error('hall_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block font-bold mb-1">Datum a čas začátku</label>
                        <input type="datetime-local" name="starts_at" value="{{ old('starts_at') }}" class="w-full border-gray-300 rounded-lg shadow-sm" required>
                        @error('starts_at') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block font-bold mb-1">Cena lístku (Kč)</label>
                        <input type="number" name="price" value="{{ old('price', 180) }}" class="w-full border-gray-300 rounded-lg shadow-sm" required>
                        @error('price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg">
                            Uložit promítání
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>