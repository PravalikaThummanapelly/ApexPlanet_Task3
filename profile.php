<?php 
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$id = $_SESSION['user_id'];

$result = $conn->query("SELECT * FROM users WHERE id=$id");
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Profile</title>

    <!-- ✅ Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to right, #4facfe, #00f2fe);
        }
        img {
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
</head>

<body>

<div class="container mt-5">
    <div class="card p-4 shadow mx-auto text-center" style="max-width: 400px;">
        <h2 class="mb-3">My Profile</h2>

        <!-- Profile Image -->
        <img src="uploads/<?php echo $user['profile_pic'] ? $user['profile_pic'] : 'default.png'; ?>" width="120" height="120"><br><br>

        <p><strong>Name:</strong> <?php echo $user['name']; ?></p>
        <p><strong>Email:</strong> <?php echo $user['email']; ?></p>

        <!-- Upload Form -->
        <form method="POST" enctype="multipart/form-data">
            <input type="file" name="image" class="form-control mb-2" required>
            <button type="submit" name="upload" class="btn btn-primary w-100">Upload</button>
        </form>

        <p class="mt-3">
            <a href="dashboard.php">⬅ Back to Dashboard</a>
        </p>

        <?php
        if (isset($_POST['upload'])) {
            $file = $_FILES['image'];

            if ($file['size'] < 2000000) {
                $filename = time() . "_" . basename($file['name']); // unique name
                move_uploaded_file($file['tmp_name'], "uploads/" . $filename);

                $conn->query("UPDATE users SET profile_pic='$filename' WHERE id=$id");

                echo "<p class='text-success mt-2'>Profile updated!</p>";

                header("refresh:1;url=profile.php");
            } else {
                echo "<p class='text-danger mt-2'>File too large!</p>";
            }
        }
        ?>
    </div>
</div>

</body>
</html>