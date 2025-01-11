<?php
defined('BASEPATH') or exit('Akses langsung tidak diperbolehkan');

class User_model extends CI_Model
{
    protected $table = 'user';

    public function __construct()
    {
        parent::__construct();
    }

    public function getUserAll()
    {
        $q = $this->db->get($this->table);
        return $q;
    }

    public function getUserByID($id = null)
    {
        $q = $this->db->where('id', $id)->get($this->table);
        return $q;
    }

    public function updateUser($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
        return $this->db->affected_rows();
    }

    public function insertUser($data)
    {
        return $this->db->insert('user', $data); // Menyimpan data tanpa enkripsi password
    }

    public function deleteUser($id = null)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->table);
        return $this->db->affected_rows();
    }

    public function getUserByUsername($username)
    {
        return $this->db->where('username', $username)->get($this->table);
    }
}
?>
