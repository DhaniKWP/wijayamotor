@extends('layouts.admin')

@section('title', 'Kelola Sparepart - Wijaya Motor')
@section('header_title', 'Gudang Sparepart')

@section('content')

<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
    <div>
        <h2 class="text-xl font-bold text-slate-800">Daftar Stok Sparepart</h2>
        <p class="text-slate-500 mt-1 text-sm">Kelola barang, harga jual, dan stok gudang bengkel.</p>
    </div>
    
    <button x-data @click="$dispatch('open-add-modal')" class="bg-[#0A192F] hover:bg-[#112a4f] text-white px-5 py-2.5 rounded-xl font-semibold flex items-center transition-all text-sm shadow-sm hover:shadow">
        <svg class="w-4 h-4 mr-2 text-[#FF8C00]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
        Stok Baru
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
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Produk</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Harga Jual</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status Stok</th>
                    <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-50">
                @forelse($spareparts as $item)
                <tr class="hover:bg-slate-50/50 transition-colors group">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-14 w-14 bg-slate-50 rounded-xl overflow-hidden border border-slate-100">
                                @if($item->image)
                                    <img class="h-14 w-14 object-cover" src="{{ asset('uploads/spareparts/'.$item->image) }}" alt="{{ $item->name }}">
                                @else
                                    <div class="h-14 w-14 flex items-center justify-center text-slate-300">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-bold text-slate-800">{{ $item->name }}</div>
                                <div class="text-xs text-slate-500 mt-0.5 max-w-[200px] truncate" title="{{ $item->description }}">{{ $item->description ?? 'Tidak ada deskripsi' }}</div>
                            </div>
                        </div>
                    </td>
                    
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-emerald-600 font-mono">Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($item->stock > 5)
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span>
                                {{ $item->stock }} Unit
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-rose-50 text-rose-700 border border-rose-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500 mr-1.5 animate-pulse"></span>
                                Sisa {{ $item->stock }}
                            </span>
                        @endif
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex items-center justify-end space-x-2">
                            <button x-data @click="$dispatch('open-edit-modal', { 
                                        action: '{{ route('admin.spareparts.update', $item->id) }}', 
                                        name: '{{ addslashes($item->name) }}', 
                                        price: '{{ intval($item->price) }}', 
                                        stock: '{{ $item->stock }}',
                                        desc: '{{ addslashes($item->description) }}' 
                                    })" 
                                class="text-slate-400 hover:text-blue-600 p-2 rounded-lg hover:bg-blue-50 transition-colors focus:outline-none" title="Edit">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </button>
                            
                            <form action="{{ route('admin.spareparts.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin bro mau hapus {{ $item->name }} secara permanen?');" class="inline-block">
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
                            <svg class="w-8 h-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                        <p class="text-sm font-bold text-slate-600">Gudang masih kosong</p>
                        <p class="text-xs mt-1 text-slate-400">Silakan tambahkan data sparepart pertama Anda.</p>
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
        editPrice: '{{ old('price') }}',
        editStock: '{{ old('stock') }}',
        editDesc: '{{ old('description') }}'
    }" 
    @open-add-modal.window="showAddModal = true"
    @open-edit-modal.window="showEditModal = true; editAction = $event.detail.action; editName = $event.detail.name; editPrice = $event.detail.price; editStock = $event.detail.stock; editDesc = $event.detail.desc;">

    <div x-show="showAddModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-sm p-4">
        <div @click.away="showAddModal = false" x-transition class="bg-white w-full max-w-lg rounded-2xl shadow-xl overflow-hidden flex flex-col max-h-[90vh]">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50 shrink-0">
                <h3 class="text-lg font-bold text-slate-800">Input Barang Baru</h3>
                <button @click="showAddModal = false" class="text-slate-400 hover:text-slate-600 transition-colors focus:outline-none">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            
            <div class="overflow-y-auto p-6">
                @if ($errors->any() && !old('_method'))
                    <div class="bg-rose-50 text-rose-600 p-4 rounded-xl mb-6 text-sm border border-rose-100 font-medium">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <form action="{{ route('admin.spareparts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-2">Nama Barang</label>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: Ban Bridgestone R15" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-[#FF8C00]/50 focus:border-[#FF8C00] outline-none transition-all placeholder-slate-300">
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-2">Harga Jual (Rp)</label>
                            <input type="number" name="price" value="{{ old('price') }}" required placeholder="Contoh: 850000" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-[#FF8C00]/50 focus:border-[#FF8C00] outline-none transition-all placeholder-slate-300">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-2">Stok Awal</label>
                            <input type="number" name="stock" value="{{ old('stock') }}" required placeholder="Contoh: 10" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-[#FF8C00]/50 focus:border-[#FF8C00] outline-none transition-all placeholder-slate-300">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-2">Deskripsi Produk</label>
                        <textarea name="description" rows="3" placeholder="Jelaskan spesifikasi barang..." class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-[#FF8C00]/50 focus:border-[#FF8C00] outline-none transition-all resize-none placeholder-slate-300">{{ old('description') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-2">Foto Produk</label>
                        <div class="border border-dashed border-slate-300 rounded-xl p-4 text-center hover:bg-slate-50 transition-colors">
                            <input type="file" name="image" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 cursor-pointer">
                        </div>
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
        <div @click.away="showEditModal = false" x-transition class="bg-white w-full max-w-lg rounded-2xl shadow-xl overflow-hidden flex flex-col max-h-[90vh]">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50 shrink-0">
                <h3 class="text-lg font-bold text-slate-800">Edit Data Barang</h3>
                <button @click="showEditModal = false" class="text-slate-400 hover:text-slate-600 transition-colors focus:outline-none">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            
            <div class="overflow-y-auto p-6">
                @if ($errors->any() && old('_method') == 'PUT')
                    <div class="bg-rose-50 text-rose-600 p-4 rounded-xl mb-6 text-sm border border-rose-100 font-medium">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form x-bind:action="editAction" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-2">Nama Barang</label>
                        <input type="text" name="name" x-model="editName" required class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500/50 outline-none transition-all">
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-2">Harga Jual (Rp)</label>
                            <input type="number" name="price" x-model="editPrice" required class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500/50 outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-2">Stok Tersedia</label>
                            <input type="number" name="stock" x-model="editStock" required class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500/50 outline-none transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-2">Deskripsi Produk</label>
                        <textarea name="description" x-model="editDesc" rows="3" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500/50 outline-none transition-all resize-none"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-2">Ganti Foto (Opsional)</label>
                        <div class="border border-dashed border-slate-300 rounded-xl p-4 text-center hover:bg-slate-50 transition-colors">
                            <input type="file" name="image" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                        </div>
                        <p class="text-[10px] text-slate-400 mt-1">*Kosongkan jika tidak ingin mengganti foto</p>
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