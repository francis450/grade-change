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
        if ($_SESSION['user_type'] == 'student') {
            $courses = $course->where('department_id', (new Student())->where('user_id', $_SESSION['user_id'])[0]['department_id']);
        } else {
            // get all courses if the user is an admin (or any other user type)
            $courses = $course->all();
        }
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
        $course = new Course();
        $student = new Student();
        $user = new User();

        if ($_SESSION['user_type'] == 'student') {
            $grades = $grade->where('student_id', (new Student())->where('user_id', $_SESSION['user_id'])[0]['id']);

            $courses = $course->where('department_id', $student->where('user_id', $_SESSION['user_id'])[0]['department_id']);
            $students = $student->all();
            $users = $user->all();

            foreach ($grades as $key => $grade) {
                $grades[$key]['course_name'] = ($course->where('course_id', $grade['course_id']))[0]['course_name'];
            }

            $this->render('dashboard/grades', [
                'grades' => $grades,
                'students' => $students,
                'courses' => $courses
            ]);
        } else {
            $grades = $grade->all();


            $courses = $course->all();
            $students = $student->all();
           ;
            $users = $user->all();

            foreach ($grades as $key => $grade) {
                $grades[$key]['course_name'] = ($course->where('course_id', $grade['course_id']))[0]['course_name'];
                $user_id = ($student->where('id', $grade['student_id']))[0]['user_id'];
                $grades[$key]['student_name'] = ($user->where('user_id', $user_id))[0]['full_name'];
            }

            $this->render('dashboard/grades', [
                'grades' => $grades,
                'students' => $students,
                'courses' => $courses
            ]);
        }
    }

    public function gradeChangeRequests()
    {
        $gradeChangeRequest = new GradeChangeRequest();
        $gradeChangeRequests = $gradeChangeRequest->all();
        $course = new Course();
        $grade = new Grade();
        $changeAbleGrades = [];

        if ($_SESSION['user_type'] == 'student') {
            $changeAbleGrades = $grade->where('student_id', (new Student())->where('user_id', $_SESSION['user_id'])[0]['id']);
            foreach ($changeAbleGrades as $key => $changeAbleGrade) {
                $changeAbleGrades[$key]['course_name'] = ($course->where('course_id', $changeAbleGrade['course_id']))[0]['course_name'];
            }
            // echo '<pre>';
            // print_r($changeAbleGrades);
            // echo '</pre>';
            $gradeChangeRequests = $gradeChangeRequest->where('student_id', (new Student())->where('user_id', $_SESSION['user_id'])[0]['id']);
        } else {
            $courses = $course->all();
        }

        foreach ($gradeChangeRequests as $key => $gradeChangeRequest) {
            $gradeChangeRequests[$key]['course_name'] = ($course->where('course_id', $gradeChangeRequest['course_id']))[0]['course_name'];
            $grade_course_id = ($course->where('course_id', $gradeChangeRequest['course_id']))[0]['course_id'];
            $courses_grades = $grade->where('course_id', $grade_course_id);
            $gradeChangeRequests[$key]['previous_grade'] = $grade->where('student_id', $courses_grades[0]['student_id']);
            $user_id = ((new Student())->where('id', $gradeChangeRequest['student_id']))[0]['user_id'];
            $gradeChangeRequests[$key]['student_name'] = (new User())->where('user_id', $user_id)[0]['full_name'];
            $gradeChangeRequests[$key]['grade'] = $gradeChangeRequest['points'] >= 75 ? 'A' : ($gradeChangeRequest['points'] >= 65 ? 'B' : ($gradeChangeRequest['points'] >= 55 ? 'C' : ($gradeChangeRequest['points'] >= 45 ? 'D' : 'F')));
        }

        if (!$gradeChangeRequests) {
            $gradeChangeRequests = [];
        }
        $this->render('dashboard/grade-change-requests', ['gradeChangeRequests' => $gradeChangeRequests, 'courses' => $changeAbleGrades]);
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
