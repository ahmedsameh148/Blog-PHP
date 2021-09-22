<?php
require_once(BASE_PATH . '/dal/basic_dal.php');

function getUsers(
    $page_size,
    $page = 1,
    $user_id = null,
    $q = null
) {
    $offset = ($page - 1) * $page_size;

    $sql = "SELECT id, name, username, email, phone, type, active 
            FROM users
            WHERE 1=1";

    $types = '';
    $vals = [];
    $sql = addWhereConditions($sql, $user_id, $q, $types, $vals);
    $sql .= " ORDER BY name limit $offset,$page_size";

    $users['data'] =  getRows($sql, $types, $vals);

    $sql = "SELECT COUNT(*) AS Cnt FROM users WHERE 1=1";
    $types = '';
    $vals = [];
    $sql = addWhereConditions($sql, $user_id, $q, $types, $vals);

    $users['count'] = getRow($sql, $types, $vals)['Cnt'];
    var_export($users['data'][0]);
    return $users;
}

function addWhereConditions($sql, $user_id = null, $q = null, &$types, &$vals)
{
    if ($user_id != null) {
        $types .= 'i';
        array_push($vals, $user_id);
        $sql .= " AND user_id=?";
    }
    if ($q != null) {
        $types .= 's';
        array_push($vals, '%' . $q . '%');
        $sql .= " AND (name like ?)";
    }
    return $sql;
}

function deleteUser($id)
{
    $sql = "DELETE FROM users WHERE id=?";
    execute($sql, 'i', [$id]);
}

function checkIfUserIsAnAdmin(){
    return $_SESSION['type'] == 0;
}

function updateUserActive($id, $value){
    $sql = "UPDATE users SET active = ? WHERE id=?";
    execute($sql, 'ii', [$value, $id]);
}