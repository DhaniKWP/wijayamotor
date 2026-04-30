<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Tambah Kendaraan</h2>
    </x-slot>

    <div class="p-6">

        @if ($errors->any())
            <div class="bg-red-500 text-white p-3 mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('vehicle.store') }}">
            @csrf

            <!-- Nama Mobil -->
            <div class="mb-4">
                <label>Nama Kendaraan</label>
                <input type="text" name="name" class="w-full border rounded">
            </div>

            <!-- Plat -->
            <div class="mb-4">
                <label>Nomor Plat</label>
                <input type="text" name="plate_number" class="w-full border rounded">
            </div>

            <!-- Tahun -->
            <div class="mb-4">
                <label>Tahun</label>
                <input type="number" name="year" class="w-full border rounded">
            </div>

            <button class="bg-blue-500 text-white px-4 py-2 rounded">
                Simpan
            </button>
        </form>
    </div>
</x-app-layout>