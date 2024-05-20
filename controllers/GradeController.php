<?php

class GradeController extends BaseController
{
    public function __construct()
    {
        // check if the user is authenticated
        $this->checkAuthentication();
    }

    public function index()
    {
        $gradeModel = new Grade();
        $grades = $gradeModel->all();
        $this->render('grade/index', ['grades' => $grades]);
    }

    public function show($id)
    {
        $gradeModel = new Grade();
        $grade = $gradeModel->read($id);
        if ($grade) {
            $this->render('grade/show', ['grade' => $grade]);
        } else {
            $this->setFlash('Grade not found', 'error');
            $this->redirect('/grades');
        }
    }

    public function create()
    {
        $this->render('grade/create');
    }

    public function store($data)
    {
        $gradeModel = new Grade();
        if ($gradeModel->create($data)) {
            $this->setFlash('Grade created successfully');
            $this->redirect('/grades');
        } else {
            $this->setFlash('Failed to create grade', 'error');
            $this->redirect('/grades/create');
        }
    }

    public function edit($id)
    {
        $gradeModel = new Grade();
        $grade = $gradeModel->read($id);
        if ($grade) {
            $this->render('grade/edit', ['grade' => $grade]);
        } else {
            $this->setFlash('Grade not found', 'error');
            $this->redirect('/grades');
        }
    }

    public function update($id, $data)
    {
        $gradeModel = new Grade();
        if ($gradeModel->update($id, $data)) {
            $this->setFlash('Grade updated successfully');
            $this->redirect('/grades');
        } else {
            $this->setFlash('Failed to update grade', 'error');
            $this->redirect("/grades/$id/edit");
        }
    }
}