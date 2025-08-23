<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pegawai_model extends CI_Model {

    public function get_data(){
        $this->db->from('pegawai');
        $this->db->order_by('date_create', 'desc');
        return $this->db->get()->result();
    }

    public function get_data_pegawai($status)
    {
        $this->db->select('
            p.*,
            g.nama_golongan,
            j.nama_jabatan,
            sp.nama_status,
            rsb.jenis_status_kerja
        ');
        $this->db->from('pegawai p');

        $this->db->join('riwayat_golongan_pegawai rgp', 'rgp.id_riwayat_golongan_pegawai = p.latest_id_riwayat_golongan', 'left');
        $this->db->join('golongan_pegawai g', 'g.id_golongan = rgp.id_golongan', 'left');

        $this->db->join('riwayat_jabatan_pegawai rjp', 'rjp.id_riwayat_jabatan_pegawai = p.latest_id_riwayat_jabatan', 'left');
        $this->db->join('jabatan_pegawai j', 'j.id_jabatan = rjp.id_jabatan', 'left');

        $this->db->join('riwayat_status_pegawai rsp', 'rsp.id_riwayat_status_pegawai = p.latest_id_riwayat_status_pegawai', 'left');
        $this->db->join('status_pegawai sp', 'sp.id_status_pegawai = rsp.id_status_pegawai', 'left');

        $this->db->join('riwayat_status_bekerja rsb', 'rsb.id_riwayat_status_bekerja = p.latest_id_riwayat_status_bekerja', 'left');

        $this->db->join('riwayat_pendidikan_pegawai rp', 'rp.id_riwayat_pendidikan_pegawai = p.latest_id_riwayat_pendidikan', 'left');

        $this->db->where('p.pegawai_status', $status);
        $this->db->order_by('p.date_create', 'desc');

        return $this->db->get()->result();
    }

    public function get_pegawai_laporan_lengkap(array $status_ids)
    {
        if (empty($status_ids)) {
            return [];
        }

        $this->db->select([
            'p.nama',
            'p.nip',
            'p.jenis_kelamin',
            'p.tempat_lahir',
            'p.tanggal_lahir',
            'p.alamat',
            'p.no_hp',
            'p.tanggal_mulai_bertugas',
            'g.nama_golongan',
            'rgp.tmt_golongan', // Mengambil TMT Golongan
            'j.nama_jabatan',
            'rjp.tmt_jabatan',   // Mengambil TMT Jabatan
            'sp.nama_status',
            'rp.nama_jurusan',   // Mengambil data pendidikan
            'rp.tahun_lulus',
            'rp.tingkat_ijazah'
        ]);
        $this->db->from('pegawai p');
        // Join untuk semua riwayat terbaru
        $this->db->join('riwayat_golongan_pegawai rgp', 'p.latest_id_riwayat_golongan = rgp.id_riwayat_golongan_pegawai', 'left');
        $this->db->join('golongan_pegawai g', 'rgp.id_golongan = g.id_golongan', 'left');
        $this->db->join('riwayat_jabatan_pegawai rjp', 'p.latest_id_riwayat_jabatan = rjp.id_riwayat_jabatan_pegawai', 'left');
        $this->db->join('jabatan_pegawai j', 'rjp.id_jabatan = j.id_jabatan', 'left');
        $this->db->join('riwayat_status_pegawai rsp', 'p.latest_id_riwayat_status_pegawai = rsp.id_riwayat_status_pegawai', 'left');
        $this->db->join('status_pegawai sp', 'rsp.id_status_pegawai = sp.id_status_pegawai', 'left');
        $this->db->join('riwayat_pendidikan_pegawai rp', 'p.latest_id_riwayat_pendidikan = rp.id_riwayat_pendidikan_pegawai', 'left');

        $this->db->where('p.pegawai_status', 1); // Hanya pegawai aktif
        $this->db->where_in('sp.id_status_pegawai', $status_ids); // Filter berdasarkan status yang dipilih
        $this->db->order_by('p.nama', 'ASC');
        
        return $this->db->get()->result();
    }

    public function get_pegawai_by_status(array $status_ids)
    {
        // Jika array status kosong, kembalikan array kosong agar tidak error
        if (empty($status_ids)) {
            return [];
        }

        $this->db->select('p.nama, p.nip, p.jenis_kelamin, j.nama_jabatan, g.nama_golongan, sp.nama_status');
        $this->db->from('pegawai p');
        $this->db->join('riwayat_jabatan_pegawai rjp', 'p.latest_id_riwayat_jabatan = rjp.id_riwayat_jabatan_pegawai', 'left');
        $this->db->join('jabatan_pegawai j', 'rjp.id_jabatan = j.id_jabatan', 'left');
        $this->db->join('riwayat_golongan_pegawai rgp', 'p.latest_id_riwayat_golongan = rgp.id_riwayat_golongan_pegawai', 'left');
        $this->db->join('golongan_pegawai g', 'rgp.id_golongan = g.id_golongan', 'left');
        $this->db->join('riwayat_status_pegawai rsp', 'p.latest_id_riwayat_status_pegawai = rsp.id_riwayat_status_pegawai', 'left');
        $this->db->join('status_pegawai sp', 'rsp.id_status_pegawai = sp.id_status_pegawai', 'left');
        
        // Menggunakan where_in untuk filter berdasarkan beberapa ID status
        $this->db->where_in('sp.id_status_pegawai', $status_ids);

        $this->db->where('p.pegawai_status', 1); // Hanya pegawai aktif
        $this->db->order_by('sp.id_status_pegawai', 'ASC');
        $this->db->order_by('p.nama', 'ASC');
        return $this->db->get()->result();
    }

    public function insert_data($data)
    {
        $this->db->insert('pegawai', $data);
        return $this->db->insert_id(); // return id_pegawai
    }

    public function get_by_id($id_pegawai)
    {
        return $this->db->get_where('pegawai', ['id_pegawai' => $id_pegawai])->row();
    }

    public function get_detail_pegawai($id)
    {
        return $this->db->get_where('pegawai', ['id_pegawai' => $id])->row();
    }

    public function simpanRiwayatTerbaru($id_pegawai, $riwayat)
    {
        // 1. Pendidikan
        if (isset($riwayat['pendidikan'])) {
            $pd = $riwayat['pendidikan']['data'];
            $pd['id_pegawai'] = $id_pegawai;
            $this->db->insert('riwayat_pendidikan_pegawai', $pd);
            $id_pd = $this->db->insert_id();
            $this->db->update('pegawai', ['latest_id_riwayat_pendidikan' => $id_pd], ['id_pegawai' => $id_pegawai]);
        }

        // 2. Riwayat Golongan
        if (isset($riwayat['golongan'])) {
            $gol = $riwayat['golongan']['data'];
            $gol['id_pegawai'] = $id_pegawai;
            $this->db->insert('riwayat_golongan_pegawai', $gol);
            $id_gol = $this->db->insert_id();
            $this->db->update('pegawai', ['latest_id_riwayat_golongan' => $id_gol], ['id_pegawai' => $id_pegawai]);
        }

        // 3. Riwayat Jabatan
        if (isset($riwayat['jabatan'])) {
            $jab = $riwayat['jabatan']['data'];
            $jab['id_pegawai'] = $id_pegawai;
            $this->db->insert('riwayat_jabatan_pegawai', $jab);
            $id_jab = $this->db->insert_id();
            $this->db->update('pegawai', ['latest_id_riwayat_jabatan' => $id_jab], ['id_pegawai' => $id_pegawai]);
        }

        // 4. Riwayat Status Pegawai
        if (isset($riwayat['status'])) {
            $sts = $riwayat['status']['data'];
            $sts['id_pegawai'] = $id_pegawai;
            $this->db->insert('riwayat_status_pegawai', $sts);
            $id_sts = $this->db->insert_id();
            $this->db->update('pegawai', ['latest_id_riwayat_status_pegawai' => $id_sts], ['id_pegawai' => $id_pegawai]);
        }

        // 5. Riwayat Status Kerja
        if (isset($riwayat['status_kerja'])) {
            $stk = $riwayat['status_kerja']['data'];
            $stk['id_pegawai'] = $id_pegawai;
            $this->db->insert('riwayat_status_bekerja', $stk);
            $id_stk = $this->db->insert_id();
            $this->db->update('pegawai', ['latest_id_riwayat_status_bekerja' => $id_stk], ['id_pegawai' => $id_pegawai]);
        }
    }

    public function nonaktifkan_pegawai_dan_riwayat($id_pegawai, $jenis_status_kerja) {
        $this->db->trans_start();

        // 1. Insert ke riwayat
        $this->db->query("INSERT INTO riwayat_status_bekerja (id_pegawai, jenis_status_kerja, tmt_status_kerja) VALUES (?, ?, CURDATE())", [
            $id_pegawai,
            $jenis_status_kerja
        ]); 

        // 2. Update pegawai dengan LAST_INSERT_ID()
        $this->db->query("UPDATE pegawai SET pegawai_status = 0, latest_id_riwayat_status_bekerja = LAST_INSERT_ID() WHERE id_pegawai = ?", [$id_pegawai]);

        $this->db->trans_complete();
        return $this->db->trans_status(); // true jika sukses
    }

    public function aktifkan_pegawai_dan_riwayat($id_pegawai) {
        $this->db->trans_start();

        $this->db->query("INSERT INTO riwayat_status_bekerja (id_pegawai, jenis_status_kerja, tmt_status_kerja) VALUES (?, 'Aktif Kembali', CURDATE())", [
            $id_pegawai
        ]);

        $this->db->query("UPDATE pegawai SET pegawai_status = 1, latest_id_riwayat_status_bekerja = LAST_INSERT_ID() WHERE id_pegawai = ?", [$id_pegawai]);

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function get_kepala_sekolah()
    {
        $this->db->select('p.nama, p.nip');
        $this->db->from('pegawai p');
        $this->db->join('riwayat_jabatan_pegawai rjp', 'rjp.id_riwayat_jabatan_pegawai = p.latest_id_riwayat_jabatan', 'left');
        $this->db->join('jabatan_pegawai j', 'j.id_jabatan = rjp.id_jabatan', 'left');
        $this->db->where('j.nama_jabatan', 'Kepala Sekolah');
        $this->db->where('p.pegawai_status', 1); // Memastikan kepala sekolah yang aktif
        $this->db->limit(1); // Hanya mengambil satu hasil
        return $this->db->get()->row(); // Mengembalikan satu baris data
    }

    public function update_data($id_pegawai, $data_update, $table)
    {
        $this->db->where('id_pegawai', $id_pegawai);
        return $this->db->update($table, $data_update); // Mengembalikan true/false
    }

    public function update_status($id_pegawai, $status)
    {
        $this->db->where('id_pegawai', $id_pegawai);
        $this->db->update('pegawai', ['pegawai_status' => $status]);
    }

    public function cek_duplikat_absen($userid, $sn_absen, $exclude_id = 0)
    {
        $this->db->where('userid_absen', $userid);
        $this->db->where('SN_Absen', $sn_absen);
        
        // Jika ada ID untuk diabaikan (saat edit, $exclude_id akan berisi ID pegawai)
        if ($exclude_id) {
            $this->db->where('id_pegawai !=', $exclude_id);
        }

        $query = $this->db->get('pegawai'); // Pastikan 'pegawai' adalah nama tabel Anda
        
        // Return true jika ada baris yang ditemukan (jumlah baris > 0)
        return $query->num_rows() > 0;
    }

    // 1. FUNGSI BANTUAN UNTUK MEMBERSIHKAN NAMA (PRIVATE)
    private function _normalize_name($name)
    {
        // Mengubah ke huruf kecil dan menghapus spasi di awal/akhir
        $clean_name = strtolower(trim($name));
        
        // Hapus gelar umum (Anda bisa tambahkan gelar lain di sini)
        $gelar = ['dr.', 'drs.', 'ir.', 'prof.', ', s.pd', ', m.kom', ', s.kom', ', s.ag', ', s.si', ', a.md', ', s.h', ', m.m', ', m.si'];
        $clean_name = str_replace($gelar, '', $clean_name);
        
        // Hapus semua tanda baca dan spasi
        $clean_name = preg_replace('/[^a-z0-9]/i', '', $clean_name);
        
        return $clean_name;
    }


    // 2. FUNGSI UTAMA UNTUK SINKRONISASI



    public function delete($where, $table){
        $this->db->where($where);
        $this->db->delete($table);
    }

}
