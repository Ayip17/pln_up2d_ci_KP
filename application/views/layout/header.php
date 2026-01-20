<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="theme-color" content="#0d6efd" />

  <!-- Favicon -->
  <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url('assets/assets/img/apple-icon.png'); ?>">
  <link rel="icon" type="image/png" href="<?= base_url('assets/assets/img/logo_pln.png'); ?>">

  <title><?= isset($page_title) ? htmlspecialchars($page_title) . ' - PLN UP2D RIAU' : 'PLN UP2D RIAU'; ?></title>

  <!-- Preconnect + Fonts -->
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&display=swap" rel="stylesheet" />

  <!-- Core CSS (local) -->
  <link href="<?= base_url('assets/assets/css/nucleo-icons.css'); ?>" rel="stylesheet" />
  <link href="<?= base_url('assets/assets/css/nucleo-svg.css'); ?>" rel="stylesheet" />
  <link id="pagestyle" href="<?= base_url('assets/assets/css/argon-dashboard.css?v=2.1.0'); ?>" rel="stylesheet" />
  <link rel="stylesheet" href="<?= base_url('assets/assets/css/sidebar.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/assets/css/pln-theme.css'); ?>">

  <!-- Select2 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

  <!-- Font Awesome (dipakai untuk semua ikon menu supaya tidak kotak-kotak) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous">

  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

  <style>
    /* =========================
       Sidebar layout: logout nempel bawah
       ========================= */
    .sidenav#sidenav-main {
      display: flex;
      flex-direction: column;
      min-height: calc(100vh - 1.5rem);
    }

    .sidenav#sidenav-main #sidenav-collapse-main {
      display: flex;
      flex-direction: column;
      flex: 1 1 auto;
      min-height: 0;
      width: 100% !important;
    }

    .sidenav#sidenav-main #sidenav-collapse-main > .navbar-nav {
      flex: 1 1 auto;
      min-height: 0;
      width: 100% !important;
    }

    .sidebar-logout-wrap {
      margin-top: auto;
      padding: 0.35rem 0.75rem 0.9rem;
      width: 100%;
    }

    .sidebar-logout-wrap .sidebar-divider {
      margin: 0.5rem 0.25rem 0.75rem;
    }

    /* 1) Pastikan bullet/marker default tidak tampil di sidebar */
    .sidenav ul,
    .sidenav li {
      list-style: none !important;
      margin: 0;
      padding: 0;
    }

    /* 2) Matikan pseudo-element (before/after) yang menambahkan panah/marker */
    .sidenav .nav-link::before,
    .sidenav .nav-link::after,
    .sidenav .nav-item::before,
    .sidenav .nav-item::after,
    .sidenav .nav-link[data-bs-toggle="collapse"]::after {
      content: none !important;
      display: none !important;
      background-image: none !important;
    }

    /* 3) Pastikan panah manual (fa-chevron-down) yang ada di markup tetap di kanan */
    .sidenav .nav-link {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      justify-content: flex-start;
      width: 100%;
      text-align: left;
    }

    .sidenav .nav-link .fa-chevron-down {
      margin-left: auto;
      order: 2;
    }

    /* 4) Sedikit spacing supaya ikon & teks rapi */
    .sidenav .submenu-list .nav-link > i {
      margin-right: 0.6rem;
    }

    .sidenav .nav-link .nav-link-text {
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    /* 5) Matikan ::marker */
    .sidenav li::marker {
      content: none !important;
      display: none !important;
    }

    /* Tambahan: pastikan submenu bisa diklik (tidak ketutup overlay collapse) */
    .submenu-list .nav-link,
    #menuAnggaran .nav-link {
      position: relative;
      z-index: 5;
      pointer-events: auto;
    }

    /* =========================
       Sidebar polish (Dashboard + Asset only)
       ========================= */
    .sidebar-section-label {
      display: block;
      padding: 0.75rem 1.25rem 0.25rem;
      font-size: 0.65rem;
      font-weight: 700;
      letter-spacing: 0.08em;
      text-transform: uppercase;
      color: #8392ab;
    }

    .sidebar-divider {
      margin: 0.9rem 1rem 0.8rem;
      height: 2px;
      border: 0;
      background: linear-gradient(
        90deg,
        rgba(52, 71, 103, 0.00) 0%,
        rgba(52, 71, 103, 0.22) 20%,
        rgba(52, 71, 103, 0.22) 80%,
        rgba(52, 71, 103, 0.00) 100%
      );
    }

    .sidenav .nav-link.nav-link-main {
      margin: 0.15rem 0.35rem;
      padding: 0.75rem 0.75rem;
      border-radius: 0.85rem;
      font-weight: 600;
      justify-content: flex-start;
    }

    /* Konsisten jarak ikon ↔ teks pada menu utama */
    .sidenav .nav-link.nav-link-main .sidebar-icon + .nav-link-text {
      margin-left: 0.6rem;
    }

    .sidenav .nav-link.nav-link-main.active {
      background: rgba(33, 82, 255, 0.10);
      color: #344767;
    }

    .sidenav .nav-link.nav-link-main .sidebar-icon {
      width: 34px;
      height: 34px;
      border-radius: 0.8rem;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      flex: 0 0 34px;
    }

    .sidenav .nav-link.nav-link-main .sidebar-icon i {
      margin-right: 0;
      opacity: 1;
    }

    .sidenav .submenu-list {
      margin-top: 0.25rem;
      padding-bottom: 0.25rem;
    }

    .sidenav .submenu-list .nav-link {
      margin: 0.05rem 0.4rem;
      padding: 0.55rem 0.65rem;
      border-radius: 0.7rem;
      justify-content: flex-start;
    }

    .sidenav .nav-link.logout-link {
      margin: 0;
      border-radius: 0.85rem;
      background: rgba(244, 67, 53, 0.08);
    }

    .sidenav .nav-link.logout-link:hover {
      background: rgba(244, 67, 53, 0.14);
    }

    .sidenav .nav-link.logout-link .nav-link-text {
      color: #d32f2f;
      font-weight: 700;
    }
  </style>

</head>

<body class="g-sidenav-show bg-gray-100">
  <div class="min-height-300 bg-dark position-absolute w-100" aria-hidden="true"></div>

  <?php
  // =========================
  // Role + segment helper
  // =========================
  $role = null;
  if (isset($this) && isset($this->session)) {
    $r = $this->session->userdata('user_role') ?: $this->session->userdata('role');
    $role = $r ? strtolower(trim($r)) : null;
  } elseif (isset($_SESSION['user_role'])) {
    $role = strtolower(trim($_SESSION['user_role']));
  }

  $role_json = json_encode($role);
  $seg1 = strtolower((string)($this->uri->segment(1) ?? ''));

  // Route groups (lowercase)
  // (Scope fork ini: hanya menu Dashboard + Asset)
  $asset_routes = ['unit', 'ulp', 'gardu_induk', 'gi_cell', 'gardu_hubung', 'gh_cell', 'pembangkit', 'kit_cell', 'pemutus', 'asset', 'assets'];
  ?>

  <!-- Sidebar -->
  <aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4" id="sidenav-main" role="navigation" aria-label="Sidebar utama">
    <div class="sidenav-header">
      <button class="btn btn-icon btn-sm text-secondary d-xl-none" id="iconSidenav" aria-label="Tutup sidebar">
        <i class="fas fa-times"></i>
      </button>

      <a class="navbar-brand m-0" href="<?= base_url('dashboard'); ?>">
        <img src="<?= base_url('assets/assets/img/logo_pln.png'); ?>" alt="Logo PLN" class="navbar-brand-img h-100" style="height:55px; width:auto;">
        <span class="ms-2 font-weight-bold text-dark">PLN UP2D RIAU</span>
      </a>
    </div>

    <hr class="horizontal dark mt-0">

    <div class="collapse navbar-collapse w-100" id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <!-- Dashboard -->
        <li class="nav-item">
          <a class="nav-link nav-link-main <?= ($seg1 == 'dashboard') ? 'active' : '' ?>" href="<?= base_url('dashboard'); ?>" aria-current="<?= ($seg1 == 'dashboard') ? 'page' : 'false' ?>">
            <span class="sidebar-icon bg-gradient-primary shadow-primary" aria-hidden="true">
              <i class="fas fa-gauge text-white text-sm"></i>
            </span>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>

        <!-- Asset -->
        <?php if ($role !== 'k3l & kam'): ?>
          <?php $asset_active = in_array($seg1, $asset_routes, true); ?>
          <li class="nav-item">
            <a href="#menuAsset"
              class="nav-link nav-link-main d-flex align-items-center <?= $asset_active ? 'active' : '' ?>"
              data-bs-toggle="collapse" role="button" aria-expanded="<?= $asset_active ? 'true' : 'false' ?>" aria-controls="menuAsset" style="font-weight: 600;">
              <span class="sidebar-icon bg-gradient-warning shadow-warning" aria-hidden="true">
                <i class="fas fa-boxes-stacked text-white text-sm"></i>
              </span>
              <span class="nav-link-text">Asset</span>
              <i class="fas fa-chevron-down text-xs me-2"></i>
            </a>

            <!-- FIX: collapse HARUS di dalam <li> -->
            <div class="collapse <?= $asset_active ? 'show' : '' ?>" id="menuAsset" role="region" aria-label="Submenu Asset">
              <ul class="nav flex-column submenu-list">
                <li class="nav-item">
                  <a class="nav-link <?= ($seg1 == 'unit') ? 'active bg-primary text-white' : '' ?>" href="<?= base_url('unit'); ?>">
                    <i class="fas fa-building me-2 text-success"></i><span class="nav-link-text">Unit</span>
                  </a>
                </li>

                <li class="nav-item">
                  <a class="nav-link <?= ($seg1 == 'gardu_induk') ? 'active bg-primary text-white' : '' ?>" href="<?= base_url('gardu_induk'); ?>">
                    <i class="fas fa-bolt me-2 text-warning"></i><span class="nav-link-text">Gardu Induk</span>
                  </a>
                </li>

                <li class="nav-item">
                  <a class="nav-link <?= ($seg1 == 'gi_cell') ? 'active bg-primary text-white' : '' ?>" href="<?= base_url('gi_cell'); ?>">
                    <i class="fas fa-wave-square me-2 text-info"></i><span class="nav-link-text">GI Cell</span>
                  </a>
                </li>

                <li class="nav-item">
                  <a class="nav-link <?= ($seg1 == 'gardu_hubung') ? 'active bg-primary text-white' : '' ?>" href="<?= base_url('gardu_hubung'); ?>">
                    <i class="fas fa-network-wired me-2 text-primary"></i><span class="nav-link-text">Gardu Hubung</span>
                  </a>
                </li>

                <li class="nav-item">
                  <a class="nav-link <?= ($seg1 == 'gh_cell') ? 'active bg-primary text-white' : '' ?>" href="<?= base_url('gh_cell'); ?>">
                    <i class="fas fa-square me-2 text-secondary"></i><span class="nav-link-text">GH Cell</span>
                  </a>
                </li>

                <li class="nav-item">
                  <!-- URL tetap mengikuti yang kamu pakai -->
                  <a class="nav-link <?= ($seg1 == 'pembangkit') ? 'active bg-primary text-white' : '' ?>" href="<?= base_url('Pembangkit'); ?>">
                    <i class="fas fa-industry me-2 text-danger"></i><span class="nav-link-text">Pembangkit</span>
                  </a>
                </li>

                <li class="nav-item">
                  <a class="nav-link <?= ($seg1 == 'kit_cell') ? 'active bg-primary text-white' : '' ?>" href="<?= base_url('Kit_cell'); ?>">
                    <i class="fas fa-microchip me-2 text-primary"></i><span class="nav-link-text">Kit Cell</span>
                  </a>
                </li>

                <li class="nav-item">
                  <a class="nav-link <?= ($seg1 == 'pemutus') ? 'active bg-primary text-white' : '' ?>" href="<?= base_url('Pemutus'); ?>">
                    <i class="fas fa-toggle-on me-2 text-warning"></i><span class="nav-link-text">Pemutus</span>
                  </a>
                </li>

              </ul>
            </div>
          </li>
        <?php endif; ?>

      </ul>

      <?php if (isset($this->session) && $this->session->userdata('logged_in')): ?>
        <div class="sidebar-logout-wrap">
          <div class="sidebar-divider" aria-hidden="true"></div>
          <a class="nav-link logout-link d-flex align-items-center" href="<?= base_url('logout'); ?>">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-power-off text-danger text-sm" aria-hidden="true"></i>
            </div>
            <span class="nav-link-text ms-1">Logout</span>
          </a>
        </div>
      <?php endif; ?>
    </div>
  </aside>

  <!-- Scripts: jQuery sebelum Select2, Chart.js -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <!-- DataTables JS -->
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

  <script defer>
    document.addEventListener('DOMContentLoaded', function() {
      try {
        const currentModule = <?= json_encode($this->uri->segment(1) ?: '') ?>;
        const role = <?= $role_json ?: 'null' ?>;

        // open-new-tab helper
        document.querySelectorAll('a.open-new-tab[href]').forEach(link => {
          const href = link.getAttribute('href') || '';
          if (!href.startsWith('javascript:') && href !== '#') {
            link.setAttribute('target', '_blank');
            link.setAttribute('rel', 'noopener noreferrer');
          }
        });

        // Restore collapse states
        const groups = {
          asset: ['unit', 'ulp', 'gardu_induk', 'gi_cell', 'gardu_hubung', 'gh_cell', 'pembangkit', 'kit_cell', 'pemutus', 'asset', 'assets']
        };

        const mod = String(currentModule).toLowerCase();

        if (groups.asset.includes(mod)) {
          const menu = document.getElementById('menuAsset');
          const toggler = document.querySelector('a[aria-controls="menuAsset"]');
          if (menu) menu.classList.add('show');
          if (toggler) toggler.setAttribute('aria-expanded', 'true');
        }
      } catch (e) {
        console && console.error && console.error(e);
      }
    });
  </script>

</body>

</html>
