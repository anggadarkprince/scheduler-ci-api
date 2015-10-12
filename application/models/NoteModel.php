<?php

/**
 * Created by PhpStorm.
 * User: Angga
 * Date: 10/12/2015
 * Time: 7:14 PM
 */
class NoteModel extends CI_Model
{
    private $table = 'notes';

    private $pk = 'id';

    public function __construct()
    {
        parent::__construct();
    }

    public function getTotalNote($user_id)
    {
        $result = $this->db->query("
            SELECT COUNT(*) AS TOTAL
            FROM notes
            WHERE user_id = $user_id
        ");

        $data = $result->row_array();

        return $data['TOTAL'];
    }

    public function getNote($user_id)
    {
        $result = $this->db->query("
            SELECT *
            FROM notes
            WHERE user_id = $user_id
            ORDER BY created_at DESC
        ");

        return $result->result_array();
    }

    public function getOneNote($id)
    {
        $result = $this->db->get_where($this->table, [$this->pk => $id]);

        return $result->row_array();
    }

    public function insertNote($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function updateNote($data, $id)
    {
        $this->db->where($this->pk, $id);

        return $this->db->update($this->table, $data);
    }

    public function deleteNote($id)
    {
        return $this->db->delete($this->table, [$this->pk => $id]);
    }
}