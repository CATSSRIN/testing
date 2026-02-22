<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin Details</h2>
            <a href="{{ route('admin.admins.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← Back to Admins</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-lg mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase">Name</p>
                    <p class="mt-1 text-sm text-gray-900">{{ $user->name }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase">Email</p>
                    <p class="mt-1 text-sm text-gray-900">{{ $user->email }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase">Created At</p>
                    <p class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('Y-m-d H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
