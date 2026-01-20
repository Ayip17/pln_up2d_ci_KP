<main class="main-content position-relative border-radius-lg ">
    <?php $this->load->view('layout/navbar'); ?>

    <div class="container-fluid py-4">


        <!-- Login counter widget (separate from notifications) -->
        <div class="row mb-3 align-items-center">
            <div class="col-12 col-md-6 col-lg-5">
                <div class="card login-count-card dashboard-elevated">
                    <div class="card-body p-3">
                        <div class="row align-items-center">
                            <!-- Left Section: Icon & Badge -->
                            <div class="col-auto">
                                <div class="d-flex flex-column align-items-center">
                                    <div class="icon icon-shape bg-gradient-info shadow-info rounded-circle d-flex align-items-center justify-content-center mb-2" style="width:64px; height:64px;">
                                        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img">
                                            <path d="M8 12h8" stroke="#FFFFFF" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M12 8l4 4-4 4" stroke="#FFFFFF" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M3 3v18a2 2 0 0 0 2 2h8" stroke="#FFFFFF" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                    <?php if (isset($user_role) && $user_role):
                                        $badge_color = 'bg-gradient-secondary';
                                        $role_lower = strtolower($user_role);
                                        if (strpos($role_lower, 'admin') !== false) {
                                            $badge_color = 'bg-gradient-danger';
                                        } elseif (strpos($role_lower, 'perencanaan') !== false) {
                                            $badge_color = 'bg-gradient-primary';
                                        } elseif (strpos($role_lower, 'operasi') !== false) {
                                            $badge_color = 'bg-gradient-success';
                                        } elseif (strpos($role_lower, 'pemeliharaan') !== false) {
                                            $badge_color = 'bg-gradient-warning';
                                        } elseif (strpos($role_lower, 'fasilitas') !== false) {
                                            $badge_color = 'bg-gradient-info';
                                        }
                                    ?>
                                        <span class="badge <?php echo $badge_color; ?>" style="font-size: 0.7rem; padding: 0.4em 0.7em;">
                                            <i class="fas fa-user-tag" style="font-size: 0.65rem;"></i>
                                            <span class="ms-1"><?php echo strtoupper(htmlspecialchars($user_role)); ?></span>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Right Section: Info -->
                            <div class="col">
                                <div class="ps-2">
                                    <p class="text-xs text-uppercase text-secondary font-weight-bold mb-1 opacity-7">Login Count</p>
                                    <h4 class="font-weight-bolder mb-2" style="font-size: 2rem; line-height: 1;">
                                        <?php echo isset($login_count) ? intval($login_count) : '—'; ?>
                                    </h4>
                                    <p class="text-sm mb-0 text-secondary" style="line-height: 1.4;">
                                        <i class="far fa-clock me-1 text-info"></i>
                                        <span class="font-weight-normal">Last login:</span>
                                    </p>
                                    <p class="text-sm mb-0 font-weight-bold" style="line-height: 1.2;">
                                        <?php echo isset($last_login) && $last_login ? $last_login : '—'; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $riwayat_aktivitas = isset($riwayat_aktivitas) ? $riwayat_aktivitas : [];
        ?>

        <!-- ====== Dashboard disederhanakan: Shortcut Asset + Carousel + Riwayat Aktivitas ====== -->
        <div class="row mt-1">

            <div class="col-lg-7 mb-lg-0 mb-4">

                <div class="card mb-4 dashboard-elevated">
                    <div class="card-header pb-0 p-3">
                        <h6 class="mb-0">Shortcut Asset</h6>
                    </div>
                    <div class="card-body p-3">
                        <div class="d-flex flex-wrap gap-2">
                            <a class="btn btn-sm btn-outline-dark mb-0" href="<?= base_url('Unit'); ?>"><i class="fas fa-sitemap me-1"></i>Unit</a>
                            <a class="btn btn-sm btn-outline-dark mb-0" href="<?= base_url('Gardu_induk'); ?>"><i class="fas fa-bolt me-1"></i>Gardu Induk</a>
                            <a class="btn btn-sm btn-outline-dark mb-0" href="<?= base_url('Gi_cell'); ?>"><i class="fas fa-th-large me-1"></i>GI Cell</a>
                            <a class="btn btn-sm btn-outline-dark mb-0" href="<?= base_url('Gardu_hubung'); ?>"><i class="fas fa-project-diagram me-1"></i>Gardu Hubung</a>
                            <a class="btn btn-sm btn-outline-dark mb-0" href="<?= base_url('Gh_cell'); ?>"><i class="fas fa-th me-1"></i>GH Cell</a>
                            <a class="btn btn-sm btn-outline-dark mb-0" href="<?= base_url('Pembangkit'); ?>"><i class="fas fa-industry me-1"></i>Pembangkit</a>
                            <a class="btn btn-sm btn-outline-dark mb-0" href="<?= base_url('Kit_cell'); ?>"><i class="fas fa-microchip me-1"></i>Kit Cell</a>
                            <a class="btn btn-sm btn-outline-dark mb-0" href="<?= base_url('Pemutus'); ?>"><i class="fas fa-toggle-off me-1"></i>Pemutus</a>
                        </div>
                    </div>
                </div>

                <!-- Slide Show -->
                <div class="card card-carousel overflow-hidden p-0 dashboard-elevated dashboard-carousel">
                    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner border-radius-lg">
                            <div class="carousel-item active" style="background-image: url('assets/assets/img/p2tl_pln.png'); background-size: cover;">
                                <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                                    <div class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3" style="width:25px; height:25px; line-height:25px;">
                                        <i class="fas fa-image text-dark" style="font-size:12px;"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="carousel-item" style="background-image: url('assets/assets/img/Pln_stop_listrik_ilegal.png'); background-size: cover;">
                                <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                                    <div class="icon icon-shape bg-white border-radius-md mb-3"
                                        style=" width: 25px; height: 25px; display: flex; align-items: center; justify-content: center; line-height: 0; ">
                                        <i class="fas fa-lightbulb text-dark" style="font-size: 14px;"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="carousel-item" style="background-image: url('assets/assets/img/penertiban.png'); background-size: cover;">
                                <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                                    <div class="icon icon-shape bg-white border-radius-md mb-3"
                                        style="width: 25px; height: 25px; display: flex; align-items: center; justify-content: center; line-height: 1; padding-top: 1px;">
                                        <i class="fas fa-trophy text-dark" style="font-size: 14px;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="carousel-control-prev w-5 me-3" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next w-5 me-3" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>

            </div>

            <!-- ====== Riwayat Aktivitas ====== -->
            <div class="col-lg-5">
                <div class="card dashboard-elevated">
                    <div class="card-header pb-0 p-3 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Riwayat Aktivitas</h6>
                        <a href="<?= base_url('Notifikasi'); ?>" class="btn btn-sm btn-outline-primary mb-0">
                            Lihat Semua
                        </a>
                    </div>

                    <div class="card-body p-3">
                        <?php if (!empty($riwayat_aktivitas)): ?>

                            <div class="activity-scroll">
                                <ul class="list-group">
                                    <?php foreach ($riwayat_aktivitas as $n): ?>
                                        <?php
                                            $jenis = strtolower($n['jenis_aktivitas'] ?? '');
                                            $icon = 'fas fa-bell';
                                            $badge = 'bg-dark';
                                            $badgeText = ucfirst($jenis);

                                            if ($jenis === 'login') { $icon = 'fas fa-sign-in-alt'; $badge = 'bg-success'; $badgeText = 'Login'; }
                                            else if ($jenis === 'logout') { $icon = 'fas fa-sign-out-alt'; $badge = 'bg-secondary'; $badgeText = 'Logout'; }
                                            else if ($jenis === 'create') { $icon = 'fas fa-plus'; $badge = 'bg-success'; $badgeText = 'Tambah'; }
                                            else if ($jenis === 'update') { $icon = 'fas fa-pen'; $badge = 'bg-warning text-dark'; $badgeText = 'Edit'; }
                                            else if ($jenis === 'delete') { $icon = 'fas fa-trash'; $badge = 'bg-danger'; $badgeText = 'Hapus'; }
                                            else if ($jenis === 'import') { $icon = 'fas fa-file-import'; $badge = 'bg-info'; $badgeText = 'Import'; }

                                            $timeText = (!empty($n['tanggal_waktu'])) ? date('d M Y H:i', strtotime($n['tanggal_waktu'])) : '—';
                                            $emailText = htmlspecialchars($n['email'] ?? '—');
                                            $roleText = htmlspecialchars($n['role'] ?? '—');
                                            $descText = htmlspecialchars($n['deskripsi'] ?? '—');

                                            $link = '';
                                            if (!empty($n['module']) && !empty($n['record_id']) && $jenis !== 'delete') {
                                                $link = base_url('Notifikasi/read/' . $n['id']);
                                            }
                                        ?>

                                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                            <div class="d-flex align-items-center">
                                                <div class="icon bg-gradient-dark shadow text-center d-flex align-items-center justify-content-center me-3"
                                                    style="width: 28px; height: 28px; border-radius: 50%;">
                                                    <i class="<?= $icon; ?> text-white" style="font-size: 12px;"></i>
                                                </div>

                                                <div class="d-flex flex-column">
                                                    <h6 class="mb-1 text-dark text-sm">
                                                        <?= $emailText; ?>
                                                        <span class="badge bg-info text-white ms-1" style="font-size:10px;">
                                                            <?= $roleText; ?>
                                                        </span>
                                                        <span class="badge <?= $badge; ?> ms-1" style="font-size:10px;">
                                                            <?= $badgeText; ?>
                                                        </span>
                                                    </h6>

                                                    <?php if (!empty($link)): ?>
                                                        <a href="<?= $link; ?>" class="text-xs text-primary text-decoration-none">
                                                            <?= $descText; ?>
                                                            <i class="fas fa-chevron-right ms-1" style="font-size: 10px;"></i>
                                                        </a>
                                                    <?php else: ?>
                                                        <span class="text-xs"><?= $descText; ?></span>
                                                    <?php endif; ?>

                                                    <span class="text-xs text-muted"><?= $timeText; ?></span>
                                                </div>
                                            </div>

                                            <button class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto">
                                                <i class="fas fa-chevron-right" aria-hidden="true" style="font-size: 10px;"></i>
                                            </button>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>

                        <?php else: ?>
                            <div class="text-center text-muted py-5">
                                <i class="fas fa-bell-slash text-muted" style="font-size: 48px;"></i>
                                <p class="mt-3">Belum ada aktivitas terbaru</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Modal: Login Activity Monitor (Admin Only) -->
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

                    <div id="loadingSpinner" class="text-center my-4" style="display:none;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Loading data...</p>
                    </div>

                    <div id="summaryView" style="display:none;">
                        <h6 class="mb-3" style="font-size: 0.95rem;">Login Summary by Role</h6>
                        <div class="table-responsive">
                            <table class="table table-hover table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 35%;">Role</th>
                                        <th style="width: 18%;" class="text-center">Users</th>
                                        <th style="width: 18%;" class="text-center">Logins</th>
                                        <th style="width: 29%;">Latest</th>
                                    </tr>
                                </thead>
                                <tbody id="summaryTableBody"></tbody>
                            </table>
                        </div>
                    </div>

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
                                <tbody id="detailTableBody"></tbody>
                            </table>
                        </div>
                    </div>

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

</main>

<style>
/* Dashboard: bikin batas card jelas di background 2 warna */
.dashboard-elevated{
    box-shadow: 0 14px 32px rgba(0,0,0,0.16) !important;
    border: 1px solid rgba(0,0,0,0.04);
}

/* Carousel: beri tinggi minimum agar tidak kepotong */
.dashboard-carousel{
    border-radius: 14px;
    min-height: 360px;
}
.dashboard-carousel .carousel,
.dashboard-carousel .carousel-inner,
.dashboard-carousel .carousel-item{
    height: 360px;
}
.dashboard-carousel .carousel-item{
    background-position: center;
}
@media (max-width: 768px){
    .dashboard-carousel{ min-height: 260px; }
    .dashboard-carousel .carousel,
    .dashboard-carousel .carousel-inner,
    .dashboard-carousel .carousel-item{ height: 260px; }
}

/* Login Count Card */
.login-count-card { transition: transform 0.2s ease, box-shadow 0.2s ease !important; }
.login-count-card:hover { transform: translateY(-2px) !important; box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.15) !important; }
.login-count-card .icon-shape { transition: transform 0.2s ease !important; }
.login-count-card:hover .icon-shape { transform: scale(1.05) !important; }
.login-count-card .badge { white-space: nowrap; box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075); }
@media (max-width: 768px) { .login-count-card .col-auto { margin-bottom: 0.5rem; } .login-count-card h4 { font-size: 1.5rem !important; } }

/* Activity scroll */
.activity-scroll{
    max-height: 355px;
    overflow-y: auto;
    padding-right: 6px;
}
.activity-scroll::-webkit-scrollbar{ width: 6px; }
.activity-scroll::-webkit-scrollbar-thumb{ background: rgba(0,0,0,0.15); border-radius: 10px; }
.activity-scroll::-webkit-scrollbar-track{ background: transparent; }
</style>

<?php if (isset($user_role) && in_array(strtolower($user_role), ['admin', 'administrator'], true)): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const loginActivityBtn = document.getElementById('loginActivityBtn');
    if (!loginActivityBtn) return;

    const loginActivityModal = new bootstrap.Modal(document.getElementById('loginActivityModal'));
    const roleSelector = document.getElementById('roleSelector');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const summaryView = document.getElementById('summaryView');
    const detailView = document.getElementById('detailView');
    const errorMessage = document.getElementById('errorMessage');

    loginActivityBtn.addEventListener('click', function() {
        loginActivityModal.show();
        loadLoginStats();
    });

    roleSelector.addEventListener('change', function() {
        loadLoginStats();
    });

    function loadLoginStats() {
        const selectedRole = roleSelector.value;

        loadingSpinner.style.display = 'block';
        summaryView.style.display = 'none';
        detailView.style.display = 'none';
        errorMessage.style.display = 'none';

        const url = selectedRole
            ? '<?= base_url('dashboard/get_role_login_stats') ?>?role=' + encodeURIComponent(selectedRole)
            : '<?= base_url('dashboard/get_role_login_stats') ?>';

        fetch(url)
            .then(response => response.json())
            .then(data => {
                loadingSpinner.style.display = 'none';

                if (data.success) {
                    if (data.summary) displaySummary(data.summary);
                    else if (data.users) displayDetails(data.role, data.users);
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

        if (!summary || summary.length === 0) {
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

        if (!users || users.length === 0) {
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
        if (!dateTimeString || dateTimeString === 'Never') return 'Never';
        try {
            const parts = dateTimeString.split(' ');
            if (parts.length === 2) {
                const datePart = parts[0].split('-');
                const timePart = parts[1].substring(0, 5);
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
<?php endif; ?>
