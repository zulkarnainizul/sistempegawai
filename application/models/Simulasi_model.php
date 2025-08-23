<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Simulasi_model extends CI_Model
{
    private $adms_db; // Properti untuk koneksi database 'adms'

    public function __construct()
    {
        parent::__construct();
        // Menghubungkan ke database mesin absensi 'adms'
        $this->adms_db = $this->load->database('adms', TRUE);
    }

    /**
     * Mengambil semua pengguna dari tabel userinfo untuk dropdown.
     */
    public function get_all_userinfo()
    {
        $this->adms_db->select('userid, name');
        $this->adms_db->from('userinfo');
        $this->adms_db->where('name IS NOT NULL');
        $this->adms_db->where('name !=', '');
        $this->adms_db->order_by('name', 'ASC');
        return $this->adms_db->get()->result();
    }

    /**
     * Mengambil semua Serial Number (SN) mesin dari tabel iclock.
     */
    public function get_all_machines()
    {
        $this->adms_db->select('SN');
        $this->adms_db->from('iclock'); // Asumsi nama tabel adalah 'iclock'
        $this->adms_db->order_by('SN', 'ASC');
        return $this->adms_db->get()->result();
    }

    /**
     * Menyimpan data simulasi absensi ke tabel checkinout.
     */
    public function insert_absensi($data)
    {
        $this->adms_db->insert('checkinout', $data);
        return $this->adms_db->insert_id();
    }
}