<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Status_model extends CI_Model {

    public function get_data(){
        $this->db->from('status_pegawai');
        $this->db->order_by('date_create', 'desc');
        return $this->db->get()->result();
    }

    public function get_by_id($id_status)
    {
        return $this->db->get_where('status_pegawai', ['id_status_pegawai' => $id_status])->row();
    }
    

    public function insert_data($data, $table){
        $this->db->insert($table, $data);
    }

    public function update_data($data, $table){
        $this->db->where('id_status_pegawai', $data['id_status_pegawai']);
        $this->db->update($table, $data);
    }

    public function delete($where, $table){
        $this->db->where($where);
        $this->db->delete($table);
    }

}
