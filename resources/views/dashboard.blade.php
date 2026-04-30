<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Customer Dashboard</h2>
    </x-slot>

    <div class="p-6">
        <h3 class="text-lg mb-4">Selamat datang, {{ auth()->user()->name }}</h3>

        <div class="space-y-3">
            <a href="{{ route('booking.create') }}" class="block bg-blue-500 text-white px-4 py-2 rounded">
                Booking Service
            </a>

            <a href="#" class="block bg-green-500 text-white px-4 py-2 rounded">
                Lihat Riwayat Booking
            </a>
        </div>
        <a href="{{ route('vehicle.create') }}" class="bg-green-500 text-white px-4 py-2 rounded">
            Tambah Kendaraan
        </a>

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