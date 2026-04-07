<?php 
include 'config.php';

$id = $_GET['id'];

$result = $conn->query("SELECT * FROM users WHERE id=$id");
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>

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
        <h2 class="text-center mb-3">Edit User</h2>

        <form method="POST">
            <input type="text" name="name" class="form-control mb-2" 
                   value="<?php echo $user['name']; ?>" required>

            <input type="email" name="email" class="form-control mb-3" 
                   value="<?php echo $user['email']; ?>" required>

            <button type="submit" name="update" class="btn btn-warning w-100">Update</button>
        </form>

        <p class="mt-3 text-center">
            <a href="dashboard.php">⬅ Back to Dashboard</a>
        </p>

        <?php
        if (isset($_POST['update'])) {
            $stmt = $conn->prepare("UPDATE users SET name=?, email=? WHERE id=?");
            $stmt->bind_param("ssi", $_POST['name'], $_POST['email'], $id);
            $stmt->execute();

            echo "<p class='text-success text-center mt-2'>User Updated Successfully!</p>";

            // Optional redirect after 2 seconds
            header("refresh:2;url=dashboard.php");
        }
        ?>
    </div>
</div>

</body>
</html>