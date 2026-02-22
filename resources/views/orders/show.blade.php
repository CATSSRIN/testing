<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Order #{{ $order->id }}</h2>
            <a href="{{ route('orders.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← {{ __('Back to Orders') }}</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <!-- Order Info -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide">{{ __('Ship') }}</p>
                        <p class="font-semibold text-gray-800 mt-1">{{ $order->ship->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide">{{ __('Date') }}</p>
                        <p class="font-semibold text-gray-800 mt-1">{{ $order->created_at->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide">{{ __('Status') }}</p>
                        @php $statusCls = match($order->status) { 'confirmed' => 'bg-blue-100 text-blue-700', 'delivered' => 'bg-green-100 text-green-700', 'cancelled' => 'bg-red-100 text-red-700', default => 'bg-yellow-100 text-yellow-700' }; @endphp
                        <span class="mt-1 inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusCls }} capitalize">{{ $order->status }}</span>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide">{{ __('Total') }}</p>
                        <p class="font-bold text-indigo-600 text-lg mt-1">Rp {{ number_format($order->total_price, 0, ",", ".") }}</p>
                    </div>
                </div>
                @if($order->notes)
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <p class="text-xs text-gray-400 uppercase tracking-wide">{{ __('Notes') }}</p>
                        <p class="text-sm text-gray-600 mt-1">{{ $order->notes }}</p>
                    </div>
                @endif
            </div>

            <!-- Items -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gray-50 px-6 py-3 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-700">{{ __('Order Items') }}</h3>
                </div>
                <table class="min-w-full divide-y divide-gray-50">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">{{ __('Product') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">{{ __('Vendor') }}</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">{{ __('Unit Price') }}</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">{{ __('Qty') }}</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">{{ __('Subtotal') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($order->items as $item)
                        <tr>
                            <td class="px-6 py-3 text-sm text-gray-800">{{ $item->product->name }}</td>
                            <td class="px-6 py-3 text-sm text-gray-500">{{ $item->product->vendor->name }}</td>
                            <td class="px-6 py-3 text-sm text-gray-800 text-right">Rp {{ number_format($item->unit_price, 0, ",", ".") }}</td>
                            <td class="px-6 py-3 text-sm text-gray-800 text-right">{{ $item->quantity }}</td>
                            <td class="px-6 py-3 text-sm font-semibold text-gray-900 text-right">Rp {{ number_format($item->subtotal, 0, ",", ".") }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray-50">
                            <td colspan="4" class="px-6 py-3 text-right font-semibold text-gray-700">{{ __('Total') }}</td>
                            <td class="px-6 py-3 text-right font-bold text-indigo-600 text-base">Rp {{ number_format($order->total_price, 0, ",", ".") }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
