<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class RiwayatPendidikan_model extends CI_Model {

    public function get_data(){
        $this->db->from('riwayat_pendidikan_pegawai');
        $this->db->order_by('date_create', 'desc');
        return $this->db->get()->result();
    }

    
    public function get_by_pegawai_id($id_pegawai)
    {
        $this->db->select('rp.*');
        $this->db->from('riwayat_pendidikan_pegawai rp');
        $this->db->where('rp.id_pegawai', $id_pegawai);
        $this->db->order_by('rp.tahun_lulus', 'desc');
        return $this->db->get()->result();
    }

    public function insert_riwayat_pendidikan($data)
    {
        $this->db->insert('riwayat_pendidikan_pegawai', $data);
        return $this->db->insert_id();
    }

    public function update_data($id_riwayat, $data)
    {
        $this->db->where('id_riwayat_pendidikan_pegawai', $id_riwayat);
        return $this->db->update('riwayat_pendidikan_pegawai', $data);
    }

    public function delete($id_riwayat)
    {
        $this->db->where('id_riwayat_pendidikan_pegawai', $id_riwayat);
        $this->db->delete('riwayat_pendidikan_pegawai');
    }

    public function get_by_id($id_riwayat)
    {
        return $this->db->get_where('riwayat_pendidikan_pegawai', ['id_riwayat_pendidikan_pegawai' => $id_riwayat])->row();
    }

    public function update_latest_riwayat($id_pegawai)
    {
        $this->db->select('id_riwayat_pendidikan_pegawai');
        $this->db->from('riwayat_pendidikan_pegawai');
        $this->db->where('id_pegawai', $id_pegawai);
        $this->db->order_by('tahun_lulus', 'DESC');
        $this->db->limit(1);

        $query = $this->db->get();
        $result = $query->row();

        if ($result) {
            $this->db->where('id_pegawai', $id_pegawai);
            $this->db->update('pegawai', ['latest_id_riwayat_pendidikan' => $result->id_riwayat_pendidikan_pegawai]);
        } else {
            // Jika tidak ada riwayat lagi, kosongkan latest_id
            $this->db->where('id_pegawai', $id_pegawai);
            $this->db->update('pegawai', ['latest_id_riwayat_pendidikan' => NULL]);
        }
    }
}
