<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SuratKeterangan_model extends CI_Model {

    private $_table = "surat_keterangan";

    /**
     * Mengambil semua data surat keterangan dengan detail pegawai.
     */
    public function get_all_surat_with_pegawai() {
        $this->db->select('sk.*, p.nama, p.nip');
        $this->db->from($this->_table . ' sk');
        $this->db->join('pegawai p', 'p.id_pegawai = sk.id_pegawai');
        $this->db->order_by('sk.date_create', 'DESC');
        return $this->db->get()->result();
    }

    /**
     * Mengambil satu data surat keterangan berdasarkan ID, dengan detail lengkap pegawai.
     */
    public function get_surat_by_id($id) {
        $this->db->select('sk.*, p.nama, p.nip, p.tempat_lahir, p.tanggal_lahir');
        $this->db->from($this->_table . ' sk');
        $this->db->join('pegawai p', 'p.id_pegawai = sk.id_pegawai');
        $this->db->where('sk.id_surat_keterangan', $id);
        return $this->db->get()->row();
    }

    /**
     * Menyimpan data surat baru.
     */
    public function insert_surat($data) {
        return $this->db->insert($this->_table, $data);
    }

    /**
     * Memperbarui data surat berdasarkan ID.
     */
    public function update_surat($id, $data) {
        return $this->db->update($this->_table, $data, ['id_surat_keterangan' => $id]);
    }
    
    /**
     * Menghapus data surat berdasarkan ID.
     */
    public function delete_surat($id) {
        return $this->db->delete($this->_table, ['id_surat_keterangan' => $id]);
    }
}