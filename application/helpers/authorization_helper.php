<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Authorization Helper
 * Helper untuk mengecek permission user berdasarkan role
 */

if (!function_exists('can_create')) {
    /**
     * Cek apakah user bisa create data
     * @return bool
     * @param string $module Optional - nama module untuk cek permission spesifik
     */
    function can_create($module = null)
    {
        $CI = &get_instance();
        $role = $CI->session->userdata('user_role');
        $is_guest = $CI->session->userdata('is_guest');

        // Guest tidak bisa create
        // Guest tidak bisa create
        if ($is_guest || strtolower($role ?? '') === 'guest') {
            return false;
        }


        // Admin bisa semua
        if (strtolower($role) === 'admin' || strtolower($role) === 'administrator') {
            return true;
        }

        // UP3: Hanya bisa CRUD di module Pengaduan
        if (strtolower($role) === 'up3') {
            // Jika tidak ada module parameter, cek dari current controller
            if ($module === null) {
                $module = $CI->router->fetch_class();
            }
            return strtolower($module) === 'pengaduan';
        }

        // Pemeliharaan: Bisa CRUD di Asset, Pustaka, Pengaduan, dan Anggaran
        if (strtolower($role) === 'pemeliharaan') {
            if ($module === null) {
                $module = $CI->router->fetch_class();
            }
            $allowed = [
                'unit',
                'gardu_induk',
                'gi_cell',
                'gardu_hubung',
                'gh_cell',
                'pembangkit',
                'kit_cell',
                'pemutus', // Asset modules
                'sop',
                'bpm',
                'ik',
                'road_map',
                'spln', // Pustaka modules
                'pengaduan', // Pengaduan module
                'input_kontrak',
                'rekomposisi',
                'operasi',
                'investasi'
            ]; // Anggaran modules
            return in_array(strtolower($module), $allowed);
        }

        // Operasi Sistem Distribusi: Bisa CRUD di Asset, Pustaka, Operasi, dan Anggaran
        if (strtolower($role) === 'operasi sistem distribusi') {
            if ($module === null) {
                $module = $CI->router->fetch_class();
            }
            $allowed = [
                'unit',
                'gardu_induk',
                'gi_cell',
                'gardu_hubung',
                'gh_cell',
                'pembangkit',
                'kit_cell',
                'pemutus', // Asset modules
                'sop',
                'bpm',
                'ik',
                'road_map',
                'spln', // Pustaka modules
                'single_line_diagram', // Operasi module
                'operasi',
                'investasi'
            ]; // Anggaran modules
            return in_array(strtolower($module), $allowed);
        }

        // Fasilitas Operasi: Bisa CRUD di Asset, Pustaka, Pengaduan, dan Anggaran
        if (strtolower($role) === 'fasilitas operasi') {
            if ($module === null) {
                $module = $CI->router->fetch_class();
            }
            $allowed = [
                'unit',
                'gardu_induk',
                'gi_cell',
                'gardu_hubung',
                'gh_cell',
                'pembangkit',
                'kit_cell',
                'pemutus', // Asset modules
                'sop',
                'bpm',
                'ik',
                'road_map',
                'spln', // Pustaka modules
                'pengaduan', // Pengaduan module
                'input_kontrak',
                'rekomposisi',
                'operasi',
                'investasi'
            ]; // Anggaran modules
            return in_array(strtolower($module), $allowed);
        }

        // K3L & KAM: Bisa CRUD di Pustaka dan Anggaran
        if (strtolower($role) === 'k3l & kam') {
            if ($module === null) {
                $module = $CI->router->fetch_class();
            }
            $allowed = [
                'sop',
                'bpm',
                'ik',
                'road_map',
                'spln', // Pustaka modules
                'operasi',
                'investasi'
            ]; // Anggaran modules
            return in_array(strtolower($module), $allowed);
        }

        // Perencanaan: Bisa CRUD di Asset, Pustaka, Pengaduan, dan Anggaran
        if (strtolower($role) === 'perencanaan') {
            if ($module === null) {
                $module = $CI->router->fetch_class();
            }
            $allowed = [
                'unit',
                'gardu_induk',
                'gi_cell',
                'gardu_hubung',
                'gh_cell',
                'pembangkit',
                'kit_cell',
                'pemutus', // Asset modules
                'sop',
                'bpm',
                'ik',
                'road_map',
                'spln', // Pustaka modules
                'pengaduan', // Pengaduan module
                'input_kontrak',
                'rekomposisi',
                'operasi',
                'investasi'
            ]; // Anggaran modules
            return in_array(strtolower($module), $allowed);
        }

        // Har & Pengadaan Keuangan: Khusus bisa Input Kontrak
        if (in_array(strtolower($role), ['har', 'pengadaan keuangan'])) {
            if ($module === null) {
                $module = $CI->router->fetch_class();
            }
            return strtolower($module) === 'input_kontrak';
        }

        // Role lain bisa create (kecuali yang spesifik di-restrict nanti)
        return true;
    }
}

if (!function_exists('can_edit')) {
    /**
     * Cek apakah user bisa edit data
     * @return bool
     * @param string $module Optional - nama module untuk cek permission spesifik
     */
    function can_edit($module = null)
    {
        $CI = &get_instance();
        $role = $CI->session->userdata('user_role');
        $is_guest = $CI->session->userdata('is_guest');

        // Guest tidak bisa edit
        if ($is_guest || strtolower($role) === 'guest') {
            return false;
        }

        // Admin bisa semua
        if (strtolower($role) === 'admin' || strtolower($role) === 'administrator') {
            return true;
        }

        // UP3: Hanya bisa CRUD di module Pengaduan
        if (strtolower($role) === 'up3') {
            // Jika tidak ada module parameter, cek dari current controller
            if ($module === null) {
                $module = $CI->router->fetch_class();
            }
            return strtolower($module) === 'pengaduan';
        }

        // Pemeliharaan: Bisa CRUD di Asset, Pustaka, Pengaduan, dan Anggaran
        if (strtolower($role) === 'pemeliharaan') {
            if ($module === null) {
                $module = $CI->router->fetch_class();
            }
            $allowed = [
                'unit',
                'gardu_induk',
                'gi_cell',
                'gardu_hubung',
                'gh_cell',
                'pembangkit',
                'kit_cell',
                'pemutus', // Asset modules
                'sop',
                'bpm',
                'ik',
                'road_map',
                'spln', // Pustaka modules
                'pengaduan', // Pengaduan module
                'input_kontrak',
                'rekomposisi',
                'operasi',
                'investasi'
            ]; // Anggaran modules
            return in_array(strtolower($module), $allowed);
        }

        // Operasi Sistem Distribusi: Bisa CRUD di Asset, Pustaka, Operasi, dan Anggaran
        if (strtolower($role) === 'operasi sistem distribusi') {
            if ($module === null) {
                $module = $CI->router->fetch_class();
            }
            $allowed = [
                'unit',
                'gardu_induk',
                'gi_cell',
                'gardu_hubung',
                'gh_cell',
                'pembangkit',
                'kit_cell',
                'pemutus', // Asset modules
                'sop',
                'bpm',
                'ik',
                'road_map',
                'spln', // Pustaka modules
                'single_line_diagram', // Operasi module
                'operasi',
                'investasi'
            ]; // Anggaran modules
            return in_array(strtolower($module), $allowed);
        }

        // Fasilitas Operasi: Bisa CRUD di Asset, Pustaka, Pengaduan, dan Anggaran
        if (strtolower($role) === 'fasilitas operasi') {
            if ($module === null) {
                $module = $CI->router->fetch_class();
            }
            $allowed = [
                'unit',
                'gardu_induk',
                'gi_cell',
                'gardu_hubung',
                'gh_cell',
                'pembangkit',
                'kit_cell',
                'pemutus', // Asset modules
                'sop',
                'bpm',
                'ik',
                'road_map',
                'spln', // Pustaka modules
                'pengaduan', // Pengaduan module
                'input_kontrak',
                'rekomposisi',
                'operasi',
                'investasi'
            ]; // Anggaran modules
            return in_array(strtolower($module), $allowed);
        }

        // K3L & KAM: Bisa CRUD di Pustaka dan Anggaran
        if (strtolower($role) === 'k3l & kam') {
            if ($module === null) {
                $module = $CI->router->fetch_class();
            }
            $allowed = [
                'sop',
                'bpm',
                'ik',
                'road_map',
                'spln', // Pustaka modules
                'operasi',
                'investasi'
            ]; // Anggaran modules
            return in_array(strtolower($module), $allowed);
        }

        // Perencanaan: Bisa CRUD di Asset, Pustaka, Pengaduan, dan Anggaran
        if (strtolower($role) === 'perencanaan') {
            if ($module === null) {
                $module = $CI->router->fetch_class();
            }
            $allowed = [
                'unit',
                'gardu_induk',
                'gi_cell',
                'gardu_hubung',
                'gh_cell',
                'pembangkit',
                'kit_cell',
                'pemutus', // Asset modules
                'sop',
                'bpm',
                'ik',
                'road_map',
                'spln', // Pustaka modules
                'pengaduan', // Pengaduan module
                'input_kontrak',
                'rekomposisi',
                'operasi',
                'investasi'
            ]; // Anggaran modules
            return in_array(strtolower($module), $allowed);
        }

        // Har & Pengadaan Keuangan: Khusus bisa Input Kontrak
        if (in_array(strtolower($role), ['har', 'pengadaan keuangan'])) {
            if ($module === null) {
                $module = $CI->router->fetch_class();
            }
            return strtolower($module) === 'input_kontrak';
        }

        // Role lain bisa edit (kecuali yang spesifik di-restrict nanti)
        return true;
    }
}

if (!function_exists('can_delete')) {
    /**
     * Cek apakah user bisa delete data
     * @return bool
     * @param string $module Optional - nama module untuk cek permission spesifik
     */
    function can_delete($module = null)
    {
        $CI = &get_instance();
        $role = $CI->session->userdata('user_role');
        $is_guest = $CI->session->userdata('is_guest');

        // Guest tidak bisa delete
        if ($is_guest || strtolower($role) === 'guest') {
            return false;
        }

        // Admin bisa semua
        if (strtolower($role) === 'admin' || strtolower($role) === 'administrator') {
            return true;
        }

        // UP3: Hanya bisa CRUD di module Pengaduan
        if (strtolower($role) === 'up3') {
            // Jika tidak ada module parameter, cek dari current controller
            if ($module === null) {
                $module = $CI->router->fetch_class();
            }
            return strtolower($module) === 'pengaduan';
        }

        // Pemeliharaan: Bisa CRUD di Asset, Pustaka, Pengaduan, dan Anggaran
        if (strtolower($role) === 'pemeliharaan') {
            if ($module === null) {
                $module = $CI->router->fetch_class();
            }
            $allowed = [
                'unit',
                'gardu_induk',
                'gi_cell',
                'gardu_hubung',
                'gh_cell',
                'pembangkit',
                'kit_cell',
                'pemutus', // Asset modules
                'sop',
                'bpm',
                'ik',
                'road_map',
                'spln', // Pustaka modules
                'pengaduan', // Pengaduan module
                'input_kontrak',
                'rekomposisi',
                'operasi',
                'investasi'
            ]; // Anggaran modules
            return in_array(strtolower($module), $allowed);
        }

        // Operasi Sistem Distribusi: Bisa CRUD di Asset, Pustaka, Operasi, dan Anggaran
        if (strtolower($role) === 'operasi sistem distribusi') {
            if ($module === null) {
                $module = $CI->router->fetch_class();
            }
            $allowed = [
                'unit',
                'gardu_induk',
                'gi_cell',
                'gardu_hubung',
                'gh_cell',
                'pembangkit',
                'kit_cell',
                'pemutus', // Asset modules
                'sop',
                'bpm',
                'ik',
                'road_map',
                'spln', // Pustaka modules
                'single_line_diagram', // Operasi module
                'operasi',
                'investasi'
            ]; // Anggaran modules
            return in_array(strtolower($module), $allowed);
        }

        // Fasilitas Operasi: Bisa CRUD di Asset, Pustaka, Pengaduan, dan Anggaran
        if (strtolower($role) === 'fasilitas operasi') {
            if ($module === null) {
                $module = $CI->router->fetch_class();
            }
            $allowed = [
                'unit',
                'gardu_induk',
                'gi_cell',
                'gardu_hubung',
                'gh_cell',
                'pembangkit',
                'kit_cell',
                'pemutus', // Asset modules
                'sop',
                'bpm',
                'ik',
                'road_map',
                'spln', // Pustaka modules
                'pengaduan', // Pengaduan module
                'input_kontrak',
                'rekomposisi',
                'operasi',
                'investasi'
            ]; // Anggaran modules
            return in_array(strtolower($module), $allowed);
        }

        // K3L & KAM: Bisa CRUD di Pustaka dan Anggaran
        if (strtolower($role) === 'k3l & kam') {
            if ($module === null) {
                $module = $CI->router->fetch_class();
            }
            $allowed = [
                'sop',
                'bpm',
                'ik',
                'road_map',
                'spln', // Pustaka modules
                'operasi',
                'investasi'
            ]; // Anggaran modules
            return in_array(strtolower($module), $allowed);
        }

        // Perencanaan: Bisa CRUD di Asset, Pustaka, Pengaduan, dan Anggaran
        if (strtolower($role) === 'perencanaan') {
            if ($module === null) {
                $module = $CI->router->fetch_class();
            }
            $allowed = [
                'unit',
                'gardu_induk',
                'gi_cell',
                'gardu_hubung',
                'gh_cell',
                'pembangkit',
                'kit_cell',
                'pemutus', // Asset modules
                'sop',
                'bpm',
                'ik',
                'road_map',
                'spln', // Pustaka modules
                'pengaduan', // Pengaduan module
                'input_kontrak',
                'rekomposisi',
                'operasi',
                'investasi'
            ]; // Anggaran modules
            return in_array(strtolower($module), $allowed);
        }

        // Har & Pengadaan Keuangan: Khusus bisa Input Kontrak
        if (in_array(strtolower($role), ['har', 'pengadaan keuangan'])) {
            if ($module === null) {
                $module = $CI->router->fetch_class();
            }
            return strtolower($module) === 'input_kontrak';
        }

        // Role lain bisa delete (kecuali yang spesifik di-restrict nanti)
        return true;
    }
}

if (!function_exists('is_guest')) {
    /**
     * Cek apakah user adalah Guest
     * @return bool
     */
    function is_guest()
    {
        $CI = &get_instance();
        $is_guest = $CI->session->userdata('is_guest');
        $role = $CI->session->userdata('user_role');

        return $is_guest === true || strtolower($role) === 'guest';
    }
}

if (!function_exists('is_admin')) {
    /**
     * Cek apakah user adalah Admin
     * @return bool
     */
    function is_admin()
    {
        $CI = &get_instance();
        $role = $CI->session->userdata('user_role');

        return strtolower($role) === 'admin' || strtolower($role) === 'administrator';
    }
}

if (!function_exists('get_user_role')) {
    /**
     * Get current user role
     * @return string|null
     */
    function get_user_role()
    {
        $CI = &get_instance();
        return $CI->session->userdata('user_role');
    }
}

if (!function_exists('can_access_module')) {
    /**
     * Cek apakah user bisa akses modul tertentu
     * @param string $module Nama modul (asset, pustaka, pengaduan, operasi, anggaran)
     * @return bool
     */
    function can_access_module($module)
    {
        $CI = &get_instance();
        $role = strtolower($CI->session->userdata('user_role') ?? '');

        // Admin bisa akses semua
        if ($role === 'admin' || $role === 'administrator') {
            return true;
        }

        // Guest bisa akses semua (view only)
        if ($role === 'guest') {
            return true;
        }

        $module = strtolower($module);

        // Mapping akses modul per role
        $access_map = [
            'up3' => ['pengaduan'],
            'perencanaan' => ['asset', 'pustaka', 'pengaduan', 'anggaran'],
            'pemeliharaan' => ['asset', 'pustaka', 'pengaduan', 'anggaran'],
            'operasi sistem distribusi' => ['asset', 'pustaka', 'operasi', 'anggaran'],
            'fasilitas operasi' => ['asset', 'pustaka', 'pengaduan', 'anggaran'],
            'k3l & kam' => ['pustaka', 'anggaran'],
        ];

        if (isset($access_map[$role])) {
            return in_array($module, $access_map[$role]);
        }

        // Default: tidak ada akses
        return false;
    }
}
