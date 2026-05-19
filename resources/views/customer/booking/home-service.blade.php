@extends('layouts.app')

@section('title', 'Booking Home Service - Wijaya Motor')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<style>
    /* Styling custom untuk radio card yang lebih modern */
    .radio-card-input:checked + div {
        border-color: #0A192F;
        background-color: #F8FAFC;
        box-shadow: 0 4px 6px -1px rgba(10, 25, 47, 0.1);
    }
    .radio-card-input:checked + div .check-icon {
        opacity: 1;
        transform: scale(1);
    }
    .custom-checkbox:checked {
        background-color: #0A192F;
        border-color: #0A192F;
    }
    #mapContainer { height: 100%; width: 100%; z-index: 1; }
</style>
@endpush

@section('content')
<div class="bg-surface min-h-screen pb-20" x-data="{ 
          bookingType: 'home_service',
          vehicleSelected: '', 
          serviceType: 'berkala', 
          
          /* State Berkala */
          kmSelected: '1000',
          showDetailModal: false,
          detailTab: 'diperiksa',
          addonAC: false,
          addonEngine: false,
          
          /* State Perbaikan Umum */
          generalRepairs: [],
          repairOptions: {
              'engine_oil': { name: 'Engine Oil', price: 498000 },
              'brake_service': { name: 'Brake Service', price: 286000 },
              'engine_tune_up': { name: 'Engine Tune Up', price: 450000 },
              'fuel_filter': { name: 'Replace Fuel Filter', price: 416000 },
              'brake_pads': { name: 'Replace Brake Pads', price: 607000 },
              'reset_alarm': { name: 'Reset Alarm', price: 63000 },
              'engine_diagnose': { name: 'Engine Diagnose', price: 216000 },
              'other': { name: 'Other Service (Harga disesuaikan)', price: 0 }
          },

          /* State Lokasi & Waktu */
          address: '',
          tempAddress: '',
          addressDetail: '', // Patokan/Blok/Unit
          showMapModal: false,
          date: '',
          time: '',
          
          /* State Peta & Search */
          map: null,
          marker: null,
          isLocating: false,
          searchQuery: '',
          searchResults: [],
          isSearching: false,
          
          init() {
              this.$watch('serviceType', (value) => {
                  if (value === 'umum') {
                      this.addonAC = false;
                      this.addonEngine = false;
                  } else {
                      this.generalRepairs = [];
                  }
              });

              this.$watch('showMapModal', (value) => {
                  if (value) {
                      setTimeout(() => { this.initMap(); }, 200);
                  }
              });
          },

          /* LOGIKA PETA & PENCARIAN */
          initMap() {
              if (this.map) {
                  this.map.invalidateSize();
                  return;
              }
              this.map = L.map('mapContainer').setView([-6.175110, 106.827166], 15);
              L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                  attribution: '&copy; OpenStreetMap contributors'
              }).addTo(this.map);

              this.marker = L.marker([-6.175110, 106.827166], {draggable: true}).addTo(this.map);
              
              this.marker.on('dragend', (e) => {
                  const position = this.marker.getLatLng();
                  this.getAddressFromCoords(position.lat, position.lng);
              });
          },

          trackLocation() {
              if (navigator.geolocation) {
                  this.isLocating = true;
                  navigator.geolocation.getCurrentPosition(
                      (position) => {
                          const lat = position.coords.latitude;
                          const lng = position.coords.longitude;
                          const newLatLng = new L.LatLng(lat, lng);
                          
                          this.map.setView(newLatLng, 16);
                          this.marker.setLatLng(newLatLng);
                          this.getAddressFromCoords(lat, lng);
                          this.isLocating = false;
                      },
                      (error) => {
                          alert('Gagal mendeteksi lokasi. Pastikan izin GPS aktif di browser Anda.');
                          this.isLocating = false;
                      },
                      { enableHighAccuracy: true }
                  );
              }
          },

          async getAddressFromCoords(lat, lng) {
              this.tempAddress = 'Mengambil alamat...';
              try {
                  const res = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`);
                  const data = await res.json();
                  if(data && data.display_name) {
                      this.tempAddress = data.display_name;
                  } else {
                      this.tempAddress = 'Alamat tidak ditemukan, silakan geser pin manual.';
                  }
              } catch (err) {
                  this.tempAddress = 'Gagal mengambil alamat otomatis.';
              }
          },

          async searchAddress() {
              if(this.searchQuery.length < 3) {
                  this.searchResults = [];
                  return;
              }
              this.isSearching = true;
              try {
                  const res = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${this.searchQuery}&countrycodes=id&limit=5`);
                  this.searchResults = await res.json();
              } catch (err) {
                  console.error(err);
              }
              this.isSearching = false;
          },

          selectSearchResult(item) {
              const lat = parseFloat(item.lat);
              const lon = parseFloat(item.lon);
              const newLatLng = new L.LatLng(lat, lon);
              
              this.map.setView(newLatLng, 17);
              this.marker.setLatLng(newLatLng);
              this.tempAddress = item.display_name;
              
              // Reset search
              this.searchQuery = '';
              this.searchResults = [];
          },
          
          /* DATA DETAIL SERVIS BERKALA */
          kmOptions: ['1000', '10000', '20000'],
          get currentKmIndex() { return this.kmOptions.indexOf(this.kmSelected); },
          nextKm() { if(this.currentKmIndex < 2) this.kmSelected = this.kmOptions[this.currentKmIndex + 1]; },
          prevKm() { if(this.currentKmIndex > 0) this.kmSelected = this.kmOptions[this.currentKmIndex - 1]; },
          
          serviceData: {
              '1000': {
                  title: 'SERVIS BERKALA 1.000 KM',
                  diperiksa: ['Aki/Battery', 'Chasis Kendaraan', 'Freon', 'Kandungan Gas Buang', 'Klakson', 'Kondisi Ban', 'Kekencangan Baut', 'Lampu-Lampu', 'Minyak Power Steering', 'Oli Mesin', 'Pedal Kopling', 'Sistem Pengereman', 'Sistem Pendingin', 'Tali Kipas', 'Wiper & Washer'],
                  diganti: []
              },
              '10000': {
                  title: 'SERVIS BERKALA 10.000 KM',
                  diperiksa: ['Aki/Battery', 'Chasis Kendaraan', 'Kandungan Gas Buang', 'Klakson', 'Kondisi Ban', 'Lampu-Lampu', 'Minyak Power Steering', 'Sistem Pengereman', 'Sistem Pendingin', 'Sistem Pembakaran', 'Saringan Udara', 'Wiper & Washer'],
                  diganti: [
                      { name: 'Gasket', price: 15000 },
                      { name: 'Oli Mesin', price: 450000 },
                      { name: 'Saringan Oli', price: 85000 }
                  ]
              },
              '20000': {
                  title: 'SERVIS BERKALA 20.000 KM',
                  diperiksa: ['Aki/Battery', 'Chasis Kendaraan', 'Freon', 'Kandungan Gas Buang', 'Klakson', 'Kondisi Ban', 'Lampu-Lampu', 'Minyak Power Steering', 'Oli Gardan', 'Oli Transmisi', 'Sistem Pengereman', 'Sistem Pendingin', 'Sistem Pembakaran', 'Saringan Udara', 'Suspensi', 'Tali Kipas', 'Wiper'],
                  diganti: [
                      { name: 'Gasket', price: 15000 },
                      { name: 'Oli Mesin', price: 450000 },
                      { name: 'Saringan Oli', price: 85000 }
                  ]
              }
          },

          /* KALKULATOR HARGA */
          get totalPrice() {
              let total = 0;
              if(this.serviceType === 'berkala') {
                  let parts = this.serviceData[this.kmSelected].diganti;
                  parts.forEach(p => total += p.price);
                  if(this.kmSelected === '10000') total += 300000; 
                  if(this.kmSelected === '20000') total += 400000; 
                  if(this.addonAC) total += 350000;
                  if(this.addonEngine) total += 400000;
              } else if (this.serviceType === 'umum') {
                  this.generalRepairs.forEach(key => { total += this.repairOptions[key].price; });
              }
              return total;
          },
          get formattedPrice() {
              return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(this.totalPrice);
          }
      }">

    <div class="bg-white border-b border-gray-200 py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-xs font-bold text-gray-400 uppercase tracking-widest flex items-center space-x-3">
            <a href="{{ url('/') }}" class="hover:text-brand transition">Beranda</a>
            <span>/</span>
            <a href="{{ route('booking.index') }}" class="hover:text-brand transition">Pilihan Servis</a>
            <span>/</span>
            <span class="text-ink">Home Service</span>
        </div>
    </div>

    <div class="bg-brand text-white py-12 relative overflow-hidden">
        <div class="absolute right-0 top-0 opacity-10 transform translate-x-1/4 -translate-y-1/4">
            <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <h1 class="text-3xl md:text-4xl font-black mb-3 tracking-tight">Wijaya Motor Home Service</h1>
            <p class="text-white/90 max-w-2xl text-sm md:text-base leading-relaxed">Bengkel bergerak yang siap melakukan perawatan dan perbaikan kendaraan langsung di garasi rumah atau kantor Anda.</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 grid grid-cols-1 lg:grid-cols-12 gap-8 relative -mt-8">
        
        <div class="lg:col-span-8 space-y-6">
            
            <form action="{{ route('booking.store') }}" method="POST" id="homeServiceForm">
                @csrf
                <input type="hidden" name="tipe_booking" value="home_service">
                <input type="hidden" name="estimasi_harga" :value="totalPrice">
                <input type="hidden" name="alamat_lengkap" :value="address ? address + (addressDetail ? ' (Patokan: ' + addressDetail + ')' : '') : ''">

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                    <div class="flex items-center gap-4 mb-6 pb-4 border-b border-gray-100">
                        <div class="w-10 h-10 rounded-full bg-brand/10 text-brand flex items-center justify-center font-black text-lg">1</div>
                        <div>
                            <h2 class="text-xl font-black text-ink">Pilih Kendaraan</h2>
                            <p class="text-xs text-gray-500 mt-1">Data ditarik dari Garasi profil {{ Auth::user()->name ?? 'Anda' }}</p>
                        </div>
                    </div>

                    @if(!isset($vehicles) || $vehicles->isEmpty())
                        <div class="bg-red-50 rounded-xl p-6 text-center border border-red-100">
                            <h4 class="font-bold text-red-700 mb-2">Garasi Masih Kosong</h4>
                            <p class="text-sm text-red-600 mb-4">Tambahkan data mobil Anda terlebih dahulu untuk melanjutkan.</p>
                            <a href="{{ route('garasi.index') }}" class="inline-block bg-ink text-white font-bold px-6 py-2.5 rounded-lg text-sm transition hover:bg-ink-light">Tambah Kendaraan</a>
                        </div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach($vehicles as $index => $vehicle)
                            <label class="relative cursor-pointer group">
                                <input type="radio" name="vehicle_id" value="{{ $vehicle->id }}" class="peer sr-only radio-card-input" x-model="vehicleSelected" required>
                                <div class="border-2 border-gray-100 rounded-xl p-5 transition-all duration-200 hover:border-gray-300 relative bg-white">
                                    <div class="check-icon opacity-0 transform scale-50 transition-all duration-300 absolute top-4 right-4 w-6 h-6 bg-ink rounded-full text-white flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <div class="w-12 h-12 bg-gray-50 rounded-lg flex items-center justify-center mb-4">
                                        <img src="https://cdn-icons-png.flaticon.com/512/3204/3204990.png" class="w-8 h-8 opacity-70">
                                    </div>
                                    <h4 class="font-black text-ink text-lg">{{ $vehicle->name }}</h4>
                                    <p class="text-sm text-gray-500 mb-3">Tahun: {{ $vehicle->year }}</p>
                                    <span class="inline-block px-3 py-1 bg-gray-100 text-ink text-xs font-bold rounded-md uppercase tracking-wider">{{ $vehicle->plate_number }}</span>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 mt-6 transition-opacity duration-300" :class="!vehicleSelected ? 'opacity-50 pointer-events-none' : ''">
                    <div class="flex items-center gap-4 mb-6 pb-4 border-b border-gray-100">
                        <div class="w-10 h-10 rounded-full bg-brand/10 text-brand flex items-center justify-center font-black text-lg">2</div>
                        <div>
                            <h2 class="text-xl font-black text-ink">Jenis Layanan</h2>
                            <p class="text-xs text-gray-500 mt-1">Tentukan perawatan yang dibutuhkan kendaraan Anda</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <label class="relative cursor-pointer">
                            <input type="radio" name="service_category" value="berkala" class="peer sr-only radio-card-input" x-model="serviceType">
                            <div class="border-2 border-gray-100 rounded-xl p-5 transition-all bg-white h-full flex flex-col justify-center items-center text-center">
                                <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center mb-3">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </div>
                                <h4 class="font-bold text-ink text-lg">Servis Berkala</h4>
                                <p class="text-xs text-gray-500 mt-1">Perawatan rutin sesuai jarak tempuh (KM)</p>
                            </div>
                        </label>

                        <label class="relative cursor-pointer">
                            <input type="radio" name="service_category" value="umum" class="peer sr-only radio-card-input" x-model="serviceType">
                            <div class="border-2 border-gray-100 rounded-xl p-5 transition-all bg-white h-full flex flex-col justify-center items-center text-center">
                                <div class="w-12 h-12 rounded-full bg-red-50 text-danger flex items-center justify-center mb-3">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </div>
                                <h4 class="font-bold text-ink text-lg">Perbaikan Umum</h4>
                                <p class="text-xs text-gray-500 mt-1">Ganti part spesifik atau pengecekan</p>
                            </div>
                        </label>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-5 border border-gray-100">
                        
                        <div x-show="serviceType === 'berkala'" x-collapse>
                            <div class="flex justify-between items-center mb-3">
                                <label class="block text-sm font-black text-ink">Jarak Tempuh (KM)</label>
                                <button type="button" @click.prevent="showDetailModal = true" class="text-xs font-bold text-brand hover:text-brand-dark flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Cek Rincian Part
                                </button>
                            </div>
                            <select name="km_service" x-model="kmSelected" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-ink focus:ring-1 focus:ring-ink font-medium">
                                <option value="1000">1.000 KM (Servis Perdana) - Bebas Biaya Jasa</option>
                                <option value="10000">10.000 KM (Servis Reguler) - +Jasa Rp300rb</option>
                                <option value="20000">20.000 KM (Servis Besar) - +Jasa Rp400rb</option>
                            </select>

                            <div class="mt-6 border-t border-gray-200 pt-5">
                                <label class="block text-sm font-black text-ink mb-3">Layanan Tambahan di Tempat (Opsional)</label>
                                <div class="space-y-3">
                                    <label class="flex items-center cursor-pointer p-3 bg-white rounded-lg border border-gray-200 hover:border-gray-300 transition">
                                        <input type="checkbox" name="addons[]" value="ac" x-model="addonAC" class="custom-checkbox w-5 h-5 rounded border-gray-300 text-ink focus:ring-ink">
                                        <span class="ml-3 text-sm text-gray-700 flex-1">AC Superlight Care</span>
                                        <span class="text-xs font-bold text-gray-500">+Rp 350.000</span>
                                    </label>
                                    <label class="flex items-center cursor-pointer p-3 bg-white rounded-lg border border-gray-200 hover:border-gray-300 transition">
                                        <input type="checkbox" name="addons[]" value="engine" x-model="addonEngine" class="custom-checkbox w-5 h-5 rounded border-gray-300 text-ink focus:ring-ink">
                                        <span class="ml-3 text-sm text-gray-700 flex-1">Engine Room Treatment</span>
                                        <span class="text-xs font-bold text-gray-500">+Rp 400.000</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div x-show="serviceType === 'umum'" x-collapse>
                            <p class="text-sm font-black text-ink mb-4">Pilih Pekerjaan Perbaikan Umum:</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <template x-for="(repair, key) in repairOptions" :key="key">
                                    <label class="flex items-center cursor-pointer group">
                                        <input type="checkbox" name="general_repairs[]" :value="key" x-model="generalRepairs" class="w-5 h-5 rounded border-gray-300 text-danger focus:ring-danger accent-danger">
                                        <div class="ml-3 flex-1 flex justify-between items-center border-b border-gray-200 pb-2 group-hover:border-gray-300">
                                            <span class="text-sm text-gray-700 font-medium" x-text="repair.name"></span>
                                            <span class="text-xs font-bold text-ink" x-text="repair.price > 0 ? new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(repair.price) : 'Rp0'"></span>
                                        </div>
                                    </label>
                                </template>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 mt-6 transition-opacity duration-300" :class="!vehicleSelected ? 'opacity-50 pointer-events-none' : ''">
                    <div class="flex items-center gap-4 mb-6 pb-4 border-b border-gray-100">
                        <div class="w-10 h-10 rounded-full bg-brand/10 text-brand flex items-center justify-center font-black text-lg">3</div>
                        <div>
                            <h2 class="text-xl font-black text-ink">Lokasi & Jadwal</h2>
                            <p class="text-xs text-gray-500 mt-1">Tentukan alamat kunjungan mekanik kami</p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Alamat Servis <span class="text-red-500">*</span></label>
                            
                            <div @click="showMapModal = true" class="w-full bg-gray-50 border border-gray-200 hover:border-brand rounded-lg p-4 cursor-pointer transition flex items-center justify-between group">
                                <div class="flex items-center w-full pr-4">
                                    <div class="w-10 h-10 bg-red-100 text-red-600 rounded-full flex items-center justify-center mr-4 shrink-0">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    </div>
                                    <div class="w-full">
                                        <p class="font-bold text-ink text-sm mb-1" x-text="address ? 'Lokasi Terpilih' : 'Pilih Lokasi Peta & Alamat'"></p>
                                        <p class="text-xs text-gray-500 truncate w-full" x-text="address ? address + (addressDetail ? ' - ' + addressDetail : '') : 'Klik untuk mencari lokasi di peta dan mengisi detail'"></p>
                                    </div>
                                </div>
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-brand shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Tanggal</label>
                                <input type="date" name="date" x-model="date" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 text-sm font-bold text-ink focus:outline-none focus:border-ink focus:ring-1 focus:ring-ink">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Jam</label>
                                <select name="time" x-model="time" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 text-sm font-bold text-ink focus:outline-none focus:border-ink focus:ring-1 focus:ring-ink">
                                    <option value="" disabled selected>-- Pilih Waktu --</option>
                                    <option value="09:00">09:00 WIB</option>
                                    <option value="11:00">11:00 WIB</option>
                                    <option value="14:00">14:00 WIB</option>
                                    <option value="16:00">16:00 WIB</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="lg:col-span-4 hidden lg:block" :class="!vehicleSelected ? 'opacity-50 pointer-events-none' : ''">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 sticky top-28">
                <h3 class="font-black text-ink text-lg border-b border-gray-100 pb-4 mb-4">Ringkasan Booking</h3>
                
                <div class="space-y-4 mb-6">
                    <div class="flex justify-between items-start text-sm">
                        <span class="text-gray-500">Mobil</span>
                        <span class="font-bold text-ink text-right" x-text="vehicleSelected ? document.querySelector('input[name=vehicle_id]:checked').parentNode.querySelector('h4').innerText : '-'"></span>
                    </div>
                    
                    <div class="flex justify-between items-start text-sm">
                        <span class="text-gray-500">Layanan</span>
                        <span class="font-bold text-ink text-right" x-text="serviceType === 'berkala' ? serviceData[kmSelected].title : 'Perbaikan Umum'"></span>
                    </div>

                    <div class="flex justify-between items-start text-sm">
                        <span class="text-gray-500">Jadwal</span>
                        <span class="font-bold text-ink text-right" x-text="(date ? date : '-') + ' / ' + (time ? time : '-')"></span>
                    </div>
                </div>

                <div class="border-t border-gray-100 pt-4 mb-6 text-sm" x-show="serviceType === 'umum' && generalRepairs.length > 0">
                    <p class="text-xs font-bold text-gray-400 mb-2 uppercase">Pekerjaan:</p>
                    <ul class="space-y-2 text-gray-600">
                        <template x-for="repairKey in generalRepairs" :key="repairKey">
                            <li class="flex justify-between items-center">
                                <span x-text="repairOptions[repairKey].name"></span> 
                                <span class="font-medium" x-text="repairOptions[repairKey].price > 0 ? new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(repairOptions[repairKey].price) : '-'"></span>
                            </li>
                        </template>
                    </ul>
                </div>

                <div class="border-t border-gray-100 pt-4 mb-6 text-sm" x-show="serviceType === 'berkala' && (addonAC || addonEngine)">
                    <p class="text-xs font-bold text-gray-400 mb-2 uppercase">Layanan Tambahan:</p>
                    <ul class="space-y-2 text-gray-600">
                        <li x-show="addonAC" class="flex justify-between"><span>AC Care</span> <span class="font-medium">Rp350k</span></li>
                        <li x-show="addonEngine" class="flex justify-between"><span>Engine Treatment</span> <span class="font-medium">Rp400k</span></li>
                    </ul>
                </div>

                <div class="bg-gray-50 rounded-xl p-4 mb-6">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Estimasi Biaya</p>
                    <p class="text-2xl font-black text-ink" x-text="formattedPrice"></p>
                    <p class="text-[10px] text-gray-400 mt-2 leading-tight">*Belum termasuk biaya kunjungan teknisi dan part tambahan sesuai kondisi real.</p>
                </div>

                <button type="button" @click="document.getElementById('homeServiceForm').submit()" 
                        :disabled="!address || !date || !time || !vehicleSelected"
                        :class="(!address || !date || !time || !vehicleSelected) ? 'bg-gray-300 text-gray-500 cursor-not-allowed' : 'bg-ink hover:bg-ink-light text-white shadow-lg'" 
                        class="w-full font-bold py-4 rounded-xl transition-all flex items-center justify-center group">
                    KONFIRMASI SEKARANG
                    <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </div>
        </div>

    </div>

    <div class="lg:hidden fixed bottom-0 left-0 w-full bg-white border-t border-gray-200 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)] z-30 p-4 flex justify-between items-center" x-show="vehicleSelected" x-transition.opacity>
        <div>
            <p class="text-xs font-bold text-gray-500">Estimasi Biaya</p>
            <p class="text-lg font-black text-ink" x-text="formattedPrice"></p>
        </div>
        <button type="button" @click="document.getElementById('homeServiceForm').submit()" 
                :disabled="!address || !date || !time"
                :class="(!address || !date || !time) ? 'bg-gray-300 text-gray-500 cursor-not-allowed' : 'bg-ink text-white'" 
                class="font-bold px-6 py-3 rounded-xl text-sm">
            Lanjut
        </button>
    </div>

    <div x-show="showMapModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-0">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="showMapModal = false" x-transition.opacity></div>
        
        <div class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl overflow-hidden relative z-20 flex flex-col max-h-[90vh]"
             x-show="showMapModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-8"
             x-transition:enter-end="opacity-100 translate-y-0">
            
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 bg-gray-50 shrink-0">
                <h3 class="font-black text-ink text-base">PILIH LOKASI SERVIS</h3>
                <button @click="showMapModal = false" class="text-gray-400 hover:text-red-500 transition bg-white rounded-full p-1 shadow-sm">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            
            <div class="px-6 py-4 bg-white border-b border-gray-200 shrink-0">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm font-medium text-gray-600">Lokasi Saat ini: <span class="font-bold text-ink" x-text="isLocating ? 'Mencari...' : (tempAddress ? tempAddress.split(',')[0] : '-')"></span></p>
                    <button @click="trackLocation()" class="text-red-500 hover:text-red-700 transition p-1" title="Lacak Lokasi Saya">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </button>
                </div>
                
                <div class="relative">
                    <p class="text-xs text-gray-500 mb-1">Cari Alamat</p>
                    <div class="relative">
                        <input type="text" x-model="searchQuery" @input.debounce.500ms="searchAddress()" placeholder="Lokasi/Kecamatan/Kelurahan" class="w-full border-b border-gray-300 py-2 pl-2 pr-10 text-sm focus:outline-none focus:border-brand">
                        <div class="absolute right-0 top-2">
                            <svg x-show="!isSearching" class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            <svg x-show="isSearching" class="w-5 h-5 animate-spin text-brand" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        </div>
                    </div>

                    <ul x-show="searchResults.length > 0" class="absolute z-50 w-full bg-white border border-gray-200 rounded-b-lg shadow-lg max-h-48 overflow-y-auto mt-1">
                        <template x-for="item in searchResults" :key="item.place_id">
                            <li @click="selectSearchResult(item)" class="px-4 py-3 hover:bg-gray-50 cursor-pointer border-b border-gray-100 last:border-0 text-sm text-gray-700 line-clamp-2" x-text="item.display_name"></li>
                        </template>
                    </ul>
                </div>
            </div>

            <div class="relative w-full h-48 sm:h-64 bg-gray-200 shrink-0">
                <div id="mapContainer"></div>
            </div>

            <div class="p-6 overflow-y-auto">
                <div class="mb-4">
                    <label class="block text-xs font-bold text-red-500 mb-1">Alamat Lengkap *</label>
                    <div class="w-full bg-gray-50 border border-gray-200 rounded p-3 text-sm text-gray-600">
                        <span x-text="tempAddress ? tempAddress : 'Geser pin pada peta untuk menentukan alamat otomatis'"></span>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-xs font-bold text-red-500 mb-1">Detail Lainnya *</label>
                    <input type="text" x-model="addressDetail" placeholder="Detail lainnya (cth: Blok / Unit No, patokan)" class="w-full border-b border-gray-300 py-2 text-sm focus:outline-none focus:border-brand">
                </div>
                
                <button type="button" @click="address = tempAddress; showMapModal = false" :disabled="!tempAddress || !addressDetail" :class="(!tempAddress || !addressDetail) ? 'bg-gray-300 text-gray-500' : 'bg-gray-200 text-ink hover:bg-gray-300'" class="w-full py-3 rounded-lg text-sm font-black tracking-wide transition">
                    GUNAKAN ALAMAT
                </button>
            </div>
        </div>
    </div>

    <div x-show="showDetailModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-0">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="showDetailModal = false" x-transition.opacity></div>
        
        <div class="bg-white w-full max-w-lg rounded-2xl shadow-2xl overflow-hidden relative z-30 flex flex-col max-h-[90vh]" 
             x-show="showDetailModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-8"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 translate-y-8">
            
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 shrink-0">
                <h3 class="font-bold text-ink">DETAIL SERVIS BERKALA</h3>
                <button @click="showDetailModal = false" class="text-gray-400 hover:text-gray-800 transition p-1">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            
            <div class="flex items-center justify-between px-6 py-4 bg-gray-50 border-b border-gray-200 shrink-0">
                <button @click="prevKm()" :class="currentKmIndex === 0 ? 'text-gray-200 cursor-not-allowed' : 'text-gray-500 hover:text-brand transition'"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg></button>
                <span class="font-black text-brand text-sm tracking-widest" x-text="serviceData[kmSelected].title"></span>
                <button @click="nextKm()" :class="currentKmIndex === 2 ? 'text-gray-200 cursor-not-allowed' : 'text-gray-500 hover:text-brand transition'"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></button>
            </div>

            <div class="flex bg-gray-100 p-1 m-6 rounded-full shrink-0">
                <button @click="detailTab = 'diperiksa'" :class="detailTab === 'diperiksa' ? 'bg-white text-ink shadow-sm' : 'text-gray-500 hover:text-ink'" class="flex-1 py-2 text-sm font-bold rounded-full transition-all">Part Diperiksa</button>
                <button @click="detailTab = 'diganti'" :class="detailTab === 'diganti' ? 'bg-white text-ink shadow-sm' : 'text-gray-500 hover:text-ink'" class="flex-1 py-2 text-sm font-bold rounded-full transition-all">Part Diganti</button>
            </div>

            <div class="flex-1 overflow-y-auto px-6 pb-6">
                <ul x-show="detailTab === 'diperiksa'" class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-3">
                    <template x-for="item in serviceData[kmSelected].diperiksa" :key="item">
                        <li class="flex items-start text-sm font-medium text-gray-700">
                            <svg class="w-4 h-4 text-brand mr-2 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span x-text="item"></span>
                        </li>
                    </template>
                </ul>

                <div x-show="detailTab === 'diganti'" class="py-2">
                    <div x-show="serviceData[kmSelected].diganti.length === 0" class="text-center py-8">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <h4 class="font-bold text-ink mb-1">Cek & Setel Ulang</h4>
                        <p class="text-sm text-gray-500 max-w-xs mx-auto">Perawatan perdana ini berfokus pada pengecekan fungsi tanpa pergantian komponen.</p>
                    </div>

                    <div x-show="serviceData[kmSelected].diganti.length > 0" class="space-y-3">
                        <template x-for="part in serviceData[kmSelected].diganti" :key="part.name">
                            <div class="flex justify-between items-center bg-gray-50 p-3 rounded-lg border border-gray-100">
                                <span class="text-sm font-bold text-ink flex items-center">
                                    <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <span x-text="part.name"></span>
                                </span>
                                <span class="font-bold text-gray-600" x-text="new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(part.price)"></span>
                            </div>
                        </template>
                        <div class="flex justify-between items-center bg-brand/10 p-3 rounded-lg mt-2 border border-brand/20">
                            <span class="text-sm font-bold text-brand">Estimasi Biaya Jasa</span>
                            <span class="font-black text-brand" x-text="kmSelected === '10000' ? 'Rp300.000' : 'Rp400.000'"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection