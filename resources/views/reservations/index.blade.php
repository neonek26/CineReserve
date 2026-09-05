<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Moje rezervace
        </h2>
    </x-slot>

    <div class="py-12" x-data="paymentModal()">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                @forelse($reservations as $reservation)
                    <div class="flex items-center justify-between border-b py-4 last:border-b-0">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">
                                {{ $reservation->screening->movie->title }}
                            </h3>
                            <p class="text-sm text-gray-600">
                                {{ \Carbon\Carbon::parse($reservation->screening->starts_at)->format('d.m.Y H:i') }} | 
                                Sál: {{ $reservation->screening->hall->name }} 
                                (Řada {{ $reservation->seat->row_number }}, Sedadlo {{ $reservation->seat->seat_number }})
                            </p>
                        </div>

                        <div class="flex items-center gap-4">
                            <span class="text-lg font-bold text-gray-800">
                                {{ number_format($reservation->screening->price ?? 0, 0) }} Kč
                            </span>

                            @if($reservation->status === 'paid')
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">
                                    Zaplaceno
                                </span>
                            @else
                                <button type="button" 
                                        @click="openModal({{ $reservation->id }}, '{{ route('reservations.pay', $reservation) }}', {{ $reservation->screening->price ?? 0 }})"
                                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded text-sm transition">
                                    Zaplatit
                                </button>
                            @endif

                            <form action="{{ route('reservations.destroy', $reservation) }}" method="POST" onsubmit="return confirm('Opravdu chcete rezervaci zrušit?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-semibold">
                                    Zrušit
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">Nemáte žádné rezervace.</p>
                @endforelse

            </div>
        </div>

        <div x-show="show" 
             x-cloak 
             class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center bg-black bg-opacity-50"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            
            <div class="bg-white rounded-lg p-6 max-w-md w-full shadow-xl relative" @click.away="if(!loading) show = false">
                <button type="button" @click="show = false" x-show="!loading" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">✕</button>

                <div x-show="step === 'form'">
                    <h3 class="text-xl font-bold mb-4 text-center">Platba za rezervaci</h3>
                    <p class="text-center text-gray-600 mb-6 font-semibold">Částka k úhradě: <span x-text="price"></span> Kč</p>

                    <div class="flex justify-center gap-4 mb-6">
                        <button type="button" 
                                @click="method = 'card'" 
                                :class="method === 'card' ? 'border-indigo-600 text-indigo-600 bg-indigo-50' : 'border-gray-200'"
                                class="flex-1 py-2 px-4 border-2 rounded-lg font-bold text-sm">
                            💳 Karta
                        </button>
                        <button type="button" 
                                @click="method = 'paypal'" 
                                :class="method === 'paypal' ? 'border-indigo-600 text-indigo-600 bg-indigo-50' : 'border-gray-200'"
                                class="flex-1 py-2 px-4 border-2 rounded-lg font-bold text-sm">
                            🅿️ PayPal
                        </button>
                    </div>

                    <form :action="actionUrl" method="POST" @submit.prevent="submitPayment($el)">
                        @csrf
                        
                        <div x-show="method === 'card'" class="space-y-3">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Číslo karty</label>
                                <input type="text" placeholder="4532 0000 0000 0000" maxlength="19" :required="method === 'card'" class="w-full border-gray-300 rounded-md text-sm">
                            </div>
                            <div class="flex gap-3">
                                <div class="w-1/2">
                                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Expirace</label>
                                    <input type="text" placeholder="MM/YY" maxlength="5" :required="method === 'card'" class="w-full border-gray-300 rounded-md text-sm">
                                </div>
                                <div class="w-1/2">
                                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">CVC/CVV</label>
                                    <input type="text" placeholder="123" maxlength="4" :required="method === 'card'" class="w-full border-gray-300 rounded-md text-sm">
                                </div>
                            </div>
                        </div>

                        <div x-show="method === 'paypal'" class="space-y-3">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">PayPal E-mail</label>
                                <input type="email" placeholder="uzivatel@example.com" :required="method === 'paypal'" class="w-full border-gray-300 rounded-md text-sm">
                            </div>
                        </div>

                        <button type="submit" class="w-full mt-6 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-lg shadow transition">
                            Zaplatit nyní
                        </button>
                    </form>
                </div>

                <div x-show="step === 'processing'" class="py-8 text-center">
                    <svg class="animate-spin h-12 w-12 text-indigo-600 mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <p class="text-lg font-bold text-gray-700">Zpracovávám platbu...</p>
                    <p class="text-sm text-gray-500 mt-1">Prosím nezatvářejte okno.</p>
                </div>

                <div x-show="step === 'success'" class="py-8 text-center">
                    <div class="w-16 h-16 bg-green-100 text-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <p class="text-xl font-bold text-gray-800">Platba byla úspěšná!</p>
                </div>

            </div>
        </div>
    </div>

    <script>
        function paymentModal() {
            return {
                show: false,
                loading: false,
                step: 'form',
                method: 'card',
                reservationId: null,
                actionUrl: '',
                price: 0,
                
                openModal(id, url, price) {
                    this.reservationId = id;
                    this.actionUrl = url;
                    this.price = price;
                    this.step = 'form';
                    this.loading = false;
                    this.show = true;
                },

                submitPayment(form) {
                    this.step = 'processing';
                    this.loading = true;

                    setTimeout(() => {
                        this.step = 'success';
                        setTimeout(() => {
                            form.submit();
                        }, 1000);
                    }, 2000);
                }
            }
        }
    </script>
</x-app-layout>