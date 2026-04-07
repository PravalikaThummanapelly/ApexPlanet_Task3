<?php
include 'config.php'; // session already started here
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>

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
        <h2 class="text-center mb-3">Login</h2>

        <form method="POST">
            <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>

            <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>

            <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
        </form>

        <p class="mt-3 text-center">
            Don't have an account? <a href="register.php">Register</a>
        </p>

        <?php
        if (isset($_POST['login'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                if (password_verify($password, $row['password'])) {
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['role'] = $row['role_id'];

                    header("Location: dashboard.php");
                    exit();
                } else {
                    echo "<p class='text-danger text-center mt-2'>Invalid Password!</p>";
                }
            } else {
                echo "<p class='text-danger text-center mt-2'>User not found!</p>";
            }
        }
        ?>
    </div>
</div>

</body>
</html>