<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between">
            <h3>Courses</h3>
            <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#addCourseModal">
                Add Course
            </button>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Course Name</th>
                    <th scope="col">Course Code</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                foreach ($courses as $course) {
                    echo '<tr>';
                    echo '<th scope="row">' . $i++ . '</th>';
                    echo '<td>' . htmlspecialchars($course['course_name']) . '</td>';
                    echo '<td>' . htmlspecialchars($course['course_code']) . '</td>';
                    echo '<td><a href="/grade-change/courses/edit/' . $course['id'] . '" class="btn btn-primary">Edit</a> <a href="/grade-change/courses/delete/' . $course['id'] . '" class="btn btn-danger">Delete</a></td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addCourseModal" tabindex="-1" aria-labelledby="addCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCourseModalLabel">Add Course</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/grade-change/courses/create" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="courseName">Course Name</label>
                        <input type="text" class="form-control" id="courseName" name="course_name" required>
                    </div>
                    <div class="form-group">
                        <label for="courseCode">Course Code</label>
                        <input type="text" class="form-control" id="courseCode" name="course_code" required>
                    </div>
                    <div class="form-group">
                        <label for="departmentId">Department</label>
                        <select class="form-control" id="departmentId" name="department_id" required>
                            <option value="">Select Department</option>
                            <?php
                            foreach ($departments as $department) {
                                echo '<option value="' . $department['id'] . '">' . htmlspecialchars($department['department_name']) . '</option>';
                            }
                            ?>
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