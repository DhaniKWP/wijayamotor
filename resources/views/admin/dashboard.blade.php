<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Wijaya Motor</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0A192F',
                        secondary: '#FF8C00',
                        neutral: '#64748B',
                    },
                    fontFamily: { sans: ['Inter', 'sans-serif'] }
                }
            }
        }
    </script>
    <style> body { font-family: 'Inter', sans-serif; } [x-cloak] { display: none !important; } </style>
</head>
<body class="bg-[#F8FAFC] flex h-screen overflow-hidden antialiased" x-data="{ sidebarOpen: false, showAddModal: {{ $errors->any() && !old('_method') ? 'true' : 'false' }}, showEditModal: {{ $errors->any() && old('_method') == 'PUT' ? 'true' : 'false' }}, editAction: '{{ old('_method') == 'PUT' ? url()->previous() : '' }}', editName: '{{ old('name') }}', editPrice: '{{ old('price_estimate') }}', editDesc: '{{ old('description') }}' }">
    
    <aside class="w-64 bg-primary text-white flex flex-col hidden md:flex shrink-0">
        <div class="h-20 flex items-center justify-center border-b border-white/5">
            <span class="font-black text-2xl tracking-tighter text-white">ADMIN <span class="text-secondary">PANEL</span></span>
        </div>
        
        <nav class="flex-1 px-4 py-8 space-y-2 overflow-y-auto">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 bg-white/5 text-white px-4 py-3.5 rounded-xl font-bold border-r-4 border-secondary transition-all">
                <svg class="w-5 h-5 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span>Master Servis</span>
            </a>
            
            <a href="{{ route('admin.spareparts.index') }}" class="flex items-center space-x-3 text-slate-400 hover:bg-white/5 hover:text-white px-4 py-3.5 rounded-xl font-medium transition-all group">
                <svg class="w-5 h-5 group-hover:text-secondary transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                <span>Kelola Sparepart</span>
            </a>

            <a href="#" class="flex items-center space-x-3 text-slate-400 hover:bg-white/5 hover:text-white px-4 py-3.5 rounded-xl font-medium transition-all group">
                <svg class="w-5 h-5 group-hover:text-secondary transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                <span>Data Booking</span>
            </a>
        </nav>

        <div class="p-4 border-t border-white/5">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center space-x-3 text-red-300 hover:bg-red-500/10 px-4 py-3 rounded-xl w-full transition-all">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden">
        
        <header class="bg-white h-20 flex items-center justify-between px-8 z-10 shrink-0 border-b border-slate-200/60">
            <h1 class="text-xl font-bold text-slate-800 tracking-tight">Overview</h1>
            <div class="flex items-center space-x-4">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-bold text-primary">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-secondary font-bold uppercase tracking-wider">Administrator</p>
                </div>
                <div class="w-10 h-10 bg-primary rounded-full flex items-center justify-center text-white font-bold border-2 border-secondary shadow-sm">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-8">

            @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-100 text-emerald-600 px-4 py-3 rounded-xl mb-6 flex items-center text-sm font-medium shadow-sm">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                {{ session('success') }}
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-primary p-6 rounded-2xl shadow-lg relative overflow-hidden group">
                    <div class="absolute -right-10 -top-10 w-32 h-32 bg-white/5 rounded-full blur-2xl group-hover:bg-white/10 transition duration-500"></div>
                    <p class="text-slate-300 text-sm font-medium mb-1">Total Booking Aktif</p>
                    <h3 class="text-4xl font-black text-white">0</h3>
                </div>
                <div class="bg-secondary p-6 rounded-2xl shadow-lg relative overflow-hidden group">
                    <div class="absolute -right-10 -top-10 w-32 h-32 bg-white/10 rounded-full blur-2xl group-hover:bg-white/20 transition duration-500"></div>
                    <p class="text-white/80 text-sm font-medium mb-1">Total Pendapatan</p>
                    <h3 class="text-4xl font-black text-white">Rp 0</h3>
                </div>
            </div>

            <div class="flex justify-between items-end mb-6">
                <div>
                    <h2 class="text-xl font-bold text-slate-800">Daftar Layanan Servis</h2>
                    <p class="text-slate-500 mt-1 text-sm">Kelola data jenis servis dan estimasi harga.</p>
                </div>
                <button @click="showAddModal = true; editAction = '';" class="bg-primary hover:bg-[#112a4f] text-white px-5 py-2.5 rounded-xl font-semibold flex items-center transition-all text-sm shadow-sm hover:shadow">
                    <svg class="w-4 h-4 mr-2 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    Tambah Servis
                </button>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200/60 overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100">
                        <thead class="bg-white">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Nama Servis</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Deskripsi</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Harga Estimasi Dasar</th>
                                <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-slate-400 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-50">
                            @forelse($services as $service)
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-slate-800">{{ $service->name }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-slate-500 max-w-xs truncate" title="{{ $service->description }}">{{ $service->description ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-slate-700">Rp {{ number_format($service->price_estimate, 0, ',', '.') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button 
                                            @click="showEditModal = true; editAction = '{{ route('admin.services.update', $service->id) }}'; editName = '{{ addslashes($service->name) }}'; editPrice = '{{ intval($service->price_estimate) }}'; editDesc = '{{ addslashes($service->description) }}';"
                                            class="text-slate-400 hover:text-blue-600 p-2 rounded-lg hover:bg-blue-50 transition-colors focus:outline-none" title="Edit">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                        </button>
                                        
                                        <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus layanan {{ $service->name }}?');">
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
                                <td colspan="4" class="px-6 py-20 text-center">
                                    <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-slate-100">
                                        <svg class="w-8 h-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                    </div>
                                    <p class="text-sm font-semibold text-slate-600">Belum ada layanan servis</p>
                                    <p class="text-xs mt-1 text-slate-400">Silakan tambahkan data layanan pertama Anda.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <div x-show="showAddModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-sm p-4">
        <div @click.away="showAddModal = false" class="bg-white w-full max-w-lg rounded-2xl shadow-xl overflow-hidden flex flex-col max-h-[90vh]">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center shrink-0">
                <h3 class="text-lg font-bold text-slate-800">Tambah Layanan Servis</h3>
                <button @click="showAddModal = false" class="text-slate-400 hover:text-slate-600 transition-colors focus:outline-none">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="overflow-y-auto p-6">
                @if ($errors->any() && !old('_method'))
                    <div class="bg-rose-50 text-rose-600 p-4 rounded-xl mb-6 text-sm border border-rose-100">
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
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wide mb-2">Nama Servis</label>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: Ganti Oli Mesin" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-secondary/50 focus:border-secondary outline-none transition-all placeholder-slate-300 text-slate-800">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wide mb-2">Harga Estimasi (Rp)</label>
                        <input type="number" name="price_estimate" value="{{ old('price_estimate') }}" required placeholder="Contoh: 150000" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-secondary/50 focus:border-secondary outline-none transition-all placeholder-slate-300 text-slate-800">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wide mb-2">Deskripsi Layanan</label>
                        <textarea name="description" rows="3" placeholder="Jelaskan detail pengerjaan..." class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-secondary/50 focus:border-secondary outline-none transition-all resize-none placeholder-slate-300 text-slate-800">{{ old('description') }}</textarea>
                    </div>

                    <div class="flex justify-end space-x-3 pt-4 border-t border-slate-100">
                        <button type="button" @click="showAddModal = false" class="px-5 py-2.5 text-sm font-semibold text-slate-500 hover:bg-slate-100 rounded-xl transition-colors">Batal</button>
                        <button type="submit" class="bg-primary hover:bg-[#112a4f] text-white px-6 py-2.5 rounded-xl text-sm font-semibold shadow-sm transition-colors">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div x-show="showEditModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-sm p-4">
        <div @click.away="showEditModal = false" class="bg-white w-full max-w-lg rounded-2xl shadow-xl overflow-hidden flex flex-col max-h-[90vh]">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center shrink-0">
                <h3 class="text-lg font-bold text-slate-800">Edit Layanan Servis</h3>
                <button @click="showEditModal = false" class="text-slate-400 hover:text-slate-600 transition-colors focus:outline-none">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="overflow-y-auto p-6">
                @if ($errors->any() && old('_method') == 'PUT')
                    <div class="bg-rose-50 text-rose-600 p-4 rounded-xl mb-6 text-sm border border-rose-100">
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
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wide mb-2">Nama Servis</label>
                        <input type="text" name="name" x-model="editName" required class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 outline-none transition-all text-slate-800">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wide mb-2">Harga Estimasi Dasar (Rp)</label>
                        <input type="number" name="price_estimate" x-model="editPrice" required class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 outline-none transition-all text-slate-800">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wide mb-2">Deskripsi Layanan</label>
                        <textarea name="description" x-model="editDesc" rows="3" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 outline-none transition-all resize-none text-slate-800"></textarea>
                    </div>

                    <div class="flex justify-end space-x-3 pt-4 border-t border-slate-100">
                        <button type="button" @click="showEditModal = false" class="px-5 py-2.5 text-sm font-semibold text-slate-500 hover:bg-slate-100 rounded-xl transition-colors">Batal</button>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl text-sm font-semibold shadow-sm transition-colors">Update Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>