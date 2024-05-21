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

        foreach ($courses as $key => $course) {
            $courses[$key]['department_name'] =
                (new Department())->where('department_id', $course['department_id'])[0]['name'];
        }

        $department = new Department();
        $departments = $department->all();

        $data = [
            'courses' => $courses,
            'departments' => $departments
        ];

        $this->render('dashboard/courses', $data);
    }


    public function departments()
    {
        $departmentModel = new Department();
        $departments = $departmentModel->all();

        $userModel = new User();
        $users = $userModel->all();
        foreach ($users as $key => $user) {
            if ($user['type'] == 'student' || $user['type'] == 'admin' || (new DepartmentHead())->where('user_id', $user['user_id'])) {
                unset($users[$key]);
            }
        }

        $departmentHeadModel = new DepartmentHead();
        $departmentHeads = $departmentHeadModel->all();
        $departmentHeadsByDepartment = [];
        foreach ($departmentHeads as $departmentHead) {
            $departmentHeadsByDepartment[$departmentHead['department_id']] = $departmentHead;
        }

        foreach ($departments as $key => $department) {
            if (isset($departmentHeadsByDepartment[$department['department_id']])) {
                $headUserId = $departmentHeadsByDepartment[$department['department_id']]['user_id'];
                $headUser = $userModel->where('user_id', $headUserId);
                if ($headUser) {
                    $departments[$key]['department_head'] = $headUser;
                }
            }
        }

        $this->render('dashboard/departments', ['departments' => $departments, 'users' => $users]);
    }


    public function grades()
    {
        $grade = new Grade();

        // Check if user is a student
        if ($_SESSION['user_type'] == 'student') {
            $grades = $grade->where('student_id', $_SESSION['user_id']);
        } else {
            $grades = $grade->all();
        }

        $course = new Course();
        $student = new Student();
        $user = new User();

        // Fetch all courses and students once to avoid multiple queries
        $courses = $course->all();
        $students = $student->all();
        $users = $user->all();

        // Create lookup arrays for courses and students
        $courseLookup = [];
        foreach ($courses as $course) {
            $courseLookup[$course['course_id']] = $course['course_name'];
        }

        $studentLookup = [];
        foreach ($students as $student) {
            $userKey = array_search($student['user_id'], array_column($users, 'user_id'));
            if ($userKey !== false) {
                $studentLookup[$student['student_id']] = $users[$userKey]['full_name'];
            }
        }

        // Add course name and student name to each grade
        foreach ($grades as $key => $grade) {
            $grades[$key]['course_name'] = $courseLookup[$grade['course_id']] ?? 'Unknown';
            $grades[$key]['student_name'] = $studentLookup[$grade['student_id']] ?? 'Unknown';
        }

        $this->render('dashboard/grades', [
            'grades' => $grades,
            'students' => $students,
            'courses' => $courses
        ]);
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

        $users = $user->where('type', 'student');

        $department = new Department();
        $departments = $department->all();

        $students = $student->all();
        foreach ($students as $key => $student) {
            $students[$key]['student_name'] = (new User())->where('user_id', $student['user_id'])[0]['full_name'];
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
