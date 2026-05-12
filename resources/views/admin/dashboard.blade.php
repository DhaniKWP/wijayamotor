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
<body class="bg-slate-50 flex h-screen overflow-hidden antialiased" x-data="{ sidebarOpen: false, showAddModal: false }">

    <aside class="w-64 bg-primary text-white flex flex-col hidden md:flex">
        <div class="h-20 flex items-center justify-center border-b border-white/5">
            <span class="font-black text-2xl tracking-tighter text-white">ADMIN <span class="text-secondary">PANEL</span></span>
        </div>
        
        <nav class="flex-1 px-4 py-8 space-y-2 overflow-y-auto">
            <a href="#" class="flex items-center space-x-3 bg-white/5 text-white px-4 py-3.5 rounded-xl font-bold border-r-4 border-secondary transition-all">
                <svg class="w-5 h-5 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span>Master Servis</span>
            </a>
            
            <a href="#" class="flex items-center space-x-3 text-slate-300 hover:bg-white/5 hover:text-white px-4 py-3.5 rounded-xl font-medium transition-all">
                <svg class="w-5 h-5 text-neutral" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                <span>Kelola Sparepart</span>
            </a>

            <a href="#" class="flex items-center space-x-3 text-slate-300 hover:bg-white/5 hover:text-white px-4 py-3.5 rounded-xl font-medium transition-all">
                <svg class="w-5 h-5 text-neutral" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
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
        
        <header class="bg-white h-20 border-b border-slate-100 flex items-center justify-between px-8 z-10 shadow-sm">
            <h1 class="text-xl font-black text-primary tracking-tight">Overview</h1>
            <div class="flex items-center space-x-4">
                <div class="text-right">
                    <p class="text-sm font-bold text-primary">Halo Admin, {{ Auth::user()->name }}</p>
                    <p class="text-xs text-secondary font-bold uppercase tracking-wider">Administrator</p>
                </div>
                <div class="w-10 h-10 bg-primary rounded-full flex items-center justify-center text-white font-bold border-2 border-secondary shadow-sm">
                    A
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-8">

            @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl relative mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span class="block sm:inline font-medium">{{ session('success') }}</span>
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-primary p-6 rounded-2xl shadow-lg relative overflow-hidden group">
                    <div class="absolute -right-10 -top-10 w-32 h-32 bg-white/5 rounded-full blur-2xl group-hover:bg-white/10 transition duration-500"></div>
                    <p class="text-slate-300 font-medium mb-1">Total Booking Aktif</p>
                    <h3 class="text-4xl font-black text-white">0</h3>
                </div>
                <div class="bg-secondary p-6 rounded-2xl shadow-lg relative overflow-hidden group">
                    <div class="absolute -right-10 -top-10 w-32 h-32 bg-white/10 rounded-full blur-2xl group-hover:bg-white/20 transition duration-500"></div>
                    <p class="text-white/80 font-medium mb-1">Total Income</p>
                    <h3 class="text-4xl font-black text-white">Rp 0</h3>
                </div>
            </div>

            <div class="flex justify-between items-end mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-primary">Daftar Layanan Servis</h2>
                    <p class="text-neutral mt-1 text-sm">Kelola data jenis servis dan harga yang ditampilkan ke pelanggan.</p>
                </div>
                <button @click="showAddModal = true" class="bg-primary hover:bg-[#112a4f] text-white px-5 py-2.5 rounded-xl font-bold flex items-center transition shadow-lg shadow-primary/20">
                    <svg class="w-5 h-5 mr-2 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Servis
                </button>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Servis</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Deskripsi</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Harga Estimasi</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @forelse($services as $service)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">#{{ $service->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-primary">{{ $service->name }}</td>
                            <td class="px-6 py-4 text-sm text-neutral truncate max-w-xs">{{ $service->description ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-secondary">Rp {{ number_format($service->price_estimate, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="#" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                                <a href="#" class="text-red-600 hover:text-red-900">Hapus</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-neutral">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-8 h-8 text-neutral-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                </div>
                                Belum ada data master servis. Silakan tambahkan baru.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <div x-show="showAddModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-primary/60 backdrop-blur-sm">
        <div @click.away="showAddModal = false" class="relative w-full max-w-lg p-4">
            <div class="relative bg-white rounded-3xl shadow-2xl overflow-hidden border border-slate-100">
                
                <div class="flex items-center justify-between p-6 border-b border-slate-100 bg-slate-50">
                    <h3 class="text-xl font-bold text-primary">Tambah Layanan Servis</h3>
                    <button @click="showAddModal = false" class="text-slate-400 hover:text-slate-900 transition-colors">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="p-6">
                    <form action="{{ route('admin.services.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-5">
                            <label class="block text-sm font-semibold text-primary mb-2">Nama Servis</label>
                            <input type="text" name="name" required placeholder="Contoh: Ganti Oli Mesin" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:ring-2 focus:ring-secondary outline-none transition-all">
                        </div>

                        <div class="mb-5">
                            <label class="block text-sm font-semibold text-primary mb-2">Harga Estimasi (Rp)</label>
                            <input type="number" name="price_estimate" required placeholder="Contoh: 150000" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:ring-2 focus:ring-secondary outline-none transition-all">
                        </div>

                        <div class="mb-8">
                            <label class="block text-sm font-semibold text-primary mb-2">Deskripsi Layanan</label>
                            <textarea name="description" rows="3" placeholder="Jelaskan detail pengerjaan servis ini..." class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:ring-2 focus:ring-secondary outline-none transition-all resize-none"></textarea>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <button type="button" @click="showAddModal = false" class="px-5 py-2.5 rounded-xl text-neutral font-bold hover:bg-slate-100 transition-colors">Batal</button>
                            <button type="submit" class="bg-secondary hover:bg-[#e67e00] text-white px-6 py-2.5 rounded-xl font-bold transition shadow-lg shadow-secondary/30">Simpan Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>