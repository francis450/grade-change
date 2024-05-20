<?php

class DepartmentController extends BaseController
{
    public function __construct()
    {
        // check if the user is authenticated
        $this->checkAuthentication();
    }

    public function index()
    {
        $departmentModel = new Department();
        $departments = $departmentModel->all();
        $this->render('department/index', ['departments' => $departments]);
    }

    public function show($id)
    {
        $departmentModel = new Department();
        $department = $departmentModel->read($id);
        if ($department) {
            $this->render('department/show', ['department' => $department]);
        } else {
            $this->setFlash('Department not found', 'error');
            $this->redirect('/departments');
        }
    }

    public function create()
    {
        $this->render('department/create');
    }

    public function store($data)
    {
        $departmentModel = new Department();
        $departmentModel->create([
            'department_name' => $data['department_name'],
            'department_head_id' => $data['department_head_id']
        ]);
    }

    public function edit($id)
    {
        $departmentModel = new Department();
        $department = $departmentModel->read($id);
        if ($department) {
            $this->render('department/edit', ['department' => $department]);
        } else {
            $this->setFlash('Department not found', 'error');
            $this->redirect('/departments');
        }
    }

    public function update($id, $data)
    {
        $departmentModel = new Department();
        if ($departmentModel->update($id, $data)) {
            $this->setFlash('Department updated successfully');
            $this->redirect('/departments');
        } else {
            $this->setFlash('Failed to update department', 'error');
            $this->redirect('/departments');
        }
    }

    public function delete($id)
    {
        $departmentModel = new Department();
        if ($departmentModel->delete($id)) {
            $this->setFlash('Department deleted successfully');
        } else {
            $this->setFlash('Failed to delete department', 'error');
        }
        $this->redirect('/departments');
    }

    
}