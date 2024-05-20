<?php

class DashboardController extends BaseController
{
    public function __construct()
    {
        $this->checkAuthentication();
    }

    public function index()
    {
        $this->render('dashboard/index');
    }

    public function users()
    {
        $user = new User();
        $users = $user->all();

        $this->render('dashboard/users', ['users' => $users]);
    }

    public function courses()
    {
        $course = new Course();
        $courses = $course->all();

        $department = new Department();
        $departments = $department->all();

        $this->render('dashboard/courses', ['courses' => $courses], ['departments' => $departments]);
    }

    public function departments()
    {
        $department = new Department();
        $departments = $department->all();
        $user = new User();
        $users = $user->where('type', 'department_head');
        foreach ($departments as $key => $department) {
            $departments[$key]['department_head'] = (new User())->find($department['department_head_id'])['name'];
        }
        $this->render('dashboard/departments', ['departments' => $departments, 'users' => $users]);
    }

    public function grades()
    {
        $grade = new Grade();
        // check if user is a student
        if ($_SESSION['user_type'] == 'student') {
            $grades = $grade->where('student_id', $_SESSION['user_id']);
        } else {
            $grades = $grade->all();
        }

        // get students who are in the same department as the course
        $student = new Student();
        $students = $student->all();
        foreach ($grades as $key => $grade) {
            $grades[$key]['student'] = (new Student())->find($grade['student_id'])['name'];
            $grades[$key]['course'] = (new Course())->find($grade['course_id'])['course_name'];
        }

        $this->render('dashboard/grades', ['grades' => $grades]);
    }

    public function gradeChangeRequests()
    {
        $gradeChangeRequest = new GradeChangeRequest();
        $gradeChangeRequests = $gradeChangeRequest->all();
        $course = new Course();

        // get all courses for the students department or all courses otherwise
        if ($_SESSION['user_type'] == 'student') {
            $courses = $course->where('department_id', (new Student())->find($_SESSION['user_id'])['department_id']);
        } else {
            $courses = $course->all();
        }

        if ($_SESSION['user_type'] == 'student') {
            $gradeChangeRequests = $gradeChangeRequest->where('student_id', $_SESSION['user_id']);
        }
        // return an empty if there are no grade change requests
        if (!$gradeChangeRequests) {
            $gradeChangeRequests = [];
        }
        $this->render('dashboard/grade-change-requests', ['gradeChangeRequests' => $gradeChangeRequests, 'courses' => $courses]);
    }

    public function students()
    {
        $student = new Student();
        $students = $student->all();

        $user = new User();

        // get every user who does not have a type in the users table
        $users = $user->where('type', null);

        // get all departments
        $department = new Department();
        $departments = $department->all();

        // get every user who is a student
        $students = $student->all();
        foreach ($students as $key => $student) {
            $students[$key]['student_name'] = (new User())->find($student['student_id'])['name'];
        }

        $this->render('dashboard/students', ['students' => $students, 'users' => $users, 'departments' => $departments]);
    }   

    public function notifications()
    {
        // get all notifications for the user or all notifications if the user is an admin
        $notification = new Notification();
        if ($_SESSION['user_type'] == 'admin') {
            $notifications = $notification->all();
        } else {
            $notifications = $notification->where('user_id', $_SESSION['user_id']);
        }

        $this->render('dashboard/notifications', ['notifications' => $notifications]);
    }

    
}
