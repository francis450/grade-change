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
        if ($userModel->create($data)) {
            $this->setFlash('User created successfully');
            $this->redirect('/users');
        } else {
            $this->setFlash('Failed to create user', 'error');
            $this->redirect('/users/create');
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

    public function update($id, $data)
    {
        $userModel = new User();
        if ($userModel->update($id, $data)) {
            $this->setFlash('User updated successfully');
            $this->redirect('/users');
        } else {
            $this->setFlash('Failed to update user', 'error');
            $this->redirect('/users/edit/' . $id);
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
