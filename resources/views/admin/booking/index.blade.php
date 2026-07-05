@extends('layouts.admin')

@section('title', 'Manajemen Booking - Wijaya Motor')
@section('header_title', 'Manajemen Booking Servis')

@section('content')

{{-- Alert --}}
@if(session('success'))
<div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm font-bold flex items-center gap-2 shadow-sm">
    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
    {{ session('success') }}
</div>
@endif

{{-- Stat Cards --}}
<div class="grid grid-cols-2 sm:grid-cols-4 gap-5 mb-8">
    <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Menunggu</p>
        <p class="text-3xl font-black text-amber-500">{{ $pending }}</p>
    </div>
    <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Disetujui</p>
        <p class="text-3xl font-black text-blue-500">{{ $confirmed }}</p>
    </div>
    <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Dikerjakan</p>
        <p class="text-3xl font-black text-orange-500">{{ $process }}</p>
    </div>
    <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Selesai</p>
        <p class="text-3xl font-black text-green-500">{{ $done }}</p>
    </div>
</div>

{{-- Filter & Tabs --}}
<div class="bg-white border border-slate-200 rounded-xl p-4 sm:p-5 shadow-sm mb-6 flex flex-col xl:flex-row xl:items-center justify-between gap-4">
    @php $currentStatus = request('status', ''); @endphp
    
    <!-- TABS -->
    <div class="flex bg-slate-100 p-1 rounded-xl border border-slate-200/80 shadow-inner overflow-x-auto">
        <a href="{{ route('admin.bookings.index', array_merge(request()->query(), ['status' => ''])) }}" class="px-4 py-2 rounded-lg text-xs font-bold whitespace-nowrap transition-all duration-200 {{ $currentStatus == '' ? 'bg-white text-danger shadow-sm ring-1 ring-slate-200/50' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-200/60' }}">
            Semua
        </a>
        <a href="{{ route('admin.bookings.index', array_merge(request()->query(), ['status' => 'pending'])) }}" class="px-4 py-2 rounded-lg text-xs font-bold whitespace-nowrap transition-all duration-200 flex items-center gap-1.5 {{ $currentStatus == 'pending' ? 'bg-white text-danger shadow-sm ring-1 ring-slate-200/50' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-200/60' }}">
            <div class="w-1.5 h-1.5 rounded-full bg-amber-500"></div> Menunggu
        </a>
        <a href="{{ route('admin.bookings.index', array_merge(request()->query(), ['status' => 'confirmed'])) }}" class="px-4 py-2 rounded-lg text-xs font-bold whitespace-nowrap transition-all duration-200 flex items-center gap-1.5 {{ $currentStatus == 'confirmed' ? 'bg-white text-danger shadow-sm ring-1 ring-slate-200/50' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-200/60' }}">
            <div class="w-1.5 h-1.5 rounded-full bg-blue-500"></div> Disetujui
        </a>
        <a href="{{ route('admin.bookings.index', array_merge(request()->query(), ['status' => 'process'])) }}" class="px-4 py-2 rounded-lg text-xs font-bold whitespace-nowrap transition-all duration-200 flex items-center gap-1.5 {{ $currentStatus == 'process' ? 'bg-white text-danger shadow-sm ring-1 ring-slate-200/50' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-200/60' }}">
            <div class="w-1.5 h-1.5 rounded-full bg-orange-500"></div> Dikerjakan
        </a>
        <a href="{{ route('admin.bookings.index', array_merge(request()->query(), ['status' => 'done'])) }}" class="px-4 py-2 rounded-lg text-xs font-bold whitespace-nowrap transition-all duration-200 flex items-center gap-1.5 {{ $currentStatus == 'done' ? 'bg-white text-danger shadow-sm ring-1 ring-slate-200/50' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-200/60' }}">
            <div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div> Selesai
        </a>
        <a href="{{ route('admin.bookings.index', array_merge(request()->query(), ['status' => 'cancelled'])) }}" class="px-4 py-2 rounded-lg text-xs font-bold whitespace-nowrap transition-all duration-200 flex items-center gap-1.5 {{ $currentStatus == 'cancelled' ? 'bg-white text-danger shadow-sm ring-1 ring-slate-200/50' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-200/60' }}">
            <div class="w-1.5 h-1.5 rounded-full bg-slate-500"></div> Batal
        </a>
    </div>

    <!-- DATE & SORT FILTERS -->
    <form action="{{ route('admin.bookings.index') }}" method="GET" class="flex flex-1 sm:flex-none gap-2">
        @if($currentStatus)
            <input type="hidden" name="status" value="{{ $currentStatus }}">
        @endif
        
        <input type="date" name="date" value="{{ request('date') }}"
               class="w-full sm:w-auto text-xs font-medium border-slate-200 rounded-lg focus:ring-danger focus:border-danger py-2.5">
               
        <select name="sort" class="w-full sm:w-auto text-xs font-medium border-slate-200 rounded-lg focus:ring-danger focus:border-danger py-2.5 bg-white">
            <option value="asc" {{ request('sort', 'asc') == 'asc' ? 'selected' : '' }}>Terlama ke Terbaru</option>
            <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Terbaru ke Terlama</option>
        </select>
        
        <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white text-[10px] font-bold uppercase tracking-widest px-4 py-2.5 rounded-lg transition shadow-sm whitespace-nowrap">
            Filter
        </button>
        
        @if(request()->anyFilled(['date', 'sort']) && (request('sort') != 'asc' || request('date')))
        <a href="{{ route('admin.bookings.index', ['status' => $currentStatus]) }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-[10px] font-bold uppercase tracking-widest px-4 py-2.5 rounded-lg transition text-center whitespace-nowrap flex items-center">
            Reset
        </a>
        @endif
    </form>
</div>

{{-- Tabel Booking --}}
<div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100 bg-slate-50/80">
                    <th class="text-left px-5 py-3.5 text-[10px] font-black text-slate-400 uppercase tracking-widest w-16">No</th>
                    <th class="text-left px-5 py-3.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Jadwal & Info</th>
                    <th class="text-left px-5 py-3.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Pelanggan & Kendaraan</th>
                    <th class="text-left px-5 py-3.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                    <th class="text-center px-5 py-3.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($bookings as $booking)
                <tr class="hover:bg-slate-50/50 transition group">
                    <td class="px-5 py-4 text-xs font-bold text-slate-500">
                        {{ ($bookings->currentPage() - 1) * $bookings->perPage() + $loop->iteration }}
                    </td>
                    <td class="px-5 py-4 whitespace-nowrap">
                        <div class="flex flex-col">
                            <p class="font-black text-slate-800 text-xs">{{ \Carbon\Carbon::parse($booking->tanggal)->translatedFormat('d M Y') }}</p>
                            <p class="text-[11px] font-semibold text-slate-500 mt-0.5">Sesi {{ ucfirst($booking->sesi) }}</p>
                            <div class="text-[10px] font-bold text-slate-400 mt-1 flex items-center gap-1.5">
                                @if($booking->tipe_booking === 'home_service')
                                    <span class="text-blue-500 uppercase tracking-wider">Home Service</span>
                                @else
                                    <span class="uppercase tracking-wider">Di Bengkel</span>
                                @endif
                                
                                @if($booking->kilometer)
                                    <span>•</span>
                                    <span>{{ number_format($booking->kilometer, 0, ',', '.') }} KM</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-4">
                        <p class="font-bold text-slate-800 text-xs">{{ $booking->user->name ?? $booking->user->username ?? 'Pelanggan' }}</p>
                        <div class="flex items-center gap-2 mt-1.5 flex-wrap">
                            <span class="inline-flex text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-300 px-2 py-0.5 rounded tracking-widest uppercase">
                                {{ $booking->vehicle->plat_nomor ?? $booking->vehicle->plate_number ?? '-' }}
                            </span>
                            <span class="text-[11px] text-slate-500 font-medium">
                                {{ $booking->vehicle->name ?? '-' }}
                            </span>
                        </div>
                    </td>
                    <td class="px-5 py-4 whitespace-nowrap">
                        @if($booking->status == 'pending')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10px] font-black uppercase tracking-wider bg-amber-50 text-amber-700 border border-amber-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                Menunggu
                            </span>
                        @elseif($booking->status == 'confirmed')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10px] font-black uppercase tracking-wider bg-blue-50 text-blue-700 border border-blue-100">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                Disetujui
                            </span>
                        @elseif($booking->status == 'process')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10px] font-black uppercase tracking-wider bg-orange-50 text-orange-700 border border-orange-100">
                                <span class="relative flex h-1.5 w-1.5">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-orange-500"></span>
                                </span>
                                Dikerjakan
                            </span>
                        @elseif($booking->status == 'done')
                            <div class="flex flex-col gap-1 items-start">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10px] font-black uppercase tracking-wider bg-green-50 text-green-700 border border-green-100">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                    Selesai
                                </span>
                                @if($booking->transaction && $booking->transaction->payment_status == 'paid')
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[9px] font-bold bg-blue-50 text-blue-600 border border-blue-100 uppercase tracking-wider"><svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg> Lunas</span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[9px] font-bold bg-red-50 text-red-600 border border-red-100 uppercase tracking-wider"><svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg> Belum Lunas</span>
                                @endif
                            </div>
                        @elseif($booking->status == 'cancelled')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10px] font-black uppercase tracking-wider bg-rose-50 text-rose-700 border border-rose-100">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                Dibatalkan
                            </span>
                        @elseif($booking->status == 'rejected')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10px] font-black uppercase tracking-wider bg-red-50 text-red-700 border border-red-100">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                Ditolak
                            </span>
                        @endif
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center justify-center gap-2">
                            <button type="button" data-id="{{ $booking->id }}" onclick="openDetailModal(this.getAttribute('data-id'))" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-[10px] font-black uppercase tracking-wider rounded-lg transition shadow-sm">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Detail
                            </button>   
                            
                            @if($booking->status == 'pending')
                                <form action="{{ route('admin.bookings.accept', $booking->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-[10px] font-black uppercase tracking-wider rounded-lg transition shadow-sm">
                                        Terima
                                    </button>
                                </form>
                                <form action="{{ route('admin.bookings.reject', $booking->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Tolak booking ini?')">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 text-[10px] font-black uppercase tracking-wider rounded-lg transition shadow-sm">
                                        Tolak
                                    </button>
                                </form>
                            @elseif($booking->status == 'confirmed')
                                <form action="{{ route('admin.bookings.process', $booking->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-[10px] font-black uppercase tracking-wider rounded-lg transition shadow-sm">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
                                        Mulai Kerja
                                    </button>
                                </form>
                            @elseif($booking->status == 'process')
                                <a href="{{ route('admin.bookings.complete.form', $booking->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-[10px] font-black uppercase tracking-wider rounded-lg transition shadow-sm">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    Selesai
                                </a>
                            @elseif($booking->status == 'done')
                                @if($booking->transaction && $booking->transaction->payment_status != 'paid')
                                    <form action="{{ route('admin.bookings.mark.paid', $booking->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Tandai tagihan ini sebagai LUNAS?')">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-[10px] font-black uppercase tracking-wider rounded-lg transition shadow-sm">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                            Tandai Lunas
                                        </button>
                                    </form>
                                @endif
                                <a href="{{ route('admin.bookings.invoice', $booking->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-800 hover:bg-slate-900 text-white text-[10px] font-black uppercase tracking-wider rounded-lg transition shadow-sm">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                    Invoice
                                </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-5 py-16 text-center">
                        <div class="w-14 h-14 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3 text-slate-300">
                            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        </div>
                        <p class="text-slate-400 text-sm font-medium">Belum ada booking masuk.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($bookings->hasPages())
    <div class="px-5 py-4 border-t border-slate-100 bg-slate-50/50">
        {{ $bookings->links() }}
    </div>
    @endif
</div>


{{-- MODAL DETAIL --}}
<div id="modalDetail" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm overflow-hidden h-full w-full flex items-center justify-center p-4">
    <div class="relative w-full max-w-2xl bg-white rounded-2xl shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
        <!-- Modal Header -->
        <div class="bg-gradient-to-r from-slate-900 to-slate-800 text-white px-6 py-5 flex justify-between items-center shrink-0">
            <div>
                <h3 class="text-base font-extrabold text-white tracking-tight uppercase flex items-center gap-2">
                    <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Detail Booking Servis
                </h3>
                <p class="text-[10px] text-slate-300 font-bold uppercase tracking-wider mt-1">Kode Transaksi: <span class="text-red-400 font-black" id="modalId"></span></p>
            </div>
            <button onclick="closeModal()" class="text-slate-400 hover:text-white hover:bg-white/10 transition-all duration-200 rounded-full p-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        
        <!-- Modal Body -->
        <div class="p-6 space-y-6 overflow-y-auto custom-scrollbar flex-1 bg-slate-50/50">
            
            <!-- Status & Method Banner -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 p-4 bg-white border border-slate-200/60 rounded-xl shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-slate-50 rounded-lg border border-slate-200/50 text-slate-400">
                        <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="text-[9px] text-slate-400 font-extrabold uppercase tracking-wider block mb-0.5">Status Booking</span>
                        <div id="modalStatusBadge"></div>
                    </div>
                </div>
                <div class="flex items-center gap-3 sm:text-right sm:flex-row-reverse">
                    <div class="p-2 bg-slate-50 rounded-lg border border-slate-200/50 text-slate-400">
                        <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                        </svg>
                    </div>
                    <div class="text-left sm:text-right">
                        <span class="text-[9px] text-slate-400 font-extrabold uppercase tracking-wider block mb-0.5">Metode Servis</span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-black bg-slate-800 text-white shadow-sm" id="modalTipe">-</span>
                    </div>
                </div>
            </div>

            <!-- Customer & Vehicle Info Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white border border-slate-200/60 rounded-xl p-5 shadow-sm">
                    <h4 class="text-xs font-bold text-slate-500 uppercase tracking-widest border-b border-slate-100 pb-2.5 mb-3.5 flex items-center gap-2">
                        <svg class="w-4 h-4 text-red-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Informasi Pelanggan
                    </h4>
                    <ul class="space-y-3.5 text-sm">
                        <li>
                            <span class="text-slate-400 block text-[9px] font-extrabold uppercase tracking-widest">Nama Pelanggan</span> 
                            <span class="font-extrabold text-slate-800" id="modalNama">-</span>
                        </li>
                        <li>
                            <span class="text-slate-400 block text-[9px] font-extrabold uppercase tracking-widest">No. Telepon / WA</span> 
                            <span class="font-bold text-slate-700" id="modalPhone">-</span>
                        </li>
                    </ul>
                </div>
                
                <div class="bg-white border border-slate-200/60 rounded-xl p-5 shadow-sm">
                    <h4 class="text-xs font-bold text-slate-500 uppercase tracking-widest border-b border-slate-100 pb-2.5 mb-3.5 flex items-center gap-2">
                        <svg class="w-4 h-4 text-red-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 16V17C19 18.1046 18.1046 19 17 19H16C14.8954 19 14 18.1046 14 17V16M10 16V17C10 18.1046 9.10457 19 8 19H7C5.89543 19 5 17 5 17V16M3 11L5.3409 6.31819C5.7483 5.5034 6.57793 5 7.4915 5H16.5085C17.4221 5 18.2517 5.5034 18.6591 6.31819L21 11M3 11V16H21V11M3 11H21"/>
                        </svg>
                        Informasi Kendaraan
                    </h4>
                    <ul class="space-y-3.5 text-sm">
                        <li>
                            <span class="text-slate-400 block text-[9px] font-extrabold uppercase tracking-widest mb-1.5">Plat Nomor</span> 
                            <div class="inline-flex items-center gap-2">
                                <span class="inline-block text-xs font-mono font-bold bg-slate-900 text-white border-2 border-slate-700 px-3 py-1 rounded shadow-sm tracking-widest uppercase" id="modalPlat">-</span>
                            </div>
                        </li>
                        <li>
                            <span class="text-slate-400 block text-[9px] font-extrabold uppercase tracking-widest">Merek & Model</span> 
                            <span class="font-extrabold text-slate-800" id="modalMerek">-</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Service details & location grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white border border-slate-200/60 rounded-xl p-5 shadow-sm">
                    <h4 class="text-xs font-bold text-slate-500 uppercase tracking-widest border-b border-slate-100 pb-2.5 mb-3.5 flex items-center gap-2">
                        <svg class="w-4 h-4 text-red-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>
                        </svg>
                        Detail Layanan
                    </h4>
                    <ul class="space-y-3.5 text-sm">
                        <li>
                            <span class="text-slate-400 block text-[9px] font-extrabold uppercase tracking-widest">Layanan Utama</span> 
                            <span class="font-extrabold text-slate-800" id="modalService">-</span>
                        </li>
                        <li>
                            <span class="text-slate-400 block text-[9px] font-extrabold uppercase tracking-widest">Jadwal</span> 
                            <span class="font-extrabold text-slate-800" id="modalJadwal">-</span>
                        </li>
                        <li>
                            <span class="text-slate-400 block text-[9px] font-extrabold uppercase tracking-widest mb-1">Jarak Tempuh</span> 
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-black bg-red-50 text-red-600" id="modalKm">-</span>
                        </li>
                        <li>
                            <span class="text-slate-400 block text-[9px] font-extrabold uppercase tracking-widest">Estimasi Harga Jasa Dasar</span> 
                            <span class="font-extrabold text-emerald-600 text-lg" id="modalHarga">-</span>
                        </li>
                    </ul>
                </div>

                <div class="bg-white border border-slate-200/60 rounded-xl p-5 shadow-sm flex flex-col justify-between">
                    <div>
                        <h4 class="text-xs font-bold text-slate-500 uppercase tracking-widest border-b border-slate-100 pb-2.5 mb-3.5 flex items-center gap-2">
                            <svg class="w-4 h-4 text-red-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Lokasi Pelaksanaan
                        </h4>
                        <div>
                            <span class="text-slate-400 block text-[9px] font-extrabold uppercase tracking-widest mb-2" id="labelLokasi">Lokasi:</span>
                            <p class="text-xs font-semibold text-slate-700 bg-slate-50 p-3 rounded-lg border border-slate-200/60 leading-relaxed" id="modalLokasi">-</p>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <span class="text-slate-400 block text-[9px] font-extrabold uppercase tracking-widest mb-2">Pekerjaan Tambahan (Add-ons)</span>
                        <div class="flex flex-wrap gap-1.5" id="modalAddons"></div>
                    </div>
                </div>
            </div>

            <!-- Catatan/Keluhan Section -->
            <div>
                <h4 class="text-xs font-bold text-slate-500 uppercase tracking-widest pb-2 mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4 text-red-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                    </svg>
                    Keluhan & Catatan Khusus
                </h4>
                <div id="modalKeluhanWrapper" class="rounded-xl p-4 shadow-sm transition-all duration-300">
                    <p id="modalKeluhan" class="leading-relaxed">-</p>
                </div>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="bg-white px-6 py-4 border-t border-slate-100 flex justify-end shrink-0 rounded-b-2xl">
            <button onclick="closeModal()" class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-black transition-all duration-200 focus:outline-none">Tutup</button>
        </div>
    </div>
</div>

<script id="booking-data" type="application/json">
    {!! json_encode($bookings->items(), JSON_HEX_TAG) !!}
</script>
<script>
    const rawData = document.getElementById('booking-data').textContent;
    const bookingsData = JSON.parse(rawData);
    const bookingsMap = {};
    bookingsData.forEach(b => { bookingsMap[b.id] = b; });

    const addonLabels = {
        'spooring': 'Spooring & Balancing',
        'ac': 'AC Superlight Care',
        'engine': 'Engine Room Treatment',
        'engine_oil': 'Engine Oil',
        'brake_service': 'Brake Service',
        'engine_tune_up': 'Engine Tune Up',
        'fuel_filter': 'Replace Fuel Filter',
        'brake_pads': 'Replace Brake Pads',
        'reset_alarm': 'Reset Alarm',
        'engine_diagnose': 'Engine Diagnose',
        'other': 'Other Service'
    };

    function openDetailModal(id) {
        let data = bookingsMap[id];
        if(!data) return;

        document.getElementById('modalId').innerText = "WM-" + data.id;
        
        let statusBadge = document.getElementById('modalStatusBadge');
        let stat = data.status.toLowerCase();
        if(stat === 'pending') {
            statusBadge.innerHTML = `<span class="inline-flex items-center px-3 py-1.5 rounded-lg text-[11px] font-bold bg-amber-100 text-amber-800">Menunggu</span>`;
        } else if(stat === 'confirmed') {
            statusBadge.innerHTML = `<span class="inline-flex items-center px-3 py-1.5 rounded-lg text-[11px] font-bold bg-blue-100 text-blue-800">Disetujui</span>`;
        } else if(stat === 'process') {
            statusBadge.innerHTML = `<span class="inline-flex items-center px-3 py-1.5 rounded-lg text-[11px] font-bold bg-orange-100 text-orange-800 gap-1.5">
                <span class="relative flex h-1.5 w-1.5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-orange-500"></span>
                </span>
                Dikerjakan
            </span>`;
        } else if(stat === 'done') {
            statusBadge.innerHTML = `<span class="inline-flex items-center px-3 py-1.5 rounded-lg text-[11px] font-bold bg-emerald-100 text-emerald-800">Selesai</span>`;
        } else {
            statusBadge.innerHTML = `<span class="inline-flex items-center px-3 py-1.5 rounded-lg text-[11px] font-bold bg-red-100 text-red-800">Ditolak / Batal</span>`;
        }

        let isHomeService = data.tipe_booking && data.tipe_booking.toLowerCase().includes('home');
        document.getElementById('modalTipe').innerText = isHomeService ? 'HOME SERVICE' : 'LAYANAN BENGKEL';
        document.getElementById('modalNama').innerText = data.user ? (data.user.name || data.user.username) : '-';
        document.getElementById('modalPhone').innerText = data.user ? (data.user.phone || data.user.no_telp || data.user.no_hp || '-') : '-';
        document.getElementById('modalPlat').innerText = data.vehicle ? (data.vehicle.plat_nomor || data.vehicle.plate_number || data.vehicle.nomor_polisi || '-') : '-';
        document.getElementById('modalMerek').innerText = data.vehicle ? (data.vehicle.merek || data.vehicle.merek_kendaraan || data.vehicle.brand || data.vehicle.name || '-') : '-';
        document.getElementById('modalService').innerText = data.service ? data.service.name : 'Servis Umum';
        document.getElementById('modalKm').innerText = data.kilometer ? data.kilometer.toLocaleString('id-ID') + ' KM' : '-';
        let sesi = data.sesi ? data.sesi.charAt(0).toUpperCase() + data.sesi.slice(1) : '-';
        let tgl = new Date(data.tanggal);
        let formattedTgl = !isNaN(tgl) ? tgl.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' }) : data.tanggal;
        document.getElementById('modalJadwal').innerText = formattedTgl + ' / Sesi ' + sesi;
        
        let harga = data.estimasi_harga ? parseFloat(data.estimasi_harga) : 0;
        document.getElementById('modalHarga').innerText = 'Rp ' + harga.toLocaleString('id-ID');

        if (isHomeService) {
            document.getElementById('labelLokasi').innerText = 'ALAMAT KUNJUNGAN:';
            document.getElementById('modalLokasi').innerText = data.alamat_lengkap || 'Alamat tidak diisi';
        } else {
            document.getElementById('labelLokasi').innerText = 'CABANG TUJUAN:';
            document.getElementById('modalLokasi').innerText = data.cabang ? ('Cabang ' + data.cabang.charAt(0).toUpperCase() + data.cabang.slice(1)) : 'Cabang Pusat';
        }

        let addonsContainer = document.getElementById('modalAddons');
        addonsContainer.innerHTML = ''; 
        if (data.addons && Array.isArray(data.addons) && data.addons.length > 0) {
            data.addons.forEach(addon => {
                let text = addonLabels[addon] || addon.charAt(0).toUpperCase() + addon.slice(1);
                addonsContainer.innerHTML += `<span class="px-2 py-1 bg-slate-100 text-slate-600 rounded text-[10px] font-bold border border-slate-200">${text}</span>`;
            });
        } else {
            addonsContainer.innerHTML = `<span class="text-xs text-slate-400 italic">Tidak ada pekerjaan tambahan</span>`;
        }
        let keluhan = data.keluhan && data.keluhan !== '-' ? data.keluhan.trim() : '';
        let keluhanEl = document.getElementById('modalKeluhan');
        let keluhanWrapEl = document.getElementById('modalKeluhanWrapper');
        if (keluhan && keluhan !== '') {
            keluhanEl.innerText = keluhan;
            keluhanWrapEl.className = "bg-amber-50 border border-amber-200/70 rounded-xl p-4 text-amber-900";
            keluhanEl.className = "text-amber-800 text-sm font-semibold leading-relaxed";
        } else {
            keluhanEl.innerText = "Tidak ada keluhan atau catatan khusus yang dicantumkan.";
            keluhanWrapEl.className = "bg-slate-50 border border-slate-200/60 rounded-xl p-4 text-slate-400";
            keluhanEl.className = "text-slate-400 text-xs italic font-medium leading-relaxed";
        }
        document.getElementById('modalDetail').classList.remove('hidden');
    }
    
    function closeModal() { document.getElementById('modalDetail').classList.add('hidden'); }
</script>
@endsection