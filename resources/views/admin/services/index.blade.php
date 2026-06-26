@extends('layouts.admin')

@section('title', 'Master Servis - Wijaya Motor')
@section('header_title', 'Master Layanan Servis')

@section('content')

<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
    <div>
        <h2 class="text-xl font-bold text-slate-800">Daftar Layanan Servis</h2>
        <p class="text-slate-500 mt-1 text-sm font-medium">Kelola data jenis servis dan harga estimasi dasar bengkel.</p>
    </div>
    
    <button x-data @click="$dispatch('open-add-modal')" class="bg-danger hover:bg-danger/90 text-white px-5 py-2.5 rounded-xl font-bold flex items-center transition-all duration-200 text-xs tracking-wide shadow-sm active:scale-95 focus:outline-none">
        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
        TAMBAH SERVIS
    </button>
</div>

@if(session('success'))
<div class="bg-emerald-50 border border-emerald-100 text-emerald-600 px-4 py-3.5 rounded-lg mb-6 flex items-center text-sm font-semibold shadow-sm">
    <svg class="w-5 h-5 mr-2 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-xl border border-slate-200/60 overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-100">
            <thead class="bg-slate-100 border-b border-slate-200">
                <tr>
                    <th scope="col" class="px-6 py-4 text-left text-[10px] font-black text-slate-500 uppercase tracking-widest">Nama Servis</th>
                    <th scope="col" class="px-6 py-4 text-left text-[10px] font-black text-slate-500 uppercase tracking-widest">Deskripsi Layanan</th>
                    <th scope="col" class="px-6 py-4 text-left text-[10px] font-black text-slate-500 uppercase tracking-widest">Harga Jasa Dasar</th>
                    <th scope="col" class="px-6 py-4 text-right text-[10px] font-black text-slate-500 uppercase tracking-widest">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-50">
                @forelse($services as $service)
                <tr class="hover:bg-slate-50/50 transition-colors group">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            @if(str_contains(strtolower($service->name), 'berkala'))
                            <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center mr-3 shrink-0 border border-blue-100 shadow-sm">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            @else
                            <div class="w-9 h-9 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center mr-3 shrink-0 border border-orange-100 shadow-sm">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                </svg>
                            </div>
                            @endif
                            <div class="text-sm font-bold text-slate-800">{{ $service->name }}</div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-xs text-slate-500 max-w-sm truncate" title="{{ $service->description }}">{{ $service->description ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-bold text-slate-700 bg-slate-50 border border-slate-200/60 px-2.5 py-0.5 rounded-lg inline-block shadow-sm">Rp {{ number_format($service->price_estimate, 0, ',', '.') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex items-center justify-end space-x-1">
                            <button x-data @click="$dispatch('open-edit-modal', { 
                                        id: '{{ $service->id }}', 
                                        action: '{{ route('admin.services.update', $service->id) }}', 
                                        name: '{{ addslashes($service->name) }}', 
                                        price: '{{ intval($service->price_estimate) }}', 
                                        desc: '{{ addslashes($service->description) }}' 
                                    })" 
                                class="text-blue-600 hover:text-white p-2 rounded-lg hover:bg-blue-600 transition-all duration-200 focus:outline-none border border-transparent hover:border-blue-700 hover:shadow-sm" title="Edit Layanan">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </button>
                            
                            <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus layanan {{ $service->name }}?');" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-danger hover:text-white p-2 rounded-lg hover:bg-danger transition-all duration-200 focus:outline-none border border-transparent hover:border-red-700 hover:shadow-sm" title="Hapus Layanan">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center">
                        <div class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-3 border border-slate-100 text-slate-350">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        </div>
                        <p class="text-sm font-bold text-slate-600">Belum ada data Master Servis</p>
                        <p class="text-xs mt-1 text-slate-400">Silakan klik tombol "Tambah Servis Baru" di atas.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('modals')
<div x-data="{ 
        showAddModal: {{ $errors->any() && !old('_method') ? 'true' : 'false' }}, 
        showEditModal: {{ $errors->any() && old('_method') == 'PUT' ? 'true' : 'false' }},
        editAction: '{{ old('_method') == 'PUT' ? url()->previous() : '' }}',
        editName: '{{ old('name') }}',
        editPrice: '{{ old('price_estimate') }}',
        editDesc: '{{ old('description') }}'
    }" 
    @open-add-modal.window="showAddModal = true"
    @open-edit-modal.window="showEditModal = true; editAction = $event.detail.action; editName = $event.detail.name; editPrice = $event.detail.price; editDesc = $event.detail.desc;">

    <!-- Add Service Modal -->
    <div x-show="showAddModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4" x-transition.opacity>
        <div @click.away="showAddModal = false" x-show="showAddModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="bg-white w-full max-w-lg rounded-xl shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-ink to-[#112a4f] text-white px-6 py-5 border-b border-white/5 flex justify-between items-center shrink-0">
                <h3 class="text-base font-extrabold text-white tracking-tight uppercase flex items-center gap-2">
                    <svg class="w-5 h-5 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Tambah Layanan Servis
                </h3>
                <button @click="showAddModal = false" class="text-slate-400 hover:text-white hover:bg-white/10 transition-all duration-200 rounded-full p-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="p-6 overflow-y-auto custom-scrollbar flex-1 bg-slate-50/20">
                @if ($errors->any() && !old('_method'))
                    <div class="bg-rose-50 text-rose-600 p-4 rounded-lg mb-6 text-sm border border-rose-100 font-medium">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('admin.services.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Nama Servis (Standard Template)</label>
                        <select name="name" required class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-3 text-sm font-semibold focus:bg-white focus:ring-2 focus:ring-brand/40 focus:border-brand outline-none transition-all duration-200 text-slate-800 cursor-pointer">
                            <option value="" disabled selected>-- Pilih Jenis Servis --</option>
                            <option value="Servis Berkala 1.000 KM">Servis Berkala 1.000 KM</option>
                            <option value="Servis Berkala 10.000 KM">Servis Berkala 10.000 KM</option>
                            <option value="Servis Berkala 20.000 KM">Servis Berkala 20.000 KM</option>
                            <option value="Servis Berkala 30.000 KM">Servis Berkala 30.000 KM</option>
                            <option value="Servis Berkala 40.000 KM">Servis Berkala 40.000 KM</option>
                            <option value="Servis Berkala 50.000 KM">Servis Berkala 50.000 KM</option>
                            <option value="Servis Berkala 60.000 KM">Servis Berkala 60.000 KM</option>
                            <option value="Servis Berkala 70.000 KM">Servis Berkala 70.000 KM</option>
                            <option value="Servis Berkala 80.000 KM">Servis Berkala 80.000 KM</option>
                            <option value="Servis Berkala 90.000 KM">Servis Berkala 90.000 KM</option>
                            <option value="Servis Berkala 100.000 KM">Servis Berkala 100.000 KM</option>
                            <option value="Servis Lainnya">Servis Lainnya / Keluhan Umum</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Harga Estimasi Jasa Dasar (Rp)</label>
                        <input type="number" name="price_estimate" value="{{ old('price_estimate') }}" required placeholder="Contoh: 300000" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-3 text-sm font-semibold focus:bg-white focus:ring-2 focus:ring-brand/40 focus:border-brand outline-none transition-all duration-200 placeholder-slate-300 text-slate-800">
                    </div>
                    <div>
                        <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Deskripsi Layanan</label>
                        <textarea name="description" rows="3" placeholder="Jelaskan detail cakupan pengecekan & pengerjaan servis ini..." class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-3 text-sm font-semibold focus:bg-white focus:ring-2 focus:ring-brand/40 focus:border-brand outline-none transition-all duration-200 resize-none placeholder-slate-300 text-slate-800">{{ old('description') }}</textarea>
                    </div>
                    <div class="flex justify-end space-x-3 pt-4 border-t border-slate-100 mt-6 shrink-0">
                        <button type="button" @click="showAddModal = false" class="px-4 py-2 text-xs font-bold text-slate-500 hover:bg-slate-100 rounded-lg transition-colors">Batal</button>
                        <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white px-5 py-2 rounded-lg text-xs font-black shadow-md shadow-slate-900/20 transition-all duration-200 active:scale-95 focus:outline-none">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Service Modal -->
    <div x-show="showEditModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4" x-transition.opacity>
        <div @click.away="showEditModal = false" x-show="showEditModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="bg-white w-full max-w-lg rounded-xl shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-ink to-[#112a4f] text-white px-6 py-5 border-b border-white/5 flex justify-between items-center shrink-0">
                <h3 class="text-base font-extrabold text-white tracking-tight uppercase flex items-center gap-2">
                    <svg class="w-5 h-5 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Layanan Servis
                </h3>
                <button @click="showEditModal = false" class="text-slate-400 hover:text-white hover:bg-white/10 transition-all duration-200 rounded-full p-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="p-6 overflow-y-auto custom-scrollbar flex-1 bg-slate-50/20">
                @if ($errors->any() && old('_method') == 'PUT')
                    <div class="bg-rose-50 text-rose-600 p-4 rounded-lg mb-6 text-sm border border-rose-100 font-medium">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form x-bind:action="editAction" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Nama Servis</label>
                        <select name="name" x-model="editName" required class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-3 text-sm font-semibold focus:bg-white focus:ring-2 focus:ring-brand/40 focus:border-brand outline-none transition-all duration-200 text-slate-800 cursor-pointer">
                            <option value="Servis Berkala 1.000 KM">Servis Berkala 1.000 KM</option>
                            <option value="Servis Berkala 10.000 KM">Servis Berkala 10.000 KM</option>
                            <option value="Servis Berkala 20.000 KM">Servis Berkala 20.000 KM</option>
                            <option value="Servis Berkala 30.000 KM">Servis Berkala 30.000 KM</option>
                            <option value="Servis Berkala 40.000 KM">Servis Berkala 40.000 KM</option>
                            <option value="Servis Berkala 50.000 KM">Servis Berkala 50.000 KM</option>
                            <option value="Servis Berkala 60.000 KM">Servis Berkala 60.000 KM</option>
                            <option value="Servis Berkala 70.000 KM">Servis Berkala 70.000 KM</option>
                            <option value="Servis Berkala 80.000 KM">Servis Berkala 80.000 KM</option>
                            <option value="Servis Berkala 90.000 KM">Servis Berkala 90.000 KM</option>
                            <option value="Servis Berkala 100.000 KM">Servis Berkala 100.000 KM</option>
                            <option value="Servis Lainnya">Servis Lainnya / Keluhan Umum</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Harga Estimasi Jasa Dasar (Rp)</label>
                        <input type="number" name="price_estimate" x-model="editPrice" required class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-3 text-sm font-semibold focus:bg-white focus:ring-2 focus:ring-brand/40 focus:border-brand outline-none transition-all duration-200 text-slate-800">
                    </div>
                    <div>
                        <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Deskripsi Layanan</label>
                        <textarea name="description" x-model="editDesc" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-3 text-sm font-semibold focus:bg-white focus:ring-2 focus:ring-brand/40 focus:border-brand outline-none transition-all duration-200 resize-none text-slate-800"></textarea>
                    </div>
                    <div class="flex justify-end space-x-3 pt-4 border-t border-slate-100 mt-6 shrink-0">
                        <button type="button" @click="showEditModal = false" class="px-4 py-2 text-xs font-bold text-slate-500 hover:bg-slate-100 rounded-lg transition-colors">Batal</button>
                        <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white px-5 py-2 rounded-lg text-xs font-black shadow-md shadow-slate-900/20 transition-all duration-200 active:scale-95 focus:outline-none">Update Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endpush