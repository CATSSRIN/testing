<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add Ship for {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-lg mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <form method="POST" action="{{ route('admin.users.ships.store', $user) }}">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <x-input-label for="name" :value="__('Ship Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="imo_number" :value="__('IMO Number')" />
                            <x-text-input id="imo_number" name="imo_number" type="text" class="mt-1 block w-full" :value="old('imo_number')" />
                            <x-input-error :messages="$errors->get('imo_number')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="flag" :value="__('Flag')" />
                            <x-text-input id="flag" name="flag" type="text" class="mt-1 block w-full" :value="old('flag')" />
                            <x-input-error :messages="$errors->get('flag')" class="mt-2" />
                        </div>
                    </div>
                    <div class="mt-6 flex items-center gap-3">
                        <x-primary-button>Add Ship</x-primary-button>
                        <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
