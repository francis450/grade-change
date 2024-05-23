<?php

class UserController extends BaseController
{
    public function __construct()
    {
        $this->checkAuthentication();
    }

    public function index()
    {
        $userModel = new User();
        $users = $userModel->all();
        $this->render('user/index', ['users' => $users]);
    }

    public function show($id)
    {
        $userModel = new User();
        $user = $userModel->read($id);
        if ($user) {
            $this->render('user/show', ['user' => $user]);
        } else {
            $this->setFlash('User not found', 'error');
            $this->redirect('/users');
        }
    }

    public function create()
    {
        $this->render('user/create');
    }

    public function store($data)
    {
        $userModel = new User();
        
        $userModel->create([
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'type' => $data['type'],
        ]);

        if($userModel) {
            echo 'success';
        }else{
            echo 'failed';
        }
    }

    public function edit($id)
    {
        $userModel = new User();
        $user = $userModel->read($id);
        if ($user) {
            $this->render('user/edit', ['user' => $user]);
        } else {
            $this->setFlash('User not found', 'error');
            $this->redirect('/users');
        }
    }

    public function update($data)
    {
        $userModel = new User();
        
        // find the user by id
        $user = $userModel->where('user_id', $data['id'])[0];
        // echo '<pre>';
        // print_r($userModel->where('user_id', $data['id'])[0]); die();
        // echo '</pre>';
        if($user) {
            $userModel->update('user_id', $data['id'], [
                'full_name' => $data['full_name'],
                'email' => $data['email'],
                'type' => $data['user_type'],
            ]);
            echo 'success';
        }else{
            echo 'failed';
        }
    }

    public function delete($id)
    {
        $userModel = new User();
        if ($userModel->delete($id)) {
            $this->setFlash('User deleted successfully');
            $this->redirect('/users');
        } else {
            $this->setFlash('Failed to delete user', 'error');
            $this->redirect('/users');
        }
    }
}
