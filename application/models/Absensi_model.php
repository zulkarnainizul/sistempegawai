<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Absensi_model extends CI_Model
{
    public $table = 'checkinout';

    public function __construct()
    {
        parent::__construct();  
        $this->adms_db = $this->load->database('adms', TRUE); 
    }   

    public function get_pegawai_absensi()
    {
        $this->db->select('
            u.userid, 
            u.SN, 
            u.name, 
            p.nip, 
            j.nama_jabatan
        ');
        $this->db->from('pegawai p');

        $this->db->join('adms_db.userinfo u', 'p.userid_absen = u.userid AND p.SN_Absen = u.SN', 'left');
        $this->db->join('riwayat_jabatan_pegawai rjp', 'p.latest_id_riwayat_jabatan = rjp.id_riwayat_jabatan_pegawai', 'left');
        $this->db->join('jabatan_pegawai j', 'rjp.id_jabatan = j.id_jabatan', 'left');
        $this->db->where('u.name IS NOT NULL AND u.name !=', '');
        $this->db->order_by('u.name', 'ASC');

        return $this->db->get()->result();
    }

    public function get_data_absensi($id, $date_start = null, $date_end = null, $limit = 10, $offset = 0)
    {
        $whereTanggal = "";
        $params = [$id];

        if ($date_start && $date_end) {
            $whereTanggal = "AND DATE(c.checktime) BETWEEN ? AND ?";
            $params[] = $date_start;
            $params[] = $date_end;
        }

        $params[] = $limit;
        $params[] = $offset;

        $sql = "
        SELECT 
            userid,
            name,
            tanggal,
            -- Jam masuk
            CASE 
                WHEN jumlah = 1 AND TIME(min_checktime) < '13:00:00' THEN min_checktime
                WHEN jumlah > 1 THEN min_checktime
                ELSE NULL
            END AS jam_masuk,

            -- Jam keluar
            CASE 
                WHEN jumlah = 1 AND TIME(max_checktime) >= '13:00:00' THEN max_checktime
                WHEN jumlah > 1 THEN max_checktime
                ELSE NULL
            END AS jam_keluar,

            -- ID jam masuk
            CASE 
                WHEN jumlah = 1 AND TIME(min_checktime) < '13:00:00' THEN min_id
                WHEN jumlah > 1 THEN min_id
                ELSE NULL
            END AS id1,

            -- ID jam keluar
            CASE 
                WHEN jumlah = 1 AND TIME(max_checktime) >= '13:00:00' THEN max_id
                WHEN jumlah > 1 THEN max_id
                ELSE NULL
            END AS id2

            FROM (
                SELECT 
                    c.userid,
                    u.name,
                    DATE(c.checktime) AS tanggal,
                    MIN(c.checktime) AS min_checktime,
                    MAX(c.checktime) AS max_checktime,
                    (
                        SELECT id FROM checkinout 
                        WHERE userid = c.userid AND DATE(checktime) = DATE(c.checktime)
                        ORDER BY checktime ASC
                        LIMIT 1
                    ) AS min_id,
                    (
                        SELECT id FROM checkinout 
                        WHERE userid = c.userid AND DATE(checktime) = DATE(c.checktime)
                        ORDER BY checktime DESC
                        LIMIT 1
                    ) AS max_id,
                    COUNT(*) AS jumlah
                FROM checkinout c
                LEFT JOIN userinfo u ON c.userid = u.userid
                WHERE c.userid = ?
                $whereTanggal
                GROUP BY tanggal, c.userid, u.name
            ) AS absen
            ORDER BY tanggal DESC
            LIMIT ? OFFSET ?
        ";

        $query = $this->adms_db->query($sql, $params);
        return $query->result();
    }

    /**
     * Mengambil data absensi real-time dan menggabungkannya dengan data pegawai
     * berdasarkan ID Absensi (userid).
     */
    // public function get_data_realtime($limit = 10, $offset = 0)
    // {
    //     $sql = "
    //         SELECT 
    //             c.id,
    //             c.userid,
    //             u.name,
    //             DATE(c.checktime) AS tanggal,
    //             TIME(c.checktime) AS jam,
    //             c.checktype,
    //             p.nama AS nama_pegawai,
    //             p.nip,
    //             j.nama_jabatan
    //         FROM checkinout c
    //         LEFT JOIN userinfo u ON c.userid = u.userid
    //         LEFT JOIN sisfopegawai.pegawai p ON u.userid = p.userid_absen AND u.SN = p.SN_Absen
    //         LEFT JOIN sisfopegawai.riwayat_jabatan_pegawai rjp ON p.latest_id_riwayat_jabatan = rjp.id_riwayat_jabatan_pegawai
    //         LEFT JOIN sisfopegawai.jabatan_pegawai j ON rjp.id_jabatan = j.id_jabatan
    //         WHERE u.name IS NOT NULL AND u.name != ''
    //         ORDER BY c.checktime DESC
    //         LIMIT ? OFFSET ?
    //     ";
        
    //     $query = $this->adms_db->query($sql, [$limit, $offset]);
    //     return $query->result();
    // }

    public function get_data_realtime($limit = 10)
    {

        $sql = "
            SELECT 
                c.id, c.userid, u.name,
                DATE(c.checktime) AS tanggal,
                TIME(c.checktime) AS jam,
                p.nip, j.nama_jabatan
            FROM checkinout c
            LEFT JOIN userinfo u ON c.userid = u.userid
            LEFT JOIN sisfopegawai.pegawai p ON u.userid = p.userid_absen AND u.SN = p.SN_Absen
            LEFT JOIN sisfopegawai.riwayat_jabatan_pegawai rjp ON p.latest_id_riwayat_jabatan = rjp.id_riwayat_jabatan_pegawai
            LEFT JOIN sisfopegawai.jabatan_pegawai j ON rjp.id_jabatan = j.id_jabatan
            WHERE u.name IS NOT NULL AND u.name != ''
            ORDER BY c.checktime DESC
            LIMIT ?
        ";
        
        // Kirim hanya parameter limit
        $query = $this->adms_db->query($sql, [(int)$limit]);
        return $query->result();
    }

    /**
     * Menghitung total hari absensi seorang pegawai.
     */
    public function count_data_absensi($id, $date_start = null, $date_end = null)
    {
        $whereTanggal = "";
        $params = [$id];

        if ($date_start && $date_end) {
            $whereTanggal = "AND DATE(c.checktime) BETWEEN ? AND ?";
            $params[] = $date_start;
            $params[] = $date_end;
        }

        $sql = "
        SELECT COUNT(*) as total FROM (
            SELECT DATE(c.checktime) AS tanggal
            FROM checkinout c
            WHERE c.userid = ?
            $whereTanggal
            GROUP BY tanggal
        ) as absen
        ";

        $query = $this->adms_db->query($sql, $params);
        return $query->row()->total;
    }

    /**
     * Mengambil data satu pegawai dari mesin absensi berdasarkan ID Absensi (userid).
     */
    public function get_pegawaiById($id)
    {
        $this->adms_db->select('name, userid');
        $this->adms_db->from('userinfo');
        $this->adms_db->where('userid', $id);
        $query = $this->adms_db->get();
        return $query->row_array();
    }
    
    /**
     * Sinkronisasi data pengguna dari mesin absensi ke tabel pegawai.
     * Mengecek berdasarkan kombinasi userid dan SN.
     * Hanya menambahkan pengguna yang benar-benar baru.
     */
    public function sinkronisasi_absensi()
    {
        // Memulai transaction untuk memastikan semua query berhasil atau tidak sama sekali
        $this->db->trans_start();

        // 1. Ambil data pengguna dari mesin absensi (adms) yang BELUM ADA
        //    di tabel pegawai berdasarkan kombinasi userid dan SN.
        $this->adms_db->select('u.userid, u.name, u.SN');
        $this->adms_db->from('userinfo u');
        
        // KUNCI UTAMA: Gabungkan dengan tabel pegawai menggunakan LEFT JOIN
        // 'p' adalah alias untuk tabel pegawai di database utama Anda.
        // Ganti 'nama_database_pegawai' dengan nama database Anda jika berbeda.
        $this->adms_db->join('sisfopegawai.pegawai p', 'u.userid = p.userid_absen AND u.SN = p.SN_Absen', 'left');
        
        // Filter hanya untuk baris yang tidak punya pasangan di tabel pegawai (p.userid_absen IS NULL)
        $this->adms_db->where('p.userid_absen IS NULL');

        // Filter tambahan untuk membersihkan data 'sampah' dari mesin absensi
        $this->adms_db->where('u.name IS NOT NULL');
        $this->adms_db->where('u.name !=', '');
        $this->adms_db->where("u.name NOT REGEXP '^[0-9]+$'", null, false); // Nama bukan hanya angka

        // Eksekusi query untuk mendapatkan daftar pegawai yang akan ditambahkan
        $users_baru_dari_absen = $this->adms_db->get()->result();

        $jumlah_ditambahkan = 0;

        // 2. Jika ada pengguna baru yang ditemukan, siapkan untuk ditambahkan
        if (!empty($users_baru_dari_absen)) {
            $data_untuk_ditambahkan = [];
            $tanggal_sekarang = date('Y-m-d H:i:s');

            foreach ($users_baru_dari_absen as $user) {
                $data_untuk_ditambahkan[] = [
                    'nama'           => trim($user->name),
                    'userid_absen'   => $user->userid,
                    'SN_Absen'       => $user->SN, // <-- SN sekarang ikut ditambahkan
                    'pegawai_status' => 1,          // Status default aktif
                    'date_create'    => $tanggal_sekarang
                ];
            }

            // 3. Tambahkan semua data baru sekaligus menggunakan insert_batch
            $this->db->insert_batch('pegawai', $data_untuk_ditambahkan);
            $jumlah_ditambahkan = $this->db->affected_rows();
        }

        // Menyelesaikan transaction
        $this->db->trans_complete();

        // Kembalikan jumlah data yang berhasil ditambahkan atau false jika gagal
        return ($this->db->trans_status() === FALSE) ? false : $jumlah_ditambahkan;
    }

    /**
     * Mengambil data lengkap pegawai dari sistem utama berdasarkan ID Absensi.
     */
    public function get_pegawai_lengkap_by_id_absen($userid)
    {
        // Langkah 1: Cari dulu SN & nama dari database absensi berdasarkan userid
        $user_info = $this->adms_db->select('SN, name')
                                ->where('userid', $userid)
                                ->get('userinfo')
                                ->row();

        // Jika user tidak ada di mesin absensi sama sekali, kembalikan data kosong
        if (!$user_info) {
            return (object)[
                'nama'         => 'User ID Tidak Ditemukan',
                'nip'          => 'N/A',
                'nama_jabatan' => 'N/A'
            ];
        }
        
        // Simpan SN yang ditemukan
        $sn = $user_info->SN;

        // Langkah 2: Gunakan userid dan SN untuk mencari data pegawai lengkap
        $this->db->select('p.nama, p.nip, j.nama_jabatan');
        $this->db->from('pegawai p');
        $this->db->join('riwayat_jabatan_pegawai rjp', 'p.latest_id_riwayat_jabatan = rjp.id_riwayat_jabatan_pegawai', 'left');
        $this->db->join('jabatan_pegawai j', 'rjp.id_jabatan = j.id_jabatan', 'left');
        $this->db->where('p.userid_absen', $userid);
        $this->db->where('p.SN_Absen', $sn); // <-- Kunci pencarian gabungan
        
        $pegawai_data = $this->db->get()->row();

        // Jika data pegawai lengkap ditemukan, kembalikan data tersebut
        if ($pegawai_data) {
            return $pegawai_data;
        }
        
        // Langkah 3 (Fallback): Jika data pegawai tidak ada, gunakan nama dari mesin absensi
        return (object)[
            'nama'         => $user_info->name, // Ambil nama dari hasil query pertama
            'nip'          => 'N/A',
            'nama_jabatan' => 'N/A'
        ];
    }

    public function get_checkinout_by_id($id)
    {
        if (empty($id)) {
            return null;
        }
        $this->adms_db->where('id', $id);
        $query = $this->adms_db->get('checkinout');
        return $query->row();
    }

    public function get_num_absen($userid, $tanggal)
    {
        $this->adms_db->from('checkinout');
        $this->adms_db->where('userid', $userid);
        $this->adms_db->where('DATE(checktime)', $tanggal);
        return $this->adms_db->count_all_results();
    }

    public function insert($data)
    {
        $this->adms_db->insert($this->table, $data);
        return $this->adms_db->insert_id();
    }

    public function update($where, $data)
    {
        $this->adms_db->update($this->table, $data, $where);
        return $this->adms_db->affected_rows();
    }

    public function get_rekap_absensi($start_date, $end_date)
    {
        // Query ini sekarang hanya fokus ke database ADMS
        $sql = "
            SELECT 
                c.userid,
                u.name,
                DATE(c.checktime) AS tanggal,
                MIN(TIME(c.checktime)) AS jam_masuk,
                MAX(TIME(c.checktime)) AS jam_keluar
            FROM checkinout c
            LEFT JOIN userinfo u ON c.userid = u.userid
            WHERE DATE(c.checktime) BETWEEN ? AND ?
            AND u.name IS NOT NULL AND u.name != ''
            GROUP BY c.userid, u.name, tanggal
            ORDER BY u.name ASC, tanggal ASC
        ";
        
        $query = $this->adms_db->query($sql, [$start_date, $end_date]);
        return $query->result();
    }
    
}


