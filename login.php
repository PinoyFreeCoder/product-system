<?php
include_once('function.php');
if (isset($_POST['submit'])) {

    //process
    $row = login($_POST['email'], $_POST['password']);
    if ($row != "Invalid credentials" && $row != "User not found!") {
        $_SESSION['LoginUser'] = array(
            "ID" => $row['ID'],
            "firstname" => $row['firstname'],
            "lastname" => $row['lastname'],
            "email" => $row['email']
        );
        header("Location: / ");
    } else {
        echo "<div class='bg-danger bg-gradient text-white p-2'>$row</div>";
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js" integrity="sha512-ykZ1QQr0Jy/4ZkvKuqWn4iF3lqPZyij9iRv6sGqLRdTPkY69YX6+7wvVGmsdBbiIfN/8OdsI7HABjvEok6ZopQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>
    <div class="container-fluid d-flex align-items-center justify-content-center vh-100">
        <form method="POST" class="d-flex flex-column gap-3 w-50 mx-auto border p-4">
            <h2 class="text-center">Login Form</h2>
            <div class="mb-2">
                <label class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control form-control-lg" autocomplete="off" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control   form-control-lg" required>
            </div>
            <button type="submit" name="submit" class="bg-primary btn btn-lg text-white">Login</button>
            <div class="text-center d-flex flex-column gap-2">
                <a href="register.php" class="text-decoration-none">Don't have an account yet? Register here</a>
                <a href="forgot.php" class="text-decoration-none">forgot password</a>
            </div>
        </form>
    </div>
</body>

</html>