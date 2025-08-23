<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class RiwayatJabatan_model extends CI_Model {

    public function get_data(){
        $this->db->from('riwayat_jabatan_pegawai');
        $this->db->order_by('tmt_jabatan', 'desc');
        return $this->db->get()->result();
    }

    public function get_by_pegawai($id_pegawai)
    {
        $this->db->select('rj.*, j.nama_jabatan, j.jenis_jabatan');
        $this->db->from('riwayat_jabatan_pegawai rj');
        $this->db->join('jabatan_pegawai j', 'j.id_jabatan = rj.id_jabatan', 'left');
        $this->db->where('rj.id_pegawai', $id_pegawai);
        $this->db->order_by('rj.tmt_jabatan', 'desc');
        return $this->db->get()->result();
    }

    public function insert_riwayat_jabatan($data)
    {
        $this->db->insert('riwayat_jabatan_pegawai', $data);
        return $this->db->insert_id();
    }

    public function update_data($id_riwayat, $data)
    {
        $this->db->where('id_riwayat_jabatan_pegawai', $id_riwayat);
        return $this->db->update('riwayat_jabatan_pegawai', $data);
    }

    public function delete($id_riwayat)
    {
        $this->db->where('id_riwayat_jabatan_pegawai', $id_riwayat);
        $this->db->delete('riwayat_jabatan_pegawai');
    }

    public function get_by_id($id_riwayat)
    {
        return $this->db->get_where('riwayat_jabatan_pegawai', ['id_riwayat_jabatan_pegawai' => $id_riwayat])->row();
    }

    public function update_latest_riwayat($id_pegawai)
    {
        $this->db->select('id_riwayat_jabatan_pegawai');
        $this->db->from('riwayat_jabatan_pegawai');
        $this->db->where('id_pegawai', $id_pegawai);
        $this->db->order_by('tmt_jabatan', 'DESC');
        $this->db->limit(1);

        $query = $this->db->get();
        $result = $query->row();

        if ($result) {
            $this->db->where('id_pegawai', $id_pegawai);
            $this->db->update('pegawai', ['latest_id_riwayat_jabatan' => $result->id_riwayat_jabatan_pegawai]);
        } else {
            // Jika tidak ada riwayat lagi, kosongkan latest_id
            $this->db->where('id_pegawai', $id_pegawai);
            $this->db->update('pegawai', ['latest_id_riwayat_jabatan' => NULL]);
        }
    }
}