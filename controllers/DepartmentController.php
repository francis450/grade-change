<?php

class DepartmentController extends BaseController
{
    public function __construct()
    {
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
        $department = $departmentModel->where('department_id', $id['id']);
        // get the department head
        $departmentHead = new DepartmentHead();

        $head = $departmentHead->where('department_id', $id['id']);
        $response = [];
        if ($department) {
            $response['department'] = $department;
            $response['head'] = $head;
            echo json_encode($response);
        } else {
            echo 'Department not found';
        }
    }

    public function create()
    {
        $this->render('department/create');
    }

    public function store($data)
    {
        $departmentModel = new Department();

        $existingDepartment = $departmentModel->where('name', $data['department_name']);

        if ($existingDepartment) {
            echo 'Department already exists';
            return;
        }

        $newDepartmentId = $departmentModel->create([
            'name' => $data['department_name']
        ]);

        if (isset($data['department_head_id']) && !empty($data['department_head_id'])) {
            $departmentHead = new DepartmentHead();

            $existingHead = $departmentHead->where('user_id', $data['department_head_id']);

            if ($existingHead) {
                echo 'User is already a department head for another department';
                return;
            }

            $departmentHead->create([
                'department_id' => $newDepartmentId,
                'title' => $data['department_name'] . ' Head',
                'user_id' => $data['department_head_id']
            ]);

            $user = new User();
            $user->update('type', $data['department_head_id'], ['type' => 'department_head']);
        }

        if ($newDepartmentId) {
            echo 'success';
        } else {
            echo 'Error Creating Department';
        }
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
        if ($departmentModel->update('department_id', $id, $data)) {
            echo ('Department updated successfully');
        } else {
            echo ('Failed to update department');
        }
    }

    public function delete($id)
    {
        $departmentModel = new Department();
        if ($departmentModel->delete($id)) {
            echo 'success';
        } else {
            echo 'Failed to delete department';
        }
    }
}
