<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Absensi_model extends CI_Model
{   
    public $table = 'checkinout';

    public function __construct()
    {
        parent::__construct();
        $this->adms_db = $this->load->database('adms', TRUE); 
    }

    public function get_absensi_pengguna()
    {
        // Memulai query dari koneksi database absensi ($this->adms_db)
        $this->adms_db->select('
            u.userid, 
            u.name, 
            p.nip, 
            j.nama_jabatan
        ');
        $this->adms_db->from('userinfo u');

        // Menggabungkan (JOIN) dengan tabel dari database utama (`sistempegawai`)
        // Format: 'nama_database.nama_tabel as alias', 'kondisi join', 'tipe join'
        $this->adms_db->join('sistempegawai.pegawai p', 'u.userid = p.userid_absen', 'left');
        $this->adms_db->join('sistempegawai.riwayat_jabatan_pegawai rjp', 'p.latest_id_riwayat_jabatan = rjp.id_riwayat_jabatan_pegawai', 'left');
        $this->adms_db->join('sistempegawai.jabatan_pegawai j', 'rjp.id_jabatan = j.id_jabatan', 'left');

        // Filter dan urutkan
        $this->adms_db->where('u.name IS NOT NULL AND u.name !=', '');
        $this->adms_db->order_by('u.name', 'ASC');

        // Eksekusi query dan kembalikan hasilnya
        return $this->adms_db->get()->result();
    }


    public function get_data_pegawai_absensi()
    {
        $pegawai = $this->db->select('p.nama, p.nip, j.nama_jabatan')
            ->from('pegawai p')
            ->join('riwayat_jabatan_pegawai rjp', 'p.latest_id_riwayat_jabatan = rjp.id_riwayat_jabatan_pegawai', 'left')
            ->join('jabatan_pegawai j', 'rjp.id_jabatan = j.id_jabatan', 'left')
            ->get()
            ->result();

        // Buat index nama pegawai
        $pegawai_index = [];
        foreach ($pegawai as $p) {
            $clean = $this->normalize_name($p->nama);
            $pegawai_index[$clean] = $p;
        }

        // Ambil user dari absensi
        $users = $this->adms_db->select('u.userid, u.name')
            ->from('userinfo u')
            ->where('u.name IS NOT NULL')
            ->where('u.name !=', '')
            ->order_by('u.name', 'ASC')
            ->get()
            ->result();

        $result = [];

        foreach ($users as $u) {
            $clean_user = $this->normalize_name($u->name);
            $pegawai_data = null;

            // 1. Exact match
            if (isset($pegawai_index[$clean_user])) {
                $pegawai_data = $pegawai_index[$clean_user];
            } else {
                // 2. Fuzzy match
                $max_sim = 0;
                foreach ($pegawai_index as $nama_pegawai_bersih => $pegawai_row) {
                    similar_text($clean_user, $nama_pegawai_bersih, $percent);
                    if ($percent > $max_sim && $percent >= 85) {
                        $max_sim = $percent;
                        $pegawai_data = $pegawai_row;
                    }
                }

                // 3. Nama absensi 1 kata? Cocokkan ke prefix pegawai
                if (!$pegawai_data && str_word_count($u->name) == 1) {
                    foreach ($pegawai_index as $nama_pegawai_bersih => $pegawai_row) {
                        if (strpos($nama_pegawai_bersih, $clean_user) === 0) {
                            $pegawai_data = $pegawai_row;
                            break;
                        }
                    }
                }
            }

            $result[] = (object)[
                'userid' => $u->userid,
                'name' => $u->name,
                'nip' => $pegawai_data ? $pegawai_data->nip : 'N/A',
                'nama_jabatan' => $pegawai_data ? $pegawai_data->nama_jabatan : 'N/A',
            ];
        }

        return $result;
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
                GROUP BY tanggal
            ) AS absen
            ORDER BY tanggal DESC
            LIMIT $limit OFFSET $offset
        ";

        $query = $this->adms_db->query($sql, $params);
        return $query->result();
    }



    // public function get_data_realtime($limit = 10, $offset = 0)
    // {
    //     $sql = "
    //     SELECT 
    //         c.id,
    //         c.userid,
    //         u.name,
    //         DATE(c.checktime) AS tanggal,
    //         TIME(c.checktime) AS jam,
    //         c.checktype
    //     FROM checkinout c
    //     LEFT JOIN userinfo u ON c.userid = u.userid
    //     ORDER BY c.checktime DESC
    //     LIMIT $limit OFFSET $offset
    //     ";

    //     $query = $this->adms_db->query($sql);
    //     return $query->result();
    // }

    public function get_data_realtime($limit = 10, $offset = 0)
    {
        // === LANGKAH 1: Ambil data pegawai dan buat indeks nama ternormalisasi ===
        $pegawai = $this->db->select('p.nama, p.nip, j.nama_jabatan')
            ->from('pegawai p')
            ->join('riwayat_jabatan_pegawai rjp', 'p.latest_id_riwayat_jabatan = rjp.id_riwayat_jabatan_pegawai', 'left')
            ->join('jabatan_pegawai j', 'rjp.id_jabatan = j.id_jabatan', 'left')
            ->get()
            ->result();

        $pegawai_index = [];
        foreach ($pegawai as $p) {
            $clean_name = $this->normalize_name($p->nama);
            $pegawai_index[$clean_name] = $p;
        }

        // === LANGKAH 2: Ambil data absensi real-time dari database absensi ===
        $sql = "
            SELECT 
                c.id,
                c.userid,
                u.name,
                DATE(c.checktime) AS tanggal,
                TIME(c.checktime) AS jam,
                c.checktype
            FROM checkinout c
            LEFT JOIN userinfo u ON c.userid = u.userid
            WHERE u.name IS NOT NULL AND u.name != ''
            ORDER BY c.checktime DESC
            LIMIT $limit OFFSET $offset
        ";
        $realtime_absensi = $this->adms_db->query($sql)->result();

        // === LANGKAH 3: Lakukan iterasi, pencocokan, dan gabungkan data ===
        $result = [];
        foreach ($realtime_absensi as $absensi) {
            // Normalisasi nama dari data absensi
            $clean_absensi_name = $this->normalize_name($absensi->name);
            $pegawai_data = null;

            // 1. Pencocokan Persis (Exact Match)
            if (isset($pegawai_index[$clean_absensi_name])) {
                $pegawai_data = $pegawai_index[$clean_absensi_name];
            } else {
                // 2. Pencocokan Fuzzy (jika exact match gagal)
                $max_sim = 0;
                foreach ($pegawai_index as $nama_pegawai_bersih => $pegawai_row) {
                    similar_text($clean_absensi_name, $nama_pegawai_bersih, $percent);
                    if ($percent > $max_sim && $percent >= 85) {
                        $max_sim = $percent;
                        $pegawai_data = $pegawai_row;
                    }
                }

                // 3. Pencocokan Prefiks (jika fuzzy match gagal & nama absensi hanya 1 kata)
                if (!$pegawai_data && str_word_count($absensi->name) == 1) {
                    foreach ($pegawai_index as $nama_pegawai_bersih => $pegawai_row) {
                        if (strpos($nama_pegawai_bersih, $clean_absensi_name) === 0) {
                            $pegawai_data = $pegawai_row;
                            break; // Ambil yang pertama kali cocok
                        }
                    }
                }
            }

            // Gabungkan hasil absensi dengan data pegawai yang cocok
            $result[] = (object)[
                'id' => $absensi->id,
                'userid' => $absensi->userid,
                'name' => $absensi->name, // Nama asli dari mesin absensi
                'tanggal' => $absensi->tanggal,
                'jam' => $absensi->jam,
                'checktype' => $absensi->checktype,
                'nama_pegawai' => $pegawai_data ? $pegawai_data->nama : 'N/A', // Nama lengkap dari tabel pegawai
                'nip' => $pegawai_data ? $pegawai_data->nip : 'N/A',
                'nama_jabatan' => $pegawai_data ? $pegawai_data->nama_jabatan : 'N/A',
            ];
        }

        return $result;
    }

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

    // public function get_data()
    // {
    //     // Mengambil nama unik yang tidak kosong
    //     $this->adms_db->distinct(); // Untuk menghindari duplikat
    //     $this->adms_db->select('name,userid,Card');
    //     $this->adms_db->from('userinfo');
    //     $this->adms_db->where('name !=', ''); // Filter nama kosong
    //     $this->adms_db->where('name IS NOT NULL'); // Filter NULL

    //     $query = $this->adms_db->get();

    //     return $query->result();
    // }

    public function get_pegawaiById($id)
    {
        $this->adms_db->distinct();
        $this->adms_db->select('name,userid');
        $this->adms_db->from('userinfo');
        $this->adms_db->where('name !=', '');
        $this->adms_db->where('userid', $id);

        $query = $this->adms_db->get();

        return $query->row_array();
    }

    private function normalize_name($name)
    {
        // 1. Hapus koma dan gelar yang muncul setelah koma
        $name = preg_replace('/,[^,]+$/', '', $name); // Buang koma dan setelahnya, contoh: ", S.Sos"

        // 2. Hilangkan gelar umum yang tidak dikoma
        $gelar = ['SE','S.KOM','S.SOS','S.SI','A.MD','M.KOM','S.PD','SH','MM','M.SI','S.AG'];
        foreach ($gelar as $g) {
            $name = preg_replace('/\b' . preg_quote($g, '/') . '\b/i', '', $name);
        }

        // 3. Hapus gelar depan
        $name = preg_replace('/^(DR|IR|HJ|H|DRS|PROF)\s+/i', '', $name);

        // 4. Hilangkan semua spasi dan karakter bukan huruf
        $name = preg_replace('/[^A-Z]/i', '', $name);

        // 5. Kapital semua
        return strtoupper($name);
    }



    // public function sinkronisasi_absensi()
    // {
    //     // Koneksi ke database absensi
    //     $adms_db = $this->load->database('adms', TRUE);

    //     // 1. Ambil semua data pegawai dari database utama
    //     $pegawai_sistem = $this->db->select('nama')->get('pegawai')->result();
        
    //     // 2. Buat "kamus" nama pegawai yang sudah dibersihkan
    //     $pegawai_lookup = [];
    //     foreach ($pegawai_sistem as $p) {
    //         // Gunakan fungsi normalize_name yang sama
    //         $clean_name = $this->normalize_name($p->nama); 
    //         $pegawai_lookup[$clean_name] = true; // Kunci: nama bersih, Nilai: true (sudah ada)
    //     }

    //     // 3. Ambil semua user dari database absensi
    //     $users_absensi = $adms_db->select('name')
    //                             ->where('name IS NOT NULL')
    //                             ->where('name !=', '')
    //                             ->distinct()
    //                             ->get('userinfo')
    //                             ->result();

    //     $pegawai_baru = [];
    //     // 4. Looping setiap user absensi untuk dicocokkan
    //     foreach ($users_absensi as $user) {
    //         $clean_name_absen = $this->normalize_name($user->name);
    //         $ditemukan = false;

    //         // === LOGIKA PENCOCOKAN MULTI-LAPIS (disalin dari get_data_pegawai_absensi) ===

    //         // Lapis 1: Pencocokan persis (setelah dibersihkan)
    //         if (isset($pegawai_lookup[$clean_name_absen])) {
    //             $ditemukan = true;
    //         }

    //         // Lapis 2: Pencocokan kemiripan (Fuzzy Match) jika lapis 1 gagal
    //         if (!$ditemukan) {
    //             foreach ($pegawai_lookup as $nama_pegawai_bersih => $val) {
    //                 similar_text($clean_name_absen, $nama_pegawai_bersih, $percent);
    //                 if ($percent >= 85) { // Angka 85% bisa disesuaikan
    //                     $ditemukan = true;
    //                     break;
    //                 }
    //             }
    //         }

    //         // Lapis 3: Pencocokan nama depan (Prefix Match) jika masih gagal
    //         if (!$ditemukan && str_word_count($user->name) == 1) {
    //             foreach ($pegawai_lookup as $nama_pegawai_bersih => $val) {
    //                 if (strpos($nama_pegawai_bersih, $clean_name_absen) === 0) {
    //                     $ditemukan = true;
    //                     break;
    //                 }
    //             }
    //         }
            
    //         // =======================================================================

    //         // Jika setelah 3 lapis pengecekan tetap TIDAK DITEMUKAN, maka ini adalah pegawai baru
    //         if (!$ditemukan) {
    //             $pegawai_baru[$clean_name_absen] = [
    //                 'nama'           => trim($user->name),
    //                 'pegawai_status' => 1,
    //                 'date_create'    => date('Y-m-d H:i:s')
    //             ];
    //             // Tambahkan ke lookup agar tidak dicek ulang dan menyebabkan duplikat
    //             $pegawai_lookup[$clean_name_absen] = true; 
    //         }
    //     }

    //     // 5. Simpan ke database jika ada pegawai baru
    //     if (!empty($pegawai_baru)) {
    //         $this->db->insert_batch('pegawai', $pegawai_baru);
    //         return $this->db->affected_rows();
    //     }

    //     return 0; // Kembalikan 0 jika tidak ada data baru
    // }
    
    public function sinkronisasi_absensi()
{
    $this->db->trans_start();

    $adms_db = $this->load->database('adms', TRUE);
    $pegawai_sistem = $this->db->select('nama, userid_absen')->get('pegawai')->result();
    
    $lookup_pegawai = [];
    $terhubung_userid = [];
    foreach ($pegawai_sistem as $p) {
        $clean_name = $this->normalize_name($p->nama);
        $lookup_pegawai[$clean_name] = true;
        if ($p->userid_absen) {
            $terhubung_userid[$p->userid_absen] = true;
        }
    }

    $users_absensi = $adms_db->select('userid, name')
                              ->where('name IS NOT NULL AND name !=', '')
                              ->distinct()
                              ->get('userinfo')
                              ->result();

    $pegawai_baru = [];
    $pegawai_update = [];

    foreach ($users_absensi as $user) {
        if (isset($terhubung_userid[$user->userid])) {
            continue;
        }
        $clean_name_absen = $this->normalize_name($user->name);
        
        if (!isset($lookup_pegawai[$clean_name_absen])) {
            $pegawai_baru[$clean_name_absen] = [
                'nama'           => trim($user->name),
                'userid_absen'   => $user->userid,
                'pegawai_status' => 1,
                'date_create'    => date('Y-m-d H:i:s')
            ];
            $lookup_pegawai[$clean_name_absen] = true;
        } else {
            $pegawai_update[] = [
                'nama_clean'   => $clean_name_absen,
                'userid_absen' => $user->userid
            ];
        }
    }

    $jumlah_ditambahkan = 0;
    if (!empty($pegawai_baru)) {
        $this->db->insert_batch('pegawai', array_values($pegawai_baru));
        $jumlah_ditambahkan += $this->db->affected_rows();
    }
    
    if(!empty($pegawai_update)) {
        foreach($pegawai_update as $update) {
            // ======================================================
            // PERBAIKAN DI SINI: Tambahkan tanda '=' di akhir string
            // ======================================================
            $this->db->where("REPLACE(REPLACE(REPLACE(REPLACE(LOWER(TRIM(nama)), 'dr. ', ''), 'drs. ', ''), ', s.pd', ''), '.','') =", $update['nama_clean']);
            $this->db->update('pegawai', ['userid_absen' => $update['userid_absen']]);
        }
    }

    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
        return false;
    } else {
        return $jumlah_ditambahkan;
    }
}

    public function get_pegawai_lengkap_by_id_absen($userid)
    {
        // 1. Ambil nama dari database absensi
        $user_absen = $this->adms_db->select('name')->get_where('userinfo', ['userid' => $userid])->row();
        if (!$user_absen) {
            return null;
        }

        $nama_absen = $user_absen->name;
        $nama_absen_clean = $this->normalize_name($nama_absen);

        // 2. Ambil semua pegawai dari DB utama
        $pegawai = $this->db->select('p.nama, p.nip, j.nama_jabatan')
            ->from('pegawai p')
            ->join('riwayat_jabatan_pegawai rjp', 'p.latest_id_riwayat_jabatan = rjp.id_riwayat_jabatan_pegawai', 'left')
            ->join('jabatan_pegawai j', 'rjp.id_jabatan = j.id_jabatan', 'left')
            ->get()
            ->result();

        // Buat index nama pegawai
        $pegawai_index = [];
        foreach ($pegawai as $p) {
            $nama_clean = $this->normalize_name($p->nama);
            $pegawai_index[$nama_clean] = $p;
        }

        // 3. Exact match
        if (isset($pegawai_index[$nama_absen_clean])) {
            return $pegawai_index[$nama_absen_clean];
        }

        // 4. Fuzzy match
        $max_sim = 0;
        $pegawai_data = null;
        foreach ($pegawai_index as $nama_pegawai_clean => $pegawai_row) {
            similar_text($nama_absen_clean, $nama_pegawai_clean, $percent);
            if ($percent > $max_sim && $percent >= 85) {
                $max_sim = $percent;
                $pegawai_data = $pegawai_row;
            }
        }

        // 5. Prefix match (jika nama absensi adalah awalan nama pegawai)
        if (!$pegawai_data && str_word_count($nama_absen) == 1) {
            foreach ($pegawai_index as $nama_pegawai_clean => $pegawai_row) {
                if (strpos($nama_pegawai_clean, $nama_absen_clean) === 0) {
                    $pegawai_data = $pegawai_row;
                    break;
                }
            }
        }

        // 6. Partial-word match (cocokkan kata per kata)
        if (!$pegawai_data) {
            $words = explode(' ', strtoupper(trim($nama_absen)));
            foreach ($pegawai as $p) {
                $nama_pegawai_upper = strtoupper($p->nama);
                $match = true;
                foreach ($words as $w) {
                    if (!str_contains($nama_pegawai_upper, $w)) {
                        $match = false;
                        break;
                    }
                }
                if ($match) {
                    $pegawai_data = $p;
                    break;
                }
            }
        }

        // 7. Return hasil
        if ($pegawai_data) {
            return $pegawai_data;
        } else {
            return (object)[
                'nama' => $nama_absen,
                'nip'  => 'N/A',
                'nama_jabatan' => 'N/A'
            ];
        }
    }       

    public function get_checkinout_by_id($id)
    {
        if (empty($id)) {
            return null; // Jika id kosong, kembalikan null
        }

        $this->adms_db->where('id', $id);
        $query = $this->adms_db->get('checkinout');
        return $query->row(); // Ambil satu baris (bukan array)
    }

    public function get_num_absen($userid, $tanggal)
    {
        $this->adms_db->from('checkinout');
        $this->adms_db->where('userid', $userid);
        $this->adms_db->where('DATE(checktime)', $tanggal);
        $cek_absen = $this->adms_db->get()->num_rows();
        // var_dump($tanggal);
        // die;
        if ($cek_absen < 1) {
            return 0;
        } else {
            return $cek_absen;
        }
    }

    public function insert($data)
    {
        $this->adms_db->insert($this->table, $data);
        return $this->db->insert_id();
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
