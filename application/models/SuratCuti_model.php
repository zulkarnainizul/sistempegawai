<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SuratCuti_model extends CI_Model
{
    private $_table = "surat_cuti";

    /**
     * Mengambil semua data surat cuti untuk ditampilkan di daftar.
     */
    public function get_all_cuti()
    {
        $this->db->select('
            sc.*, 
            p.nama as nama_pemohon, 
            p.nip as nip_pemohon,
            j.nama_jabatan
        ');
        $this->db->from($this->_table . ' sc');
        $this->db->join('pegawai p', 'p.id_pegawai = sc.id_pegawai', 'left');
        $this->db->join('riwayat_jabatan_pegawai rjp', 'rjp.id_riwayat_jabatan_pegawai = p.latest_id_riwayat_jabatan', 'left');
        $this->db->join('jabatan_pegawai j', 'j.id_jabatan = rjp.id_jabatan', 'left');
        $this->db->order_by('sc.date_create', 'DESC');
        return $this->db->get()->result();
    }

    /**
     * Mengambil satu data surat cuti berdasarkan ID, lengkap dengan detail pegawai.
     */
    public function get_cuti_by_id($id)
    {
        $this->db->select("
            sc.*, 
            p.nama as nama_pemohon, 
            p.nip as nip_pemohon,
            j.nama_jabatan as jabatan, 
            j.nama_jabatan as unit_kerja, /* Diasumsikan unit kerja sama dengan jabatan */
            TIMESTAMPDIFF(YEAR, p.tanggal_mulai_bertugas, CURDATE()) as masa_kerja_tahun,
            TIMESTAMPDIFF(MONTH, p.tanggal_mulai_bertugas, CURDATE()) % 12 as masa_kerja_bulan
        ");
        $this->db->from($this->_table . ' sc');
        $this->db->join('pegawai p', 'p.id_pegawai = sc.id_pegawai', 'left');
        $this->db->join('riwayat_jabatan_pegawai rjp', 'rjp.id_riwayat_jabatan_pegawai = p.latest_id_riwayat_jabatan', 'left');
        $this->db->join('jabatan_pegawai j', 'j.id_jabatan = rjp.id_jabatan', 'left');
        $this->db->where('sc.id_surat_cuti', $id);
        return $this->db->get()->row();
    }

    /**
     * Menyimpan data baru ke tabel surat_cuti.
     */
    public function insert_cuti($data)
    {
        return $this->db->insert($this->_table, $data);
    }

    /**
     * Memperbarui data di tabel surat_cuti berdasarkan ID.
     */
    public function update_cuti($id, $data)
    {
        return $this->db->update($this->_table, $data, ['id_surat_cuti' => $id]);
    }
    
    /**
     * Menghapus data dari tabel surat_cuti berdasarkan ID.
     */
    public function delete_cuti($id)
    {
        return $this->db->delete($this->_table, ['id_surat_cuti' => $id]);
    }
}