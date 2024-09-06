<?php
$userId = $SESS_USER_ID;

?>

<header id="header" class="header fixed-top d-flex align-items-center">

    <!-- Logo -->
    <div class="d-flex align-items-center justify-content-between">
        <i class="bi bi-list toggle-sidebar-btn"></i>

        <a href="index.php?page=dashboard" class="navbar-brand ms-2 d-none d-lg-block font-monospace subheading-2">
            <span>ACCOUNT SYSTEM</span>
        </a>
    </div>
    <!-- End Logo -->


    <!-- Navigation -->
    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <!-- Profile -->
            <li class="nav-item dropdown pe-3">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <img class="rounded-circle" src="/images/user-logo.png" alt="System Logo" />
                    <span class="d-none d-md-block dropdown-toggle ps-2 text-light"><?= $SESS_USER_NAME ?></span>
                </a>

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6><?= $SESS_USER_NAME ?></h6>
                        <span><?= $SESS_USER_TYPE ?></span>
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                        <a class="dropdown-item d-flex align-items-center" href="index.php?page=user-profile">
                            <i class="bi bi-person"></i> <span>My Profile</span>
                        </a>
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                        <a class="dropdown-item d-flex align-items-center" href="logout.php">
                            <i class="bi bi-box-arrow-right"></i> <span>Sign Out</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- End Profile -->
        </ul>
    </nav>
    <!-- End Navigation -->
</header>