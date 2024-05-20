<?php

class GradeChangeController extends BaseController
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
        if ($gradeChangeModel->create($data)) {
            $this->setFlash('Grade change created successfully');
            $this->redirect('/grade_changes');
        } else {
            $this->setFlash('Failed to create grade change', 'error');
            $this->redirect('/grade_changes/create');
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

    public function delete($id)
    {
        $gradeChangeModel = new GradeChange();
        if ($gradeChangeModel->delete($id)) {
            $this->setFlash('Grade change deleted successfully');
        } else {
            $this->setFlash('Failed to delete grade change', 'error');
        }
        $this->redirect('/grade_changes');
    }

    public function approve($id)
    {
        $gradeChangeModel = new GradeChange();
        $gradeChange = $gradeChangeModel->read($id);
        if ($gradeChange) {
            $gradeChangeModel->approve($id);
            $this->setFlash('Grade change approved successfully');
        } else {
            $this->setFlash('Grade change not found', 'error');
        }
        $this->redirect('/grade_changes');
    }

    public function reject($id)
    {
        $gradeChangeModel = new GradeChange();
        $gradeChange = $gradeChangeModel->read($id);
        if ($gradeChange) {
            $gradeChangeModel->reject($id);
            $this->setFlash('Grade change rejected successfully');
        } else {
            $this->setFlash('Grade change not found', 'error');
        }
        $this->redirect('/grade_changes');
    }

    public function cancel($id)
    {
        $gradeChangeModel = new GradeChange();
        $gradeChange = $gradeChangeModel->read($id);
        if ($gradeChange) {
            $gradeChangeModel->cancel($id);
            $this->setFlash('Grade change cancelled successfully');
        } else {
            $this->setFlash('Grade change not found', 'error');
        }
        $this->redirect('/grade_changes');
    }

    public function approveAll()
    {
        $gradeChangeModel = new GradeChange();
        $gradeChangeModel->approveAll();
        $this->setFlash('All grade changes approved successfully');
        $this->redirect('/grade_changes');
    }

    public function rejectAll()
    {
        $gradeChangeModel = new GradeChange();
        $gradeChangeModel->rejectAll();
        $this->setFlash('All grade changes rejected successfully');
        $this->redirect('/grade_changes');
    }

    public function cancelAll()
    {
        $gradeChangeModel = new GradeChange();
        $gradeChangeModel->cancelAll();
        $this->setFlash('All grade changes cancelled successfully');
        $this->redirect('/grade_changes');
    }
    
}