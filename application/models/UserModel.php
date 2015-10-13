<?php

/**
 * Created by PhpStorm.
 * User: Angga
 * Date: 10/12/2015
 * Time: 4:49 PM
 */
class UserModel extends CI_Model
{
    private $table = 'users';

    private $pk = 'id';

    private $username = 'username';

    public function __construct()
    {
        parent::__construct();
    }

    public static function isValidToken($token)
    {
        $CI = get_instance();
        $result = $CI->db->query("
            SELECT *
            FROM users
            WHERE token = '$token'
        ");

        if ($result->num_rows() != 0) {
            return true;
        }
        return false;
    }

    public function login($username, $password, $on_check = false)
    {
        $user = $this->db->query("
            SELECT *
            FROM users
            WHERE username = '$username'
            AND password = '$password'
        ");

        $data = $user->row_array();

        if ($on_check) {
            return $data;
        }

        if(!empty($data)){
            $this->session->set_userdata('sch_id', $data['id']);
            $this->session->set_userdata('sch_token', $data['token']);
            $this->session->set_userdata('sch_username', $data['username']);
            $this->session->set_userdata('sch_name', $data['name']);
        }

        return $data;
    }

    public function logout()
    {
        $this->session->unset_userdata('sch_id');
        $this->session->unset_userdata('sch_token');
        $this->session->unset_userdata('sch_username');
        $this->session->unset_userdata('sch_name');
    }

    public function getUser()
    {
        $result = $this->db->get($this->table);
        return $result->result_array();
    }

    public function checkAvailability($username)
    {
        $result = $this->db->query("
            SELECT *
            FROM users
            WHERE username = '$username'
        ");

        if ($result->num_rows() == 0) {
            return false;
        }
        return true;
    }

    public function registerUser($data)
    {
        return $this->db->insert($this->table, $data);

        return false;
    }

    public function getOneUserById($id)
    {
        $result = $this->db->get_where($this->table, [$this->pk => $id]);

        return $result->row_array();
    }

    public function getOneUserByUsername($username)
    {
        $result = $this->db->get_where($this->table, [$this->username => $username]);

        return $result->row_array();
    }

    public function updateUser($data, $id)
    {
        $this->db->where($this->pk, $id);

        return $this->db->update($this->table, $data);
    }

    public function deleteUser($id)
    {
        return $this->db->delete($this->table, [$this->pk => $id]);
    }
}