@extends('layouts.app')

@section('title', 'Order Berhasil — Wijaya Motor')

@section('content')

<div class="bg-white border-b border-gray-200 py-3">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-xs font-bold text-gray-500 tracking-wider uppercase flex items-center space-x-2">
        <a href="{{ url('/') }}" class="hover:text-danger transition">Home</a>
        <span>&rsaquo;</span>
        <a href="{{ route('sparepart.index') }}" class="hover:text-danger transition">Aksesoris & Spareparts</a>
        <span>&rsaquo;</span>
        <span class="text-ink">Konfirmasi Order</span>
    </div>
</div>

<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    {{-- Header Sukses --}}
    <div class="text-center mb-8">
        <div class="w-16 h-16 bg-green-50 border border-green-200 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        </div>
        <h1 class="text-2xl font-black text-gray-900 uppercase tracking-tight">Order Berhasil Dibuat</h1>
        <p class="text-sm text-gray-500 mt-2">Terima kasih, <strong>{{ Auth::user()->name }}</strong>. Pesanan Anda sedang menunggu konfirmasi admin.</p>
    </div>

    {{-- Detail Order --}}
    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm mb-6">
        
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
            <h2 class="text-xs font-bold text-gray-900 uppercase tracking-wider">Ringkasan Order</h2>
            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
        </div>

        <div class="p-6">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="text-left pb-3 text-[9px] font-bold text-gray-400 uppercase tracking-wider">Produk</th>
                        <th class="text-center pb-3 text-[9px] font-bold text-gray-400 uppercase tracking-wider w-12">Qty</th>
                        <th class="text-right pb-3 text-[9px] font-bold text-gray-400 uppercase tracking-wider w-32">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($order->items as $item)
                    <tr>
                        <td class="py-3">
                            <div class="flex items-center gap-3">
                                @if($item->sparepart->image)
                                    <img src="{{ asset('uploads/spareparts/' . $item->sparepart->image) }}" class="w-10 h-10 object-cover rounded-lg border border-gray-100" alt="">
                                @else
                                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    </div>
                                @endif
                                <div>
                                    <p class="font-bold text-gray-900">{{ $item->sparepart->name }}</p>
                                    <p class="text-xs text-gray-400">Rp {{ number_format($item->price, 0, ',', '.') }} / unit</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-3 text-center font-bold text-gray-700">{{ $item->qty }}</td>
                        <td class="py-3 text-right font-bold text-gray-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="border-t-2 border-gray-200 bg-gray-50">
                    <tr>
                        <td colspan="2" class="px-0 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Total Pembayaran</td>
                        <td class="py-3 text-right font-black text-danger text-base">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {{-- Info Pembayaran --}}
    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm mb-6">
        <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wider mb-4 pb-2 border-b border-gray-100">Cara Pembayaran</h3>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            {{-- Tunai saat pickup --}}
            <div class="border border-gray-200 rounded-lg p-4">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <p class="text-xs font-bold text-gray-900 uppercase tracking-wider">Tunai saat Pickup</p>
                </div>
                <p class="text-xs text-gray-500 leading-relaxed">Bayar langsung di kasir saat mengambil sparepart di bengkel. Admin akan menyiapkan barang setelah order dikonfirmasi.</p>
            </div>
            
            {{-- Transfer --}}
            <div class="border border-gray-200 rounded-lg p-4">
                <div class="flex items-center gap-2 mb-3">
                    <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    <p class="text-xs font-bold text-gray-900 uppercase tracking-wider">Transfer Bank</p>
                </div>
                <div class="space-y-2 text-xs">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Bank</span>
                        <span class="font-bold text-gray-900">{{ $bankInfo['bank'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">No. Rekening</span>
                        <span class="font-bold text-gray-900 tracking-wider">{{ $bankInfo['nomor'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Atas Nama</span>
                        <span class="font-bold text-gray-900">{{ $bankInfo['atas_nama'] }}</span>
                    </div>
                    <div class="border-t border-gray-100 pt-2 flex justify-between">
                        <span class="text-gray-500">Nominal</span>
                        <span class="font-black text-danger">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4 bg-amber-50 border border-amber-100 rounded-lg px-4 py-3">
            <p class="text-xs text-amber-700 font-bold">
                Pickup berlaku setelah admin mengkonfirmasi order. Anda akan dihubungi melalui data profil terdaftar.
            </p>
        </div>
    </div>

    {{-- Actions --}}
    <div class="flex flex-col sm:flex-row gap-3">
        <a href="{{ route('customer.pesanan') }}?tab=sparepart" class="flex-1 bg-gray-900 hover:bg-black text-white text-xs font-bold uppercase tracking-widest py-3.5 rounded-xl text-center transition shadow-sm">
            Lihat Riwayat Pesanan
        </a>
        <a href="{{ route('sparepart.index') }}" class="flex-1 border border-gray-200 hover:bg-gray-50 text-gray-700 text-xs font-bold uppercase tracking-widest py-3.5 rounded-xl text-center transition">
            Lanjut Belanja
        </a>
    </div>

</div>

@endsection
