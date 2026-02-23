<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Warehouse Accounts') }}</h2>
            <a href="{{ route('admin.warehouses.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                {{ __('Add Warehouse') }}
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg">{{ session('success') }}</div>
            @endif

            @if($warehouses->isEmpty())
                <div class="text-center py-16 bg-white rounded-xl shadow-sm border border-gray-100">
                    <p class="text-gray-400">{{ __('No warehouse accounts yet.') }}</p>
                </div>
            @else
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">{{ __('Name') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">{{ __('Email') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">{{ __('Created') }}</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($warehouses as $warehouse)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $warehouse->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $warehouse->email }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $warehouse->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4 text-right">
                                    <form method="POST" action="{{ route('admin.warehouses.destroy', $warehouse) }}" onsubmit="return confirm('{{ __('Delete this warehouse account?') }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">{{ __('Delete') }}</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $warehouses->links() }}</div>
            @endif
        </div>
    </div>
</x-app-layout>
