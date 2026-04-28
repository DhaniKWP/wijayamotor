<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Admin Dashboard</h2>
    </x-slot>

    <div class="p-6">
        <h3 class="text-lg mb-4">Halo Admin, {{ auth()->user()->name }}</h3>

        <div class="grid grid-cols-2 gap-4">
            <div class="bg-blue-500 text-white p-4 rounded">
                Total Booking
            </div>

            <div class="bg-green-500 text-white p-4 rounded">
                Total Income
            </div>
        </div>

        <div class="mt-6 space-y-3">
            <a href="#" class="block bg-yellow-500 text-white px-4 py-2 rounded">
                Kelola Booking
            </a>

            <a href="#" class="block bg-purple-500 text-white px-4 py-2 rounded">
                Kelola Sparepart
            </a>
        </div>

        <!-- Logout -->
        <div class="mt-6">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="bg-red-500 text-white px-4 py-2 rounded">
                    Logout
                </button>
            </form>
        </div>
    </div>
</x-app-layout>