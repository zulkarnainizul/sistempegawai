<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class RiwayatGolongan_model extends CI_Model {

    public function get_data()
    {
        $this->db->from('riwayat_golongan_pegawai');
        $this->db->order_by('tmt_golongan', 'desc');
        return $this->db->get()->result();
    }

    public function get_by_pegawai($id_pegawai)
    {
        $this->db->select('rg.*, gp.nama_golongan');
        $this->db->from('riwayat_golongan_pegawai rg');
        $this->db->join('golongan_pegawai gp', 'gp.id_golongan = rg.id_golongan', 'left');
        $this->db->where('rg.id_pegawai', $id_pegawai);
        $this->db->order_by('rg.tmt_golongan', 'desc');
        return $this->db->get()->result();
    }

    public function insert_riwayat_golongan($data)
    {
        $this->db->insert('riwayat_golongan_pegawai', $data);
        return $this->db->insert_id();
    }

    public function update_data($id_riwayat, $data)
    {
        $this->db->where('id_riwayat_golongan_pegawai', $id_riwayat);
        return $this->db->update('riwayat_golongan_pegawai', $data);
    }

    public function delete($id_riwayat)
    {
        $this->db->where('id_riwayat_golongan_pegawai', $id_riwayat);
        $this->db->delete('riwayat_golongan_pegawai');
    }

    public function get_by_id($id_riwayat)
    {
        return $this->db->get_where('riwayat_golongan_pegawai', ['id_riwayat_golongan_pegawai' => $id_riwayat])->row();
    }

    public function update_latest_riwayat($id_pegawai)
    {
        $this->db->select('id_riwayat_golongan_pegawai');
        $this->db->from('riwayat_golongan_pegawai');
        $this->db->where('id_pegawai', $id_pegawai);
        $this->db->order_by('tmt_golongan', 'DESC');
        $this->db->limit(1);

        $query = $this->db->get();
        $result = $query->row();

        if ($result) {
            $this->db->where('id_pegawai', $id_pegawai);
            $this->db->update('pegawai', ['latest_id_riwayat_golongan' => $result->id_riwayat_golongan_pegawai]);
        } else {
            // Jika tidak ada riwayat lagi, kosongkan latest_id
            $this->db->where('id_pegawai', $id_pegawai);
            $this->db->update('pegawai', ['latest_id_riwayat_golongan' => NULL]);
        }
    }
}
