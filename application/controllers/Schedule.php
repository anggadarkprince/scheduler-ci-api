<?php

/**
 * Created by PhpStorm.
 * User: Angga
 * Date: 10/12/2015
 * Time: 4:45 PM
 */
class Schedule extends CI_Controller
{
    public function __construct()
    {
        $this->load->model('ScheduleModel', 'schedule');
    }

    public function index()
    {
        if(UserModel::isValidToken($this->input->post('token'))){
            $user_id = $this->input->post('user_id');
            $result = [
                'status' => STATUS_SUCCESS,
                'schedules' => $this->schedule->getSchedule($user_id),
            ];
        }
        else{
            $result = ['status' => STATUS_RESTRICT];
        }
        Util::encode($result);
    }

    public function summary()
    {
        $this->load->model('NoteModel', 'note');
        if(UserModel::isValidToken($this->input->post('token'))){
            $user_id = $this->input->post('user_id');
            $result = [
                'status' => STATUS_SUCCESS,
                'total_schedule' => $this->schedule->getTotalSchedule($user_id),
                'total_incoming' => $this->schedule->getTotalIncoming($user_id),
                'total_note' => $this->note->getTotalNote($user_id)
            ];
        }
        else{
            $result = ['status' => STATUS_RESTRICT];
        }
        Util::encode($result);
    }

    public function incoming()
    {
        if(UserModel::isValidToken($this->input->post('token'))){
            $user_id = $this->input->post('user_id');
            $result = [
                'status' => STATUS_SUCCESS,
                'incoming' => $this->schedule->getIncomingSchedule($user_id),
            ];
        }
        else{
            $result = ['status' => STATUS_RESTRICT];
        }
        Util::encode($result);
    }

    public function today()
    {
        if(UserModel::isValidToken($this->input->post('token'))){
            $user_id = $this->input->post('user_id');
            $result = [
                'status' => STATUS_SUCCESS,
                'today' => $this->schedule->getTodaySchedule($user_id),
            ];
        }
        else{
            $result = ['status' => STATUS_RESTRICT];
        }
        Util::encode($result);
    }

    public function tomorrow()
    {
        if(UserModel::isValidToken($this->input->post('token'))){
            $user_id = $this->input->post('user_id');
            $result = [
                'status' => STATUS_SUCCESS,
                'tomorrow' => $this->schedule->getTomorrowSchedule($user_id),
            ];
        }
        else{
            $result = ['status' => STATUS_RESTRICT];
        }
        Util::encode($result);
    }

    public function insert()
    {
        if(UserModel::isValidToken($this->input->post('token'))){
            $data = [
                'user_id' => $this->input->post('user_id'),
                'event' => $this->input->post('event'),
                'date' => $this->input->post('date'),
                'time' => $this->input->post('time'),
                'location' => $this->input->post('location'),
                'description' => $this->input->post('description'),
            ];

            $insert = $this->schedule->insertSchedule($data);

            if($insert){
                $result = ['status' => STATUS_SUCCESS];
            }
            else{
                $result = ['status' => STATUS_FAILED];
            }
        }
        else{
            $result = ['status' => STATUS_RESTRICT];
        }
        Util::encode($result);
    }

    public function edit()
    {
        if(UserModel::isValidToken($this->input->post('token'))){
            $id = $this->input->post('id');
            $result = [
                'status' => STATUS_SUCCESS,
                'schedule' => $this->schedule->getOneSchedule($id)
            ];
        }
        else{
            $result = ['status' => STATUS_RESTRICT];
        }
        Util::encode($result);
    }

    public function update()
    {
        if(UserModel::isValidToken($this->input->post('token'))){
            $id = $this->input->post('id');
            $data = [
                'event' => $this->input->post('event'),
                'date' => $this->input->post('date'),
                'time' => $this->input->post('time'),
                'location' => $this->input->post('location'),
                'description' => $this->input->post('description'),
            ];

            $update = $this->schedule->updateSchedule($data, $id);

            if($update){
                $result = ['status' => STATUS_SUCCESS];
            }
            else{
                $result = ['status' => STATUS_FAILED];
            }
        }
        else{
            $result = ['status' => STATUS_RESTRICT];
        }
        Util::encode($result);
    }

    public function delete()
    {
        if(UserModel::isValidToken($this->input->post('token'))){
            $id = $this->input->post('id');
            if($this->schedule->deleteSchedule($id)){
                $result = ['status' => STATUS_SUCCESS];
            }
            else{
                $result = ['status' => STATUS_FAILED];
            }
        }
        else{
            $result = ['status' => STATUS_RESTRICT];
        }
        Util::encode($result);
    }
}