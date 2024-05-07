<?php
include_once('function.php');
if (!isset($_SESSION['LoginUser'])) {
    header("Location: login.php");
}

$user = getUserById($_SESSION['LoginUser']['ID']);



if (isset($_POST['submit'])) {

    $status =  updateUserInfo($_SESSION['LoginUser']['ID'], $_POST['firstname'], $_POST['lastname']);

    if ($status === "success") {
        header("Location: profile.php");
    } else {
        echo "<div class='bg-danger bg-gradient text-white p-2'>$status</div>";
    }
}

?>
<?php include_once('templates/header.php'); ?>
<div class="container">
    <?php if ($user) : ?>
        <h1 class="my-5">My Profile</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">First Name</label>
                <input type="text" name="firstname" id="firstname" class="form-control form-control-lg" required value="<?= $user['firstname']; ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Last Name</label>
                <input type="text" name="lastname" id="lastname" class="form-control form-control-lg" required value="<?= $user['lastname']; ?>">
            </div>

            <button type="submit" name="submit" class="bg-primary btn btn-lg my-4 text-white">Update Profile</button>
            <input type="hidden" name="ID" value="<?= $user['ID']; ?>">
        </form>
    <?php else : ?>
        <h3 class="mt-5">User does not exist.</h3>
    <?php endif; ?>

</div>
<?php include_once('templates/footer.php'); ?>