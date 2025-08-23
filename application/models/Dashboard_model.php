<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

    private $adms_db; // Koneksi ke database absensi

    public function __construct()
    {
        parent::__construct();
        $this->adms_db = $this->load->database('adms', TRUE);
    }

    public function get_kehadiran_hari_ini()
    {
        $today = date('Y-m-d');
        
        $this->adms_db->select('COUNT(DISTINCT userid) as jumlah_hadir');
        $this->adms_db->from('checkinout');
        $this->adms_db->where('DATE(checktime)', $today);
        
        $result = $this->adms_db->get()->row();
        
        return $result ? $result->jumlah_hadir : 0;
    }

    public function get_statistik_kehadiran_by_range($start_date, $end_date)
    {
        $date_range_data = [];
        $current_date = new DateTime($start_date);
        $end = new DateTime($end_date);

        while ($current_date <= $end) {
            $date_range_data[$current_date->format('Y-m-d')] = 0;
            $current_date->modify('+1 day');
        }

        $this->adms_db->select('DATE(checktime) as tanggal, COUNT(DISTINCT userid) as jumlah_hadir');
        $this->adms_db->from('checkinout');
        $this->adms_db->where('DATE(checktime) >=', $start_date);
        $this->adms_db->where('DATE(checktime) <=', $end_date);
        $this->adms_db->group_by('DATE(checktime)');
        
        $query = $this->adms_db->get();
        $result = $query->result_array();

        foreach ($result as $row) {
            if (isset($date_range_data[$row['tanggal']])) {
                $date_range_data[$row['tanggal']] = (int) $row['jumlah_hadir'];
            }
        }

        return $date_range_data;
    }
    
    /**
     * Menghitung jumlah pegawai berdasarkan status aktif (1) atau tidak aktif (0).
     */
    public function count_pegawai_by_status($status)
    {
        return $this->db->where('pegawai_status', $status)->count_all_results('pegawai');
    }

    /**
     * Mengambil ringkasan jumlah pegawai per jabatan (hanya pegawai aktif).
     */
    public function get_summary_by_jabatan()
    {
        $this->db->select('j.nama_jabatan, COUNT(p.id_pegawai) as total');
        $this->db->from('pegawai p');
        $this->db->join('riwayat_jabatan_pegawai rjp', 'rjp.id_riwayat_jabatan_pegawai = p.latest_id_riwayat_jabatan', 'left');
        $this->db->join('jabatan_pegawai j', 'j.id_jabatan = rjp.id_jabatan', 'left');
        $this->db->where('p.pegawai_status', 1); // Hanya pegawai aktif
        $this->db->where('p.latest_id_riwayat_jabatan IS NOT NULL');
        $this->db->where('rjp.id_jabatan IS NOT NULL');
        $this->db->group_by('j.nama_jabatan');
        $this->db->order_by('total', 'DESC');
        return $this->db->get()->result();
    }

    /**
     * Mengambil ringkasan jumlah pegawai per golongan (hanya pegawai aktif).
     */
    public function get_summary_by_golongan()
    {
        $this->db->select('g.nama_golongan, COUNT(p.id_pegawai) as total');
        $this->db->from('pegawai p');
        $this->db->join('riwayat_golongan_pegawai rgp', 'rgp.id_riwayat_golongan_pegawai = p.latest_id_riwayat_golongan', 'left');
        $this->db->join('golongan_pegawai g', 'g.id_golongan = rgp.id_golongan', 'left');
        $this->db->where('p.pegawai_status', 1); // Hanya pegawai aktif
        
        // BARIS TAMBAHAN: Memastikan riwayat jabatan tidak kosong
        $this->db->where('p.latest_id_riwayat_golongan IS NOT NULL');
        $this->db->where('rgp.id_golongan IS NOT NULL');
        
        $this->db->group_by('g.nama_golongan');
        $this->db->order_by('total', 'DESC');
        return $this->db->get()->result();
    }

    /**
     * Mengambil ringkasan jumlah pegawai per status kepegawaian (hanya pegawai aktif).
     */
    public function get_summary_by_status_pegawai()
    {
        $this->db->select('sp.nama_status, COUNT(p.id_pegawai) as total');
        $this->db->from('pegawai p');
        $this->db->join('riwayat_status_pegawai rsp', 'rsp.id_riwayat_status_pegawai = p.latest_id_riwayat_status_pegawai', 'left');
        $this->db->join('status_pegawai sp', 'sp.id_status_pegawai = rsp.id_status_pegawai', 'left');
        $this->db->where('p.pegawai_status', 1); // Hanya pegawai aktif
        $this->db->where('p.latest_id_riwayat_status_pegawai IS NOT NULL');
        $this->db->where('rsp.id_status_pegawai IS NOT NULL');
        $this->db->group_by('sp.nama_status');
        $this->db->order_by('total', 'DESC');
        return $this->db->get()->result();
    }

    /**
     * Mengambil ringkasan jumlah pegawai per jenis kelamin (hanya pegawai aktif).
     */
    public function get_summary_by_gender()
    {
        $this->db->select('jenis_kelamin, COUNT(id_pegawai) as total');
        $this->db->from('pegawai');
        $this->db->where('pegawai_status', 1); // Hanya pegawai aktif
        $this->db->group_by('jenis_kelamin');
        return $this->db->get()->result();
    }
}
?>