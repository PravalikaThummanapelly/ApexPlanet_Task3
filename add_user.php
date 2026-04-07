<?php include 'config.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Add User</title>

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
    <div class="card p-4 shadow mx-auto" style="max-width: 400px;">
        <h2 class="text-center mb-3">Add User</h2>

        <form method="POST">
            <input type="text" name="name" class="form-control mb-2" placeholder="Name" required>

            <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>

            <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>

            <button type="submit" name="add" class="btn btn-success w-100">Add User</button>
        </form>

        <p class="mt-3 text-center">
            <a href="dashboard.php">⬅ Back to Dashboard</a>
        </p>

        <?php
        if (isset($_POST['add'])) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO users (name, email, password, role_id) VALUES (?, ?, ?, 2)");
            $stmt->bind_param("sss", $_POST['name'], $_POST['email'], $password);
            $stmt->execute();

            echo "<p class='text-success text-center mt-2'>User Added Successfully!</p>";

            // Optional redirect after 2 seconds
            header("refresh:2;url=dashboard.php");
        }
        ?>
    </div>
</div>

</body>
</html>