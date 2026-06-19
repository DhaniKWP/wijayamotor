@extends('layouts.app')

@section('title', 'Booking Servis Layanan Bengkel - Wijaya Motor')

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
            dbServices: {{ $services->toJson() }},
            vehicleSelected: '', 
            serviceType: 'berkala', 
            kmSelected: '1.000', 
            showDetailModal: false,
            detailTab: 'diperiksa',
            addonSpooring: false,
            addonAC: false,
            addonEngine: false,
            branch: '',
            date: '',
            sesi: '',
            quota: {
                pagi: { count: 0, is_full: false, label: 'Sesi Pagi (08:00 - 12:00)' },
                siang: { count: 0, is_full: false, label: 'Sesi Siang (13:00 - 16:00)' }
            },
            customComplaint: '',
            
            init() {
                this.$watch('serviceType', (value) => {
                    if (value === 'lainnya') {
                        this.addonSpooring = false;
                        this.addonAC = false;
                        this.addonEngine = false;
                    }
                });
            },
            
            checkQuota() {
                if (!this.date) return;
                fetch(`/api/check-quota?date=${this.date}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.pagi) {
                            this.quota = data;
                            if (this.quota.pagi.is_full && this.sesi === 'pagi') this.sesi = '';
                            if (this.quota.siang.is_full && this.sesi === 'siang') this.sesi = '';
                        }
                    })
                    .catch(err => console.error('Error fetching quota:', err));
            },
            
            get realServiceId() {
                if (this.serviceType === 'lainnya') {
                    let s = this.dbServices.find(x => x.name.toLowerCase().includes('lain'));
                    return s ? s.id : '';
                } else {
                    let s = this.dbServices.find(x => x.name.includes(this.kmSelected));
                    return s ? s.id : '';
                }
            },
            
            kmOptions: ['1.000', '10.000', '20.000', '30.000', '40.000', '50.000', '60.000', '70.000', '80.000', '90.000', '100.000'],
            get currentKmIndex() { return this.kmOptions.indexOf(this.kmSelected); },
            nextKm() { if(this.currentKmIndex < 10) this.kmSelected = this.kmOptions[this.currentKmIndex + 1]; },
            prevKm() { if(this.currentKmIndex > 0) this.kmSelected = this.kmOptions[this.currentKmIndex - 1]; },
            
            serviceData: {
                '1.000': {
                    title: 'SERVIS BERKALA 1.000 KM',
                    diperiksa: ['Aki/Battery', 'Chasis Kendaraan', 'Klakson', 'Kondisi Ban', 'Lampu-Lampu', 'Minyak Power Steering', 'Oli Mesin', 'Pedal Kopling', 'Sistem Pengereman', 'Tali Kipas', 'Wiper & Washer'],
                    diganti: []
                },
                '10.000': {
                    title: 'SERVIS BERKALA 10.000 KM',
                    diperiksa: ['Aki/Battery', 'Chasis Kendaraan', 'Klakson', 'Kondisi Ban', 'Lampu-Lampu', 'Minyak Power Steering', 'Sistem Pengereman', 'Sistem Pendingin', 'Saringan Udara'],
                    diganti: [{ name: 'Gasket', price: 15000 }, { name: 'Oli Mesin', price: 450000 }, { name: 'Saringan Oli', price: 85000 }]
                },
                '20.000': {
                    title: 'SERVIS BERKALA 20.000 KM',
                    diperiksa: ['Aki/Battery', 'Chasis Kendaraan', 'Freon', 'Klakson', 'Kondisi Ban', 'Lampu', 'Suspensi', 'Tali Kipas', 'Wiper'],
                    diganti: [{ name: 'Gasket', price: 15000 }, { name: 'Oli Mesin', price: 450000 }, { name: 'Saringan Oli', price: 85000 }, { name: 'Busi (Set)', price: 160000 }]
                },
                '30.000': {
                    title: 'SERVIS BERKALA 30.000 KM',
                    diperiksa: ['Aki/Battery', 'Chasis Kendaraan', 'Klakson', 'Kondisi Ban', 'Lampu-Lampu', 'Sistem Pengereman', 'Saringan Udara'],
                    diganti: [{ name: 'Gasket', price: 15000 }, { name: 'Oli Mesin', price: 450000 }, { name: 'Saringan Oli', price: 85000 }]
                },
                '40.000': {
                    title: 'SERVIS BERKALA 40.000 KM (SERVIS BESAR)',
                    diperiksa: ['Aki/Battery', 'Chasis Kendaraan', 'Freon', 'Klakson', 'Kondisi Ban', 'Suspensi', 'Tali Kipas', 'Wiper', 'Celah Katup'],
                    diganti: [{ name: 'Gasket', price: 15000 }, { name: 'Oli Mesin', price: 450000 }, { name: 'Saringan Oli', price: 85000 }, { name: 'Minyak Rem', price: 50000 }, { name: 'Filter Udara', price: 120000 }, { name: 'Oli Gardan/Transmisi', price: 300000 }]
                },
                '50.000': {
                    title: 'SERVIS BERKALA 50.000 KM',
                    diperiksa: ['Aki/Battery', 'Chasis Kendaraan', 'Klakson', 'Kondisi Ban', 'Lampu-Lampu', 'Sistem Pengereman', 'Saringan Udara'],
                    diganti: [{ name: 'Gasket', price: 15000 }, { name: 'Oli Mesin', price: 450000 }, { name: 'Saringan Oli', price: 85000 }]
                },
                '60.000': {
                    title: 'SERVIS BERKALA 60.000 KM',
                    diperiksa: ['Aki/Battery', 'Chasis Kendaraan', 'Freon', 'Klakson', 'Kondisi Ban', 'Lampu', 'Suspensi', 'Tali Kipas', 'Wiper'],
                    diganti: [{ name: 'Gasket', price: 15000 }, { name: 'Oli Mesin', price: 450000 }, { name: 'Saringan Oli', price: 85000 }, { name: 'Busi (Set)', price: 160000 }]
                },
                '70.000': {
                    title: 'SERVIS BERKALA 70.000 KM',
                    diperiksa: ['Aki/Battery', 'Chasis Kendaraan', 'Klakson', 'Kondisi Ban', 'Lampu-Lampu', 'Sistem Pengereman', 'Saringan Udara'],
                    diganti: [{ name: 'Gasket', price: 15000 }, { name: 'Oli Mesin', price: 450000 }, { name: 'Saringan Oli', price: 85000 }]
                },
                '80.000': {
                    title: 'SERVIS BERKALA 80.000 KM (SERVIS BESAR)',
                    diperiksa: ['Aki/Battery', 'Chasis Kendaraan', 'Freon', 'Klakson', 'Kondisi Ban', 'Suspensi', 'Tali Kipas', 'Wiper', 'Celah Katup'],
                    diganti: [{ name: 'Gasket', price: 15000 }, { name: 'Oli Mesin', price: 450000 }, { name: 'Saringan Oli', price: 85000 }, { name: 'Minyak Rem', price: 50000 }, { name: 'Filter Udara', price: 120000 }, { name: 'Oli Gardan/Transmisi', price: 300000 }]
                },
                '90.000': {
                    title: 'SERVIS BERKALA 90.000 KM',
                    diperiksa: ['Aki/Battery', 'Chasis Kendaraan', 'Klakson', 'Kondisi Ban', 'Lampu-Lampu', 'Sistem Pengereman', 'Saringan Udara'],
                    diganti: [{ name: 'Gasket', price: 15000 }, { name: 'Oli Mesin', price: 450000 }, { name: 'Saringan Oli', price: 85000 }]
                },
                '100.000': {
                    title: 'SERVIS BERKALA 100.000 KM',
                    diperiksa: ['Aki/Battery', 'Chasis Kendaraan', 'Freon', 'Klakson', 'Kondisi Ban', 'Lampu', 'Suspensi', 'Tali Kipas', 'Wiper'],
                    diganti: [{ name: 'Gasket', price: 15000 }, { name: 'Oli Mesin', price: 450000 }, { name: 'Saringan Oli', price: 85000 }, { name: 'Busi (Set)', price: 160000 }, { name: 'Coolant Radiator', price: 100000 }]
                }
            },

            // LOGIKA HARGA JASA DIAMBIL DARI DATABASE
            get serviceFee() {
                let s = this.dbServices.find(x => x.name.includes(this.kmSelected));
                return s && s.price_estimate ? parseFloat(s.price_estimate) : 0;
            },

            get totalPrice() {
                let total = 0;
                if(this.serviceType === 'berkala') {
                    let parts = this.serviceData[this.kmSelected].diganti;
                    parts.forEach(p => total += p.price);
                    
                    // Tambah harga jasa murni dari database
                    total += this.serviceFee;
                    
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
    </div><br>

    <div class="bg-ink text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl md:text-4xl font-black mb-3 tracking-tight">Formulir Booking Servis</h1>
            <p class="text-gray-400 max-w-2xl text-sm md:text-base leading-relaxed">Lengkapi detail kendaraan dan jadwal servis Anda. Tim mekanik Wijaya Motor siap memberikan perawatan terbaik untuk mobil kesayangan Anda.</p>
        </div>
    </div><br>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 grid grid-cols-1 lg:grid-cols-12 gap-8 relative -mt-8">
        
        <div class="lg:col-span-8 space-y-6">
            
            <form action="{{ route('booking.store') }}" method="POST" id="bookingForm">
                @csrf
                
                <input type="hidden" name="service_id" :value="realServiceId">
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
                                <option value="1.000">1.000 KM (Servis Perdana)</option>
                                <option value="10.000">10.000 KM (Servis Reguler)</option>
                                <option value="20.000">20.000 KM (Servis Reguler)</option>
                                <option value="30.000">30.000 KM (Servis Reguler)</option>
                                <option value="40.000">40.000 KM (Servis Besar)</option>
                                <option value="50.000">50.000 KM (Servis Reguler)</option>
                                <option value="60.000">60.000 KM (Servis Reguler)</option>
                                <option value="70.000">70.000 KM (Servis Reguler)</option>
                                <option value="80.000">80.000 KM (Servis Besar)</option>
                                <option value="90.000">90.000 KM (Servis Reguler)</option>
                                <option value="100.000">100.000 KM (Servis Reguler)</option>
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
                            <h2 class="text-xl font-black text-ink">Jadwal Kedatangan</h2>
                            <p class="text-xs text-gray-500 mt-1">Pilih waktu kedatangan Anda di bengkel</p>
                        </div>
                    </div>

                    <div class="space-y-5">
                        <input type="hidden" name="branch" value="pusat">
                        
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Tanggal</label>
                                <input type="date" name="date" x-model="date" @change="checkQuota" :min="new Date().toISOString().split('T')[0]" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 text-sm font-bold text-ink focus:outline-none focus:border-ink focus:ring-1 focus:ring-ink">
                            </div>
                            <div class="mt-2" x-show="date">
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Sesi Kedatangan</label>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <label class="relative cursor-pointer" :class="quota.pagi.is_full ? 'opacity-50' : ''">
                                        <input type="radio" name="sesi" value="pagi" class="peer sr-only" x-model="sesi" :disabled="quota.pagi.is_full" required>
                                        <div class="border-2 border-gray-100 rounded-xl p-4 transition-all" :class="quota.pagi.is_full ? 'bg-gray-100 cursor-not-allowed' : 'bg-white hover:border-brand peer-checked:border-brand peer-checked:bg-brand/5'">
                                            <div class="flex items-center justify-between mb-1">
                                                <h4 class="font-bold text-ink" x-text="quota.pagi.label"></h4>
                                                <span x-show="quota.pagi.is_full" class="text-[10px] bg-red-100 text-red-600 px-2 py-0.5 rounded font-bold uppercase">Penuh</span>
                                            </div>
                                            <p class="text-xs text-gray-500">Kuota Terisi: <span x-text="quota.pagi.count"></span>/4 Mobil</p>
                                        </div>
                                    </label>
                                    <label class="relative cursor-pointer" :class="quota.siang.is_full ? 'opacity-50' : ''">
                                        <input type="radio" name="sesi" value="siang" class="peer sr-only" x-model="sesi" :disabled="quota.siang.is_full" required>
                                        <div class="border-2 border-gray-100 rounded-xl p-4 transition-all" :class="quota.siang.is_full ? 'bg-gray-100 cursor-not-allowed' : 'bg-white hover:border-brand peer-checked:border-brand peer-checked:bg-brand/5'">
                                            <div class="flex items-center justify-between mb-1">
                                                <h4 class="font-bold text-ink" x-text="quota.siang.label"></h4>
                                                <span x-show="quota.siang.is_full" class="text-[10px] bg-red-100 text-red-600 px-2 py-0.5 rounded font-bold uppercase">Penuh</span>
                                            </div>
                                            <p class="text-xs text-gray-500">Kuota Terisi: <span x-text="quota.siang.count"></span>/4 Mobil</p>
                                        </div>
                                    </label>
                                </div>
                                <div class="mt-4 p-3 bg-blue-50 border border-blue-100 rounded-lg flex items-start">
                                    <svg class="w-5 h-5 text-blue-500 mr-2 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <p class="text-xs text-blue-700 leading-relaxed"><strong>Estimasi Pengerjaan: Sesuai antrean fisik.</strong><br>Sistem Sesi memastikan Anda datang di rentang waktu yang tidak padat. Waktu mulai dan selesai pengerjaan menyesuaikan hasil pengecekan mekanik di lokasi.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="lg:col-span-4 hidden lg:block" :class="!vehicleSelected ? 'opacity-50 pointer-events-none' : ''">
            <div class="bg-ink rounded-2xl shadow-2xl overflow-hidden sticky top-28 text-white border border-gray-800">
                <div class="p-5 bg-slate-800/50 border-b border-gray-700/50 flex items-center justify-between">
                    <h3 class="font-black text-white text-lg flex items-center">
                        <svg class="w-5 h-5 mr-2 text-danger" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        Ringkasan Booking
                    </h3>
                </div>
                
                <div class="p-6">
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between items-start text-sm border-b border-gray-700/50 pb-3">
                            <span class="text-gray-400">Mobil</span>
                            <span class="font-bold text-white text-right" x-text="vehicleSelected ? document.querySelector('input[name=vehicle_id]:checked').parentNode.querySelector('h4').innerText : '-'"></span>
                        </div>
                        
                        <div class="flex justify-between items-start text-sm border-b border-gray-700/50 pb-3">
                            <span class="text-gray-400">Layanan</span>
                            <span class="font-bold text-white text-right" x-text="serviceType === 'berkala' ? serviceData[kmSelected].title : 'Servis Umum / Keluhan'"></span>
                        </div>

                        <div class="flex justify-between items-start text-sm border-b border-gray-700/50 pb-3">
                            <span class="text-gray-400">Jadwal</span>
                            <span class="font-bold text-white text-right" x-text="(date ? date : '-') + ' / Sesi ' + (sesi ? (sesi === 'pagi' ? 'Pagi' : 'Siang') : '-')"></span>
                        </div>
                    </div>

                    <div class="mb-6 text-sm" x-show="serviceType === 'berkala' && (addonSpooring || addonAC || addonEngine)">
                        <p class="text-xs font-bold text-gray-500 mb-2 uppercase tracking-wider">Layanan Tambahan:</p>
                        <ul class="space-y-2 text-gray-300">
                            <li x-show="addonSpooring" class="flex justify-between items-center"><span class="flex items-center"><svg class="w-3 h-3 text-brand mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>Spooring</span> <span class="font-medium">Rp250k</span></li>
                            <li x-show="addonAC" class="flex justify-between items-center"><span class="flex items-center"><svg class="w-3 h-3 text-brand mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>AC Care</span> <span class="font-medium">Rp350k</span></li>
                            <li x-show="addonEngine" class="flex justify-between items-center"><span class="flex items-center"><svg class="w-3 h-3 text-brand mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>Engine Treatment</span> <span class="font-medium">Rp400k</span></li>
                        </ul>
                    </div>

                    <div class="bg-slate-800 rounded-xl p-5 mb-6 border border-slate-700 relative overflow-hidden group">
                        <div class="absolute -top-10 -right-10 w-32 h-32 bg-danger rounded-full blur-2xl opacity-20 group-hover:opacity-40 transition-opacity duration-500"></div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Estimasi Biaya</p>
                        <p class="text-3xl font-black text-white relative z-10" x-text="formattedPrice"></p>
                        <p class="text-[10px] text-gray-500 mt-2 leading-tight relative z-10">*Harga estimasi jasa + part. Dapat berubah setelah pengecekan fisik.</p>
                    </div>

                    <button type="button" @click="document.getElementById('bookingForm').submit()" 
                        :disabled="!date || !sesi || !vehicleSelected"
                        :class="(!date || !sesi || !vehicleSelected) ? 'bg-gray-700 text-gray-500 cursor-not-allowed' : 'bg-danger hover:bg-red-700 text-white shadow-[0_4px_15px_rgba(220,38,38,0.4)] transform hover:-translate-y-0.5'" 
                        class="w-full font-bold py-4 rounded-xl transition-all duration-300 flex items-center justify-center uppercase tracking-wide">
                        KONFIRMASI SEKARANG
                    </button>
                </div>
            </div>
        </div>

    </div>

    <div class="lg:hidden fixed bottom-0 left-0 w-full bg-white border-t border-gray-200 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)] z-30 p-4 flex justify-between items-center" x-show="vehicleSelected" x-transition.opacity>
        <div>
            <p class="text-xs font-bold text-gray-500">Estimasi Biaya</p>
            <p class="text-lg font-black text-ink" x-text="formattedPrice"></p>
        </div>
        <button type="button" @click="document.getElementById('bookingForm').submit()" 
                :disabled="!branch || !date || !sesi"
                :class="(!branch || !date || !sesi) ? 'bg-gray-300 text-gray-500 cursor-not-allowed' : 'bg-ink text-white'" 
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
                <button @click="nextKm()" :class="currentKmIndex === 10 ? 'text-gray-200 cursor-not-allowed' : 'text-gray-500 hover:text-brand transition'"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></button>
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
                        
                        <div x-show="serviceFee > 0" class="flex justify-between items-center bg-brand/10 p-3 rounded-lg mt-2 border border-brand/20">
                            <span class="text-sm font-bold text-brand">Estimasi Biaya Jasa Dasar</span>
                            <span class="font-black text-brand" x-text="new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(serviceFee)"></span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection