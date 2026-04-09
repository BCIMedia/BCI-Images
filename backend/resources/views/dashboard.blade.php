<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <p>Welcome to the dashboard.</p>

                <p class="mt-2">
                    Logged in as: {{ auth()->user()->email }}
                </p>

                <p class="mt-2">
                    Role: {{ auth()->user()->role }}
                </p>
            </div>

        </div>
    </div>
</x-app-layout>