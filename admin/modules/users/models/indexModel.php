<?php

# Function indexController

function add_admin($data) {
    return db_insert('tbl_admin', $data);
}

function admin_exists($username, $email) {
    $result = db_num_rows("SELECT * FROM `tbl_admin` WHERE username = '{$username}' OR email = '{$email}'");
    if ($result == 1)
        return true;

    return false;
}

function check_login($username, $password) {
    $result = db_num_rows("SELECT * FROM `tbl_admin` WHERE `username` = '{$username} ' AND `password` = '{$password}'");
    if ($result == 1)
        return true;

    return false;
}

function update_info_admin($data, $username) {
    db_update('tbl_admin', $data, "`username` = '{$username}'");
}

function update_new_password($data, $pass_old) {
    $pass_old = md5($pass_old);
    db_update('tbl_admin', $data, "`password` = '{$pass_old}'");
}

function check_pass_old($pass_old) {
    $pass_old = md5($pass_old);
    $result = db_num_rows("SELECT * FROM `tbl_admin` WHERE `password` = '{$pass_old}'");
    if ($result == 1)
        return true;

    return false;
}

function check_email($email) {
    $result = db_num_rows("SELECT * FROM `tbl_admin` WHERE `email` = '{$email}'");
    if ($result == 1)
        return true;

    return false;
}

function update_reset_token($data, $email) {
    db_update('tbl_admin', $data, "`email` = '{$email}'");
}

function check_reset_token($reset_token) {
    $result = db_num_rows("SELECT * FROM `tbl_admin` WHERE `reset_token` = '{$reset_token}'");
    if ($result == 1)
        return true;

    return false;
}

function update_pass($data, $reset_token) {
    db_update('tbl_admin', $data, "`reset_token` = '{$reset_token}'");
}

function get_admin($username) {
    $result = db_fetch_row("SELECT * FROM `tbl_admin` WHERE `username`= '{$username}'");
    if (!empty($result))
        return $result;
}

# Function teamController

function get_list_user($role = "") {
    if (!empty($role)) {
        $result = db_fetch_array("SELECT * FROM `tbl_admin` WHERE `role` = '{$role}'");
        if(!empty($result)) return $result;
    } else {
        return db_fetch_array("SELECT * FROM `tbl_admin`");
    }
}

function get_num_rows($table) {
    $result = db_num_rows("SELECT * FROM `{$table}` ");
    return $result;
}

function check_role($username) {
    $result = db_fetch_row("SELECT * FROM `tbl_admin` WHERE `username` = '{$username}'");
    return $result['role'];
}

function convert_role($role) {
    if ($role == "admin") {
        $role = 1;
    } elseif ($role == "editor") {
        $role = 2;
    } elseif ($role == "worker") {
        $role = 3;
    } else {
        $role = 4;
    }
    return $role;
}

function update_role($data, $username) {
    db_update('tbl_admin', $data, "`username` = '{$username}'");
}
