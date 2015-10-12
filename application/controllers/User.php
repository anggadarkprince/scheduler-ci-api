<?php

/**
 * Created by PhpStorm.
 * User: Angga
 * Date: 10/12/2015
 * Time: 8:21 PM
 */
class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('UserModel', 'user');
    }

    public function index()
    {
        if(UserModel::isValidToken($this->input->post('token'))){
            $result = [
                'status' => STATUS_SUCCESS,
                'users' => $this->user->getUser(),
            ];
        }
        else{
            $result = ['status' => STATUS_RESTRICT];
        }
        Util::encode($result);
    }

    public function login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        if($this->user->login($username, $password)){
            $result = ['status' => STATUS_SUCCESS];
        }
        else{
            $result = ['status' => STATUS_FAILED];
        }
        Util::encode($result);
    }

    public function logout()
    {
        if(UserModel::isValidToken($this->input->post('token'))){
            $this->user->logout();
            $result = ['status' => STATUS_SUCCESS];
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
                'user' => $this->user->getOneUserById($id)
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
                'name' => $this->input->post('name'),
                'work' => $this->input->post('work'),
                'about' => $this->input->post('about'),
            ];

            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $checkPassword = $this->user->login($username, $password);

            if ($checkPassword) {
                if (!empty($this->input->post('password_new'))) {
                    $data['password'] = $this->input->post('password_new');
                }

                $update = $this->user->updateUser($data, $id);

                if ($update) {
                    $result = ['status' => STATUS_SUCCESS];
                }
                else{
                    $result = ['status' => STATUS_FAILED];
                }
            }
            else{
                $result = ['status' => STATUS_MISMATCH];
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
            if($this->user->deleteUser($id)){
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