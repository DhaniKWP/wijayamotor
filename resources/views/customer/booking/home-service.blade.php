@extends('layouts.app')

@section('title', 'Booking Home Service - Wijaya Motor')

@push('styles')
<style>
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
          showMapModal: false,
          date: '',
          time: '',
          
          init() {
              this.$watch('serviceType', (value) => {
                  if (value === 'umum') {
                      this.addonAC = false;
                      this.addonEngine = false;
                  } else {
                      this.generalRepairs = [];
                  }
              });
          },
          
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
                  this.generalRepairs.forEach(key => {
                      total += this.repairOptions[key].price;
                  });
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

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                    <div class="flex items-center gap-4 mb-6 pb-4 border-b border-gray-100">
                        <div class="w-10 h-10 rounded-full bg-brand/10 text-brand flex items-center justify-center font-black text-lg">1</div>
                        <div>
                            <h2 class="text-xl font-black text-ink">Pilih Kendaraan</h2>
                            <p class="text-xs text-gray-500 mt-1">Pilih kendaraan yang akan diservis di lokasi Anda</p>
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
                            <p class="text-xs text-gray-500 mt-1">Servis apa yang dibutuhkan mobil Anda?</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <label class="relative cursor-pointer">
                            <input type="radio" name="service_category" value="berkala" class="peer sr-only radio-card-input" x-model="serviceType">
                            <div class="border-2 border-gray-100 rounded-xl p-5 transition-all bg-white flex flex-col">
                                <h4 class="font-bold text-ink text-lg mb-1">Servis Berkala</h4>
                                <p class="text-xs text-gray-500 mb-3">Perawatan rutin sesuai jadwal KM</p>
                                <button type="button" @click.prevent="showDetailModal = true; serviceType='berkala'" class="text-sm font-bold text-brand hover:underline mt-auto self-start text-left">Lihat Detail Servis</button>
                            </div>
                        </label>

                        <label class="relative cursor-pointer">
                            <input type="radio" name="service_category" value="umum" class="peer sr-only radio-card-input" x-model="serviceType">
                            <div class="border-2 border-gray-100 rounded-xl p-5 transition-all bg-white flex flex-col">
                                <h4 class="font-bold text-ink text-lg mb-1">Perbaikan Umum</h4>
                                <p class="text-xs text-gray-500 mb-3">Ganti part spesifik & Pengecekan</p>
                            </div>
                        </label>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-5 border border-gray-100">
                        
                        <div x-show="serviceType === 'berkala'" x-collapse>
                            <label class="block text-sm font-black text-ink mb-2">Jarak Tempuh (KM)</label>
                            <select name="km_service" x-model="kmSelected" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-ink focus:ring-1 focus:ring-ink">
                                <option value="1000">1.000 KM (Servis Perdana)</option>
                                <option value="10000">10.000 KM (Servis Reguler)</option>
                                <option value="20000">20.000 KM (Servis Besar)</option>
                            </select>

                            <div class="mt-6 border-t border-gray-200 pt-5">
                                <label class="block text-sm font-black text-ink mb-3">Layanan Tambahan di Tempat (Opsional)</label>
                                <div class="space-y-3">
                                    <label class="flex items-center cursor-pointer p-3 bg-white rounded-lg border border-gray-200 hover:border-gray-300 transition">
                                        <input type="checkbox" name="addons[]" value="ac" x-model="addonAC" class="custom-checkbox w-5 h-5 rounded border-gray-300 text-ink">
                                        <span class="ml-3 text-sm text-gray-700 flex-1">AC Superlight Care</span>
                                        <span class="text-xs font-bold text-gray-500">+Rp 350.000</span>
                                    </label>
                                    <label class="flex items-center cursor-pointer p-3 bg-white rounded-lg border border-gray-200 hover:border-gray-300 transition">
                                        <input type="checkbox" name="addons[]" value="engine" x-model="addonEngine" class="custom-checkbox w-5 h-5 rounded border-gray-300 text-ink">
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
                            <h2 class="text-xl font-black text-ink">Lokasi Servis & Waktu</h2>
                            <p class="text-xs text-gray-500 mt-1">Tentukan alamat kunjungan mekanik kami</p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Alamat Servis <span class="text-red-500">*</span></label>
                            
                            <input type="hidden" name="alamat_lengkap" :value="address">

                            <div @click="showMapModal = true" class="w-full bg-gray-50 border border-gray-200 hover:border-brand rounded-lg p-4 cursor-pointer transition flex items-center justify-between group">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-red-100 text-red-600 rounded-full flex items-center justify-center mr-4">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    </div>
                                    <div>
                                        <p class="font-bold text-ink text-sm mb-1" x-text="address ? 'Lokasi Tersimpan' : 'Pilih Lokasi & Alamat'"></p>
                                        <p class="text-xs text-gray-500 line-clamp-1" x-text="address ? address : 'Klik untuk menentukan lokasi di peta'"></p>
                                    </div>
                                </div>
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-brand transition" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Tanggal Kunjungan</label>
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
                <h3 class="font-black text-ink text-lg border-b border-gray-100 pb-4 mb-4">Ringkasan Home Service</h3>
                
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

                <div class="bg-gray-50 rounded-xl p-4 mb-6">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Estimasi Biaya</p>
                    <p class="text-2xl font-black text-ink" x-text="formattedPrice"></p>
                    <p class="text-[10px] text-gray-400 mt-2 leading-tight">*Belum termasuk biaya kunjungan (jika ada) dan *part* tambahan di luar estimasi.</p>
                </div>

                <button type="button" @click="document.getElementById('homeServiceForm').submit()" 
                        :disabled="!address || !date || !time || !vehicleSelected"
                        :class="(!address || !date || !time || !vehicleSelected) ? 'bg-gray-300 text-gray-500 cursor-not-allowed' : 'bg-brand hover:bg-brand-dark text-white shadow-lg'" 
                        class="w-full font-bold py-4 rounded-xl transition-all flex items-center justify-center group">
                    PESAN HOME SERVICE
                    <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </div>
        </div>
    </div>

    <div x-show="showMapModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-0">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="showMapModal = false" x-transition.opacity></div>
        
        <div class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl overflow-hidden relative z-20 flex flex-col"
             x-show="showMapModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-8"
             x-transition:enter-end="opacity-100 translate-y-0">
            
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="font-black text-ink text-lg uppercase tracking-wide">PILIH LOKASI SERVIS</h3>
                <button @click="showMapModal = false" class="text-gray-400 hover:text-red-500 transition bg-white rounded-full p-1 shadow-sm">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            
            <div class="relative w-full h-64 bg-gray-200">
                <img src="https://images.unsplash.com/photo-1524661135-423995f22d0b?auto=format&fit=crop&w=1200&q=80" alt="Map" class="w-full h-full object-cover opacity-60">
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <div class="w-12 h-12 text-red-600 animate-bounce">
                        <svg fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                    </div>
                    <div class="w-4 h-1.5 bg-black/30 rounded-[100%] blur-[1px]"></div>
                </div>
            </div>

            <div class="p-6">
                <label class="block text-sm font-bold text-ink mb-2">Alamat Lengkap <span class="text-red-500">*</span></label>
                <textarea x-model="tempAddress" rows="3" placeholder="Contoh: Jl. Sudirman No 12, RT 01/02 (Rumah Pagar Hitam)..." class="w-full bg-gray-50 border border-gray-300 rounded-lg p-3 text-sm focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand"></textarea>
                
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" @click="showMapModal = false" class="px-6 py-2.5 border border-gray-300 rounded-lg text-sm font-bold text-gray-600 hover:bg-gray-50">Batal</button>
                    <button type="button" @click="address = tempAddress; showMapModal = false" class="px-6 py-2.5 bg-brand hover:bg-brand-dark text-white rounded-lg text-sm font-bold shadow-md">Simpan Lokasi</button>
                </div>
            </div>
        </div>
    </div>

    </div>
@endsection