<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rekomposisi_model extends CI_Model
{
    private $table = 'rekomposisi';

    // 🔹 Ambil semua data rekomposisi, optional keyword untuk pencarian
    public function get_all_rekomposisi($keyword = null)
    {
        $this->db->order_by('ID_REKOMPOSISI', 'DESC');

        if ($keyword) {
            $this->db->group_start();
            $this->db->like('JENIS_ANGGARAN', $keyword);
            $this->db->or_like('NOMOR_PRK', $keyword);
            $this->db->or_like('NOMOR_SKK_IO', $keyword);
            $this->db->or_like('PRK', $keyword);
            $this->db->or_like('JUDUL_DRP', $keyword);
            $this->db->group_end();
        }

        return $this->db->get($this->table)->result_array();
    }

    // 🔹 Ambil data berdasarkan ID
    public function get_rekomposisi_by_id($id)
    {
        return $this->db->get_where($this->table, ['ID_REKOMPOSISI' => $id])->row_array();
    }

    // 🔹 Tambah data baru
    public function insert_rekomposisi($data)
    {
        return $this->db->insert($this->table, $data);
    }

    // 🔹 Update data
    public function update_rekomposisi($id, $data)
    {
        $this->db->where('ID_REKOMPOSISI', $id);
        return $this->db->update($this->table, $data);
    }

    // 🔹 Hapus data
    public function delete_rekomposisi($id)
    {
        $this->db->where('ID_REKOMPOSISI', $id);
        return $this->db->delete($this->table);
    }

    // 🔹 Pagination
    public function get_rekomposisi_paginated($limit, $start, $keyword = null)
    {
        $this->db->order_by('ID_REKOMPOSISI', 'DESC');

        if ($keyword) {
            $this->db->group_start();
            $this->db->like('JENIS_ANGGARAN', $keyword);
            $this->db->or_like('NOMOR_PRK', $keyword);
            $this->db->or_like('NOMOR_SKK_IO', $keyword);
            $this->db->or_like('PRK', $keyword);
            $this->db->or_like('JUDUL_DRP', $keyword);
            $this->db->group_end();
        }

        return $this->db->get($this->table, $limit, $start)->result_array();
    }

    // 🔹 Get distinct PRK by Jenis Anggaran
    public function get_prk_by_jenis($jenis_anggaran = null)
    {
        $this->db->select('NOMOR_PRK, PRK');
        $this->db->distinct();
        
        if ($jenis_anggaran) {
            $this->db->where('JENIS_ANGGARAN', $jenis_anggaran);
        }
        
        $this->db->order_by('NOMOR_PRK', 'ASC');
        return $this->db->get($this->table)->result_array();
    }

    // 🔹 Get SKK by PRK
    public function get_skk_by_prk($nomor_prk)
    {
        $this->db->select('NOMOR_SKK_IO, SKKI_O, PRK');
        $this->db->where('NOMOR_PRK', $nomor_prk);
        $this->db->order_by('NOMOR_SKK_IO', 'ASC');
        return $this->db->get($this->table)->result_array();
    }

    // 🔹 Get DRP by PRK
    public function get_drp_by_prk($nomor_prk)
    {
        $this->db->select('JUDUL_DRP');
        $this->db->distinct();
        $this->db->where('NOMOR_PRK', $nomor_prk);
        $this->db->where('JUDUL_DRP IS NOT NULL');
        $this->db->where('JUDUL_DRP !=', '');
        $this->db->order_by('JUDUL_DRP', 'ASC');
        return $this->db->get($this->table)->result_array();
    }

    // 🔹 Get SKK Value by Nomor SKK
    public function get_skk_value($nomor_skk)
    {
        $this->db->select('SKKI_O, PRK');
        $this->db->where('NOMOR_SKK_IO', $nomor_skk);
        return $this->db->get($this->table)->row_array();
    }
}
