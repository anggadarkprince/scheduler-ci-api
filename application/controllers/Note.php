<?php

/**
 * Created by PhpStorm.
 * User: Angga
 * Date: 10/12/2015
 * Time: 7:18 PM
 */
class Note extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('NoteModel', 'note');
    }

    public function index()
    {
        if(UserModel::isValidToken($this->input->post('token'))){
            $user_id = $this->input->post('user_id');
            $result = [
                'status' => STATUS_SUCCESS,
                'notes' => $this->note->getNote($user_id),
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
                'title' => $this->input->post('title'),
                'label' => $this->input->post('label'),
                'note' => $this->input->post('note'),
            ];

            $insert = $this->note->insertNote($data);

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
                'note' => $this->note->getOneNote($id)
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
                'title' => $this->input->post('title'),
                'label' => $this->input->post('label'),
                'note' => $this->input->post('note'),
            ];

            $update = $this->note->updateNote($data, $id);

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
            if($this->note->deleteNote($id)){
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