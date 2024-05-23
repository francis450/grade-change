<?php

class CourseController extends BaseController
{
    public function __construct()
    {
        // check if the user is authenticated
        $this->checkAuthentication();
    }

    public function department($data)
    {
        $students = new Student;
        $courses = new Course;
        
        $courses = $courses->where('department_id', $data['department_id']);
        $students = $students->where('department_id', $data['department_id']);
        
        // add full name to students
        foreach ($students as $key => $student) {
            $students[$key]['full_name'] = (new User)->where('user_id', $student['user_id'])[0]['full_name'];
        }

        $response = [
            'courses' => $courses,
            'students' => $students
        ];
        
        return json_encode($response);
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

        $courseModel->create([
            'course_name' => $data['course_name'],
            'course_code' => $data['course_code'],
            'department_id' => $data['department_id']
        ]);

        if ($courseModel) {
            echo "success";
        } else {
            echo "failed";
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
