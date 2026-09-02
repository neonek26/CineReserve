<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Přidat nový film
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('movies.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block font-bold mb-1">Název filmu</label>
                        <input type="text" name="title" value="{{ old('title') }}" class="w-full border-gray-300 rounded-lg shadow-sm" required>
                        @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block font-bold mb-1">Žánr</label>
                        <input type="text" name="genre" value="{{ old('genre') }}" class="w-full border-gray-300 rounded-lg shadow-sm" placeholder="např. Sci-Fi, Drama" required>
                        @error('genre') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block font-bold mb-1">Délka (v minutách)</label>
                        <input type="number" name="duration" value="{{ old('duration') }}" class="w-full border-gray-300 rounded-lg shadow-sm" placeholder="120" required>
                        @error('duration') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block font-bold mb-1">Popis</label>
                        <textarea name="description" rows="4" class="w-full border-gray-300 rounded-lg shadow-sm" required>{{ old('description') }}</textarea>
                        @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block font-bold mb-1">URL plakátu / obrázku</label>
                        <input type="url" name="poster_url" value="{{ old('poster_url') }}" class="w-full border-gray-300 rounded-lg shadow-sm" placeholder="https://example.com/plakat.jpg">
                        @error('poster_url') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg">
                            Uložit film
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>