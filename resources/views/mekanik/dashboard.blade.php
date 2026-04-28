<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Mekanik Dashboard</h2>
    </x-slot>

    <div class="p-6">
        <h3 class="text-lg mb-4">Halo Mekanik, {{ auth()->user()->name }}</h3>

        <div class="space-y-3">
            <a href="#" class="block bg-blue-500 text-white px-4 py-2 rounded">
                Lihat Jadwal Servis
            </a>

            <a href="#" class="block bg-green-500 text-white px-4 py-2 rounded">
                Update Status Pekerjaan
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