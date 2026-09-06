<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Správa všech rezervací (Admin)
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b bg-gray-50 text-xs font-bold text-gray-500 uppercase">
                                <th class="p-3">ID</th>
                                <th class="p-3">Uživatel</th>
                                <th class="p-3">Film</th>
                                <th class="p-3">Termín</th>
                                <th class="p-3">Sál / Místo</th>
                                <th class="p-3">Stav</th>
                                <th class="p-3">Akce</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y text-sm">
                            @forelse($reservations as $reservation)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 font-mono font-bold">#{{ $reservation->id }}</td>
                                    <td class="p-3">
                                        <div class="font-semibold text-gray-900">{{ $reservation->user->name ?? 'Neznámý' }}</div>
                                        <div class="text-xs text-gray-500">{{ $reservation->user->email ?? '' }}</div>
                                    </td>
                                    <td class="p-3 font-medium">{{ $reservation->screening->movie->title ?? 'N/A' }}</td>
                                    <td class="p-3">
                                        {{ isset($reservation->screening->starts_at) ? \Carbon\Carbon::parse($reservation->screening->starts_at)->format('d.m.Y H:i') : '-' }}
                                    </td>
                                    <td class="p-3">
                                        {{ $reservation->screening->hall->name ?? '-' }} 
                                        <span class="text-xs text-gray-500">(Řada {{ $reservation->seat->row_number ?? '-' }}, Sedadlo {{ $reservation->seat->seat_number ?? '-' }})</span>
                                    </td>
                                    <td class="p-3">
                                        @if($reservation->status === 'paid')
                                            <span class="bg-green-100 text-green-800 px-2.5 py-0.5 rounded-full text-xs font-semibold">Zaplaceno</span>
                                        @else
                                            <span class="bg-yellow-100 text-yellow-800 px-2.5 py-0.5 rounded-full text-xs font-semibold">Čeká na platbu</span>
                                        @endif
                                    </td>
                                    <td class="p-3">
                                        <form action="{{ route('reservations.destroy', $reservation) }}" method="POST" onsubmit="return confirm('Opravdu chcete zrušit tuto rezervaci?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 font-semibold text-xs">
                                                Smazat
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-4 text-center text-gray-500">Žádné rezervace nebyly nalezeny.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>