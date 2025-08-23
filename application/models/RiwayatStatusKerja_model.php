<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class RiwayatStatusKerja_model extends CI_Model {

    public function get_data(){
        $this->db->from('riwayat_status_bekerja');
        $this->db->order_by('date_create', 'desc');
        return $this->db->get()->result();
    }

    
    public function get_by_pegawai($id_pegawai)
    {
        $this->db->select('rsk.*');
        $this->db->from('riwayat_status_bekerja rsk');
        $this->db->where('rsk.id_pegawai', $id_pegawai);
        $this->db->order_by('rsk.tmt_status_kerja', 'desc');
        return $this->db->get()->result();
    }

    public function insert_data($data)
    {
        return $this->db->insert('riwayat_status_bekerja', $data);
    }

    public function update_data($data, $table){
        $this->db->where('id_riwayat_status_bekerja', $data['id_riwayat_status_bekerja']);
        $this->db->update($table, $data);
    }

    public function update_tmt_mulai_bekerja($id_pegawai, $tanggal_mulai_bertugas)
    {
        $this->db->where('id_pegawai', $id_pegawai);
        $this->db->where('jenis_status_kerja', 'Mulai Bekerja');
        return $this->db->update('riwayat_status_bekerja', [
            'tmt_status_kerja' => $tanggal_mulai_bertugas
        ]);
    }

    public function delete($where, $table){
        $this->db->where($where);
        $this->db->delete($table);
    }

}
