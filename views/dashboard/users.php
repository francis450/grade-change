<div class="row">
        <!-- display all users in a table with checkboxes for actions on the users -->
        <div class="col-md-12">
            <div class="d-flex justify-content-between">
                <h3>Users</h3>
                <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#addUserModal">
                    Add User
                </button>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Full Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Type</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($users as $user) {
                        echo '<tr>';
                        echo '<th scope="row">' . $i++ . '</th>';
                        echo '<td>' . htmlspecialchars($user['full_name']) . '</td>';
                        echo '<td>' . htmlspecialchars($user['email']) . '</td>';
                        echo '<td>' . htmlspecialchars($user['type']) . '</td>';
                        echo '<td><a href="#" class="btn btn-primary">Edit</a> <a href="#" class="btn btn-danger">Delete</a></td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addUserForm" method="post" action="/users/store">
                        <div class="mb-3">
                            <label for="fullName" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="fullName" name="full_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="userType" class="form-label">Type</label>
                            <select class="form-select form-control" id="userType" name="type" required>
                                <option value="">Select Type</option>
                                <option value="student">Student</option>
                                <option value="lecturer">Lecturer</option>
                                <option value="department_head">Department Head</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Add User</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>