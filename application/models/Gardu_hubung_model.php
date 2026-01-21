<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gardu_hubung_model extends CI_Model
{
    private $table = 'gh'; // Nama tabel di database

    /** @var array<string,bool> */
    private $columnExistsCache = [];

    private function hasColumn(string $column): bool
    {
        if (array_key_exists($column, $this->columnExistsCache)) {
            return $this->columnExistsCache[$column];
        }

        $this->columnExistsCache[$column] = (bool) $this->db->field_exists($column, $this->table);
        return $this->columnExistsCache[$column];
    }

    /**
     * Override nilai legacy dengan kolom typed (additive migration) bila tersedia.
     * Ini menjaga kompatibilitas view/controller yang masih memakai nama kolom lama.
     *
     * @param array<string,mixed> $row
     * @return array<string,mixed>
     */
    private function overlayTypedFields(array $row): array
    {
        if ($this->hasColumn('LATITUDEY_DEC') && isset($row['LATITUDEY_DEC']) && $row['LATITUDEY_DEC'] !== null && $row['LATITUDEY_DEC'] !== '') {
            $row['LATITUDEY'] = (string) $row['LATITUDEY_DEC'];
        }
        if ($this->hasColumn('LONGITUDEX_DEC') && isset($row['LONGITUDEX_DEC']) && $row['LONGITUDEX_DEC'] !== null && $row['LONGITUDEX_DEC'] !== '') {
            $row['LONGITUDEX'] = (string) $row['LONGITUDEX_DEC'];
        }
        if ($this->hasColumn('INSTALLDATE_DATE') && !empty($row['INSTALLDATE_DATE'])) {
            $row['INSTALLDATE'] = (string) $row['INSTALLDATE_DATE'];
        }
        if ($this->hasColumn('ACTUALOPRDATE_DATE') && !empty($row['ACTUALOPRDATE_DATE'])) {
            $row['ACTUALOPRDATE'] = (string) $row['ACTUALOPRDATE_DATE'];
        }
        if ($this->hasColumn('CHANGEDATE_DATE') && !empty($row['CHANGEDATE_DATE'])) {
            $row['CHANGEDATE'] = (string) $row['CHANGEDATE_DATE'];
        }
        if ($this->hasColumn('SLOACTIVEDATE_DATE') && !empty($row['SLOACTIVEDATE_DATE'])) {
            $row['SLOACTIVEDATE'] = (string) $row['SLOACTIVEDATE_DATE'];
        }

        return $row;
    }

    // Ambil semua data Gardu Hubung
    public function get_all_gardu_hubung()
    {
        $rows = $this->db->get($this->table)->result_array();
        foreach ($rows as $i => $row) {
            $rows[$i] = $this->overlayTypedFields($row);
        }
        return $rows;
    }

    public function get_gardu_hubung($limit, $offset)
    {
        $this->db->limit($limit, $offset);
        $rows = $this->db->get($this->table)->result_array();
        foreach ($rows as $i => $row) {
            $rows[$i] = $this->overlayTypedFields($row);
        }
        return $rows;
    }

    public function count_all_gardu_hubung()
    {
        return $this->db->count_all($this->table);
    }

    // Ambil data Gardu Hubung berdasarkan SSOTNUMBER
    public function get_gardu_hubung_by_id($ssotnumber)
    {
        $row = $this->db->get_where($this->table, ['SSOTNUMBER' => $ssotnumber])->row_array();
        if (!$row) {
            return $row;
        }
        return $this->overlayTypedFields($row);
    }

    // Tambah data baru
    public function insert_gardu_hubung($data)
    {
        return $this->db->insert($this->table, $data);
    }

    // Update data berdasarkan SSOTNUMBER
    public function update_gardu_hubung($ssotnumber, $data)
    {
        $this->db->where('SSOTNUMBER', $ssotnumber);
        return $this->db->update($this->table, $data);
    }

    // Hapus data berdasarkan SSOTNUMBER
    public function delete_gardu_hubung($ssotnumber)
    {
        $this->db->where('SSOTNUMBER', $ssotnumber);
        return $this->db->delete($this->table);
    }
}
