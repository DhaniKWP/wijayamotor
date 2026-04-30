<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Booking Service</h2>
    </x-slot>

    <div class="p-6">

        <!-- ERROR -->
        @if ($errors->any())
            <div class="bg-red-500 text-white p-3 mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('booking.store') }}">
            @csrf

            <!-- Kendaraan -->
            <div class="mb-4">
                <label>Kendaraan</label>
                <select name="vehicle_id" class="w-full border rounded">
                    @foreach($vehicles as $v)
                        <option value="{{ $v->id }}">
                            {{ $v->name }} - {{ $v->plate_number }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Service -->
            <div class="mb-4">
                <label>Service</label>
                <select name="service_id" class="w-full border rounded">
                    @foreach($services as $s)
                        <option value="{{ $s->id }}">
                            {{ $s->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Tanggal -->
            <div class="mb-4">
                <label>Tanggal</label>
                <input type="date" name="tanggal" class="w-full border rounded">
            </div>

            <!-- Jam -->
            <div class="mb-4">
                <label>Jam</label>
                <input type="time" name="jam" class="w-full border rounded">
            </div>

            <!-- Keluhan -->
            <div class="mb-4">
                <label>Keluhan</label>
                <textarea name="keluhan" class="w-full border rounded"></textarea>
            </div>

            <button class="bg-blue-500 text-white px-4 py-2 rounded">
                Booking Sekarang
            </button>
        </form>
    </div>
</x-app-layout>