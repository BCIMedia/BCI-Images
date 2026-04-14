<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>

            @if(auth()->user()->role === 'admin')
                <a
                    href="{{ route('admin.dashboard') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition"
                >
                    Admin Area
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <h3 class="text-lg font-semibold mb-4">
                        Welcome to the dashboard.
                    </h3>

                    <div class="space-y-2">
                        <p>
                            <span class="font-semibold">Logged in as:</span>
                            {{ auth()->user()->email }}
                        </p>

                        <p>
                            <span class="font-semibold">Role:</span>
                            {{ ucfirst(auth()->user()->role) }}
                        </p>

                        @if(auth()->user()->name)
                            <p>
                                <span class="font-semibold">Name:</span>
                                {{ auth()->user()->name }}
                            </p>
                        @endif
                    </div>

                    @if(auth()->user()->role === 'admin')
                        <div class="mt-6 p-4 border rounded bg-gray-50">
                            <p class="font-semibold text-gray-800">
                                Admin Access Enabled
                            </p>

                            <p class="text-sm text-gray-600 mt-1">
                                You have permission to manage all users, images, and albums.
                            </p>
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</x-app-layout>