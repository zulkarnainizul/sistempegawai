<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SuratTugas_model extends CI_Model {

    // Mengambil SEMUA surat tugas dan MENGGABUNGKAN pelaksananya di Controller
    public function get_semua_surat_dengan_pelaksana() {
        $this->db->select('
            st.*, 
            p.id_pegawai as pelaksana_id_pegawai, 
            p.nama as nama_pelaksana, 
            p.nip as nip_pelaksana
        ');
        $this->db->from('surat_tugas st');
        $this->db->join('pelaksana_tugas pt', 'st.id_surat_tugas = pt.id_surat_tugas', 'left');
        $this->db->join('pegawai p', 'pt.id_pegawai = p.id_pegawai', 'left');
        $this->db->order_by('st.date_create', 'DESC');
        $flat_results = $this->db->get()->result();

        // Olah data mentah menjadi data terstruktur
        $surat_terstruktur = [];
        foreach ($flat_results as $row) {
            if (!isset($surat_terstruktur[$row->id_surat_tugas])) {
                $surat_terstruktur[$row->id_surat_tugas] = (object)[
                    'id_surat_tugas'  => $row->id_surat_tugas,
                    'no_surat'        => $row->no_surat,
                    'dasar_surat'     => $row->dasar_surat,
                    'nama_kegiatan'   => $row->nama_kegiatan,
                    'tanggal_mulai'   => $row->tanggal_mulai,
                    'tanggal_akhir'   => $row->tanggal_akhir,
                    'tempat_kegiatan' => $row->tempat_kegiatan,
                    'lokasi_kegiatan' => $row->lokasi_kegiatan,
                    'pemberi_tugas'   => $row->pemberi_tugas,
                    'date_create'     => $row->date_create,
                    'pelaksana'       => []
                ];
            }
            if ($row->pelaksana_id_pegawai !== null) {
                $surat_terstruktur[$row->id_surat_tugas]->pelaksana[] = (object)[
                    'id_pegawai' => $row->pelaksana_id_pegawai,
                    'nama'       => $row->nama_pelaksana,
                    'nip'        => $row->nip_pelaksana
                ];
            }
        }
        return array_values($surat_terstruktur);
    }

    /**
     * BARU: Mengambil SATU surat tugas beserta detail pelaksananya
     */
    public function get_surat_detail_by_id($id) {
        // 1. Ambil data utama surat
        $surat = $this->db->get_where('surat_tugas', ['id_surat_tugas' => $id])->row();
        
        if ($surat) {
            // 2. Ambil data pelaksana
            $this->db->select('p.id_pegawai, p.nama, p.nip');
            $this->db->from('pelaksana_tugas pt');
            $this->db->join('pegawai p', 'pt.id_pegawai = p.id_pegawai');
            $this->db->where('pt.id_surat_tugas', $id);
            $pelaksana = $this->db->get()->result();
            
            // 3. Gabungkan ke dalam objek surat
            $surat->pelaksana = $pelaksana;
        }
        
        return $surat;
    }

    public function insert_surat_tugas($data) {
        $this->db->insert('surat_tugas', $data);
        return $this->db->insert_id();
    }

    public function update_surat_tugas($id, $data) {
        $this->db->where('id_surat_tugas', $id);
        return $this->db->update('surat_tugas', $data);
    }

    public function delete_surat_tugas($id) {
        $this->db->where('id_surat_tugas', $id);
        return $this->db->delete('surat_tugas');
    }
}