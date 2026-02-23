<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Gudang') }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg">{{ session('success') }}</div>
            @endif

            @if($orders->isEmpty())
                <div class="text-center py-16 bg-white rounded-xl shadow-sm border border-gray-100">
                    <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-700">{{ __('No orders yet') }}</h3>
                </div>
            @else
                <div class="space-y-6">
                    @foreach($orders as $order)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <!-- Order Header -->
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div>
                                    <span class="font-semibold text-gray-800">Order #{{ $order->id }}</span>
                                    <span class="ml-2 text-sm text-gray-500">— {{ $order->user->name }}{{ $order->user->company_name ? ' (' . $order->user->company_name . ')' : '' }}</span>
                                </div>
                                @php $statusCls = match($order->status) { 'confirmed' => 'bg-blue-100 text-blue-700', 'delivered' => 'bg-green-100 text-green-700', 'cancelled' => 'bg-red-100 text-red-700', default => 'bg-yellow-100 text-yellow-700' }; @endphp
                                <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusCls }} capitalize">{{ $order->status }}</span>
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ __('Ship') }}: {{ $order->ship->name }}
                                @if($order->pickup_date)
                                    &nbsp;·&nbsp; {{ \Carbon\Carbon::parse($order->pickup_date)->format('d M Y') }}{{ $order->pickup_time ? ' ' . \Carbon\Carbon::parse($order->pickup_time)->format('H:i') : '' }}
                                @endif
                                @if($order->pickup_location)
                                    &nbsp;·&nbsp; {{ $order->pickup_location }}
                                @endif
                            </div>
                        </div>

                        <!-- Order Items -->
                        <table class="min-w-full divide-y divide-gray-50">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">{{ __('Product') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">{{ __('Vendor') }}</th>
                                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">{{ __('Ordered Qty') }}</th>
                                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">{{ __('Received Qty') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($order->items as $item)
                                <tr>
                                    <td class="px-6 py-3 text-sm text-gray-800">{{ $item->product->name }}</td>
                                    <td class="px-6 py-3 text-sm text-gray-500">{{ $item->product->vendor->name }}</td>
                                    <td class="px-6 py-3 text-sm text-gray-800 text-right">{{ $item->quantity }}</td>
                                    <td class="px-6 py-3 text-sm text-gray-800 text-right">
                                        {{ $item->warehouseReceipts->sum('quantity_received') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Record Receipt Button -->
                        <div class="px-6 py-4 border-t border-gray-100 flex justify-end">
                            <button
                                onclick="document.getElementById('receipt-modal-{{ $order->id }}').classList.remove('hidden')"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ __('Record Received') }}
                            </button>
                        </div>
                    </div>

                    <!-- Receipt Modal -->
                    <div id="receipt-modal-{{ $order->id }}" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
                        <div class="bg-white rounded-xl shadow-xl w-full max-w-lg mx-4 p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="font-semibold text-lg text-gray-800">{{ __('Record Received — Order #') }}{{ $order->id }}</h3>
                                <button onclick="document.getElementById('receipt-modal-{{ $order->id }}').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                            <form method="POST" action="{{ route('warehouse.receipts.store', $order) }}">
                                @csrf
                                <div class="space-y-3">
                                    @foreach($order->items as $item)
                                    <div class="flex items-center gap-4">
                                        <input type="hidden" name="receipts[{{ $loop->index }}][order_item_id]" value="{{ $item->id }}">
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-800">{{ $item->product->name }}</p>
                                            <p class="text-xs text-gray-400">{{ __('Ordered') }}: {{ $item->quantity }}</p>
                                        </div>
                                        <div class="w-28">
                                            <x-input-label for="receipt_qty_{{ $order->id }}_{{ $item->id }}" :value="__('Qty Received')" />
                                            <x-text-input
                                                id="receipt_qty_{{ $order->id }}_{{ $item->id }}"
                                                name="receipts[{{ $loop->index }}][quantity]"
                                                type="number"
                                                min="0"
                                                :value="0"
                                                class="mt-1 block w-full" />
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="mt-6 flex items-center gap-3 justify-end">
                                    <button type="button" onclick="document.getElementById('receipt-modal-{{ $order->id }}').classList.add('hidden')" class="text-sm text-gray-500 hover:text-gray-700">{{ __('Cancel') }}</button>
                                    <x-primary-button>{{ __('Save') }}</x-primary-button>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
