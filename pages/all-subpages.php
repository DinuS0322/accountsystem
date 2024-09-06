<?php
if (!isset($_GET['subpage'])) {
    $subpage = '';
} else {
    $subpage = filter_var($_GET['subpage'], FILTER_SANITIZE_URL);
}

$subPageTitle = ucwords(str_replace('-', ' ', $subpage));


if (file_exists("pages/subpage/$subpage.php")) {
    include "pages/subpage/$subpage.php";
} else {
    include '404.php';
}