<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Input_kontrak extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Input_kontrak_model', 'kontrak');
        $this->load->library('pagination');
        $this->load->helper(['url', 'form']);
        $this->load->library('form_validation');
    }

    // Halaman list data
    public function index()
    {
        $per_page = $this->input->get('per_page') ? (int)$this->input->get('per_page') : 5;
        $page = $this->input->get('page') ? (int)$this->input->get('page') : 1;
        $offset = ($page - 1) * $per_page;

        $total_rows = $this->kontrak->count_all();

        $config['base_url'] = base_url('Input_kontrak');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
        $config['reuse_query_string'] = TRUE;

        // Pagination Bootstrap
        $config['full_tag_open'] = '<nav><ul class="pagination pagination-sm">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '</span></li>';
        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close'] = '</span></li>';
        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close'] = '</span></li>';
        $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close'] = '</span></li>';

        $this->pagination->initialize($config);

        $data = [
            'input_kontrak' => $this->kontrak->get_limit($per_page, $offset),
            'total_rows'    => $total_rows,
            'per_page'      => $per_page,
            'start_no'      => $offset + 1,
            'pagination'    => $this->pagination->create_links(),
            'page_title'    => 'Data Input Kontrak',
            'page_icon'     => 'fas fa-file-signature me-2'
        ];

        $this->load->view('layout/header', $data);
        $this->load->view('input_kontrak/vw_input_kontrak', $data);
        $this->load->view('layout/footer', $data);
    }

    // Menampilkan form tambah
    public function tambah()
    {
        $data = [
            'page_title' => 'Tambah Input Kontrak',
            'page_icon'  => 'fas fa-file-signature me-2'
        ];

        $this->load->view('layout/header', $data);
        $this->load->view('input_kontrak/vw_tambah_input_kontrak', $data);
        $this->load->view('layout/footer', $data);
    }

    // Simpan data baru
    public function store()
    {
        $this->form_validation->set_rules('SUMBER_DANA', 'Sumber Dana', 'required');
        $this->form_validation->set_rules('SKKO', 'SKKO', 'required');
        $this->form_validation->set_rules('URAIAN_KONTRAK_PEKERJAAN', 'Uraian Kontrak / Pekerjaan', 'required');
        $this->form_validation->set_rules('USER', 'User', 'required');

        $data_header = [
            'page_title' => 'Tambah Input Kontrak',
            'page_icon'  => 'fas fa-file-signature me-2'
        ];

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', $data_header);
            $this->load->view('input_kontrak/vw_tambah_input_kontrak', $data_header);
            $this->load->view('layout/footer', $data_header);
        } else {
            // Data sesuai nama kolom database
            $data = [
                'SUMBER DANA' => $this->input->post('SUMBER_DANA', TRUE),
                'SKKO' => $this->input->post('SKKO', TRUE),
                'SUB POS' => $this->input->post('SUB_POS', TRUE),
                'DRP' => $this->input->post('DRP', TRUE),
                'URAIAN KONTRAK / PEKERJAAN' => $this->input->post('URAIAN_KONTRAK_PEKERJAAN', TRUE),
                'USER' => $this->input->post('USER', TRUE),
                'PAGU ANG/RAB USER' => $this->input->post('PAGU_ANG_RAB_USER', TRUE),
                'KOMITMENT ND' => $this->input->post('KOMITMENT_ND', TRUE),
                'RENC AKHIR KONTRAK' => $this->input->post('RENC_AKHIR_KONTRAK', TRUE),
                'TGL ND/AMS' => $this->input->post('TGL_ND_AMS', TRUE),
                'NOMOR ND / AMS' => $this->input->post('NOMOR_ND_AMS', TRUE),
                'KETERANGAN' => $this->input->post('KETERANGAN', TRUE),
                'TAHAP KONTRAK' => $this->input->post('TAHAP_KONTRAK', TRUE),
                'PROGNOSA' => $this->input->post('PROGNOSA', TRUE),
                'NO SPK / SPB / KONTRAK' => $this->input->post('NO_SPK_SPB_KONTRAK', TRUE),
                'REKANAN' => $this->input->post('REKANAN', TRUE),
                'TGL KONTRAK' => $this->input->post('TGL_KONTRAK', TRUE),
                'TGL AKHIR KONTRAK' => $this->input->post('TGL_AKHIR_KONTRAK', TRUE),
                'NILAI KONTRAK TOTAL' => $this->input->post('NILAI_KONTRAK_TOTAL', TRUE),
                'NILAI KONTRAK TAHUN BERJALAN' => $this->input->post('NILAI_KONTRAK_TAHUN_BERJALAN', TRUE),
                'TGL BAYAR' => $this->input->post('TGL_BAYAR', TRUE),
                'ANGGARAN TERPAKAI' => $this->input->post('ANGGARAN_TERPAKAI', TRUE),
                'SISA ANGGARAN' => $this->input->post('SISA_ANGGARAN', TRUE),
                'STATUS KONTRAK' => $this->input->post('STATUS_KONTRAK', TRUE),
                'BULAN RENC BAYAR' => $this->input->post('BULAN_RENC_BAYAR', TRUE),
                'BULAN BAYAR' => $this->input->post('BULAN_BAYAR', TRUE),
            ];

            // BLN KTRK1 - KTRK12
            for ($i = 1; $i <= 12; $i++) {
                $data["BLN KTRK$i"] = $this->input->post("BLN_KTRK$i", TRUE);
            }

            $this->kontrak->insert($data);
            $this->session->set_flashdata('success', 'Data progress kontrak berhasil disimpan!');
            redirect('Input_kontrak');
        }
    }

    // Menampilkan form edit
    public function edit($id)
    {
        $data_kontrak = $this->kontrak->get_by_id($id);

        if (!$data_kontrak) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan!');
            redirect('input_kontrak');
        }

        $data = [
            'input_kontrak' => $data_kontrak,
            'page_title'    => 'Edit Input Kontrak',
            'page_icon'     => 'fas fa-file-signature me-2'
        ];

        $this->load->view('layout/header', $data);
        $this->load->view('input_kontrak/vw_edit_input_kontrak', $data);
        $this->load->view('layout/footer', $data);
    }

    // Proses update data
    public function update()
    {
        $id = $this->input->post('original_id');

        $data = [
            'SUMBER DANA' => $this->input->post('SUMBER_DANA', TRUE),
            'SKKO' => $this->input->post('SKKO', TRUE),
            'SUB POS' => $this->input->post('SUB_POS', TRUE),
            'DRP' => $this->input->post('DRP', TRUE),
            'URAIAN KONTRAK / PEKERJAAN' => $this->input->post('URAIAN_KONTRAK_PEKERJAAN', TRUE),
            'USER' => $this->input->post('USER', TRUE),
            'PAGU ANG/RAB USER' => $this->input->post('PAGU_ANG_RAB_USER', TRUE),
            'KOMITMENT ND' => $this->input->post('KOMITMENT_ND', TRUE),
            'RENC AKHIR KONTRAK' => $this->input->post('RENC_AKHIR_KONTRAK', TRUE),
            'TGL ND/AMS' => $this->input->post('TGL_ND_AMS', TRUE),
            'NOMOR ND / AMS' => $this->input->post('NOMOR_ND_AMS', TRUE),
            'KETERANGAN' => $this->input->post('KETERANGAN', TRUE),
            'TAHAP KONTRAK' => $this->input->post('TAHAP_KONTRAK', TRUE),
            'PROGNOSA' => $this->input->post('PROGNOSA', TRUE),
            'NO SPK / SPB / KONTRAK' => $this->input->post('NO_SPK_SPB_KONTRAK', TRUE),
            'REKANAN' => $this->input->post('REKANAN', TRUE),
            'TGL KONTRAK' => $this->input->post('TGL_KONTRAK', TRUE),
            'TGL AKHIR KONTRAK' => $this->input->post('TGL_AKHIR_KONTRAK', TRUE),
            'NILAI KONTRAK TOTAL' => $this->input->post('NILAI_KONTRAK_TOTAL', TRUE),
            'NILAI KONTRAK TAHUN BERJALAN' => $this->input->post('NILAI_KONTRAK_TAHUN_BERJALAN', TRUE),
            'TGL BAYAR' => $this->input->post('TGL_BAYAR', TRUE),
            'ANGGARAN TERPAKAI' => $this->input->post('ANGGARAN_TERPAKAI', TRUE),
            'SISA ANGGARAN' => $this->input->post('SISA_ANGGARAN', TRUE),
            'STATUS KONTRAK' => $this->input->post('STATUS_KONTRAK', TRUE),
            'BULAN RENC BAYAR' => $this->input->post('BULAN_RENC_BAYAR', TRUE),
            'BULAN BAYAR' => $this->input->post('BULAN_BAYAR', TRUE),
        ];

        for ($i = 1; $i <= 12; $i++) {
            $data["BLN KTRK$i"] = $this->input->post("BLN_KTRK$i", TRUE);
        }

        $this->kontrak->update($id, $data);
        $this->session->set_flashdata('success', 'Data berhasil diperbarui!');
        redirect('input_kontrak');
    }

    // Export CSV
    public function export_csv()
    {
        $this->load->dbutil();
        $this->load->helper(['file', 'download']);

        $query = $this->db->query("SELECT * FROM anggaran_op"); // sesuaikan tabel
        $csv = $this->dbutil->csv_from_result($query);

        force_download('input_kontrak.csv', $csv);
    }
    // Detail data kontrak
    public function detail($id)
    {
        $data_kontrak = $this->kontrak->get_by_id($id);

        if (!$data_kontrak) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan!');
            redirect('input_kontrak');
        }

        $data = [
            'input_kontrak' => $data_kontrak,
            'page_title'    => 'Detail Input Kontrak',
            'page_icon'     => 'fas fa-file-signature me-2'
        ];

        $this->load->view('layout/header', $data);
        $this->load->view('Input_kontrak/vw_detail_input_kontrak', $data);
        $this->load->view('layout/footer', $data);
    }
}
