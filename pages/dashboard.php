<?php
 if ($SESS_USER_TYPE == 'superAdmin' || $SESS_USER_TYPE == 'admin'  || $SESS_USER_TYPE == 'branchOfficer' ||  $SESS_USER_TYPE == 'director' || $SESS_USER_TYPE == 'financeManager') {
    include 'pages/dashboard/admin-dashboard.php';
}else  if ($SESS_USER_TYPE === 'fieldOfficer') {
    include 'pages/dashboard/fieldofficer-dashboard.php';
}else  if ($SESS_USER_TYPE === 'Client') {
    include 'pages/dashboard/client-dashboard.php';
}
