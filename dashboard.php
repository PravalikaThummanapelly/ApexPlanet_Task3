<?php 
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$isAdmin = ($_SESSION['role'] == 1);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>

    <!-- ✅ Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to right, #4facfe, #00f2fe);
        }
    </style>
</head>

<body>

<div class="container mt-5">
    <div class="card p-4 shadow">

        <h2 class="text-center mb-3">Dashboard</h2>

        <!-- Navigation -->
        <div class="text-center mb-3">
            <?php if ($isAdmin) { ?>
                <a href="add_user.php" class="btn btn-success btn-sm">Add User</a>
            <?php } ?>
            <a href="profile.php" class="btn btn-primary btn-sm">My Profile</a>
            <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
        </div>

        <hr>

        <?php if (!$isAdmin) { ?>
            <p class="text-center text-warning">Only Admin can view users!</p>
        <?php } else { ?>

            <!-- Users Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $result = $conn->query("SELECT users.*, roles.role_name 
                        FROM users JOIN roles ON users.role_id = roles.id");

                        while ($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['role_name']; ?></td>
                            <td>
                                <a href="edit_user.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>

                                <a href="delete_user.php?id=<?php echo $row['id']; ?>" 
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Delete?')">Delete</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

        <?php } ?>

    </div>
</div>

</body>
</html>