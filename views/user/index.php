<h1>Users</h1>
<a href="/users/create">Create New User</a>
<ul>
    <?php foreach ($users as $user): ?>
        <li>
            <?php echo $user['name']; ?> - <?php echo $user['email']; ?>
            <a href="/users/show/<?php echo $user['id']; ?>">View</a>
            <a href="/users/edit/<?php echo $user['id']; ?>">Edit</a>
            <a href="/users/delete/<?php echo $user['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
        </li>
    <?php endforeach; ?>
</ul>
