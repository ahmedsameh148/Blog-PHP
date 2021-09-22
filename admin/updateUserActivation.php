<?php

require_once('../config.php');
require_once(BASE_PATH . '/logic/users.php');
require_once(BASE_PATH . '/logic/auth.php');
if (!isset($_REQUEST['id']) || !isset($_REQUEST['value'])) {
    header('Location:index.php');
    die();
}
$id = $_REQUEST['id'];
$value = $_REQUEST['value'];
if (!checkIfUserIsAnAdmin()) {
    header('Location:index.php');
    die();
}
updateUserActive($id, $value);
header('Location:/admin/filter_users.php');
die();
