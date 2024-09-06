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

        <hr class="nav-hr">
        <li class="nav-heading">ALL</li>

        <li class="nav-item hidden">
            <a class="nav-link  <?= activeBar(['#'])  ?> " href="#" data-bs-target="#Accountingview" data-bs-toggle="collapse">
                <i class="fas fa-money-bill-alt"></i> <span>Accounting</span>
                <i class="fa fa-chevron-down arrow" style="margin-left: 60px;"></i>
            </a>
            <ul id="Accountingview" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a class="nav-link <?= activeBar(['view-account']) ?> mt-2" href="index.php?page=all-subpages&subpage=view-account">
                        <i class="fas fa-file-invoice-dollar" style="font-size: 16px;"></i> <span>View of Accounts</span>
                    </a>
                    <a class="nav-link <?= activeBar(['create-account']) ?> mt-2" href="index.php?page=all-subpages&subpage=create-account">
                        <i class="fas fa-file-invoice-dollar" style="font-size: 16px;"></i> <span>Create Accounts</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item hidden">
            <a class="nav-link  <?= activeBar(['branch-settings', 'view-branch'])  ?> " href="#" data-bs-target="#Branchesview" data-bs-toggle="collapse">
                <i class="fa fa-university" aria-hidden="true"></i><span>Branches</span>
                <i class="fa fa-chevron-down arrow" style="margin-left: 80px;"></i>
            </a>
            <ul id="Branchesview" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a class="nav-link <?= activeBar(['view-branch']) ?> mt-2" href="index.php?page=all-subpages&subpage=view-branch">
                        <i class="fa fa-university" style="font-size: 16px;"></i> <span>View Branches</span>
                    </a>
                    <a class="nav-link <?= activeBar(['branch-settings']) ?> mt-2" href="index.php?page=all-subpages&subpage=branch-settings">
                        <i class="fa fa-plus-square" style="font-size: 16px;"></i> <span>Create Branch</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link  <?= activeBar(['create-client', 'view-client', 'view-client-details'])  ?> " href="#" data-bs-target="#Clientsview" data-bs-toggle="collapse">
                <i class="fa fa-user-circle" aria-hidden="true"></i><span>Clients</span>
                <i class="fa fa-chevron-down arrow" style="margin-left: 95px;"></i>
            </a>
            <ul id="Clientsview" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a class="nav-link <?= activeBar(['view-client', 'view-client-details']) ?> mt-2" href="index.php?page=all-subpages&subpage=view-client">
                        <i class="fa fa-users" style="font-size: 16px;"></i> <span>View Clients</span>
                    </a>
                    <a class="nav-link <?= activeBar(['create-client']) ?> mt-2" href="index.php?page=all-subpages&subpage=create-client">
                        <i class="fa fa-user-plus" style="font-size: 16px;"></i> <span>Create Client</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link  <?= activeBar(['loan-manage-product', 'loan-manage-charge', 'view-loan-charge', 'view-loan-product', 'create-loan', 'view-loan', 'view-separate-loan', 'add-repayment'])  ?> " href="#" data-bs-target="#Loansview" data-bs-toggle="collapse">
                <i class="fa fa-file" aria-hidden="true"></i><span>Loans</span>
                <i class="fa fa-chevron-down arrow" style="margin-left: 105px;"></i>
            </a>
            <ul id="Loansview" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a class="nav-link <?= activeBar(['view-loan']) ?> mt-2" href="index.php?page=all-subpages&subpage=view-loan">
                        <i class="fa fa-file" style="font-size: 16px;"></i> <span>View Loans</span>
                    </a>
                    <a class="nav-link <?= activeBar(['create-loan']) ?> mt-2" href="index.php?page=all-subpages&subpage=create-loan">
                        <i class="fa fa-plus-square" style="font-size: 16px;"></i> <span>Create Loan</span>
                    </a>
                    <!-- <a class="nav-link hidden <?= activeBar(['loan-manage-product', 'view-loan-product']) ?> mt-2" href="index.php?page=all-subpages&subpage=view-loan-product">
                        <i class="fa fa-file" style="font-size: 16px;"></i> <span>Manage Products</span>
                    </a>
                    <a class="nav-link hidden <?= activeBar(['view-loan-charge', 'loan-manage-charge']) ?> mt-2" href="index.php?page=all-subpages&subpage=view-loan-charge">
                        <i class="fa fa-file" style="font-size: 16px;"></i> <span>Manage Charges</span>
                    </a> -->
                    <a class="nav-link <?= activeBar(['#']) ?> mt-2" href="#">
                        <i class="fa fa-calculator" style="font-size: 16px;"></i> <span>Loan Calculator</span>
                    </a>
                </li>
            </ul>
        </li>


        <li class="nav-item">
            <a class="nav-link <?= activeBar(['all-repayments']) ?>" href="index.php?page=all-subpages&subpage=all-repayments">
                <i class="fa fa-file" aria-hidden="true"></i> <span>Repayments</span>
            </a>
        </li>

        <!-- <li class="nav-item">
            <a class="nav-link  <?= activeBar(['view-meetings', 'add-meetings'])  ?> " href="#" data-bs-target="#meetingview" data-bs-toggle="collapse">
                <i class="fa fa-university" aria-hidden="true"></i><span>Meetings</span>
                <i class="fa fa-chevron-down arrow" style="margin-left: 80px;"></i>
            </a>
            <ul id="meetingview" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a class="nav-link <?= activeBar(['add-meetings']) ?> mt-2" href="index.php?page=all-subpages&subpage=add-meeting">
                        <i class="fa fa-university" style="font-size: 16px;"></i> <span>Add Meeting</span>
                    </a>
                    <a class="nav-link <?= activeBar(['view-meetings']) ?> mt-2" href="index.php?page=all-subpages&subpage=view-meetings">
                        <i class="fa fa-plus-square" style="font-size: 16px;"></i> <span>View Meetings</span>
                    </a>
                </li>
            </ul>
        </li> -->

        <li class="nav-item hidden">
            <a class="nav-link  <?= activeBar(['#'])  ?> " href="#" data-bs-target="#Expenseview" data-bs-toggle="collapse">
                <i class="fa fa-file" aria-hidden="true"></i><span>Expense</span>
                <i class="fa fa-chevron-down arrow" style="margin-left: 90px;"></i>
            </a>
            <ul id="Expenseview" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a class="nav-link <?= activeBar(['#']) ?> mt-2" href="#">
                        <i class="fa fa-file" style="font-size: 16px;"></i> <span>View Expense</span>
                    </a>
                    <a class="nav-link <?= activeBar(['#']) ?> mt-2" href="#">
                        <i class="fa fa-plus-square" style="font-size: 16px;"></i> <span>Create Expense</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link  <?= activeBar(['view-savings', 'view-savings-separate', 'create-saving', 'saving-manage-product'])  ?> " href="#" data-bs-target="#Savingsview" data-bs-toggle="collapse">
                <i class="fa fa-tasks" aria-hidden="true"></i><span>Savings</span>
                <i class="fa fa-chevron-down arrow" style="margin-left: 93px;"></i>
            </a>
            <ul id="Savingsview" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a class="nav-link <?= activeBar(['view-savings']) ?> mt-2" href="index.php?page=all-subpages&subpage=view-savings">
                        <i class="fa fa-tasks" style="font-size: 16px;"></i> <span>View Savings</span>
                    </a>
                    <a class="nav-link <?= activeBar(['saving-manage-product']) ?> mt-2" href="index.php?page=all-subpages&subpage=saving-manage-product">
                        <i class="fa fa-tasks" style="font-size: 16px;"></i> <span>Manage Products</span>
                    </a>
                    <a class="nav-link <?= activeBar(['create-saving']) ?> mt-2" href="index.php?page=all-subpages&subpage=create-saving">
                        <i class="fa fa-plus-square" style="font-size: 16px;"></i> <span>Create Saving</span>
                    </a>
                    <a class="nav-link <?= activeBar(['saving-deposit']) ?> mt-2" href="index.php?page=all-subpages&subpage=saving-deposit">
                        <i class="fa fa-plus-square" style="font-size: 16px;"></i> <span>Savings Deposit</span>
                    </a>
                    <a class="nav-link <?= activeBar(['saving-withdrawal']) ?> mt-2" href="index.php?page=all-subpages&subpage=saving-withdrawal">
                        <i class="bi bi-bank" style="font-size: 16px;"></i> <span>Withdrawal</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item hidden">
            <a class="nav-link  <?= activeBar(['#'])  ?> " href="#" data-bs-target="#Incomeview" data-bs-toggle="collapse">
                <i class="fa fa-file" aria-hidden="true"></i><span>Income</span>
                <i class="fa fa-chevron-down arrow" style="margin-left: 93px;"></i>
            </a>
            <ul id="Incomeview" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a class="nav-link <?= activeBar(['#']) ?> mt-2" href="#">
                        <i class="fa fa-file" style="font-size: 16px;"></i> <span>View Income</span>
                    </a>
                    <a class="nav-link <?= activeBar(['#']) ?> mt-2" href="#">
                        <i class="fa fa-plus-square" style="font-size: 16px;"></i> <span>Create Income</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link  <?= activeBar(['other-settings'])  ?> " href="#" data-bs-target="#Settingsview" data-bs-toggle="collapse">
                <i class="fa fa-file" aria-hidden="true"></i><span>Settings</span>
                <i class="fa fa-chevron-down arrow" style="margin-left: 85px;"></i>
            </a>
            <ul id="Settingsview" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a class="nav-link <?= activeBar(['#']) ?> mt-2" href="#">
                        <i class="fa fa-file" style="font-size: 16px;"></i> <span>System Settings</span>
                    </a>
                    <a class="nav-link <?= activeBar(['other-settings']) ?> mt-2" href="index.php?page=all-subpages&subpage=other-settings">
                        <i class="fa fa-plus-square" style="font-size: 16px;"></i> <span>Other Settings</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link <?= activeBar(['#']) ?>" href="#">
                <i class="fa fa-file" aria-hidden="true"></i> <span>Reports</span>
            </a>
        </li>

        <li class="nav-item hidden">
            <a class="nav-link <?= activeBar(['activity-log']) ?>" href="index.php?page=all-subpages&subpage=activity-log">
                <i class="fa fa-file" aria-hidden="true"></i> <span>Activity Log</span>
            </a>
        </li>

    </ul>
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