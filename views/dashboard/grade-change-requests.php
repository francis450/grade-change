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
                    <th scope="col">Student Name</th>
                    <th scope="col">Course Name</th>
                    <th scope="col">Grade</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                foreach ($gradeChangeRequests as $gradeChangeRequest) {
                    echo '<tr>';
                    echo '<th scope="row">' . $i++ . '</th>';
                    echo '<td>' . htmlspecialchars($gradeChangeRequest['student_name']) . '</td>';
                    echo '<td>' . htmlspecialchars($gradeChangeRequest['course_name']) . '</td>';
                    echo '<td>' . htmlspecialchars($gradeChangeRequest['grade']) . '</td>';
                    echo '<td><a href="/grade-change/grade-change-requests/edit/' . $gradeChangeRequest['id'] . '" class="btn btn-primary">Edit</a> <a href="/grade-change/grade-change-requests/delete/' . $gradeChangeRequest['id'] . '" class="btn btn-danger">Delete</a></td>';
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
                <form id="addGradeChangeRequestForm" method="post" action="/grade-change/grade-change-requests/store">
                    <div class="mb-3">
                        <label for="courseName" class="form-label">Course Name</label>
                        <!-- select course to apply grade change -->
                        <select class="form-select form-control" id="courseName" name="course_name" required>
                            <option value="">Select Course</option>
                            <?php
                            foreach ($courses as $course) {
                                echo '<option value="' . $course['id'] . '">' . htmlspecialchars($course['course_name']) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="grade" class="form-label">Grade</label>
                        <select class="form-select form-control" id="grade" name="grade" required>
                            <option value="">Select Grade</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="F">F</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="reason" class="form-label">Reason</label>
                        <textarea class="form-control" id="reason" name="reason" required></textarea>
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