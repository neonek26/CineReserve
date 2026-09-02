<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Vytvořit nový sál
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('halls.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block font-bold mb-1">Název sálu</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="w-full border-gray-300 rounded-lg shadow-sm" placeholder="např. Sál 1 (Velký)" required>
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block font-bold mb-1">Počet řad</label>
                            <input type="number" name="rows" value="{{ old('rows', 5) }}" class="w-full border-gray-300 rounded-lg shadow-sm" required>
                            @error('rows') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block font-bold mb-1">Sedadla v jedné řadě</label>
                            <input type="number" name="seats_per_row" value="{{ old('seats_per_row', 8) }}" class="w-full border-gray-300 rounded-lg shadow-sm" required>
                            @error('seats_per_row') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg">
                            Vytvořit sál a vygenerovat sedadla
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>