<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class PelaksanaTugas_model extends CI_Model {

public function insert_batch_pelaksana($data)
    {
        if (!empty($data)) {
            return $this->db->insert_batch('pelaksana_tugas', $data);
        }
        return true;
    }

    public function get_pelaksana_by_surat_id($id_surat_tugas)
    {
        $this->db->select('
            p.nama, 
            p.nip,
            j.nama_jabatan,
            sp.nama_status,
            g.nama_golongan
        ');
        $this->db->from('pelaksana_tugas pt'); // pt = alias untuk pelaksana_tugas
        $this->db->join('pegawai p', 'pt.id_pegawai = p.id_pegawai'); // p = alias untuk pegawai
        
        // Join untuk mendapatkan Jabatan terakhir dari riwayat
        $this->db->join('riwayat_jabatan_pegawai rjp', 'p.latest_id_riwayat_jabatan = rjp.id_riwayat_jabatan_pegawai', 'left');
        $this->db->join('jabatan_pegawai j', 'rjp.id_jabatan = j.id_jabatan', 'left');
        
        // Join untuk mendapatkan Status terakhir dari riwayat
        $this->db->join('riwayat_status_pegawai rsp', 'p.latest_id_riwayat_status_pegawai = rsp.id_riwayat_status_pegawai', 'left');
        $this->db->join('status_pegawai sp', 'rsp.id_status_pegawai = sp.id_status_pegawai', 'left');

         // Join untuk mendapatkan golongan terakhir dari riwayat
        $this->db->join('riwayat_golongan_pegawai rgp', 'p.latest_id_riwayat_golongan = rgp.id_riwayat_golongan_pegawai', 'left');
        $this->db->join('golongan_pegawai g', 'rgp.id_golongan = g.id_golongan', 'left');
        
        $this->db->where('pt.id_surat_tugas', $id_surat_tugas);
        
        return $this->db->get()->result();
    }

    public function delete_pelaksana_by_surat_id($id_surat_tugas)
    {
        $this->db->where('id_surat_tugas', $id_surat_tugas);
        return $this->db->delete('pelaksana_tugas');
    }

}
