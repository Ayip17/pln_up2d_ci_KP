<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Controller for Import Data
 *
 * @property CI_Input $input
 * @property CI_Session $session
 * @property ImportJob_model $ImportJob_model
 * @property CI_Upload $upload
 * @property CI_URI $uri
 * @property CI_Config $config
 * @property CI_DB_query_builder $db
 */
class Import extends CI_Controller
{

    private $entityMap = [
        'gi'           => 'gi',
        'gardu_induk'  => 'gi',
        'gardu_hubung' => 'gh',
        'gh_cell'      => 'gh_cell',
        'gi_cell'      => 'gi_cell',
        'kit_cell'     => 'kit_cell',
        'pembangkit'   => 'pembangkit',
        'pemutus'      => 'lbs_recloser',
        'unit'         => 'unit',
        'ulp'          => 'ulp',

        // ➕ entity untuk Data Kontrak
        'data_kontrak' => 'data_kontrak',

        // ✅ TAMBAHAN: entity untuk master rekomposisi
        // sehingga link /import/rekomposisi akan masuk ke tabel master_rekomposisi
        'rekomposisi'  => 'master_rekomposisi',
        'master_rekomposisi' => 'master_rekomposisi',
    ];

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['url', 'form', 'file']);
        $this->load->library(['session', 'upload']);
        $this->load->database();
        $this->load->model(['ImportJob_model']);
    }

    // Upload form (default GI)
    public function index($entity = 'gi')
    {
        $entity = strtolower($entity);
        if (!isset($this->entityMap[$entity])) {
            $entity = 'gi';
        }
        $targetTable = $this->entityMap[$entity];

        $data = [
            'title'        => 'Import ' . strtoupper($targetTable) . ' - Phase 1',
            'entity'       => $entity,
            'target_table' => $targetTable,
        ];
        $this->load->view('import/form', $data);
    }

    // Preview first 100 rows
    public function preview($entity = 'gi')
    {
        $entity = strtolower($entity);
        if (!isset($this->entityMap[$entity])) {
            $entity = 'gi';
        }
        $targetTable = $this->entityMap[$entity];

        // Accept CSV or XLSX (for now CSV fallback; XLSX in next step)
        $config = [
            'upload_path'   => FCPATH . 'uploads/imports/',
            'allowed_types' => 'csv|xlsx',
            'max_size'      => 10240, // 10 MB
            'encrypt_name'  => TRUE,
        ];
        if (!is_dir($config['upload_path'])) {
            @mkdir($config['upload_path'], 0755, true);
        }
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('file')) {
            $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
            return redirect('import/' . $entity);
        }

        $fileData = $this->upload->data();
        $fullpath = $fileData['full_path'];

        // Ensure job schema exists then log job shell
        $this->ImportJob_model->ensure_schema();

        // Determine if this entity uses staging (only GI for now)
        $stagingTable = ($targetTable === 'gi') ? 'gi_import_raw' : null;

        $job_id = $this->ImportJob_model->create_job([
            'target_table'      => $targetTable,
            'staging_table'     => $stagingTable,
            'original_filename' => $fileData['client_name'],
            'stored_path'       => 'uploads/imports/' . $fileData['file_name'],
            'file_size'         => (int)$fileData['file_size'],
            'chunk_size'        => 500,
            'duplicate_policy'  => 'ask',
            'status'            => 'preview',
        ]);

        // Read first 100 rows
        $rows    = [];
        $headers = [];

        if (strtolower($fileData['file_ext']) === '.csv') {
            $fp = fopen($fullpath, 'r');
            if ($fp !== false) {
                // Try to detect separator ; or ,
                $firstLine = fgets($fp);
                $sep = (substr_count($firstLine, ';') > substr_count($firstLine, ',')) ? ';' : ',';
                rewind($fp);
                $lineNo = 0;
                while (($data = fgetcsv($fp, 0, $sep)) !== false) {
                    if ($lineNo === 0) {
                        $headers = $data;
                    } else {
                        $rows[] = $data;
                        if (count($rows) >= 100) break;
                    }
                    $lineNo++;
                }
                fclose($fp);
            }
        } else {
            // XLSX support placeholder
            $headers = ['INFO'];
            $rows    = [['XLSX preview membutuhkan PHPSpreadsheet. Sementara, unggah CSV.']];
        }

        $data = [
            'title'   => 'Preview Import ' . strtoupper($targetTable),
            'job_id'  => $job_id,
            'entity'  => $entity,
            'headers' => $headers,
            'rows'    => $rows,
        ];
        $this->load->view('import/preview', $data);
    }

    // Process chunks into staging table / target table
    public function process($entity = 'gi')
    {
        $job_id = (int)$this->input->post('job_id');
        $entity = strtolower($entity);
        $policy = $this->input->post('duplicate_policy'); // belum dipakai (phase1)

        $job = $this->ImportJob_model->get_job($job_id);
        if (!$job) return show_error('Job not found', 404);

        $stored_path = FCPATH . $job->stored_path;
        if (!is_file($stored_path)) return show_error('File not found', 404);

        // Process CSV only for phase 1
        $inserted = 0;
        $failed   = 0;
        $total    = 0;

        $fp = fopen($stored_path, 'r');
        if ($fp === false) return show_error('Cannot open file', 500);

        $firstLine = fgets($fp);
        $sep = (substr_count($firstLine, ';') > substr_count($firstLine, ',')) ? ';' : ',';
        $headers = str_getcsv(trim($firstLine), $sep);

        // Normalize headers
        $norm = function ($s) {
            return strtolower(trim(preg_replace('/\s+/', ' ', $s)));
        };
        $headers = array_map($norm, $headers);

        // Map some expected aliases (simple for phase 1) – GI / Asset
        $aliases = [
            'unit_layanan'   => 'UNIT_LAYANAN',
            'gardu_induk'    => 'GARDU_INDUK',
            'longitudex'     => 'LONGITUDEX',
            'latitudey'      => 'LATITUDEY',
            'status_operasi' => 'STATUS_OPERASI',
            'ip_rtu'         => 'IP_RTU',
            'ip_gateway'     => 'IP_GATEWAY',
        ];

        // ➕ alias minim untuk data_kontrak (boleh dipakai atau diabaikan di CSV)
        if ($job->target_table === 'data_kontrak') {
            $aliases = array_merge($aliases, [
                'jenis_anggaran'      => 'jenis_anggaran_text',
                'nomor_prk'           => 'nomor_prk_text',
                'uraian_prk'          => 'uraian_prk_text',
                'nomor_skkio'         => 'nomor_skk_io_text',
                'uraian_pekerjaan'    => 'uraian_pekerjaan',
                'user_pengusul'       => 'user_pengusul',
                'rab_user'            => 'rab_user',
                'rencana_hari_kerja'  => 'rencana_hari_kerja',
                'jenis_penagihan'     => 'jenis_penagihan',
                'tanggal_bastp'       => 'tanggal_bastp',
                'tgl_nd_ams'          => 'tgl_nd_ams',
                'nomor_nd_ams'        => 'nomor_nd_ams',
                'status_kontrak'      => 'status_kontrak',
                'keterangan'          => 'keterangan',
                'no_rks'              => 'no_rks',
                'metode_pengadaan'    => 'metode_pengadaan',
                'tahapan_pengadaan'   => 'tahapan_pengadaan',
                'prognosa_kontrak'    => 'prognosa_kontrak_tgl',
                'no_kontrak'          => 'no_kontrak',
                'vendor'              => 'pelaksana_vendor',
                'pelaksana_vendor'    => 'pelaksana_vendor',
                'tgl_kontrak'         => 'tgl_kontrak',
                'end_kontrak'         => 'end_kontrak',
                'nilai_kontrak'       => 'nilai_kontrak',
                'kendala_kontrak'     => 'kendala_kontrak',
                'tahapan_pembayaran'  => 'tahapan_pembayaran',
                'nilai_bayar'         => 'nilai_bayar',
                'tgl_tahapan'         => 'tgl_tahapan',
            ]);
        }

        $map = [];
        foreach ($headers as $i => $h) {
            $key = preg_replace('/[^a-z0-9_]/', '', $h);
            if (isset($aliases[$key])) {
                $map[$i] = $aliases[$key];
            } else {
                $map[$i] = strtoupper($key);
            }
        }

        // ==== CASE 1: GI pakai staging ====
        if ($job->target_table === 'gi') {
            $this->ImportJob_model->ensure_staging_for_gi();
            rewind($fp);
            $lineNo    = 0;
            $batch     = [];
            $chunkSize = 500;

            while (($row = fgetcsv($fp, 0, $sep)) !== false) {
                $lineNo++;
                if ($lineNo === 1) continue;
                $total++;

                $assoc = [];
                foreach ($row as $i => $val) {
                    $col = isset($map[$i]) ? $map[$i] : ('COL' . $i);
                    $assoc[$col] = is_string($val) ? trim($val) : $val;
                }
                $assoc['import_id'] = $job_id;
                $assoc['row_no']    = $lineNo - 1;
                $batch[] = $assoc;

                if (count($batch) >= $chunkSize) {
                    $ok = $this->ImportJob_model->insert_staging_batch('gi', $batch);
                    if (!$ok) $failed += count($batch);
                    else $inserted += count($batch);
                    $batch = [];
                }
            }

            if (count($batch) > 0) {
                $ok = $this->ImportJob_model->insert_staging_batch('gi', $batch);
                if (!$ok) $failed += count($batch);
                else $inserted += count($batch);
            }

            fclose($fp);

            $this->ImportJob_model->finish_job($job_id, [
                'total_rows' => $total,
                'inserted'   => $inserted,
                'failed'     => $failed,
                'status'     => 'done'
            ]);

            $this->session->set_flashdata('success', 'Import selesai: total ' . $total . ', masuk ' . $inserted . ', gagal ' . $failed);
            return redirect('import/status/' . $job_id);
        }

        // ==== CASE 2: Entity lain – termasuk master_rekomposisi – langsung ke target_table ====
        $target_table = $job->target_table;
        if (!$this->db->table_exists($target_table)) {
            $this->session->set_flashdata('error', 'Tabel target tidak ditemukan: ' . $target_table);
            fclose($fp);
            return redirect('import/status/' . $job_id);
        }

        $target_fields = $this->db->list_fields($target_table);

        rewind($fp);
        $lineNo    = 0;
        $batch     = [];
        $chunkSize = 500;

        while (($row = fgetcsv($fp, 0, $sep)) !== false) {
            $lineNo++;
            if ($lineNo === 1) continue;
            $total++;

            $assoc = [];
            foreach ($row as $i => $val) {
                $col = isset($map[$i]) ? $map[$i] : ('COL' . $i);

                // default: pakai UPPER (karena master_rekomposisi kolomnya lower_snake_case? -> kolom Anda ternyata lower_snake_case, jadi kita sesuaikan)
                // ✅ KHUSUS master_rekomposisi: kolomnya: jenis_anggaran, nomor_prk, nomor_skk_io, uraian_prk, pagu_skk_io, judul_drp, lkao_usulan, created_at, updated_at
                if ($target_table === 'master_rekomposisi') {
                    $col = strtolower($col);
                } elseif ($target_table === 'data_kontrak') {
                    $col = strtolower($col);
                } else {
                    $col = strtoupper($col);
                }

                if (in_array($col, $target_fields, true)) {
                    $assoc[$col] = is_string($val) ? trim($val) : $val;
                }
            }

            if (!empty($assoc)) {
                $batch[] = $assoc;
            }

            if (count($batch) >= $chunkSize) {
                $this->db->insert_batch($target_table, $batch);
                $aff = $this->db->affected_rows();
                if ($aff > 0) $inserted += $aff;
                else $failed += count($batch);
                $batch = [];
            }
        }

        if (count($batch) > 0) {
            $this->db->insert_batch($target_table, $batch);
            $aff = $this->db->affected_rows();
            if ($aff > 0) $inserted += $aff;
            else $failed += count($batch);
        }

        fclose($fp);

        $this->ImportJob_model->finish_job($job_id, [
            'total_rows' => $total,
            'inserted'   => $inserted,
            'failed'     => $failed,
            'status'     => 'committed'
        ]);

        // ✅ KHUSUS master_rekomposisi: balik ke halaman Rekomposisi
        if ($target_table === 'master_rekomposisi') {
            $this->session->set_flashdata(
                'success',
                'Import master rekomposisi selesai: total ' . $total . ', masuk ' . $inserted . ', gagal ' . $failed
            );
            return redirect('rekomposisi');
        }

        // KHUSUS data_kontrak: kembali ke data_kontrak
        if ($target_table === 'data_kontrak') {
            $this->session->set_flashdata(
                'success',
                'Import data kontrak selesai: total ' . $total . ', masuk ' . $inserted . ', gagal ' . $failed
            );
            return redirect('data_kontrak');
        }

        // Entity lain tetap ke halaman status import
        $this->session->set_flashdata('success', 'Import selesai: total ' . $total . ', masuk ' . $inserted . ', gagal ' . $failed);
        return redirect('import/status/' . $job_id);
    }

    public function status($job_id)
    {
        $job = $this->ImportJob_model->get_job((int)$job_id);
        if (!$job) return show_404();
        $data = ['title' => 'Status Import', 'job' => $job];
        $this->load->view('import/status', $data);
    }

    public function download_error($job_id)
    {
        show_404();
    }

    public function commit($job_id)
    {
        $job = $this->ImportJob_model->get_job((int)$job_id);
        if (!$job) return show_404();

        if (empty($job->staging_table)) {
            $this->session->set_flashdata('error', 'Commit tidak diperlukan untuk import ini. Data sudah dimasukkan.');
            return redirect('import/status/' . $job->id);
        }

        $inserted = $this->ImportJob_model->commit_staging_to_target($job->id, $job->target_table);
        if ($inserted === -1) {
            $this->session->set_flashdata('error', 'Tabel target tidak ditemukan: ' . $job->target_table);
        } elseif ($inserted === -2) {
            $this->session->set_flashdata('error', 'Skema tabel target memiliki PRIMARY KEY yang bukan AUTO_INCREMENT. Ubah kolom PK menjadi AUTO_INCREMENT atau hapus PK sebelum commit (append-only).');
        } else {
            $this->ImportJob_model->finish_job($job->id, [
                'updated' => 0,
                'skipped' => 0,
                'status'  => 'committed'
            ]);
            $this->session->set_flashdata('success', 'Berhasil commit ke tabel ' . $job->target_table . ': ' . $inserted . ' baris ditambahkan.');
        }

        return redirect('import/status/' . $job->id);
    }
}
