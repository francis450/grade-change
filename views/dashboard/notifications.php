<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between">
            <h3>Notifications</h3>
            <!-- <a href="/grade-change/notifications/create" class="btn btn-primary mb-2">Add Notification</a> -->
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Notification</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                foreach ($notifications as $notification) {
                    echo '<tr>';
                    echo '<th scope="row">' . $i++ . '</th>';
                    echo '<td>' . $notification['notification'] . '</td>';
                    echo '<td><a href="/grade-change/notifications/edit/' . $notification['id'] . '" class="btn btn-primary">Edit</a> <a href="/grade-change/notifications/delete/' . $notification['id'] . '" class="btn btn-danger">Delete</a></td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>