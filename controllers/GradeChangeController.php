<?php

class GradeChangeController extends
{
    public function __construct()
    {
        // check if the user is authenticated
        $this->checkAuthentication();
    }

    public function index()
    {
        $gradeChangeModel = new GradeChange();
        $gradeChanges = $gradeChangeModel->all();
        $this->render('grade_change/index', ['gradeChanges' => $gradeChanges]);
    }

    public function show($id)
    {
        $gradeChangeModel = new GradeChange();
        $gradeChange = $gradeChangeModel->read($id);
        if ($gradeChange) {
            $this->render('grade_change/show', ['gradeChange' => $gradeChange]);
        } else {
            $this->setFlash('Grade change not found', 'error');
            $this->redirect('/grade_changes');
        }
    }

    public function create()
    {
        $this->render('grade_change/create');
    }

    public function store($data)
    {
        $gradeChangeModel = new GradeChange();
        
        $gradeChangeModel = $gradeChangeModel->create([
            'course_id' => $data['course_id'],
            'student_id' => $data['student_id'],
            'points' => $data['points'],
            'grade' => $data['grade']
        ]);

        if ($gradeChangeModel) {
            echo json_encode(['status' => 'success', 'message' => 'Grade change created successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to create grade change']);
        }
    }

    public function edit($id)
    {
        $gradeChangeModel = new GradeChange();
        $gradeChange = $gradeChangeModel->read($id);
        if ($gradeChange) {
            $this->render('grade_change/edit', ['gradeChange' => $gradeChange]);
        } else {
            $this->setFlash('Grade change not found', 'error');
            $this->redirect('/grade_changes');
        }
    }

    public function update($id, $data)
    {
        $gradeChangeModel = new GradeChange();
        if ($gradeChangeModel->update($id, $data)) {
            $this->setFlash('Grade change updated successfully');
            $this->redirect('/grade_changes');
        } else {
            $this->setFlash('Failed to update grade change', 'error');
            $this->redirect("/grade_changes/$id/edit");
        }
    }
}