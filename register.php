<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>

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
        <h2 class="text-center mb-3">Register</h2>

        <form method="POST">
            <input type="text" name="name" class="form-control mb-2" placeholder="Name" required>

            <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>

            <input type="password" name="password" class="form-control mb-2" placeholder="Password" required>

            <select name="role" class="form-control mb-3">
                <option value="1">Admin</option>
                <option value="2">User</option>
            </select>

            <button type="submit" name="register" class="btn btn-primary w-100">Register</button>
        </form>

        <p class="mt-3 text-center">
            Already have an account? <a href="login.php">Login</a>
        </p>

        <?php
        if (isset($_POST['register'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $role = $_POST['role'];

            $check = $conn->prepare("SELECT id FROM users WHERE email=?");
            $check->bind_param("s", $email);
            $check->execute();
            $res = $check->get_result();

            if ($res->num_rows > 0) {
                echo "<p class='text-danger text-center mt-2'>Email already exists!</p>";
            } else {
                $stmt = $conn->prepare("INSERT INTO users (name, email, password, role_id) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("sssi", $name, $email, $password, $role);
                $stmt->execute();

                echo "<p class='text-success text-center mt-2'>Registered Successfully!</p>";
            }
        }
        ?>
    </div>
</div>

</body>
</html>