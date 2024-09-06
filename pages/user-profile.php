<?php
if ($SESS_USER_TYPE == 'superAdmin' || $SESS_USER_TYPE == 'admin'  || $SESS_USER_TYPE == 'branchOfficer' ||  $SESS_USER_TYPE == 'director' || $SESS_USER_TYPE == 'financeManager') {
    include 'pages/profile/admin-profile.php';
}else if ($SESS_USER_TYPE == 'fieldOfficer') {
    include 'pages/profile/admin-profile.php';
}else if ($SESS_USER_TYPE == 'Client') {
    include 'pages/profile/client-profile.php';
}