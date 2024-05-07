<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <div class="container-fluid">
        <a href="/" class="navbar-brand">Logo</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav">
                <li class="nav-link"> <a href="/" class="text-decoration-none text-white">Products</a></li>
                <?php if (isset($_SESSION['LoginUser'])) : ?>
                    <li class="nav-link"> <a href="profile.php" class="text-decoration-none text-white">My Profile</a></li>
                    <li class="nav-link"> <a href="logout.php" class="text-decoration-none text-white">Logout</a></li>
                <?php else :; ?>
                    <li class="nav-link"> <a href="login.php" class="text-decoration-none text-white">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>