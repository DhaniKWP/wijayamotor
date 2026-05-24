@extends('layouts.admin')

@section('title', 'Manajemen Booking - Wijaya Motor')
@section('header_title', 'Manajemen Booking Servis')

@section('content')

@if(session('success'))
<div class="bg-emerald-50 border border-emerald-100 text-emerald-600 px-4 py-3 rounded-xl mb-6 flex items-center text-sm font-medium shadow-sm">
    <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
    {{ session('success') }}
</div>
@endif

<!-- Statistik Singkat (TIDAK ADA PERUBAHAN) -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Isi sama dengan sebelumnya -->
</div>

<!-- Tabel Manajemen Booking -->
<div class="bg-white rounded-2xl border border-slate-200/60 overflow-hidden shadow-sm">
    <div class="p-6 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-bold text-slate-800">Daftar Antrean & Persetujuan</h2>
        </div>
        
        <form action="{{ route('admin.bookings.index') }}" method="GET" class="flex space-x-2" id="filterForm">
            <select name="status" onchange="document.getElementById('filterForm').submit()" class="text-sm border-slate-200 rounded-lg focus:ring-secondary focus:border-secondary py-2 pl-3 pr-10 text-slate-600 font-medium bg-slate-50">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu Persetujuan</option>
                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Disetujui</option> <!-- Perbaikan status -->
                <option value="process" {{ request('status') == 'process' ? 'selected' : '' }}>Dikerjakan</option>
                <option value="done" {{ request('status') == 'done' ? 'selected' : '' }}>Selesai</option>
            </select>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-100">
            <thead class="bg-slate-50/50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Waktu & Tipe</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Pelanggan & Kendaraan</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-50">
                
                @forelse($bookings as $booking)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-bold text-slate-800">{{ \Carbon\Carbon::parse($booking->tanggal)->format('d M Y') }}</div>
                        <div class="text-xs text-slate-500 mt-1">{{ \Carbon\Carbon::parse($booking->jam)->format('H:i') }} WIB</div> <!-- Pakai field jam -->
                        <span class="inline-flex items-center px-2 py-0.5 mt-2 rounded text-[10px] font-bold bg-slate-100 text-slate-600">
                            {{ strtoupper($booking->tipe_booking ?? 'BENGKEL') }} <!-- Pakai field tipe_booking -->
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-bold text-slate-800">{{ $booking->user->name ?? $booking->user->username ?? 'Pelanggan' }}</div>
                        
                        <!-- Cek beberapa kemungkinan nama kolom plat -->
                        <div class="text-xs text-secondary font-bold mt-1 tracking-wider">
                            {{ $booking->vehicle->plat_nomor ?? $booking->vehicle->plate_number ?? $booking->vehicle->nomor_polisi ?? '-' }}
                        </div>
                        <!-- Cek beberapa kemungkinan nama kolom merek/tipe -->
                        <div class="text-xs text-slate-500 mt-0.5">
                            {{ $booking->vehicle->merek ?? $booking->vehicle->merek_kendaraan ?? $booking->vehicle->brand ?? $booking->vehicle->name ?? '-' }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($booking->status == 'pending')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1.5 animate-pulse"></span> Pending
                            </span>
                        @elseif($booking->status == 'confirmed')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-1.5"></span> Disetujui
                            </span>
                        @elseif($booking->status == 'process')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-purple-100 text-purple-700 animate-pulse">
                                <span class="w-1.5 h-1.5 rounded-full bg-purple-500 mr-1.5"></span> Dikerjakan
                            </span>
                        @elseif($booking->status == 'done')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span> Selesai
                            </span>
                        @elseif($booking->status == 'cancelled')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-700">
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500 mr-1.5"></span> Ditolak
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                        
                        <button type="button" 
                            data-id="{{ $booking->id }}"
                            onclick="openDetailModal(this.getAttribute('data-id'))" 
                            class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-3 py-2 rounded-lg text-xs font-bold transition inline-flex items-center">
                            Detail
                        </button>   
                     
                        @if($booking->status == 'pending')
                            <form action="{{ route('admin.bookings.accept', $booking->id) }}" method="POST" class="inline-block">
                                @csrf
                                <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white px-3 py-2 rounded-lg text-xs font-bold shadow-sm transition inline-flex items-center">Terima</button>
                            </form>
                            <form action="{{ route('admin.bookings.reject', $booking->id) }}" method="POST" class="inline-block">
                                @csrf
                                <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-600 px-3 py-2 rounded-lg text-xs font-bold transition inline-flex items-center">Tolak</button>
                            </form>
                        @elseif($booking->status == 'confirmed')
                            <form action="{{ route('admin.bookings.process', $booking->id) }}" method="POST" class="inline-block">
                                @csrf
                                <button type="submit" class="bg-primary hover:bg-[#112a4f] text-white px-4 py-2 rounded-lg text-xs font-bold shadow-sm transition">Mulai Kerjakan</button>
                            </form>
                        @elseif($booking->status == 'process')
                            <form action="{{ route('admin.bookings.complete', $booking->id) }}" method="POST" class="inline-block">
                                @csrf
                                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-xs font-bold shadow-sm transition">Selesaikan Servis</button>
                            </form>
                        @endif

                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-slate-500 text-sm">Tidak ada data booking.</td>
                </tr>
                @endforelse

            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-slate-100">
        {{ $bookings->links() }}
    </div>
</div>

<!-- MODAL DETAIL BOOKING DINAMIS -->
<div id="modalDetail" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm overflow-y-auto h-full w-full flex items-center justify-center">
    <div class="relative w-full max-w-2xl mx-4 my-8 bg-white rounded-2xl shadow-2xl overflow-hidden">
        
        <div class="bg-slate-50 px-6 py-4 border-b border-slate-100 flex justify-between items-center">
            <h3 class="text-lg font-bold text-slate-800">Detail Booking <span id="modalId"></span></h3>
            <button onclick="closeModal()" class="text-slate-400 hover:text-rose-500 transition">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="p-6 space-y-6">
            <!-- Header Info -->
            <div class="flex items-center justify-between p-4 bg-slate-50 border border-slate-200 rounded-xl">
                <div>
                    <p class="text-xs text-slate-500 font-bold uppercase tracking-wider mb-1">Status Saat Ini</p>
                    <p class="text-sm font-bold text-slate-800" id="modalStatus">-</p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-slate-500 font-bold uppercase tracking-wider mb-1">Tipe Layanan</p>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-primary text-white" id="modalTipe">-</span>
                </div>
            </div>
            <!-- Pelanggan & Kendaraan -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-sm font-bold text-slate-800 border-b border-slate-100 pb-2 mb-3">Informasi Pelanggan</h4>
                    <ul class="space-y-2 text-sm">
                        <li><span class="text-slate-500 block text-xs">Nama:</span> <span class="font-medium text-slate-800" id="modalNama">-</span></li>
                        <li><span class="text-slate-500 block text-xs">No. Telepon / WA:</span> <span class="font-medium text-slate-800" id="modalPhone">-</span></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-slate-800 border-b border-slate-100 pb-2 mb-3">Informasi Kendaraan</h4>
                    <ul class="space-y-2 text-sm">
                        <li><span class="text-slate-500 block text-xs">Plat Nomor:</span> <span class="font-bold text-secondary" id="modalPlat">-</span></li>
                        <li><span class="text-slate-500 block text-xs">Merek / Tipe:</span> <span class="font-medium text-slate-800" id="modalMerek">-</span></li>
                    </ul>
                </div>
            </div>
            <!-- Detail Layanan & Lokasi -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-sm font-bold text-slate-800 border-b border-slate-100 pb-2 mb-3">Detail Layanan</h4>
                    <ul class="space-y-2 text-sm">
                        <li><span class="text-slate-500 block text-xs">Paket Servis:</span> <span class="font-bold text-slate-800" id="modalService">-</span></li>
                        <li><span class="text-slate-500 block text-xs">Jenis Servis:</span> <span class="font-medium text-slate-800 capitalize" id="modalJenisServis">-</span></li>
                        <li><span class="text-slate-500 block text-xs">Kilometer (Odo):</span> <span class="font-medium text-slate-800" id="modalKm">-</span></li>
                        <li><span class="text-slate-500 block text-xs">Estimasi Biaya:</span> <span class="font-bold text-emerald-600" id="modalHarga">-</span></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-slate-800 border-b border-slate-100 pb-2 mb-3">Lokasi & Tambahan</h4>
                    <div class="space-y-3">
                        <div>
                            <span class="text-slate-500 block text-xs mb-1 font-bold uppercase tracking-wider" id="labelLokasi">Lokasi:</span>
                            <p class="text-sm font-medium text-slate-800 bg-slate-100 p-2.5 rounded-lg border border-slate-200" id="modalLokasi">-</p>
                        </div>
                        <div>
                            <span class="text-slate-500 block text-xs mb-1 font-bold uppercase tracking-wider">Add-ons:</span>
                            <div class="flex flex-wrap gap-1.5" id="modalAddons">
                                <!-- Terisi Otomatis JS -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Keluhan -->
            <div>
                <h4 class="text-sm font-bold text-slate-800 border-b border-slate-100 pb-2 mb-3">Keluhan & Catatan</h4>
                <div class="bg-amber-50 border border-amber-100/50 rounded-xl p-4">
                    <p class="text-amber-900 text-sm italic" id="modalKeluhan">-</p>
                </div>
            </div>
        </div>
        <div class="bg-slate-50 px-6 py-4 border-t border-slate-100 flex justify-end">
            <button onclick="closeModal()" class="px-4 py-2 bg-white border border-slate-200 text-slate-600 rounded-lg text-sm font-bold hover:bg-slate-50 transition shadow-sm">
                Tutup Detail
            </button>
        </div>
    </div>
</div>

<!-- 1. Simpan data JSON di tag khusus yang kebal dari error VS Code -->
<script id="booking-data" type="application/json">
    {!! json_encode($bookings->items(), JSON_HEX_TAG) !!}
</script>

<!-- 2. Script utama diletakkan LANGSUNG (Tanpa push) agar dijamin muncul di halaman -->
<script>
    // Ambil string JSON dari elemen di atas, lalu ubah jadi Javascript Object
    const rawData = document.getElementById('booking-data').textContent;
    const bookingsData = JSON.parse(rawData);
    
    // Kelompokkan data berdasarkan ID
    const bookingsMap = {};
    bookingsData.forEach(b => {
        bookingsMap[b.id] = b;
    });

    function openDetailModal(id) {
        let data = bookingsMap[id];
        
        if(!data) {
            console.error("Data booking tidak ditemukan!");
            return;
        }

        // Identitas Booking
        document.getElementById('modalId').innerText = "#" + data.id;
        document.getElementById('modalStatus').innerText = data.status.toUpperCase();
        
        let isHomeService = data.tipe_booking && data.tipe_booking.toLowerCase().includes('home');
        document.getElementById('modalTipe').innerText = data.tipe_booking ? data.tipe_booking.toUpperCase() : 'BENGKEL';
        
        // Data Pelanggan
        document.getElementById('modalNama').innerText = data.user ? (data.user.name || data.user.username) : '-';
        document.getElementById('modalPhone').innerText = data.user ? (data.user.phone || data.user.no_telp || data.user.no_hp || '-') : '-';
        
        // Data Kendaraan 
        document.getElementById('modalPlat').innerText = data.vehicle ? (data.vehicle.plat_nomor || data.vehicle.plate_number || data.vehicle.nomor_polisi || '-') : '-';
        document.getElementById('modalMerek').innerText = data.vehicle ? (data.vehicle.merek || data.vehicle.merek_kendaraan || data.vehicle.brand || data.vehicle.name || '-') : '-';

        // Detail Servis
        document.getElementById('modalService').innerText = data.service ? data.service.name : 'Servis Umum';
        document.getElementById('modalJenisServis').innerText = data.jenis_servis || '-';
        document.getElementById('modalKm').innerText = data.kilometer ? data.kilometer.toLocaleString('id-ID') + ' KM' : '-';
        
        // Estimasi Harga 
        let harga = data.estimasi_harga ? parseFloat(data.estimasi_harga) : 0;
        document.getElementById('modalHarga').innerText = 'Rp ' + harga.toLocaleString('id-ID');

        // Lokasi
        if (isHomeService) {
            document.getElementById('labelLokasi').innerText = 'ALAMAT HOME SERVICE:';
            document.getElementById('modalLokasi').innerText = data.alamat_lengkap || 'Alamat tidak diisi';
        } else {
            document.getElementById('labelLokasi').innerText = 'CABANG BENGKEL:';
            document.getElementById('modalLokasi').innerText = data.cabang || 'Cabang Pusat';
        }

        // Add-ons
        let addonsContainer = document.getElementById('modalAddons');
        addonsContainer.innerHTML = ''; 
        if (data.addons && Array.isArray(data.addons) && data.addons.length > 0) {
            data.addons.forEach(addon => {
                addonsContainer.innerHTML += `<span class="px-2 py-1 bg-indigo-50 text-indigo-600 border border-indigo-100 rounded-md text-xs font-semibold shadow-sm">${addon}</span>`;
            });
        } else {
            addonsContainer.innerHTML = `<span class="text-xs text-slate-400 italic">Tidak ada add-ons</span>`;
        }

        // Keluhan 
        document.getElementById('modalKeluhan').innerText = data.keluhan || 'Tidak ada keluhan yang dicantumkan.';

        // Tampilkan Modal
        document.getElementById('modalDetail').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('modalDetail').classList.add('hidden');
    }
</script>

@endsection