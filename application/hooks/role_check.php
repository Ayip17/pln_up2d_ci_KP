<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * role_check hook
 * Runs after controller constructor and blocks unauthorized URIs based on role.
 */
function role_check()
{
    $CI =& get_instance();

    // If no session library or not logged in, skip (login hook should handle auth)
    if (!isset($CI->session)) return;

    $logged_in = $CI->session->userdata('logged_in');
    if (!$logged_in) return; // not logged in; other auth mechanisms handle this

    $role = $CI->session->userdata('user_role');
    // If no role set, allow by default
    if (!$role) return;

    // Example rule: Perencanaan can access dashboard, asset, pustaka, and pengaduan
    if (strtolower($role) === 'perencanaan') {
        // Don't run role checks for auth or public controllers so login/logout still work
        $controller = strtolower($CI->router->fetch_class());
        $excluded_controllers = ['login', 'logout', 'welcome', 'assets', 'notifikasi'];
        if (in_array($controller, $excluded_controllers)) {
            return;
        }

        $allowed_controllers = ['dashboard', 'pengaduan',
                               // Asset modules
                               'unit', 'gardu_induk', 'gi_cell', 'gardu_hubung', 'gh_cell', 
                               'pembangkit', 'kit_cell', 'pemutus',
                               // Pustaka modules
                               'sop', 'bpm', 'ik', 'road_map', 'spln',
                               // Anggaran modules
                               'input_kontrak', 'rekomposisi',
                               'operasi', 'investasi'];

        if (!in_array($controller, $allowed_controllers)) {
            // If request is AJAX, return 403 JSON
            if ($CI->input->is_ajax_request()) {
                $CI->output
                    ->set_status_header(403)
                    ->set_content_type('application/json', 'utf-8')
                    ->set_output(json_encode(['error' => 'Access denied']))
                    ->_display();
                exit;
            }

            // Otherwise redirect to dashboard with flash
            $CI->session->set_flashdata('error', 'Anda tidak memiliki akses ke halaman tersebut.');
            redirect('dashboard');
        }
    }
}
