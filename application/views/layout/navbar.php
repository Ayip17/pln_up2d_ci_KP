<!-- Navbar -->
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="false">
    <div class="container-fluid py-1 px-3">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm">
                    <a class="opacity-5 text-white" href="<?= base_url('dashboard'); ?>">Dashboard</a>
                </li>
                <li class="breadcrumb-item text-sm text-white active" aria-current="page">
                    <?= isset($page_title) ? $page_title : 'Page'; ?>
                </li>
            </ol>
            <h6 class="font-weight-bolder text-white mb-0">
                <?php if (isset($page_icon)): ?>
                    <i class="<?= $page_icon; ?> text-white text-sm opacity-10 me-2"></i>
                <?php endif; ?>
                <?= isset($page_title) ? $page_title : 'Page'; ?>
            </h6>
        </nav>

        <!-- Right Icons -->
        <div class="d-flex align-items-center ms-auto">
            <ul class="navbar-nav flex-row align-items-center mb-0">
                <!-- Sign In / User Info -->
                <li class="nav-item d-flex align-items-center me-3">
                    <a href="<?= base_url('pages/profile'); ?>" class="nav-link text-white font-weight-bold px-0" title="Profile">
                        <i class="fa fa-user me-sm-1"></i>
                        <span class="d-sm-inline d-none">
                            <?php 
                            if ($this->session->userdata('logged_in')) {
                                echo $this->session->userdata('username') ?: 'User';
                            } else {
                                echo 'Sign In';
                            }
                            ?>
                        </span>
                    </a>
                </li>

                <!-- Settings -->
                <li class="nav-item px-2 d-flex align-items-center me-3">
                    <a href="javascript:;" class="nav-link text-white p-0" title="Settings">
                        <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
                    </a>
                </li>

                <?php 
                // Get user role
                $user_role = $this->session->userdata('user_role');
                if (isset($user_role) && strpos(strtolower($user_role), 'admin') !== false): 
                ?>
                <!-- Login Activity Monitor (Admin Only) -->
                <li class="nav-item px-2 d-flex align-items-center me-3">
                    <a href="javascript:;" class="nav-link text-white p-0" id="loginActivityBtn" title="Monitor Login Activity">
                        <i class="fa fa-users cursor-pointer"></i>
                    </a>
                </li>
                <?php endif; ?>

                <!-- Notification Bell -->
                <li class="nav-item dropdown pe-2 d-flex align-items-center">
                    <a href="<?= base_url('Notifikasi'); ?>" class="nav-link text-white p-0 position-relative" title="Lihat Notifikasi">
                        <i class="fa fa-bell cursor-pointer" style="font-size: 18px;"></i>
                        <span id="notifBadge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 9px; display: none;">
                            0
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- End Navbar -->

<script>
// Fetch notification count on page load
document.addEventListener('DOMContentLoaded', function() {
    fetchNotificationCount();
    
    // Refresh notification count every 30 seconds
    setInterval(fetchNotificationCount, 30000);
});

function fetchNotificationCount() {
    fetch('<?= base_url("Notifikasi/get_unread_count"); ?>')
        .then(response => response.json())
        .then(data => {
            const badge = document.getElementById('notifBadge');
            if (data.count > 0) {
                badge.textContent = data.count > 99 ? '99+' : data.count;
                badge.style.display = 'inline-block';
            } else {
                badge.style.display = 'none';
            }
        })
        .catch(error => console.error('Error fetching notification count:', error));
}
</script>
