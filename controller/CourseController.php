<?php

class CourseController extends BaseController
{
    public function __construct()
    {
        // check if the user is authenticated
        $this->checkAuthentication();
    }

    public function index()
    {
        $courseModel = new Course();
        $courses = $courseModel->all();
        $this->render('course/index', ['courses' => $courses]);
    }

    public function show($id)
    {
        $courseModel = new Course();
        $course = $courseModel->read($id);
        if ($course) {
            $this->render('course/show', ['course' => $course]);
        } else {
            $this->setFlash('Course not found', 'error');
            $this->redirect('/courses');
        }
    }

    public function create()
    {
        $this->render('course/create');
    }

    public function store($data)
    {
        $courseModel = new Course();
        if ($courseModel->create($data)) {
            $this->setFlash('Course created successfully');
            $this->redirect('/courses');
        } else {
            $this->setFlash('Failed to create course', 'error');
            $this->redirect('/courses/create');
        }
    }

    public function edit($id)
    {
        $courseModel = new Course();
        $course = $courseModel->read($id);
        if ($course) {
            $this->render('course/edit', ['course' => $course]);
        } else {
            $this->setFlash('Course not found', 'error');
            $this->redirect('/courses');
        }
    }

    public function update($id, $data)
    {
        $courseModel = new Course();
        if ($courseModel->update($id, $data)) {
            $this->setFlash('Course updated successfully');
            $this->redirect('/courses');
        } else {
            $this->setFlash('Failed to update course', 'error');
            $this->redirect("/courses/$id/edit");
        }
    }

    public function destroy($id)
    {
        $courseModel = new Course();
        if ($courseModel->delete($id)) {
            $this->setFlash('Course deleted successfully');
        } else {
            $this->setFlash('Failed to delete course', 'error');
        }
        $this->redirect('/courses');
    }
}