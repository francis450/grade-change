<?php

class StudentController extends BaseController
{
    public function __construct()
    {
        // check if the user is authenticated
        $this->checkAuthentication();
    }

    public function index()
    {
        $studentModel = new Student();
        $students = $studentModel->all();
        $this->render('student/index', ['students' => $students]);
    }

    public function show($id)
    {
        $studentModel = new Student();
        $student = $studentModel->read($id);
        if ($student) {
            $this->render('student/show', ['student' => $student]);
        } else {
            $this->setFlash('Student not found', 'error');
            $this->redirect('/students');
        }
    }

    public function course($courseId)
    {
        $course = new Course();
        $students = new Student();
        $user = new User();

        $course = $course->where('course_id', $courseId['course_id']);
    
        $departmentId = $course[0]['department_id'];
        
        $students = $students->where('department_id', $departmentId);

        $students = array_map(function ($student) use ($user) {
            $user = $user->where('user_id', $student['user_id']);
            $student['full_name'] = $user[0]['full_name'];
            return $student;
        }, $students);

        echo json_encode($students);
    }

    public function create()
    {
        $this->render('student/create');
    }

    public function store($data)
    {
        $studentModel = new Student();
        // check if student already exists
        $student = $studentModel->where('user_id', $data['user_id']);
        if ($student) {
            echo 'Student already exists';
            return;
        }
        $department = new Department();
        $dept = $department->where('department_id', $data['department_id']);

        $departmentAbbreviation = substr($dept[0]['name'], 0, 3);
        $studentId = strtoupper($departmentAbbreviation) . $data['user_id'];

        $studentModel->create([
            'user_id' => $data['user_id'],
            'department_id' => $data['department_id'],
            'student_number' => $studentId
        ]);

        $user = new User();
        $options = array(
            'type' => 'student'
        );

        $user->update('user_id', $data['user_id'], $options);

        if ($studentModel && $user) {
            echo 'success';
        } else {
            echo 'failed';
        }
    }

    public function edit($id)
    {
        $studentModel = new Student();
        $student = $studentModel->read($id);
        if ($student) {
            $this->render('student/edit', ['student' => $student]);
        } else {
            $this->setFlash('Student not found', 'error');
            $this->redirect('/students');
        }
    }

    public function update($id, $data)
    {
        $studentModel = new Student();
        if ($studentModel->update($id, $data)) {
            $this->setFlash('Student updated successfully');
            $this->redirect('/students');
        } else {
            $this->setFlash('Failed to update student', 'error');
            $this->redirect("/students/$id/edit");
        }
    }

    public function delete($id)
    {
        $studentModel = new Student();
        if ($studentModel->delete($id)) {
            $this->setFlash('Student deleted successfully');
        } else {
            $this->setFlash('Failed to delete student', 'error');
        }
        $this->redirect('/students');
    }
}
