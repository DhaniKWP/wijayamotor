<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // 1. Tangkap Flash Message Session dari Laravel
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{!! session('success') !!}",
            timer: 3000,
            showConfirmButton: false,
            customClass: {
                popup: 'rounded-2xl',
            }
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "{!! session('error') !!}",
            customClass: {
                popup: 'rounded-2xl',
                confirmButton: 'bg-danger text-white px-5 py-2 rounded-xl font-bold'
            }
        });
    @endif

    @if($errors->any())
        Swal.fire({
            icon: 'warning',
            title: 'Peringatan Validasi',
            html: `
                <ul class="text-left text-sm text-gray-600 mb-0">
                    @foreach($errors->all() as $error)
                        <li class="mb-1">⚠️ {{ $error }}</li>
                    @endforeach
                </ul>
            `,
            customClass: {
                popup: 'rounded-2xl',
                confirmButton: 'bg-danger text-white px-5 py-2 rounded-xl font-bold'
            }
        });
    @endif

    @if(session('status'))
        Swal.fire({
            icon: 'info',
            title: 'Informasi',
            text: "{!! session('status') !!}",
            customClass: {
                popup: 'rounded-2xl',
                confirmButton: 'bg-blue-600 text-white px-5 py-2 rounded-xl font-bold'
            }
        });
    @endif

    // 2. Ubah semua alert Confirm bawaan browser (Javascript confirm) jadi SweetAlert
    document.addEventListener('DOMContentLoaded', function () {
        // A. Handle elemen <form onsubmit="return confirm('...')">
        const confirmForms = document.querySelectorAll('form[onsubmit*="return confirm"]');
        confirmForms.forEach(form => {
            const onsubmitAttr = form.getAttribute('onsubmit');
            const match = onsubmitAttr.match(/confirm\(['"](.*?)['"]\)/);
            const msg = match ? match[1] : 'Yakin ingin melanjutkan?';
            
            form.removeAttribute('onsubmit');
            
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Konfirmasi Tindakan',
                    text: msg,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, Lanjutkan!',
                    cancelButtonText: 'Batal',
                    customClass: {
                        popup: 'rounded-2xl',
                        confirmButton: 'rounded-xl',
                        cancelButton: 'rounded-xl'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // B. Handle elemen <button onclick="return confirm('...')"> atau <a>
        const confirmBtns = document.querySelectorAll('[onclick*="return confirm"]');
        confirmBtns.forEach(btn => {
            const onclickAttr = btn.getAttribute('onclick');
            const match = onclickAttr.match(/confirm\(['"](.*?)['"]\)/);
            const msg = match ? match[1] : 'Yakin ingin melanjutkan?';
            
            btn.removeAttribute('onclick');
            
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Konfirmasi',
                    text: msg,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, Lanjutkan!',
                    cancelButtonText: 'Batal',
                    customClass: {
                        popup: 'rounded-2xl',
                        confirmButton: 'rounded-xl',
                        cancelButton: 'rounded-xl'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (btn.type === 'submit' && btn.closest('form')) {
                            btn.closest('form').submit();
                        } else if (btn.tagName === 'A') {
                            window.location.href = btn.href;
                        }
                    }
                });
            });
        });
    });
</script>
