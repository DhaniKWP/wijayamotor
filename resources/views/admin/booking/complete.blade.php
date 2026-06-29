@extends('layouts.admin')

@section('title', 'Work Order Servis - Wijaya Motor')
@section('header_title', 'Input Hasil Servis')

@section('content')

<div class="max-w-4xl mx-auto space-y-6">

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-xs font-bold text-slate-400">
        <a href="{{ route('admin.bookings.index') }}" class="hover:text-brand transition-colors">Manajemen Booking</a>
        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
        <span class="text-slate-600">Selesaikan Servis #WM-{{ $booking->id }}</span>
    </div>

    {{-- Info Header Booking --}}
    <div class="bg-white border border-slate-200/60 rounded-xl shadow-sm overflow-hidden">
        <div class="bg-gradient-to-r from-slate-800 to-slate-900 px-6 py-4 flex items-center justify-between">
            <div>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Work Order</p>
                <h2 class="text-white font-black text-lg tracking-tight">WM-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</h2>
            </div>
            <div class="text-right">
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Tanggal Servis</p>
                <p class="text-white font-bold text-sm">{{ \Carbon\Carbon::parse($booking->tanggal)->translatedFormat('d F Y') }}</p>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 divide-x divide-slate-100 border-t border-slate-100">
            <div class="px-5 py-4">
                <p class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">Pelanggan</p>
                <p class="text-sm font-bold text-slate-800">{{ $booking->user->name ?? $booking->user->username ?? '-' }}</p>
                <p class="text-xs text-slate-400 font-medium">{{ $booking->user->no_telp ?? $booking->user->phone ?? '-' }}</p>
            </div>
            <div class="px-5 py-4">
                <p class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">Kendaraan</p>
                <p class="text-sm font-bold text-slate-800">{{ $booking->vehicle->merek ?? $booking->vehicle->name ?? '-' }}</p>
                <span class="inline-block text-[10px] font-mono font-black bg-slate-900 text-white px-2 py-0.5 rounded tracking-widest mt-1">{{ $booking->vehicle->plat_nomor ?? $booking->vehicle->plate_number ?? '-' }}</span>
            </div>
            <div class="px-5 py-4">
                <p class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">Layanan Utama</p>
                <p class="text-sm font-bold text-slate-800">{{ $booking->service->name ?? '-' }}</p>
                <p class="text-xs text-slate-400 font-medium">{{ $booking->kilometer ? number_format($booking->kilometer, 0, ',', '.') . ' KM' : '' }}</p>
            </div>
            <div class="px-5 py-4">
                <p class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">Estimasi Awal</p>
                <p class="text-sm font-black text-brand">Rp {{ number_format($booking->estimasi_harga ?? 0, 0, ',', '.') }}</p>
                <p class="text-[10px] text-slate-400">Akan diupdate ke harga final</p>
            </div>
        </div>
    </div>

    {{-- Form Work Order --}}
    <form id="workOrderForm" action="{{ route('admin.bookings.complete.transaction', $booking->id) }}" method="POST">
        @csrf

        {{-- Tabel Item Servis --}}
        <div class="bg-white border border-slate-200/60 rounded-xl shadow-sm overflow-hidden mb-5">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-extrabold text-slate-800 uppercase tracking-tight">Rincian Pekerjaan & Item</h3>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mt-0.5">Tambahkan jasa dan sparepart yang digunakan</p>
                </div>
                <button type="button" id="btnAddRow"
                    class="inline-flex items-center gap-1.5 bg-brand text-white px-4 py-2 rounded-lg text-xs font-black hover:bg-brand/90 transition-all shadow-sm">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    Tambah Baris
                </button>
            </div>

            {{-- Baris item service utama (readonly, auto-filled dari master katalog servis) --}}
            <div class="px-6 pt-4 pb-2">
                <div class="flex items-center gap-2 px-4 py-3 bg-brand/5 border border-brand/20 rounded-lg">
                    <div class="w-6 h-6 rounded-full bg-brand/20 flex items-center justify-center shrink-0">
                        <svg class="w-3.5 h-3.5 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-black text-brand">{{ $booking->service->name ?? 'Layanan Utama' }}</p>
                        <p class="text-[10px] text-slate-500">Biaya jasa dasar (dari master katalog servis)</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs font-black text-slate-800">Rp {{ number_format($booking->service->price_estimate ?? 0, 0, ',', '.') }}</p>
                        <p class="text-[10px] text-slate-400">Sudah termasuk</p>
                    </div>
                </div>
            </div>

            {{-- Dynamic rows --}}
            <div class="overflow-x-auto px-6 pb-4 mt-3">
                <table class="w-full text-xs" id="itemsTable">
                    <thead>
                        <tr class="border-b border-slate-100">
                            <th class="text-left py-2.5 text-[9px] font-extrabold text-slate-400 uppercase tracking-wider w-28">Tipe</th>
                            <th class="text-left py-2.5 text-[9px] font-extrabold text-slate-400 uppercase tracking-wider">Item / Nama Jasa</th>
                            <th class="text-left py-2.5 text-[9px] font-extrabold text-slate-400 uppercase tracking-wider w-14">Qty</th>
                            <th class="text-left py-2.5 text-[9px] font-extrabold text-slate-400 uppercase tracking-wider w-36">Harga Satuan</th>
                            <th class="text-right py-2.5 text-[9px] font-extrabold text-slate-400 uppercase tracking-wider w-32">Subtotal</th>
                            <th class="w-8"></th>
                        </tr>
                    </thead>
                    <tbody id="itemsBody">
                        {{-- JS akan inject baris di sini --}}
                    </tbody>
                </table>

                <p id="emptyMsg" class="text-center text-slate-400 text-xs italic py-6">Belum ada item tambahan. Klik "Tambah Baris" untuk mulai.</p>
            </div>
        </div>

        {{-- Ringkasan Total & Pembayaran --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            {{-- Metode Pembayaran --}}
            <div class="bg-white border border-slate-200/60 rounded-xl shadow-sm p-6">
                <h3 class="text-sm font-extrabold text-slate-800 uppercase tracking-tight mb-4">Metode Pembayaran</h3>
                <div class="grid grid-cols-2 gap-3">
                    <label class="payment-option cursor-pointer">
                        <input type="radio" name="payment_method" value="cash" class="sr-only" checked>
                        <div class="payment-card border-2 border-brand bg-brand/5 rounded-xl p-4 text-center transition-all">
                            <svg class="w-6 h-6 mx-auto mb-2 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            <p class="text-xs font-black text-brand">TUNAI</p>
                            <p class="text-[10px] text-slate-400 mt-0.5">Bayar di kasir</p>
                        </div>
                    </label>
                    <label class="payment-option cursor-pointer">
                        <input type="radio" name="payment_method" value="transfer" class="sr-only">
                        <div class="payment-card border-2 border-slate-200 rounded-xl p-4 text-center transition-all hover:border-slate-300">
                            <svg class="w-6 h-6 mx-auto mb-2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                            <p class="text-xs font-black text-slate-600">TRANSFER</p>
                            <p class="text-[10px] text-slate-400 mt-0.5">Bank / e-wallet</p>
                        </div>
                    </label>
                </div>
            </div>

            {{-- Ringkasan Biaya --}}
            <div class="bg-white border border-slate-200/60 rounded-xl shadow-sm p-6">
                <h3 class="text-sm font-extrabold text-slate-800 uppercase tracking-tight mb-4">Ringkasan Biaya</h3>
                <div class="space-y-2.5 text-sm">
                    <div class="flex justify-between text-slate-500">
                        <span>Jasa Dasar ({{ $booking->service->name ?? '-' }})</span>
                        <span class="font-bold">Rp <span id="summaryBase">{{ number_format($booking->service->price_estimate ?? 0, 0, ',', '.') }}</span></span>
                    </div>
                    <div class="flex justify-between text-slate-500">
                        <span>Jasa Tambahan</span>
                        <span class="font-bold">Rp <span id="summaryJasa">0</span></span>
                    </div>
                    <div class="flex justify-between text-slate-500">
                        <span>Sparepart</span>
                        <span class="font-bold">Rp <span id="summarySparepart">0</span></span>
                    </div>
                    <div class="border-t border-slate-100 pt-3 flex justify-between text-slate-800">
                        <span class="font-extrabold text-sm">TOTAL</span>
                        <span class="font-black text-brand text-lg">Rp <span id="summaryTotal">{{ number_format($booking->service->price_estimate ?? 0, 0, ',', '.') }}</span></span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex items-center justify-between mt-6">
            <a href="{{ route('admin.bookings.index') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-slate-700 text-sm font-bold transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                Kembali
            </a>
            <button type="submit" id="btnSubmit"
                class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-3 rounded-xl text-sm font-black shadow-md shadow-emerald-600/20 transition-all active:scale-95 focus:outline-none">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Selesaikan & Buat Invoice
            </button>
        </div>
    </form>
</div>

{{-- Data spareparts untuk JS --}}
<script id="spareparts-data" type="application/json">
    {!! json_encode($spareparts->map(fn($s) => [
        'id'    => $s->id,
        'name'  => $s->name,
        'price' => floatval($s->price),
        'stock' => $s->stock,
    ])) !!}
</script>

<script>
    const spareparts = JSON.parse(document.getElementById('spareparts-data').textContent);
    const basePrice  = {{ floatval($booking->service->price_estimate ?? 0) }};
    let rowIndex     = 0;

    // =====================
    // BUILD SPAREPART OPTIONS
    // =====================
    function buildSparepartOptions() {
        return spareparts.map(s =>
            `<option value="${s.id}" data-price="${s.price}" data-stock="${s.stock}">${s.name} (Stok: ${s.stock})</option>`
        ).join('');
    }

    // =====================
    // ADD ROW
    // =====================
    document.getElementById('btnAddRow').addEventListener('click', () => addRow());

    function addRow(type = 'jasa') {
        document.getElementById('emptyMsg').style.display = 'none';
        const tbody = document.getElementById('itemsBody');
        const idx   = rowIndex++;

        const tr = document.createElement('tr');
        tr.className = 'item-row border-b border-slate-50 hover:bg-slate-50/30 transition-colors';
        tr.dataset.idx = idx;

        tr.innerHTML = `
            <td class="py-2.5 pr-3">
                <select name="items[${idx}][item_type]" onchange="onTypeChange(this)"
                    class="w-full border border-slate-200 rounded-lg text-xs font-bold text-slate-700 py-2 px-3 focus:ring-2 focus:ring-brand/30 focus:border-brand bg-white">
                    <option value="jasa" ${type==='jasa'?'selected':''}>Jasa Tambahan</option>
                    <option value="sparepart" ${type==='sparepart'?'selected':''}>Sparepart</option>
                </select>
            </td>
            <td class="py-2.5 pr-3">
                <div class="item-name-wrapper">
                    <!-- Jasa: text input -->
                    <input type="text" name="items[${idx}][item_name]" placeholder="Nama jasa, mis: Tune Up, Balancing..."
                        class="jasa-input w-full border border-slate-200 rounded-lg text-xs font-semibold text-slate-700 py-2 px-3 focus:ring-2 focus:ring-brand/30 focus:border-brand ${type==='sparepart'?'hidden':''}">
                    <!-- Sparepart: dropdown -->
                    <select name="items[${idx}][sparepart_id]" onchange="onSparepartChange(this)"
                        class="sparepart-input w-full border border-slate-200 rounded-lg text-xs font-semibold text-slate-700 py-2 px-3 focus:ring-2 focus:ring-brand/30 focus:border-brand bg-white ${type==='jasa'?'hidden':''}">
                        <option value="">— Pilih Sparepart —</option>
                        ${buildSparepartOptions()}
                    </select>
                </div>
                <input type="text" name="items[${idx}][note]" placeholder="Catatan (opsional)"
                    class="mt-1.5 w-full border border-slate-100 bg-slate-50/50 rounded-lg text-[10px] text-slate-400 py-1.5 px-3 focus:ring-1 focus:ring-brand/20 focus:border-brand">
            </td>
            <td class="py-2.5 pr-3">
                <input type="number" name="items[${idx}][qty]" value="1" min="1"
                    oninput="recalcRow(this)"
                    class="w-14 border border-slate-200 rounded-lg text-xs font-bold text-center text-slate-700 py-2 px-2 focus:ring-2 focus:ring-brand/30 focus:border-brand">
            </td>
            <td class="py-2.5 pr-3">
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs font-bold">Rp</span>
                    <input type="number" name="items[${idx}][price]" value="0" min="0" step="500"
                        oninput="recalcRow(this)"
                        class="price-input w-full border border-slate-200 rounded-lg text-xs font-bold text-slate-700 py-2 pl-8 pr-3 focus:ring-2 focus:ring-brand/30 focus:border-brand">
                </div>
            </td>
            <td class="py-2.5 text-right">
                <span class="subtotal-display text-xs font-black text-slate-800">Rp 0</span>
            </td>
            <td class="py-2.5 pl-2">
                <button type="button" onclick="removeRow(this)"
                    class="w-7 h-7 flex items-center justify-center rounded-lg text-slate-300 hover:text-rose-500 hover:bg-rose-50 transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </td>
        `;

        tbody.appendChild(tr);
        recalcAll();
    }

    // =====================
    // TIPE CHANGE (jasa ↔ sparepart)
    // =====================
    function onTypeChange(select) {
        const row = select.closest('tr');
        const isSparepart = select.value === 'sparepart';
        row.querySelector('.jasa-input').classList.toggle('hidden', isSparepart);
        row.querySelector('.sparepart-input').classList.toggle('hidden', !isSparepart);

        // Reset price jika ganti tipe
        if (!isSparepart) {
            row.querySelector('.price-input').value = 0;
            // Reset max attr
            row.querySelector('input[name*="[qty]"]').removeAttribute('max');
        } else {
            // Auto trigger change untuk update max attr
            onSparepartChange(row.querySelector('.sparepart-input'));
        }
        recalcAll();
    }

    // =====================
    // SPAREPART SELECTED → AUTO FILL PRICE & SET MAX QTY
    // =====================
    function onSparepartChange(select) {
        const row = select.closest('tr');
        const selectedOpt = select.options[select.selectedIndex];
        if (!selectedOpt.value) return;

        const price = selectedOpt.dataset.price || 0;
        const stock = parseInt(selectedOpt.dataset.stock) || 0;
        
        const qtyInput = row.querySelector('input[name*="[qty]"]');
        qtyInput.max = stock;
        
        if (parseInt(qtyInput.value) > stock) {
            qtyInput.value = stock;
            alert(`Stok maksimal untuk ${selectedOpt.text.split('(')[0].trim()} adalah ${stock}`);
        }

        row.querySelector('.price-input').value = price;
        recalcRow(row.querySelector('.price-input'));
    }

    // =====================
    // REMOVE ROW
    // =====================
    function removeRow(btn) {
        const row = btn.closest('tr');
        row.remove();
        if (document.querySelectorAll('.item-row').length === 0) {
            document.getElementById('emptyMsg').style.display = 'block';
        }
        recalcAll();
    }

    // =====================
    // RECALC PER-ROW
    // =====================
    function recalcRow(inputEl) {
        const row = inputEl.closest('tr');
        const qtyInput = row.querySelector('input[name*="[qty]"]');
        let qty = parseInt(qtyInput.value) || 0;

        // --- CHECK STOCK IF TYPE IS SPAREPART ---
        const type = row.querySelector('select[name*="[item_type]"]').value;
        if (type === 'sparepart') {
            const spSelect = row.querySelector('select[name*="[sparepart_id]"]');
            const selectedOpt = spSelect.options[spSelect.selectedIndex];
            if (selectedOpt && selectedOpt.value) {
                const stock = parseInt(selectedOpt.dataset.stock) || 0;
                if (qty > stock) {
                    qty = stock;
                    qtyInput.value = stock;
                    alert(`Stok tidak mencukupi! Sisa stok hanya ${stock}.`);
                }
            }
        }
        // ----------------------------------------

        const price = parseFloat(row.querySelector('.price-input').value) || 0;
        const subtotal = qty * price;
        row.querySelector('.subtotal-display').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
        recalcAll();
    }

    // =====================
    // RECALC TOTALS
    // =====================
    function recalcAll() {
        let jasaTotal = 0;
        let sparepartTotal = 0;

        document.querySelectorAll('.item-row').forEach(row => {
            const type     = row.querySelector('select[name*="[item_type]"]').value;
            const qty      = parseInt(row.querySelector('input[name*="[qty]"]').value) || 0;
            const price    = parseFloat(row.querySelector('.price-input').value) || 0;
            const subtotal = qty * price;

            if (type === 'jasa') {
                jasaTotal += subtotal;
            } else {
                sparepartTotal += subtotal;
            }
        });

        const grandTotal = basePrice + jasaTotal + sparepartTotal;

        document.getElementById('summaryJasa').textContent      = jasaTotal.toLocaleString('id-ID');
        document.getElementById('summarySparepart').textContent = sparepartTotal.toLocaleString('id-ID');
        document.getElementById('summaryTotal').textContent     = grandTotal.toLocaleString('id-ID');
    }

    // =====================
    // PAYMENT METHOD TOGGLE
    // =====================
    document.querySelectorAll('.payment-option input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', () => {
            document.querySelectorAll('.payment-card').forEach(card => {
                card.classList.remove('border-brand', 'bg-brand/5');
                card.classList.add('border-slate-200');
                card.querySelectorAll('p').forEach(p => {
                    p.classList.remove('text-brand');
                    if (p.classList.contains('text-xs')) p.classList.add('text-slate-600');
                });
                card.querySelector('svg').classList.replace('text-brand', 'text-slate-400');
            });
            const activeCard = radio.closest('.payment-option').querySelector('.payment-card');
            activeCard.classList.add('border-brand', 'bg-brand/5');
            activeCard.classList.remove('border-slate-200');
            activeCard.querySelector('p.text-xs').classList.add('text-brand');
            activeCard.querySelector('p.text-xs').classList.remove('text-slate-600');
            activeCard.querySelector('svg').classList.replace('text-slate-400', 'text-brand');
        });
    });

    // =====================
    // FORM VALIDATION
    // =====================
    document.getElementById('workOrderForm').addEventListener('submit', function(e) {
        const rows = document.querySelectorAll('.item-row');
        // Boleh submit meski 0 baris tambahan (service utama sudah ada)
        // Tapi validasi setiap baris yang ada harus lengkap
        let valid = true;
        rows.forEach(row => {
            const type = row.querySelector('select[name*="[item_type]"]').value;
            if (type === 'jasa') {
                const name = row.querySelector('input[name*="[item_name]"]').value.trim();
                if (!name) { valid = false; }
            } else {
                const spId = row.querySelector('select[name*="[sparepart_id]"]').value;
                if (!spId) { valid = false; }
            }
        });

        if (!valid) {
            e.preventDefault();
            alert('Mohon lengkapi semua baris item. Pastikan nama jasa atau sparepart sudah dipilih.');
            return;
        }

        document.getElementById('btnSubmit').disabled = true;
        document.getElementById('btnSubmit').innerHTML = `
            <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
            Memproses...
        `;
    });
</script>

@endsection
