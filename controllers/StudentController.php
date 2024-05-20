<?php

class StudentController extends BaseController {
    public function __construct() {
        // check if the user is authenticated
        $this->checkAuthentication();
    }

    public function index() {
        $studentModel = new Student();
        $students = $studentModel->all();
        $this->render('student/index', ['students' => $students]);
    }

    public function show($id) {
        $studentModel = new Student();
        $student = $studentModel->read($id);
        if ($student) {
            $this->render('student/show', ['student' => $student]);
        } else {
            $this->setFlash('Student not found', 'error');
            $this->redirect('/students');
        }
    }

    public function create() {
        $this->render('student/create');
    }

    public function store($data) {
        $studentModel = new Student();
        if ($studentModel->create($data)) {
            $this->setFlash('Student created successfully');
            $this->redirect('/students');
        } else {
            $this->setFlash('Failed to create student', 'error');
            $this->redirect('/students/create');
        }
    }

    public function edit($id) {
        $studentModel = new Student();
        $student = $studentModel->read($id);
        if ($student) {
            $this->render('student/edit', ['student' => $student]);
        } else {
            $this->setFlash('Student not found', 'error');
            $this->redirect('/students');
        }
    }

    public function update($id, $data) {
        $studentModel = new Student();
        if ($studentModel->update($id, $data)) {
            $this->setFlash('Student updated successfully');
            $this->redirect('/students');
        } else {
            $this->setFlash('Failed to update student', 'error');
            $this->redirect("/students/$id/edit");
        }
    }

    public function delete($id) {
        $studentModel = new Student();
        if ($studentModel->delete($id)) {
            $this->setFlash('Student deleted successfully');
        } else {
            $this->setFlash('Failed to delete student', 'error');
        }
        $this->redirect('/students');
    }
}