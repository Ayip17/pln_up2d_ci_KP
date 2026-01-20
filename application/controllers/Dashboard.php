<?php
defined('BASEPATH') or exit('No direct script acces allowed');

/**
 * @property CI_Session $session
 * @property User_model $User_model
 * @property Notifikasi_model $Notifikasi_model
 * @property CI_Input $input
 */
class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['authorization']);
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }

        // Pastikan DB tersedia walaupun autoload berubah pada fork ini
        $this->load->database();
        $this->load->model('User_model');
        $this->load->model('Notifikasi_model');
    }

    public function index()
    {
        $data['judul'] = "Halaman Dashboard";

        // Navbar data
        $data['page_title'] = "Dashboard";
        $data['page_icon'] = "ni ni-tv-2";

        // If user is logged in, fetch their login_count and last_login for display
        $data['login_count'] = null;
        $data['last_login'] = null;
        $data['user_role'] = null;

        // Try to get role from session first (faster)
        $session_role = $this->session->userdata('user_role');
        if ($session_role) {
            $data['user_role'] = $session_role; // Keep original case
        }

        $user_id = $this->session->userdata('user_id');
        if ($user_id) {
            $user = $this->User_model->find_by_id($user_id);
            if ($user) {
                $data['login_count'] = isset($user['login_count']) ? $user['login_count'] : null;
                $data['last_login'] = isset($user['last_login']) ? $user['last_login'] : null;
                // Override with DB role if available (keep original case)
                if (isset($user['role'])) {
                    $data['user_role'] = $user['role'];
                }
            }
        }

        // =========================
        // Fork ini difokuskan ke CRUD Asset.
        // Dashboard disederhanakan: hanya info login + riwayat aktivitas.
        // =========================
        $data['riwayat_aktivitas'] = [];

        $has_notif = $this->db->table_exists('notifikasi_aktivitas');
        if ($has_notif) {
            $data['riwayat_aktivitas'] = $this->Notifikasi_model->get_latest(8);
        }

        $this->load->view("layout/header");
        $this->load->view("dashboard/vw_dashboard.php", $data);
        $this->load->view("layout/footer");
    }

    /**
     * AJAX endpoint: Get login statistics for a specific role
     * Only accessible by admin users
     */
    public function get_role_login_stats()
    {
        // Admin/Administrator only
        if (!is_admin()) {
            echo json_encode(['success' => false, 'message' => 'Access denied. Admin only.']);
            return;
        }

        // Get role from query parameter
        $role = $this->input->get('role');

        if ($role) {
            // Get specific role stats
            $users = $this->User_model->get_users_login_stats($role);
            echo json_encode(['success' => true, 'role' => $role, 'users' => $users]);
        } else {
            // Get all roles summary
            $summary = $this->User_model->get_login_stats_by_role();
            echo json_encode(['success' => true, 'summary' => $summary]);
        }
    }
}
