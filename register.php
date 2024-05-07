<?php

include_once('function.php');
if (isset($_POST['submit'])) {
    //confirm password
    if ($_POST['password'] === $_POST['confirm_password']) {
        //process
        $status = register($_POST['email'], $_POST['password']);
        if ($status === "success") {
            echo "<div class='bg-success bg-gradient text-white p-2'>Register Success , you can now login</div>";
        } else {
            echo "<div class='bg-danger bg-gradient text-white p-2'>$status</div>";
        }
    } else {
        echo "<div class='bg-danger bg-gradient text-white p-2'>Password does not match</div>";
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
            <h2 class="text-center">Register Form</h2>
            <div class="mb-2">
                <label class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control form-control-lg" autocomplete="off" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control   form-control-lg" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control   form-control-lg" required>
            </div>
            <button type="submit" name="submit" class="bg-primary btn btn-lg text-white">Register</button>
            <div class="text-center d-flex flex-column gap-2">
                <a href="login.php" class="text-decoration-none">Already have an account? Login here</a>
                <a href="forgot.php" class="text-decoration-none">forgot password</a>
            </div>
        </form>
    </div>
</body>

</html>