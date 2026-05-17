<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Garasi Saya - Wijaya Motor</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { primary: '#0A192F', secondary: '#FF8C00', neutral: '#64748B' },
                    fontFamily: { sans: ['Inter', 'sans-serif'] }
                }
            }
        }
    </script>
    <style> [x-cloak] { display: none !important; } </style>
</head>
<body class="bg-slate-50 flex h-screen overflow-hidden antialiased" x-data="{ showAddModal: {{ $errors->any() ? 'true' : 'false' }} }">

    <aside class="w-64 bg-primary text-white flex flex-col hidden md:flex shrink-0">
        <div class="h-20 flex items-center justify-center border-b border-white/5">
            <span class="font-black text-2xl tracking-tighter text-white">WIJAYA <span class="text-secondary">MOTOR</span></span>
        </div>
        <nav class="flex-1 px-4 py-8 space-y-2 overflow-y-auto">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 text-slate-400 hover:bg-white/5 hover:text-white px-4 py-3.5 rounded-xl font-medium transition-all group">
                <svg class="w-5 h-5 group-hover:text-secondary transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span>Panel Kontrol</span>
            </a>
            <a href="#" class="flex items-center space-x-3 bg-white/5 text-white px-4 py-3.5 rounded-xl font-bold border-r-4 border-secondary transition-all">
                <svg class="w-5 h-5 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                <span>Garasi Saya</span>
            </a>
            </nav>
        <div class="p-4 border-t border-white/5">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center space-x-3 text-red-300 hover:bg-red-500/10 px-4 py-3 rounded-xl w-full transition-all">
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white h-20 flex items-center justify-between px-8 z-10 shrink-0 border-b border-slate-200/60">
            <h1 class="text-xl font-bold text-slate-800 tracking-tight">Garasi Saya</h1>
            <button @click="showAddModal = true" class="bg-primary hover:bg-[#112a4f] text-white px-5 py-2.5 rounded-xl font-semibold flex items-center transition-all text-sm shadow-sm">
                <svg class="w-4 h-4 mr-2 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                Tambah Kendaraan
            </button>
        </header>

        <main class="flex-1 overflow-y-auto p-8">
            @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-100 text-emerald-600 px-4 py-3 rounded-xl mb-6 flex items-center text-sm font-medium shadow-sm">
                {{ session('success') }}
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($vehicles as $vehicle)
                <div class="bg-white rounded-2xl p-6 border border-slate-200/60 shadow-sm hover:shadow-md transition-all group relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-slate-50 rounded-full group-hover:bg-secondary/5 transition-colors"></div>
                    
                    <div class="relative flex items-start justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center text-slate-400">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-800">{{ $vehicle->name }}</h3>
                                <p class="text-sm text-secondary font-black tracking-widest">{{ $vehicle->plate_number }}</p>
                            </div>
                        </div>
                        
                        <form action="{{ route('garasi.destroy', $vehicle->id) }}" method="POST" onsubmit="return confirm('Hapus kendaraan ini dari garasi?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-slate-300 hover:text-rose-500 transition-colors">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>

                    <div class="mt-6 flex items-center justify-between border-t border-slate-50 pt-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">
                        <span>Tahun: {{ $vehicle->year }}</span>
                        <span class="text-emerald-500">Terdaftar</span>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-20 text-center">
                    <div class="w-20 h-20 bg-slate-100 rounded-3xl flex items-center justify-center mx-auto mb-4 border border-slate-200/60">
                        <svg class="w-10 h-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <p class="text-slate-500 font-medium">Belum ada kendaraan di garasi Anda.</p>
                    <button @click="showAddModal = true" class="text-secondary font-bold text-sm mt-2 hover:underline">Tambah kendaraan pertama Anda</button>
                </div>
                @endforelse
            </div>
        </main>
    </div>

    <div x-show="showAddModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-sm p-4">
        <div @click.away="showAddModal = false" class="bg-white w-full max-w-md rounded-2xl shadow-xl overflow-hidden flex flex-col">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                <h3 class="text-lg font-bold text-slate-800">Daftarkan Kendaraan</h3>
                <button @click="showAddModal = false" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            
            <div class="p-6">
                @if ($errors->any())
                    <div class="bg-rose-50 text-rose-600 p-4 rounded-xl mb-6 text-sm border border-rose-100">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <form action="{{ route('garasi.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wide mb-2">Nama/Merk Mobil</label>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: Mitsubishi Pajero Sport" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-secondary/50 focus:border-secondary outline-none transition-all text-slate-800">
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wide mb-2">Nomor Plat</label>
                            <input type="text" name="plate_number" value="{{ old('plate_number') }}" required placeholder="A 1234 BC" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-secondary/50 focus:border-secondary outline-none transition-all text-slate-800">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wide mb-2">Tahun</label>
                            <input type="number" name="year" value="{{ old('year', date('Y')) }}" required class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-secondary/50 focus:border-secondary outline-none transition-all text-slate-800">
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 pt-6">
                        <button type="button" @click="showAddModal = false" class="px-5 py-2.5 text-sm font-semibold text-slate-500 hover:bg-slate-100 rounded-xl transition-colors">Batal</button>
                        <button type="submit" class="bg-primary hover:bg-[#112a4f] text-white px-6 py-2.5 rounded-xl text-sm font-semibold shadow-sm">Simpan Kendaraan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>