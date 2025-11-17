<footer class="footer pt-3">
    <div class="container-fluid">
        <div class="row align-items-center justify-content-lg-between">
            <div class="col-lg-6 mb-lg-0 mb-4">
                <!-- <div class="copyright text-center text-sm text-muted text-lg-start">
                    © <script>
                        document.write(new Date().getFullYear())
                    </script>,
                    made with <i class="fa fa-heart"></i> by
                    <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank">Creative Tim</a>
                    for a better web.
                </div> -->
            </div>
            <div class="col-lg-6">
                <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                    <li class="nav-item"><a href="https://www.creative-tim.com" class="nav-link text-muted" target="_blank">Creative Tim</a></li>
                    <li class="nav-item"><a href="https://www.creative-tim.com/presentation" class="nav-link text-muted" target="_blank">About Us</a></li>
                    <li class="nav-item"><a href="https://www.creative-tim.com/blog" class="nav-link text-muted" target="_blank">Blog</a></li>
                    <li class="nav-item"><a href="https://www.creative-tim.com/license" class="nav-link pe-0 text-muted" target="_blank">License</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>
</div>
</main>

<!-- Core JS Files -->
<script src="<?= base_url('assets/assets/js/core/popper.min.js'); ?>"></script>
<script src="<?= base_url('assets/assets/js/core/bootstrap.min.js'); ?>"></script>
<script src="<?= base_url('assets/assets/js/plugins/perfect-scrollbar.min.js'); ?>"></script>
<script src="<?= base_url('assets/assets/js/plugins/smooth-scrollbar.min.js'); ?>"></script>
<script src="<?= base_url('assets/assets/js/argon-dashboard.min.js') ?>"></script>

<!-- Font Awesome & Nucleo -->
<script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
<link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-icons.css" rel="stylesheet">
<link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-svg.css" rel="stylesheet">

<!-- Argon Dashboard JS -->
<script src="<?= base_url('assets/assets/js/argon-dashboard.min.js?v=2.1.0'); ?>"></script>

<!-- SweetAlert2 (global) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Global SweetAlert delete confirm for any link with .btn-hapus
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('a.btn-hapus').forEach(function(btn) {
            if (btn.dataset.boundSwal === '1') return; // avoid duplicate binding
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

        // Global Horizontal Scroll dengan Alt + Scroll untuk semua tabel
        document.querySelectorAll('.table-responsive').forEach(function(tableContainer) {
            tableContainer.addEventListener('wheel', function(e) {
                // Jika tombol Alt ditekan
                if (e.altKey) {
                    e.preventDefault(); // Mencegah scroll vertikal default

                    // Scroll horizontal
                    this.scrollLeft += e.deltaY;
                }
            }, {
                passive: false
            });
        });
    });
</script>

<script>
    // Scrollbar untuk Windows
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = {
            damping: '0.5'
        }
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
</script>
<script>
    const ctx = document.getElementById('chart-line').getContext('2d');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
            datasets: [{
                label: 'Sales',
                data: [50, 60, 70, 80, 90, 100, 110],
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 3,
                tension: 0.4,
                fill: false,
                pointBackgroundColor: 'rgba(75, 192, 192, 1)',
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
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(200, 200, 200, 0.2)',
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
</script>

<script>
    $(document).ready(function() {
        $('.select2-modern').select2({
            placeholder: "-- Pilih atau Ketik Jenis Pengaduan --",
            allowClear: true,
            width: '100%'
        });

        // Hilangkan border kotak default dari select2
        $('.select2-container--default .select2-selection--single').css({
            'height': '43px',
            'border': '1px solid #d2d6da',
            'border-radius': '8px',
            'padding': '6px 12px',
            'display': 'flex',
            'align-items': 'center',
            'font-size': '0.875rem'
        });

        // Placeholder abu seperti input PIC
        $('.select2-container--default .select2-selection__placeholder').css({
            'color': '#adb5bd'
        });

        // Warna saat fokus
        $('.select2-container--default .select2-selection--single:focus').css({
            'border-color': '#5e72e4',
            'box-shadow': '0 0 0 0.2rem rgba(94,114,228,.25)'
        });

        // Panah dropdown biar lebih kecil dan elegan
        $('.select2-container--default .select2-selection__arrow').css({
            'height': '38px',
            'right': '10px'
        });
    });

    // Update notifikasi badge
    function updateNotifBadge() {
        fetch('<?= base_url("Notifikasi/ajax_unread_count"); ?>')
            .then(response => response.json())
            .then(data => {
                const badge = document.getElementById('notifBadge');
                if (badge) {
                    const count = data.unread || 0;
                    badge.textContent = count;
                    badge.style.display = count > 0 ? 'inline-block' : 'none';
                }
            })
            .catch(error => console.error('Error fetching notification count:', error));
    }

    // Update badge saat halaman dimuat
    <?php if ($this->session->userdata('logged_in')): ?>
    updateNotifBadge();
    // Update tiap 30 detik
    setInterval(updateNotifBadge, 30000);
    <?php endif; ?>
</script>

<!-- Login Activity Monitor Modal (Admin Only) -->
<?php 
$user_role = $this->session->userdata('user_role');
if (isset($user_role) && strpos(strtolower($user_role), 'admin') !== false): 
?>
<div class="modal fade" id="loginActivityModal" tabindex="-1" aria-labelledby="loginActivityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginActivityModalLabel">
                    <i class="fa fa-users me-2"></i>Login Activity Monitor
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Role Selector -->
                <div class="mb-3">
                    <label for="roleSelector" class="form-label">Select Role:</label>
                    <select class="form-select" id="roleSelector">
                        <option value="">-- All Roles Summary --</option>
                        <option value="Perencanaan">Perencanaan</option>
                        <option value="Admin">Admin</option>
                        <option value="Operasi Sistem Distribusi">Operasi Sistem Distribusi</option>
                        <option value="Fasilitas Operasi">Fasilitas Operasi</option>
                        <option value="Pemeliharaan">Pemeliharaan</option>
                        <option value="K3L & KAM">K3L & KAM</option>
                    </select>
                </div>

                <!-- Loading Spinner -->
                <div id="loadingSpinner" class="text-center my-4" style="display:none;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Loading data...</p>
                </div>

                <!-- Summary View (All Roles) -->
                <div id="summaryView" style="display:none;">
                    <h6 class="mb-3" style="font-size: 0.95rem;">Login Summary by Role</h6>
                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 35%;">Role</th>
                                    <th style="width: 18%;" class="text-center">Total Users</th>
                                    <th style="width: 18%;" class="text-center">Total Logins</th>
                                    <th style="width: 29%;">Latest Login</th>
                                </tr>
                            </thead>
                            <tbody id="summaryTableBody">
                                <!-- Populated by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Detail View (Specific Role) -->
                <div id="detailView" style="display:none;">
                    <h6 class="mb-3" style="font-size: 0.95rem;">Users in <span id="selectedRoleName" class="text-primary"></span> Role</h6>
                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 8%;" class="text-center">#</th>
                                    <th style="width: 28%;">Name</th>
                                    <th style="width: 32%;">Email</th>
                                    <th style="width: 12%;" class="text-center">Count</th>
                                    <th style="width: 20%;">Last Login</th>
                                </tr>
                            </thead>
                            <tbody id="detailTableBody">
                                <!-- Populated by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Error Message -->
                <div id="errorMessage" class="alert alert-danger" style="display:none;" role="alert">
                    <i class="fa fa-exclamation-triangle me-2"></i>
                    <span id="errorText"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const loginActivityBtn = document.getElementById('loginActivityBtn');
    if (!loginActivityBtn) return; // Exit if button doesn't exist
    
    const loginActivityModal = new bootstrap.Modal(document.getElementById('loginActivityModal'));
    const roleSelector = document.getElementById('roleSelector');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const summaryView = document.getElementById('summaryView');
    const detailView = document.getElementById('detailView');
    const errorMessage = document.getElementById('errorMessage');

    // Open modal on button click
    loginActivityBtn.addEventListener('click', function() {
        loginActivityModal.show();
        loadLoginStats(); // Load summary by default
    });

    // Handle role change
    roleSelector.addEventListener('change', function() {
        loadLoginStats();
    });

    function loadLoginStats() {
        const selectedRole = roleSelector.value;
        
        // Show loading, hide others
        loadingSpinner.style.display = 'block';
        summaryView.style.display = 'none';
        detailView.style.display = 'none';
        errorMessage.style.display = 'none';

        // Build URL
        const url = selectedRole 
            ? '<?= base_url('dashboard/get_role_login_stats') ?>?role=' + encodeURIComponent(selectedRole)
            : '<?= base_url('dashboard/get_role_login_stats') ?>';

        // Fetch data
        fetch(url)
            .then(response => response.json())
            .then(data => {
                loadingSpinner.style.display = 'none';
                
                if (data.success) {
                    if (data.summary) {
                        // Show summary view
                        displaySummary(data.summary);
                    } else if (data.users) {
                        // Show detail view
                        displayDetails(data.role, data.users);
                    }
                } else {
                    showError(data.message || 'Failed to load data');
                }
            })
            .catch(error => {
                loadingSpinner.style.display = 'none';
                showError('Network error: ' + error.message);
            });
    }

    function displaySummary(summary) {
        const tbody = document.getElementById('summaryTableBody');
        tbody.innerHTML = '';

        if (summary.length === 0) {
            tbody.innerHTML = '<tr><td colspan="4" class="text-center">No data available</td></tr>';
        } else {
            summary.forEach(item => {
                const row = document.createElement('tr');
                const formattedDate = formatDateTime(item.latest_login);
                row.innerHTML = `
                    <td><strong style="font-size: 0.85rem;">${escapeHtml(item.role || 'N/A')}</strong></td>
                    <td class="text-center">${item.total_users || 0}</td>
                    <td class="text-center"><span class="badge bg-primary">${item.total_logins || 0}</span></td>
                    <td><small>${formattedDate}</small></td>
                `;
                tbody.appendChild(row);
            });
        }

        summaryView.style.display = 'block';
    }

    function displayDetails(role, users) {
        document.getElementById('selectedRoleName').textContent = role;
        const tbody = document.getElementById('detailTableBody');
        tbody.innerHTML = '';

        if (users.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" class="text-center">No users found for this role</td></tr>';
        } else {
            users.forEach((user, index) => {
                const row = document.createElement('tr');
                const formattedDate = formatDateTime(user.last_login);
                row.innerHTML = `
                    <td class="text-center">${index + 1}</td>
                    <td style="font-size: 0.85rem;">${escapeHtml(user.name || 'N/A')}</td>
                    <td><small>${escapeHtml(user.email || 'N/A')}</small></td>
                    <td class="text-center"><span class="badge bg-info">${user.login_count || 0}</span></td>
                    <td><small>${formattedDate}</small></td>
                `;
                tbody.appendChild(row);
            });
        }

        detailView.style.display = 'block';
    }

    function formatDateTime(dateTimeString) {
        if (!dateTimeString || dateTimeString === 'Never') {
            return 'Never';
        }
        
        try {
            // Format: 2025-11-03 07:29:03 -> 03/11 07:29
            const parts = dateTimeString.split(' ');
            if (parts.length === 2) {
                const datePart = parts[0].split('-');
                const timePart = parts[1].substring(0, 5); // Get HH:MM only
                return `${datePart[2]}/${datePart[1]} ${timePart}`;
            }
            return dateTimeString;
        } catch (e) {
            return dateTimeString;
        }
    }

    function showError(message) {
        document.getElementById('errorText').textContent = message;
        errorMessage.style.display = 'block';
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
});
</script>

<style>
/* Responsive Modal for Login Activity Monitor */
#loginActivityModal .modal-dialog {
    max-width: 700px;
    width: 90%;
}

@media (max-width: 768px) {
    #loginActivityModal .modal-dialog {
        max-width: 95%;
    }
    
    #loginActivityModal table {
        font-size: 0.8rem;
    }
    
    #loginActivityModal th,
    #loginActivityModal td {
        padding: 0.4rem 0.3rem;
    }
}
</style>
<?php endif; ?>

</body>
</html>