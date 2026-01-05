<footer class="footer pt-3">
    <div class="container-fluid">
        <div class="row align-items-center justify-content-lg-between">
            <div class="col-lg-6 mb-lg-0 mb-4"></div>
            <div class="col-lg-6">
                <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                    <li class="nav-item"><a href="https://www.creative-tim.com" class="nav-link text-muted" target="_blank" rel="noopener">Creative Tim</a></li>
                    <li class="nav-item"><a href="https://www.creative-tim.com/presentation" class="nav-link text-muted" target="_blank" rel="noopener">About Us</a></li>
                    <li class="nav-item"><a href="https://www.creative-tim.com/blog" class="nav-link text-muted" target="_blank" rel="noopener">Blog</a></li>
                    <li class="nav-item"><a href="https://www.creative-tim.com/license" class="nav-link pe-0 text-muted" target="_blank" rel="noopener">License</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>

</div>
</main>

<!-- =========================
     CORE JS (Argon)
     ========================= -->
<script src="<?= base_url('assets/assets/js/core/popper.min.js'); ?>"></script>
<script src="<?= base_url('assets/assets/js/core/bootstrap.min.js'); ?>"></script>

<script src="<?= base_url('assets/assets/js/plugins/perfect-scrollbar.min.js'); ?>"></script>
<script src="<?= base_url('assets/assets/js/plugins/smooth-scrollbar.min.js'); ?>"></script>

<!-- ✅ PENTING: Argon Dashboard HANYA 1x -->
<script src="<?= base_url('assets/assets/js/argon-dashboard.min.js?v=2.1.0'); ?>"></script>

<!-- =========================
     Font Awesome (AMAN) - HAPUS KIT (403)
     ========================= -->
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- ✅ HAPUS nucleo dari demo external (sering bikin font error) -->
<!-- kalau butuh, pakai versi local yang sudah kamu load di header -->

<!-- =========================
     SweetAlert2 (global)
     ========================= -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        /* =========================
           SweetAlert delete confirm
           ========================= */
        document.querySelectorAll('a.btn-hapus').forEach(function(btn) {
            if (btn.dataset.boundSwal === '1') return;
            btn.dataset.boundSwal = '1';

            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const url = btn.getAttribute('href');
                if (!url) return;

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Data ini akan dihapus secara permanen!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            });
        });

        /* =========================
           Horizontal scroll Alt+Wheel
           ========================= */
        document.querySelectorAll('.table-responsive').forEach(function(tableContainer) {
            tableContainer.addEventListener('wheel', function(e) {
                if (e.altKey) {
                    e.preventDefault();
                    this.scrollLeft += e.deltaY;
                }
            }, {
                passive: false
            });
        });

        /* =========================
           Scrollbar Windows (aman)
           ========================= */
        try {
            var win = navigator.platform.indexOf('Win') > -1;
            if (win && document.querySelector('#sidenav-scrollbar') && window.Scrollbar) {
                Scrollbar.init(document.querySelector('#sidenav-scrollbar'), {
                    damping: '0.5'
                });
            }
        } catch (e) {
            console.error(e);
        }

        /* =========================
           Chart.js (AMAN: cek canvas)
           ========================= */
        try {
            const canvas = document.getElementById('chart-line');
            if (canvas && window.Chart) {
                const ctx = canvas.getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                        datasets: [{
                            label: 'Sales',
                            data: [50, 60, 70, 80, 90, 100, 110],
                            borderWidth: 3,
                            tension: 0.4,
                            fill: false,
                            pointRadius: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            }
        } catch (e) {
            console.error('Chart init error:', e);
        }

    });
</script>

<!-- =========================
     Select2 init (AMAN)
     ========================= -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // pastikan jQuery + select2 ada
        if (typeof window.jQuery === 'undefined') return;
        if (typeof jQuery.fn.select2 === 'undefined') return;

        $('.select2-modern').select2({
            placeholder: "-- Pilih atau Ketik --",
            allowClear: true,
            width: '100%'
        });

        // styling select2 (opsional)
        $('.select2-container--default .select2-selection--single').css({
            'height': '43px',
            'border': '1px solid #d2d6da',
            'border-radius': '8px',
            'padding': '6px 12px',
            'display': 'flex',
            'align-items': 'center',
            'font-size': '0.875rem'
        });

        $('.select2-container--default .select2-selection__placeholder').css({
            'color': '#adb5bd'
        });

        $('.select2-container--default .select2-selection__arrow').css({
            'height': '38px',
            'right': '10px'
        });
    });
</script>

<!-- =========================
     Notif badge (opsional)
     ========================= -->
<script>
    <?php if ($this->session->userdata('logged_in')): ?>
            (function() {
                function updateNotifBadge() {
                    fetch('<?= base_url("Notifikasi/ajax_unread_count"); ?>')
                        .then(r => r.json())
                        .then(data => {
                            const badge = document.getElementById('notifBadge');
                            if (!badge) return;
                            const count = data.unread || 0;
                            badge.textContent = count;
                            badge.style.display = count > 0 ? 'inline-block' : 'none';
                        })
                        .catch(err => console.error('Notif count error:', err));
                }

                document.addEventListener('DOMContentLoaded', function() {
                    updateNotifBadge();
                    setInterval(updateNotifBadge, 30000);
                });
            })();
    <?php endif; ?>
</script>

<!-- =========================
     Login Activity Monitor (Admin Only) - BIARKAN, sudah aman
     ========================= -->
<?php
$user_role = $this->session->userdata('user_role');
if (isset($user_role) && strpos(strtolower($user_role), 'admin') !== false):
?>
    <!-- (kode modal kamu tetap, tidak aku ubah; boleh tempel kembali persis seperti punyamu) -->
<?php endif; ?>

</body>

</html>