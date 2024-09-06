<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <!-- <a class="nav-link <?= activeBar(['dashboard']) ?>" href="index.php?page=dashboard"> -->
            <div class="sidebarLogo">
                <img class="mb-3 login-logo " src="/images/logo.png" alt="System Logo" />
            </div>
            <!-- </a> -->
        </li>

        <li class="nav-item">
            <a class="nav-link <?= activeBar(['dashboard', 'email-template', 'create-email-template']) ?>" href="index.php?page=dashboard">
                <i class="fa fa-home" aria-hidden="true"></i> Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?= activeBar(['user-profile']) ?>" href="index.php?page=user-profile">
                <i class="fa fa-user-circle" aria-hidden="true"></i> <span>Profile</span>
            </a>
        </li>

       
</aside>


<?php
function activeBar($activePages)
{
    if (isset($_GET['page'])) {

        if ($_GET['page'] == 'all-subpages') {
            $page = filter_var($_GET['subpage'], FILTER_SANITIZE_URL);
        } else {
            $page = filter_var($_GET['page'], FILTER_SANITIZE_URL);
        }
    } else {
        $page = 'dashboard';
    }

    if (in_array($page, $activePages)) {
        return ' ';
    } else {
        return 'collapsed';
    }
}


?>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        $('.nav-link').click(function() {
            // Toggle the arrow class
            $(this).find('.arrow').toggleClass('fa-chevron-down fa-chevron-up');
        });
    });
</script>