<div class="row">
    <div class="col-12" style="max-height: 600px; overflow-y: auto;">
        <div class="d-flex justify-content-between">
            <h3>Students</h3>
            <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#addStudentModal">
                Add Student
            </button>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Student Name</th>
                    <th scope="col">Student ID</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                foreach ($students as $student) {
                    echo '<tr>';
                    echo '<th scope="row">' . $i++ . '</th>';
                    echo '<td>' . htmlspecialchars($student['student_name']) . '</td>';
                    echo '<td>' . htmlspecialchars($student['student_number']) . '</td>';
                    echo '<td><a href="/grade-change/students/edit/' . $student['id'] . '" class="btn btn-primary">Edit</a> <a href="/grade-change/students/delete/' . $student['id'] . '" class="btn btn-danger">Delete</a></td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Student Modal -->
<div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
    <form id="addStudentForm" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStudentModalLabel">Add Student</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    <div class="form-group">
                        <label for="studentName" class="form-label">Student Name</label>
                        <!-- select user to be made student -->
                        <select class="form-select form-control" id="studentName" name="student_name" required>
                            <option value="">Select User</option>
                            <?php
                            foreach ($users as $user) {
                                echo '<option value="' . $user['user_id'] . '">' . htmlspecialchars($user['full_name']) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="department" class="form-label">Department</label>
                        <select class="form-select form-control" id="department" name="department_id" required>
                            <option value="">Select Department</option>
                            <?php
                            foreach ($departments as $department) {
                                echo '<option value="' . $department['department_id'] . '">' . htmlspecialchars($department['name']) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <!-- error or success message -->
                    <div class="alert alert-danger d-none">
                        <p class="error"></p>
                    </div>
                    <div class="alert alert-success d-none">
                        <p class="success"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Add Student</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </form>
</div>