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
                        echo '<td>' . htmlspecialchars($grade['grade']) . '</td>';
                        echo '<td><a href="/grade-change/grades/edit/' . $grade['id'] . '" class="btn btn-primary">Edit</a> <a href="/grade-change/grades/delete/' . $grade['id'] . '" class="btn btn-danger">Delete</a></td>';
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
                <form action="/grade-change/grades/create" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="course">Course</label>
                            <select class="form-control" id="course" name="course_id" required>
                                <option value="">Select Course</option>
                                <?php
                                foreach ($courses as $course) {
                                    echo '<option value="' . $course['id'] . '">' . htmlspecialchars($course['course_name']) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="student">Student</label>
                            <select class="form-control" id="student" name="student_id" required>
                                <option value="">Select Student</option>
                                <?php
                                foreach ($students as $student) {
                                    echo '<option value="' . $student['id'] . '">' . htmlspecialchars($student['name']) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="points">Points</label>
                            <input type="number" class="form-control" id="points" name="points" required>
                        </div>
                        <div class="form-group">
                            <label for="grade">Grade</label>
                            <!-- choose from A, B, C, D, E, F -->
                            <select class="form-control" id="grade" name="grade" required>
                                <option value="">Select Grade</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                                <option value="E">E</option>
                                <option value="F">F</option>
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