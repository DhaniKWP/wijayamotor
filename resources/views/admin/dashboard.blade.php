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

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200/60 flex items-center space-x-4">
        <div class="w-12 h-12 rounded-full bg-amber-100 flex items-center justify-center text-amber-600">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">Menunggu Konfirmasi</p>
            <h3 class="text-2xl font-black text-slate-800">12</h3>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200/60 flex items-center space-x-4">
        <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        </div>
        <div>
            <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">Jadwal Hari Ini</p>
            <h3 class="text-2xl font-black text-slate-800">5</h3>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200/60 flex items-center space-x-4">
        <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center text-purple-600">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/></svg>
        </div>
        <div>
            <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">Sedang Dikerjakan</p>
            <h3 class="text-2xl font-black text-slate-800">3</h3>
        </div>
    </div>

    <div class="bg-primary p-6 rounded-2xl shadow-lg relative overflow-hidden group">
        <div class="absolute -right-10 -top-10 w-32 h-32 bg-white/5 rounded-full blur-2xl"></div>
        <p class="text-slate-300 text-xs font-bold uppercase tracking-wider mb-1">Selesai Bulan Ini</p>
        <h3 class="text-3xl font-black text-white">48</h3>
    </div>
</div>

<div class="bg-white rounded-2xl border border-slate-200/60 overflow-hidden shadow-sm">
    <div class="p-6 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-bold text-slate-800">Daftar Antrean Servis</h2>
        </div>
        
        <div class="flex space-x-2">
            <select class="text-sm border-slate-200 rounded-lg focus:ring-secondary focus:border-secondary py-2 pl-3 pr-10 text-slate-600 font-medium bg-slate-50">
                <option value="">Semua Status</option>
                <option value="pending">Pending</option>
                <option value="process">Dikerjakan</option>
                <option value="done">Selesai</option>
            </select>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-100">
            <thead class="bg-slate-50/50">
                <tr>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Waktu & Tipe</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Pelanggan & Kendaraan</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Layanan</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-50">
                
                {{-- Data Dummy Visualisasi, nanti ganti pakai @foreach($bookings as $booking) --}}
                
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-bold text-slate-800">19 Mei 2026</div>
                        <div class="text-xs text-slate-500 mt-1">10:00 WIB</div>
                        <span class="inline-flex items-center px-2 py-0.5 mt-2 rounded text-[10px] font-bold bg-slate-100 text-slate-600">
                            BENGKEL
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-bold text-slate-800">Raka Pratama</div>
                        <div class="text-xs text-secondary font-bold mt-1 tracking-wider">B 1234 XYZ</div>
                        <div class="text-xs text-slate-500 mt-0.5">Toyota Innova Reborn (2022)</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-semibold text-slate-700">Servis Berkala 40.000 KM</div>
                        <div class="text-xs text-slate-500 mt-1 italic">"Rem agak bunyi decit"</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1.5"></span> Menunggu
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <button class="bg-primary hover:bg-[#112a4f] text-white px-4 py-2 rounded-lg text-xs font-bold shadow-sm transition">Proses Kendaraan</button>
                    </td>
                </tr>

                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-bold text-slate-800">19 Mei 2026</div>
                        <div class="text-xs text-slate-500 mt-1">13:00 WIB</div>
                        <span class="inline-flex items-center px-2 py-0.5 mt-2 rounded text-[10px] font-bold bg-purple-50 text-purple-600 border border-purple-100">
                            HOME SERVICE
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-bold text-slate-800">Dhani Wardana</div>
                        <div class="text-xs text-secondary font-bold mt-1 tracking-wider">A 9999 AA</div>
                        <div class="text-xs text-slate-500 mt-0.5">Honda CR-V (2020)</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-semibold text-slate-700">Ganti Aki & Pengecekan Kelistrikan</div>
                        <div class="text-xs text-slate-500 mt-1 line-clamp-1" title="Jl. Sudirman No. 12 (Patokan minimarket)">Jl. Sudirman No. 12...</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-1.5"></span> Dikonfirmasi
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <button class="bg-primary hover:bg-[#112a4f] text-white px-4 py-2 rounded-lg text-xs font-bold shadow-sm transition">Proses Kendaraan</button>
                    </td>
                </tr>

                <tr class="hover:bg-slate-50/50 transition-colors bg-slate-50/30">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-bold text-slate-800">19 Mei 2026</div>
                        <div class="text-xs text-slate-500 mt-1">09:00 WIB</div>
                        <span class="inline-flex items-center px-2 py-0.5 mt-2 rounded text-[10px] font-bold bg-slate-100 text-slate-600">
                            BENGKEL
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-bold text-slate-800">Budi Santoso</div>
                        <div class="text-xs text-secondary font-bold mt-1 tracking-wider">D 4567 TY</div>
                        <div class="text-xs text-slate-500 mt-0.5">Mitsubishi Xpander (2023)</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-semibold text-slate-700">Spooring & Balancing</div>
                        <div class="text-xs text-slate-500 mt-1">-</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-purple-100 text-purple-700 animate-pulse">
                            <span class="w-1.5 h-1.5 rounded-full bg-purple-500 mr-1.5"></span> Sedang Dikerjakan
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <button class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-xs font-bold shadow-sm transition">Selesaikan & Buat Tagihan</button>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
</div>

@endsection