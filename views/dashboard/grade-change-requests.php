<?php
$user_type = $_SESSION['user_type'] ?? '';

$show_student_name = $user_type != 'student';
$show_course_name = true;
$show_grade = true;
$show_actions = $user_type != 'student';
?>
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between">
            <h3>Grade Change Requests</h3>
            <button type="button" class="btn btn-primary mb-2 <?php echo $_SESSION['user_type'] != 'student' ? 'd-none' : ''; ?>" data-toggle="modal" data-target="#addGradeChangeRequestModal">
                Add Grade Change Request
            </button>

        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <?php if ($show_student_name) : ?>
                        <th scope="col">Student Name</th>
                    <?php endif; ?>
                    <?php if ($show_course_name) : ?>
                        <th scope="col">Course Name</th>
                    <?php endif; ?>
                    <?php if ($show_grade) : ?>
                        <th scope="col">Grade</th>
                    <?php endif; ?>
                    <?php if ($show_actions) : ?>
                        <th scope="col">Actions</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                foreach ($gradeChangeRequests as $gradeChangeRequest) {
                    echo '<tr>';
                    echo '<th scope="row">' . $i++ . '</th>';

                    if ($show_student_name) {
                        echo '<td>' . htmlspecialchars($gradeChangeRequest['student_name']) . '</td>';
                    }
                    if ($show_course_name) {
                        echo '<td>' . htmlspecialchars($gradeChangeRequest['course_name']) . '</td>';
                    }
                    if ($show_grade) {
                        echo '<td>' . htmlspecialchars($gradeChangeRequest['grade']) . '</td>';
                    }
                    if ($show_actions) {
                        echo '<td><a href="/grade-change/grade-change-requests/edit/' . htmlspecialchars($gradeChangeRequest['request_id']) . '" class="btn btn-primary">Edit</a> <a href="/grade-change/grade-change-requests/delete/' . htmlspecialchars($gradeChangeRequest['request_id']) . '" class="btn btn-danger">Delete</a></td>';
                    }

                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>

    </div>
</div>

<!-- Add Grade Change Request Modal -->
<div class="modal fade" id="addGradeChangeRequestModal" tabindex="-1" aria-labelledby="addGradeChangeRequestModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addGradeChangeRequestModalLabel">Add Grade Change Request</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addGradeChangeRequestForm">
                    <div class="mb-3">
                        <label for="courseName" class="form-label">Course Name</label>
                        <!-- select course to apply grade change -->
                        <select class="form-select form-control" id="course_id" name="course_name" required>
                            <option value="">Select Course</option>
                            <?php
                            foreach ($courses as $course) {
                                echo '<option value="' . $course['course_id'] . '">' . htmlspecialchars($course['course_name']) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="points" class="form-label">Deserved Points</label>
                        <input type="number" class="form-control" id="points" name="points" required>
                    </div>
                    <div class="mb-3">
                        <label for="grade" class="form-label">Deserved Grade</label>
                        <select class="form-select form-control" id="grade" disabled name="grade" required>
                            <option value="">Enter Points Above</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="F">F</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="attachment">Attachment</label>
                        <input type="file" class="form-control border-0" id="attachment" name="attachment" accept=".pdf, .doc, .docx, .txt" required>
                    </div>
                    <div class="form-group">
                        <label for="reason" class="form-label">Reason</label>
                        <textarea class="form-control" placeholder="Describe why the assigned grade should change" id="reason" name="reason" required></textarea>
                    </div>
                    <div class="alert alert-danger d-none">
                        <p class="error"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Add Grade Change Request</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>