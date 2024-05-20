<div class="row">
    <div class="col-12">
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
                    <th scope="col">Department Name</th>
                    <th class="col">Department Head</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                foreach ($departments as $department) {
                    echo '<tr>';
                    echo '<th scope="row">' . $i++ . '</th>';
                    echo '<td>' . $department['department_name'] . '</td>';
                    echo '<td>' . $department['department_head'] . '</td>';
                    echo '<td><a href="/grade-change/departments/edit/' . $department['id'] . '" class="btn btn-primary">Edit</a> <a href="/grade-change/departments/delete/' . $department['id'] . '" class="btn btn-danger">Delete</a></td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addDepartmentModal" tabindex="-1" aria-labelledby="addDepartmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDepartmentModalLabel">Add Department</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>  
            <form action="/grade-change/departments/store" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="departmentName">Department Name</label>
                        <input type="text" class="form-control" id="departmentName" name="department_name" required>
                    </div>
                    <div class="form-group">
                        <label for="departmentHead">Department Head</label>
                        <select class="form-control" id="departmentHead" name="department_head_id" required>
                            <option value="">Select Department Head</option>
                            <?php
                            foreach ($users as $user) {
                                echo '<option value="' . $user['id'] . '">' . $user['full_name'] . '</option>';
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