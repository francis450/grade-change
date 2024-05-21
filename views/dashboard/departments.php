<div class="row">
    <div class="col-12" style="max-height: 600px; overflow-y: auto;">
        <div class="d-flex justify-content-between">
            <h3>Departments</h3>
            <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#addDepartmentModal">
                Add Department
            </button>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col" class="col-4">Department Name</th>
                    <th scope="col" class="col-4">Department Head</th>
                    <th scope="col" class="col-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                foreach ($departments as $department) {
                    echo "<tr data-id='" . htmlspecialchars($department['department_id']) . "'>";
                    echo '<th scope="row">' . $i++ . '</th>';
                    echo '<td>' . htmlspecialchars($department['name']) . '</td>';

                    if (isset($department['department_head']) && !empty($department['department_head'])) {
                        $departmentHeads = array_map(function ($head) {
                            return htmlspecialchars($head['full_name']);
                        }, $department['department_head']);
                        echo '<td>' . implode(', ', $departmentHeads) . '</td>';
                    } else {
                        echo '<td>N/A</td>';
                    }

                    echo '<td>';
                    echo '<a class="btn btn-primary edit-department">Edit</a> ';
                    echo '<a href="/grade-change/departments/delete/' . htmlspecialchars($department['department_id']) . '" class="btn btn-danger">Delete</a>';
                    echo '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Department Modal -->
<div class="modal fade" id="addDepartmentModal" tabindex="-1" aria-labelledby="addDepartmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDepartmentModalLabel">Add Department</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="department-form">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="departmentName">Department Name</label>
                        <input type="text" class="form-control" id="departmentName" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="departmentHead">Department Head</label>
                        <select class="form-control" id="departmentHead" name="department_head_id" required>
                            <option value="">Select Department Head</option>
                            <?php
                            foreach ($users as $user) {
                                echo '<option value="' . $user['user_id'] . '">' . htmlspecialchars($user['full_name']) . '</option>';
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Department Modal -->
<div class="modal fade" id="editDepartmentModal" tabindex="-1" aria-labelledby="editDepartmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDepartmentModalLabel">Edit Department</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="department-form">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="editDepartmentName">Department Name</label>
                        <input type="text" class="form-control" id="departmentName" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="editDepartmentHead">Department Head</label>
                        <select class="form-control" id="departmentHead" name="department_head_id" required>
                            <option value="">Select Department Head</option>
                            <?php
                            // Loop through $users array to populate options
                            foreach ($users as $user) {
                                echo '<option value="' . $user['user_id'] . '">' . htmlspecialchars($user['full_name']) . '</option>';
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>