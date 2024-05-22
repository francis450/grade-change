<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between">
            <h3>Grades</h3>
            <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#addGradeModal">
                Add Grade
            </button>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Course</th>
                    <!-- Display student column only if the logged-in user is an admin or department head -->
                    <?php if ($_SESSION['user_type'] == 'admin' || $_SESSION['user_type'] == 'department_head') : ?>
                        <th scope="col">Student</th>
                    <?php endif; ?>
                    <th scope="col">Points</th>
                    <th scope="col">Grade</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                foreach ($grades as $grade) {
                    echo '<tr>';
                    echo '<th scope="row">' . $i++ . '</th>';
                    echo '<td>' . htmlspecialchars($grade['course_name']) . '</td>';
                    // Display student column only if the logged-in user is an admin or department head
                    if ($_SESSION['user_type'] == 'admin' || $_SESSION['user_type'] == 'department_head') {
                        echo '<td>' . htmlspecialchars($grade['student_name']) . '</td>';
                    }
                    echo '<td>' . htmlspecialchars($grade['points']) . '</td>';
                    echo '<td>' . htmlspecialchars($grade['grade']) . '</td>';
                    echo '<td><a href="/grade-change/grades/edit/' . $grade['grade_id'] . '" class="btn btn-primary">Edit</a> <a href="/grade-change/grades/delete/' . $grade['grade_id'] . '" class="btn btn-danger">Delete</a></td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
           
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addGradeModal" tabindex="-1" aria-labelledby="addGradeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addGradeModalLabel">Add Grade</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addGradeForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="course">Course</label>
                        <select class="form-control" id="courseId" name="course_id" required>
                            <option value="">Select Course</option>
                            <?php
                            foreach ($courses as $course) {
                                echo '<option value="' . $course['course_id'] . '">' . htmlspecialchars($course['course_name']) . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <?php if ($_SESSION['user_type'] == 'admin' || $_SESSION['user_type'] == 'department_head') : ?>
                        <div class="form-group">
                            <label for="student">Student</label>
                            <select class="form-control" id="studentId" name="student_id" required>
                                <!-- <option value="">Select Student</option> -->
                                <?php                              
                                    // foreach ($students as $student) {
                                    //     echo '<option value="' . $student['id'] . '">' . htmlspecialchars($student['student_name']) . '</option>';
                                    // }
                                ?>
                            </select>
                        </div>
                    <?php elseif ($_SESSION['user_type'] == 'lecturer') : ?>
                        <div class="form-group">
                            <input type="hidden" id="student" name="student_id" value="<?php echo $lecturer_student_id; ?>">
                        </div>
                    <?php endif; ?>

                    <div class="form-group">
                        <label for="points">Points</label>
                        <input type="number" class="form-control" min="1" max="100" id="points" name="points" required>
                    </div>
                    <div class="form-group">
                        <label for="grade">Grade</label>
                        <!-- Choose from A, B, C, D, E, F -->
                        <select disabled class="form-control" id="grade" name="grade" required>
                            <option value="">Select Grade</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="E">E</option>
                            <option value="F">F</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>