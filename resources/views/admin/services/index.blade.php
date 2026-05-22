@extends('layouts.admin')

@section('title', 'Master Servis - Wijaya Motor')
@section('header_title', 'Master Layanan Servis')

@section('content')

<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
    <div>
        <h2 class="text-xl font-bold text-slate-800">Daftar Layanan Servis</h2>
        <p class="text-slate-500 mt-1 text-sm">Kelola data jenis servis dan harga estimasi dasar bengkel.</p>
    </div>
    
    <button x-data @click="$dispatch('open-add-modal')" class="bg-[#0A192F] hover:bg-[#112a4f] text-white px-5 py-2.5 rounded-xl font-semibold flex items-center transition-all text-sm shadow-sm hover:shadow">
        <svg class="w-4 h-4 mr-2 text-[#FF8C00]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
        Tambah Servis Baru
    </button>
</div>

@if(session('success'))
<div class="bg-emerald-50 border border-emerald-100 text-emerald-600 px-4 py-3 rounded-xl mb-6 flex items-center text-sm font-medium shadow-sm">
    <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-2xl border border-slate-200/60 overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-100">
            <thead class="bg-slate-50">
                <tr>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama Servis</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Deskripsi Singkat</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Harga Estimasi (Rp)</th>
                    <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-50">
                @forelse($services as $service)
                <tr class="hover:bg-slate-50/50 transition-colors group">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-bold text-slate-800">{{ $service->name }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-slate-500 max-w-sm truncate" title="{{ $service->description }}">{{ $service->description ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-emerald-600 font-mono">Rp {{ number_format($service->price_estimate, 0, ',', '.') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex items-center justify-end space-x-2">
                            <button x-data @click="$dispatch('open-edit-modal', { 
                                        id: '{{ $service->id }}', 
                                        action: '{{ route('admin.services.update', $service->id) }}', 
                                        name: '{{ addslashes($service->name) }}', 
                                        price: '{{ intval($service->price_estimate) }}', 
                                        desc: '{{ addslashes($service->description) }}' 
                                    })" 
                                class="text-slate-400 hover:text-blue-600 p-2 rounded-lg hover:bg-blue-50 transition-colors focus:outline-none" title="Edit">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </button>
                            
                            <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus layanan {{ $service->name }}?');" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-slate-400 hover:text-rose-600 p-2 rounded-lg hover:bg-rose-50 transition-colors focus:outline-none" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-16 text-center">
                        <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-slate-100">
                            <svg class="w-8 h-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
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

    <div x-show="showAddModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-sm p-4">
        <div @click.away="showAddModal = false" x-transition class="bg-white w-full max-w-lg rounded-2xl shadow-xl overflow-hidden flex flex-col">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="text-lg font-bold text-slate-800">Tambah Layanan Servis</h3>
                <button @click="showAddModal = false" class="text-slate-400 hover:text-slate-600 transition-colors focus:outline-none">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="p-6">
                @if ($errors->any() && !old('_method'))
                    <div class="bg-rose-50 text-rose-600 p-4 rounded-xl mb-6 text-sm border border-rose-100 font-medium">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('admin.services.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-2">Nama Servis</label>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: Ganti Kampas Rem" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-[#FF8C00]/50 focus:border-[#FF8C00] outline-none transition-all placeholder-slate-300">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-2">Harga Estimasi (Rp)</label>
                        <input type="number" name="price_estimate" value="{{ old('price_estimate') }}" required placeholder="Contoh: 250000" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-[#FF8C00]/50 focus:border-[#FF8C00] outline-none transition-all placeholder-slate-300">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-2">Deskripsi Layanan</label>
                        <textarea name="description" rows="3" placeholder="Detail pengerjaan..." class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-[#FF8C00]/50 focus:border-[#FF8C00] outline-none transition-all resize-none placeholder-slate-300">{{ old('description') }}</textarea>
                    </div>
                    <div class="flex justify-end space-x-3 pt-4 border-t border-slate-100 mt-6">
                        <button type="button" @click="showAddModal = false" class="px-5 py-2.5 text-sm font-bold text-slate-500 hover:bg-slate-100 rounded-xl transition-colors">Batal</button>
                        <button type="submit" class="bg-[#0A192F] hover:bg-[#112a4f] text-white px-6 py-2.5 rounded-xl text-sm font-bold shadow-sm transition-colors">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div x-show="showEditModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-sm p-4">
        <div @click.away="showEditModal = false" x-transition class="bg-white w-full max-w-lg rounded-2xl shadow-xl overflow-hidden flex flex-col">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="text-lg font-bold text-slate-800">Edit Layanan Servis</h3>
                <button @click="showEditModal = false" class="text-slate-400 hover:text-slate-600 transition-colors focus:outline-none">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="p-6">
                @if ($errors->any() && old('_method') == 'PUT')
                    <div class="bg-rose-50 text-rose-600 p-4 rounded-xl mb-6 text-sm border border-rose-100 font-medium">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form x-bind:action="editAction" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-2">Nama Servis</label>
                        <input type="text" name="name" x-model="editName" required class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-2">Harga Estimasi (Rp)</label>
                        <input type="number" name="price_estimate" x-model="editPrice" required class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-2">Deskripsi Layanan</label>
                        <textarea name="description" x-model="editDesc" rows="3" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 outline-none transition-all resize-none"></textarea>
                    </div>
                    <div class="flex justify-end space-x-3 pt-4 border-t border-slate-100 mt-6">
                        <button type="button" @click="showEditModal = false" class="px-5 py-2.5 text-sm font-bold text-slate-500 hover:bg-slate-100 rounded-xl transition-colors">Batal</button>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl text-sm font-bold shadow-sm transition-colors">Update Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endpush