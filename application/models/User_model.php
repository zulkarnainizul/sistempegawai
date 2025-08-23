<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    
    public function get_data($table) {
        return $this->db->get($table);
    }

    public function validate($username, $password)
    {
        // Cek dulu apakah username ada
        $user = $this->db->get_where('user', ['username' => $username])->row_array();

        if ($user) {
            // Jika username ada, cek password-nya
            if (password_verify($password, $user['password'])) {
                // Jika password cocok, kembalikan data user
                return $user;
            } else {
                // Jika password salah
                return 'password_wrong';
            }
        } else {
            // Jika username tidak ditemukan
            return 'username_not_found';
        }
    }
}