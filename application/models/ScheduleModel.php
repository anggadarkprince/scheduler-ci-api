<?php

/**
 * Created by PhpStorm.
 * User: Angga
 * Date: 10/12/2015
 * Time: 4:52 PM
 */
class ScheduleModel extends CI_Model
{
    private $table = 'schedules';

    private $pk = 'id';

    public function __construct()
    {
        parent::__construct();
    }

    public function getTotalSchedule($user_id)
    {
        $result = $this->db->query("
            SELECT COUNT(*) AS TOTAL
            FROM schedules
            WHERE user_id = $user_id
        ");

        $data = $result->row_array();

        return $data['TOTAL'];
    }

    public function getTotalIncoming($user_id)
    {
        $result = $this->db->query("
            SELECT COUNT(*) AS TOTAL
            FROM schedules
            WHERE user_id = $user_id
            AND date >= CURRENT_DATE
        ");

        $data = $result->row_array();

        return $data['TOTAL'];
    }

    public function getIncomingSchedule($user_id)
    {
        $result = $this->db->query("
            SELECT *
            FROM schedules
            WHERE user_id = $user_id
            AND date >= CURRENT_DATE
            ORDER BY date DESC, time DESC
        ");

        return $result->result_array();
    }

    public function getTodaySchedule($user_id)
    {
        $result = $this->db->query("
            SELECT *
            FROM schedules
            WHERE user_id = $user_id
            AND date = CURRENT_DATE
            ORDER BY date DESC, time DESC
        ");

        return $result->result_array();
    }

    public function getTomorrowSchedule($user_id)
    {
        $result = $this->db->query("
            SELECT *
            FROM schedules
            WHERE user_id = $user_id
            AND date = CURRENT_DATE + 1
            ORDER BY date DESC, time DESC
        ");

        return $result->result_array();
    }

    public function getSchedule($user_id)
    {
        $result = $this->db->query("
            SELECT *
            FROM schedules
            WHERE user_id = $user_id
            ORDER BY date DESC, time DESC
        ");

        return $result->result_array();
    }

    public function getOneSchedule($id)
    {
        $result = $this->db->get_where($this->table, [$this->pk => $id]);

        return $result->row_array();
    }

    public function insertSchedule($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function updateSchedule($data, $id)
    {
        $this->db->where($this->pk, $id);

        return $this->db->update($this->table, $data);
    }

    public function deleteSchedule($id)
    {
        return $this->db->delete($this->table, [$this->pk => $id]);
    }

}