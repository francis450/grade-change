<?php
$userRole = $_SESSION['user_type'];

function generateSidebarLinks($role)
{
    $links = [
        'common' => [
            'Dashboard' => '/grade-change/dashboard',
            'Notifications' => '/grade-change/dashboard/notifications',
        ],
        'student' => [
            'Courses' => '/grade-change/dashboard/courses',
            'Grades' =>     '/grade-change/dashboard/grades',
            'My Grade Change Requests' => '/grade-change/dashboard/grade-change-requests',
        ],
        'lecturer' => [
            'Courses' => '/grade-change/dashboard/courses',
            'Grade Change Requests' => '/grade-change/dashboard/grade-change-requests',
            'Students' => '/grade-change/dashboard/students'
        ],
        'department_head' => [
            'Courses' => '/grade-change/dashboard/courses',
            'Grades' => '/grade-change/dashboard/grades',
            'Grade Change Requests' => '/grade-change/dashboard/grade-change-requests',
            'Students' => '/grade-change/dashboard/students'
        ],
        'admin' => [
            'Departments' => '/grade-change/dashboard/departments',
            'Students' => '/grade-change/dashboard/students',
            'Courses' => '/grade-change/dashboard/courses',
            'Grades' => '/grade-change/dashboard/grades',
            'Grade Change Requests' => '/grade-change/dashboard/grade-change-requests',
            'Users' => '/grade-change/dashboard/users'
        ],
    ];

    $menuItems = $links['common'];

    if (isset($links[$role])) {
        $menuItems = array_merge($menuItems, $links[$role]);
    }

    foreach ($menuItems as $title => $url) {
        $activeClass = ($_SERVER['REQUEST_URI'] == $url) ? 'active' : ''; // Check if the current URL matches the link URL
        echo "<a href=\"$url\" class=\"list-group-item list-group-item-action $activeClass\">$title</a>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'My Application'; ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>


<body>
    <div class="container-fluid">
        <!-- Navigation bar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">Dashboard</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item mr-1">
                        <a class="nav-link btn btn-outline-primary" href="#">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-danger logout" href="#">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Dashboard Content -->
        <div class="row mt-4">
            <div class="col-md-3">
                <!-- Sidebar -->
                <div class="list-group">
                    <?php generateSidebarLinks($_SESSION['user_type']); ?>
                </div>
            </div>
            <div class="col-md-9">
                <!-- Main Content -->
                <?php echo $content; ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (optional) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Custom JS -->
    <script src="../../../grade-change/assets/js/app.js"></script>
</body>

</html>