@extends('layouts.app')

@section('title', 'Booking Servis Layanan Bengkel - Wijaya Motor')

@push('styles')
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
</style>
@endpush

@section('content')
<div class="bg-surface min-h-screen pb-20" x-data="{ 
          vehicleSelected: '', 
          serviceType: 'berkala', 
          kmSelected: '1000',
          showDetailModal: false,
          detailTab: 'diperiksa',
          addonSpooring: false,
          addonAC: false,
          addonEngine: false,
          branch: '',
          date: '',
          time: '',
          customComplaint: '',
          
          /* FITUR BARU: Reset Addons kalau pindah ke Servis Lainnya */
          init() {
              this.$watch('serviceType', (value) => {
                  if (value === 'lainnya') {
                      this.addonSpooring = false;
                      this.addonAC = false;
                      this.addonEngine = false;
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

          /* LOGIKA HARGA DIPERBAIKI */
          get totalPrice() {
              let total = 0;
              // Harga parts, jasa, dan addons HANYA dihitung kalau milih Berkala
              if(this.serviceType === 'berkala') {
                  let parts = this.serviceData[this.kmSelected].diganti;
                  parts.forEach(p => total += p.price);
                  if(this.kmSelected === '10000') total += 300000; 
                  if(this.kmSelected === '20000') total += 400000; 
                  
                  if(this.addonSpooring) total += 250000;
                  if(this.addonAC) total += 350000;
                  if(this.addonEngine) total += 400000;
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
            <span class="text-ink">Layanan Bengkel</span>
        </div>
    </div>

    <div class="bg-ink text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl md:text-4xl font-black mb-3 tracking-tight">Formulir Booking Servis</h1>
            <p class="text-gray-400 max-w-2xl text-sm md:text-base leading-relaxed">Lengkapi detail kendaraan dan jadwal servis Anda. Tim mekanik Wijaya Motor siap memberikan perawatan terbaik untuk mobil kesayangan Anda.</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 grid grid-cols-1 lg:grid-cols-12 gap-8 relative -mt-8">
        
        <div class="lg:col-span-8 space-y-6">
            
            <form action="{{ route('booking.store') }}" method="POST" id="bookingForm">
                @csrf
                <input type="hidden" name="estimasi_harga" :value="totalPrice">

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
                            <input type="radio" name="service_category" value="lainnya" class="peer sr-only radio-card-input" x-model="serviceType">
                            <div class="border-2 border-gray-100 rounded-xl p-5 transition-all bg-white h-full flex flex-col justify-center items-center text-center">
                                <div class="w-12 h-12 rounded-full bg-red-50 text-danger flex items-center justify-center mb-3">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </div>
                                <h4 class="font-bold text-ink text-lg">Servis Lain/Keluhan</h4>
                                <p class="text-xs text-gray-500 mt-1">Ganti part spesifik atau perbaikan masalah</p>
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
                                <label class="block text-sm font-black text-ink mb-3">Layanan Tambahan (Add-on)</label>
                                <div class="space-y-3">
                                    <label class="flex items-center cursor-pointer p-3 bg-white rounded-lg border border-gray-200 hover:border-gray-300 transition">
                                        <input type="checkbox" name="addons[]" value="spooring" x-model="addonSpooring" class="custom-checkbox w-5 h-5 rounded border-gray-300 text-ink focus:ring-ink">
                                        <span class="ml-3 text-sm text-gray-700 flex-1">Spooring & Balancing</span>
                                        <span class="text-xs font-bold text-gray-500">+Rp 250.000</span>
                                    </label>
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

                        <div x-show="serviceType === 'lainnya'" x-collapse>
                            <label class="block text-sm font-black text-ink mb-2">Deskripsi Keluhan</label>
                            <textarea name="custom_complaint" x-model="customComplaint" rows="4" placeholder="Contoh: AC kurang dingin, rem bunyi berdecit, ganti bohlam lampu depan..." class="w-full bg-white border border-gray-300 rounded-lg p-4 text-sm focus:outline-none focus:border-ink focus:ring-1 focus:ring-ink"></textarea>
                            <div class="flex justify-end mt-1">
                                <span class="text-xs text-gray-400" x-text="customComplaint.length + '/220 Karakter'"></span>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 mt-6 transition-opacity duration-300" :class="!vehicleSelected ? 'opacity-50 pointer-events-none' : ''">
                    <div class="flex items-center gap-4 mb-6 pb-4 border-b border-gray-100">
                        <div class="w-10 h-10 rounded-full bg-brand/10 text-brand flex items-center justify-center font-black text-lg">3</div>
                        <div>
                            <h2 class="text-xl font-black text-ink">Lokasi & Jadwal</h2>
                            <p class="text-xs text-gray-500 mt-1">Pilih waktu kedatangan di bengkel</p>
                        </div>
                    </div>

                    <div class="space-y-5">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Cabang Bengkel</label>
                            <select name="branch" x-model="branch" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 text-sm font-bold text-ink focus:outline-none focus:border-ink focus:ring-1 focus:ring-ink">
                                <option value="" disabled selected>-- Pilih Cabang --</option>
                                <option value="selatan">Wijaya Motor Jakarta Selatan</option>
                                <option value="pusat">Wijaya Motor Jakarta Pusat</option>
                            </select>
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
                                    <option value="08:00">08:00 WIB</option>
                                    <option value="10:00">10:00 WIB</option>
                                    <option value="13:00">13:00 WIB</option>
                                    <option value="15:00">15:00 WIB</option>
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
                        <span class="font-bold text-ink text-right" x-text="serviceType === 'berkala' ? serviceData[kmSelected].title : 'Servis Umum / Keluhan'"></span>
                    </div>

                    <div class="flex justify-between items-start text-sm">
                        <span class="text-gray-500">Jadwal</span>
                        <span class="font-bold text-ink text-right" x-text="(date ? date : '-') + ' / ' + (time ? time : '-')"></span>
                    </div>
                </div>

                <div class="border-t border-gray-100 pt-4 mb-6 text-sm" x-show="serviceType === 'berkala' && (addonSpooring || addonAC || addonEngine)">
                    <p class="text-xs font-bold text-gray-400 mb-2 uppercase">Layanan Tambahan:</p>
                    <ul class="space-y-2 text-gray-600">
                        <li x-show="addonSpooring" class="flex justify-between"><span>Spooring</span> <span class="font-medium">Rp250k</span></li>
                        <li x-show="addonAC" class="flex justify-between"><span>AC Care</span> <span class="font-medium">Rp350k</span></li>
                        <li x-show="addonEngine" class="flex justify-between"><span>Engine Treatment</span> <span class="font-medium">Rp400k</span></li>
                    </ul>
                </div>

                <div class="bg-gray-50 rounded-xl p-4 mb-6">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Estimasi Biaya</p>
                    <p class="text-2xl font-black text-ink" x-text="formattedPrice"></p>
                    <p class="text-[10px] text-gray-400 mt-2 leading-tight">*Harga estimasi jasa + part. Dapat berubah setelah pengecekan fisik oleh mekanik.</p>
                </div>

                <button type="button" @click="document.getElementById('bookingForm').submit()" 
                        :disabled="!branch || !date || !time || !vehicleSelected"
                        :class="(!branch || !date || !time || !vehicleSelected) ? 'bg-gray-300 text-gray-500 cursor-not-allowed' : 'bg-ink hover:bg-ink-light text-white shadow-lg'" 
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
        <button type="button" @click="document.getElementById('bookingForm').submit()" 
                :disabled="!branch || !date || !time"
                :class="(!branch || !date || !time) ? 'bg-gray-300 text-gray-500 cursor-not-allowed' : 'bg-ink text-white'" 
                class="font-bold px-6 py-3 rounded-xl text-sm">
            Lanjut
        </button>
    </div>

    <div x-show="showDetailModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-0">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="showDetailModal = false" x-transition.opacity></div>
        
        <div class="bg-white w-full max-w-lg rounded-2xl shadow-2xl overflow-hidden relative z-20 flex flex-col max-h-[90vh]" 
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