<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Vendors') }}</h2>
            <a href="{{ route('admin.vendors.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                {{ __('Add Vendor') }}
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg">{{ session('success') }}</div>
            @endif

            @if($vendors->isEmpty())
                <div class="text-center py-16 bg-white rounded-xl shadow-sm border border-gray-100">
                    <p class="text-gray-400">{{ __('No vendors yet.') }}</p>
                </div>
            @else
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">{{ __('Vendor') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">{{ __('Contact') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">{{ __('Products') }}</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($vendors as $vendor)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <p class="font-medium text-gray-900">{{ $vendor->name }}</p>
                                    @if($vendor->email)<p class="text-xs text-gray-400">{{ $vendor->email }}</p>@endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    @if($vendor->contact_name){{ $vendor->contact_name }}@endif
                                    @if($vendor->phone)<p class="text-xs text-gray-400">{{ $vendor->phone }}</p>@endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $vendor->products_count }}</td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('admin.vendors.edit', $vendor) }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">{{ __('Edit') }}</a>
                                        <form method="POST" action="{{ route('admin.vendors.destroy', $vendor) }}" onsubmit="return confirm('{{ __('Delete this vendor?') }}')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium">{{ __('Delete') }}</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
