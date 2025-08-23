<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class RiwayatStatusPegawai_model extends CI_Model {

    public function get_data(){
        $this->db->from('riwayat_status_pegawai');
        $this->db->order_by('date_create', 'desc');
        return $this->db->get()->result();
    }

    public function get_by_pegawai($id_pegawai)
    {
        $this->db->select('rsp.*, sp.nama_status');
        $this->db->from('riwayat_status_pegawai rsp');
        $this->db->join('status_pegawai sp', 'sp.id_status_pegawai = rsp.id_status_pegawai', 'left');
        $this->db->where('rsp.id_pegawai', $id_pegawai);
        $this->db->order_by('rsp.tmt_status', 'desc');
        return $this->db->get()->result();
    }

    public function insert_riwayat_status($data)
    {
        $this->db->insert('riwayat_status_pegawai', $data);
        return $this->db->insert_id();
    }

    public function update_data($id_riwayat, $data)
    {
        $this->db->where('id_riwayat_status_pegawai', $id_riwayat);
        return $this->db->update('riwayat_status_pegawai', $data);
    }

    public function delete($id_riwayat)
    {
        $this->db->where('id_riwayat_status_pegawai', $id_riwayat);
        $this->db->delete('riwayat_status_pegawai');
    }

    public function get_by_id($id_riwayat)
    {
        return $this->db->get_where('riwayat_status_pegawai', ['id_riwayat_status_pegawai' => $id_riwayat])->row();
    }

    public function update_latest_riwayat($id_pegawai)
    {
        $this->db->select('id_riwayat_status_pegawai');
        $this->db->from('riwayat_status_pegawai');
        $this->db->where('id_pegawai', $id_pegawai);
        $this->db->order_by('tmt_status', 'DESC');
        $this->db->limit(1);

        $query = $this->db->get();
        $result = $query->row();

        if ($result) {
            $this->db->where('id_pegawai', $id_pegawai);
            $this->db->update('pegawai', ['latest_id_riwayat_status_pegawai' => $result->id_riwayat_status_pegawai]);
        } else {
            // Jika tidak ada riwayat lagi, kosongkan latest_id
            $this->db->where('id_pegawai', $id_pegawai);
            $this->db->update('pegawai', ['latest_id_riwayat_status_pegawai' => NULL]);
        }
    }
}