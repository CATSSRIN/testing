<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('My Orders') }}</h2>
            <a href="{{ route('orders.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                {{ __('New Order') }}
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg">{{ session('success') }}</div>
            @endif

            @if($orders->isEmpty())
                <div class="text-center py-16 bg-white rounded-xl shadow-sm border border-gray-100">
                    <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-700">{{ __('No orders yet') }}</h3>
                    <a href="{{ route('orders.create') }}" class="mt-4 inline-block px-5 py-2 bg-indigo-600 text-white text-sm rounded-lg hover:bg-indigo-700">{{ __('Place First Order') }}</a>
                </div>
            @else
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Order #') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Ship') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Total') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Status') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Pickup') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Date') }}</th>
                                <th class="px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($orders as $order)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">#{{ $order->id }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $order->ship->name }}</td>
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900">Rp {{ number_format($order->total_price, 0, ",", ".") }}</td>
                                <td class="px-6 py-4">
                                    @php $statusCls = match($order->status) { 'confirmed' => 'bg-blue-100 text-blue-700', 'delivered' => 'bg-green-100 text-green-700', 'cancelled' => 'bg-red-100 text-red-700', default => 'bg-yellow-100 text-yellow-700' }; @endphp
                                    <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusCls }} capitalize">{{ $order->status }}</span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    @if($order->pickup_date || $order->pickup_location)
                                        <div class="space-y-0.5">
                                            @if($order->pickup_date)
                                                <div>{{ \Carbon\Carbon::parse($order->pickup_date)->format('d M Y') }}{{ $order->pickup_time ? ' ' . \Carbon\Carbon::parse($order->pickup_time)->format('H:i') : '' }}</div>
                                            @endif
                                            @if($order->pickup_location)
                                                <div class="text-xs text-gray-400">{{ $order->pickup_location }}</div>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-gray-300">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $order->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-3">
                                        <button
                                            onclick="document.getElementById('pickup-modal-{{ $order->id }}').classList.remove('hidden')"
                                            class="text-teal-600 hover:text-teal-800 text-sm font-medium">
                                            {{ __('Set Schedule') }}
                                        </button>
                                        <a href="{{ route('orders.show', $order) }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">{{ __('View') }}</a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>

                {{-- Pickup Schedule Modals --}}
                @foreach($orders as $order)
                <div id="pickup-modal-{{ $order->id }}" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
                    <div class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-semibold text-lg text-gray-800">{{ __('Set Shipping Schedule — Order #') }}{{ $order->id }}</h3>
                            <button onclick="document.getElementById('pickup-modal-{{ $order->id }}').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                        <form method="POST" action="{{ route('orders.pickup', $order) }}">
                            @csrf
                            @method('PATCH')
                            <div class="space-y-4">
                                <div>
                                    <x-input-label for="pickup_date_{{ $order->id }}" :value="__('Date')" />
                                    <x-text-input id="pickup_date_{{ $order->id }}" name="pickup_date" type="date" class="mt-1 block w-full"
                                        value="{{ $order->pickup_date ? \Carbon\Carbon::parse($order->pickup_date)->format('Y-m-d') : '' }}" />
                                </div>
                                <div>
                                    <x-input-label for="pickup_time_{{ $order->id }}" :value="__('Time')" />
                                    <x-text-input id="pickup_time_{{ $order->id }}" name="pickup_time" type="time" class="mt-1 block w-full"
                                        value="{{ $order->pickup_time ? \Carbon\Carbon::parse($order->pickup_time)->format('H:i') : '' }}" />
                                </div>
                                <div>
                                    <x-input-label for="pickup_location_{{ $order->id }}" :value="__('Location')" />
                                    <x-text-input id="pickup_location_{{ $order->id }}" name="pickup_location" type="text" class="mt-1 block w-full"
                                        value="{{ $order->pickup_location ?? '' }}" placeholder="{{ __('e.g. Port of Tanjung Priok') }}" />
                                </div>
                            </div>
                            <div class="mt-6 flex items-center gap-3 justify-end">
                                <button type="button" onclick="document.getElementById('pickup-modal-{{ $order->id }}').classList.add('hidden')" class="text-sm text-gray-500 hover:text-gray-700">{{ __('Cancel') }}</button>
                                <x-primary-button>{{ __('Save') }}</x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</x-app-layout>

