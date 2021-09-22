<?php

require_once('../config.php');
require_once(BASE_PATH . '/logic/users.php');
require_once(BASE_PATH . '/logic/auth.php');
if (!isset($_REQUEST['id'])) {
    header('Location:index.php');
    die();
}
$id = $_REQUEST['id'];
if (!checkIfUserIsAnAdmin()) {
    header('Location:index.php');
    die();
}
deleteUser($id);
header('Location:/admin/filter_users.php');
die();
