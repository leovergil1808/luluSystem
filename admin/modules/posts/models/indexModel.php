<?php

# Function for Post category

function add_cat($data) {
    return db_insert('tbl_post_cat', $data);
}

function get_list_post_cat() {
    $list_cat = db_fetch_array("SELECT * FROM `tbl_post_cat`");

    if (!empty($list_cat)) {
        foreach ($list_cat as &$cat) {
            $cat['url_delete'] = "?mod=posts&action=deleteCat&cat_id={$cat['cat_id']}";
            $cat['url_update'] = "?mod=posts&action=updateCat&cat_id={$cat['cat_id']}";
        }
        return $list_cat;
    }
}

function get_list_post_cat_limit($start, $num_per_page) {
    $result = db_fetch_array("SELECT * FROM `tbl_post_cat` LIMIT {$start}, {$num_per_page}");
    if (!empty($result)) {
        foreach ($result as &$cat) {
            $cat['url_delete'] = "?mod=posts&action=deleteCat&cat_id={$cat['cat_id']}";
            $cat['url_update'] = "?mod=posts&action=updateCat&cat_id={$cat['cat_id']}";
        }
        return $result;
    }
}

function update_cat($data, $cat_id) {
    db_update("tbl_post_cat", $data, "`cat_id` = {$cat_id}");
}

function delete_cat($cat_id) {
    db_delete("tbl_post_cat", "`cat_id` = {$cat_id}");
}

# Function for Post

function add_post($data) {
    db_insert("tbl_post", $data);
}

function get_post_by_id($id) {
    $result = db_fetch_row("SELECT * FROM `tbl_post` WHERE `id` = '{$id}'");

    if (!empty($result)) {
        switch ($result['cat_id']) {
            case 1 : $result['cat_title'] = "Thể thao";
                break;
            case 2 : $result['cat_title'] = "Xã hội";
                break;
            case 3 : $result['cat_title'] = "Chính trị";
                break;
            default : $result['cat_title'] = "Chưa có";
        }
        $result['url_edit'] = "?mod=posts&controller=index&action=editPost&id={$result['id']}";
        $result['url_move_trash'] = "?mod=posts&controller=index&action=moveTrash&id={$result['id']}";
        return $result;
    }
    return false;
}

function get_list_post($start, $num_per_page) {
    $result = db_fetch_array("SELECT * FROM `tbl_post` LIMIT {$start} , {$num_per_page}");
    if (!empty($result)) {
        foreach ($result as &$item) {
            switch ($item['cat_id']) {
                case 1 : $item['cat_title'] = "Thể thao";
                    break;
                case 2 : $item['cat_title'] = "Xã hội";
                    break;
                case 3 : $item['cat_title'] = "Chính trị";
                    break;
                default : $item['cat_title'] = "Chưa có";
            }
            switch ($item['post_status']) {
                case 0 : $item['post_status'] = "Waiting";
                    $item['status_css'] = 0;
                    break;
                case 1 : $item['post_status'] = "Approved";
                    $item['status_css'] = 1;
                    break;
                case 2 : $item['post_status'] = "Trash";
                    $item['status_css'] = 2;
                    break;
            }
            $item['url_edit'] = "?mod=posts&controller=index&action=editPost&id={$item['id']}";
            $item['url_move_trash'] = "?mod=posts&controller=index&action=moveTrash&id={$item['id']}";
            $item['status_css'] = set_css_by_status($item['status_css']);
        }
        return $result;
    }
    return false;
}

function edit_post($data, $id) {
    $check = db_update("tbl_post", $data, "`id` = {$id}");
    if ($check)
        return true;

    return false;
}

function delete_post($id) {
    db_delete("tbl_post", "`id` = {$id}");
}

function approve_post($data, $id) {
    $check = db_update("tbl_post", $data, "`id` = $id");
    if ($check)
        return true;

    return false;
}

function get_waiting_post($start, $num_per_page) {
    $result = db_fetch_array("SELECT * FROM `tbl_post` WHERE `post_status` = '0' LIMIT {$start}, {$num_per_page}");
    if (!empty($result)) {
        foreach ($result as &$item) {
            switch ($item['cat_id']) {
                case 1 : $item['cat_title'] = "Thể thao";
                    break;
                case 2 : $item['cat_title'] = "Xã hội";
                    break;
                case 3 : $item['cat_title'] = "Xã hội";
                    break;
                default : $item['cat_title'] = "Chưa có";
            }
            switch ($item['post_status']) {
                case 0 : $item['post_status'] = "Waiting";
                    $item['status_css'] = 0;
                    break;
                case 1 : $item['post_status'] = "Approved";
                    $item['status_css'] = 1;
                    break;
                case 2 : $item['post_status'] = "Trash";
                    $item['status_css'] = 2;
                    break;
            }
            $item['url_edit'] = "?mod=posts&controller=index&action=editPost&id={$item['id']}";
            $item['url_move_trash'] = "?mod=posts&controller=index&action=moveTrash&id={$item['id']}";
            $item['url_approve'] = "?mod=posts&controller=index&action=approvePost&id={$item['id']}";
        }
        return $result;
    }
    return false;
}

function get_approved_post($start, $num_per_page) {
    $result = db_fetch_array("SELECT * FROM `tbl_post` WHERE `post_status` = '1' LIMIT {$start}, {$num_per_page}");
    if (!empty($result)) {
        foreach ($result as &$item) {
            switch ($item['cat_id']) {
                case 1 : $item['cat_title'] = "Thể thao";
                    break;
                case 2 : $item['cat_title'] = "Xã hội";
                    break;
                case 3 : $item['cat_title'] = "Xã hội";
                    break;
                default : $item['cat_title'] = "Chưa có";
            }
            $item['url_edit'] = "?mod=posts&controller=index&action=editPost&id={$item['id']}";
            $item['url_move_trash'] = "?mod=posts&controller=index&action=moveTrash&id={$item['id']}";
        }
        return $result;
    }
    return false;
}

function get_trash_post($start, $num_per_page) {
    $result = db_fetch_array("SELECT * FROM `tbl_post` WHERE `post_status` = '2' LIMIT {$start}, {$num_per_page}");
    if (!empty($result)) {
        foreach ($result as &$item) {
            switch ($item['cat_id']) {
                case 1 : $item['cat_title'] = "Thể thao";
                    break;
                case 2 : $item['cat_title'] = "Xã hội";
                    break;
                case 3 : $item['cat_title'] = "Xã hội";
                    break;
                default : $item['cat_title'] = "Chưa có";
            }
            $item['url_edit'] = "?mod=posts&controller=index&action=editPost&id={$item['id']}";
            $item['url_move_trash'] = "?mod=posts&controller=index&action=moveTrash&id={$item['id']}";
            $item['url_restore'] = "?mod=posts&controller=index&action=restorePost&id={$item['id']}";
            $item['url_delete'] = "?mod=posts&controller=index&action=deletePost&id={$item['id']}";
        }
        return $result;
    }
    return false;
}

# Function global for all

function get_admin_info($username) {
    $result = db_fetch_row("SELECT * FROM `tbl_admin` WHERE `username` = '{$username}'");
    return $result['fullname'];
}

function get_url_upload_image($id) {
    $result = db_fetch_row("SELECT * FROM `tbl_post` WHERE `id` = {$id}");
    return $result['post_thumbnail'];
}

function get_num_rows($table, $where = '') {
    if (empty($where)) {
        $result = db_num_rows("SELECT * FROM `{$table}`");
        return $result;
    } else {
        $result = db_num_rows("SELECT * FROM `{$table}` WHERE {$where}");
        return $result;
    }
}

function is_exists($table, $key, $value) {
    $check = db_num_rows("SELECT * FROM `{$table}` WHERE `{$key}` = '{$value}'");
    if ($check > 0) {
        return true;
    }
    return false;
}

function search_item($table, $search_by, $s, $start, $num_per_page) {

    if (!empty($s)) {
        $result = db_fetch_array("SELECT * FROM `{$table}` WHERE {$search_by} LIKE '%{$s}%' LIMIT {$start} , {$num_per_page}");
        if (!empty($result)) {
            foreach ($result as &$item) {
                switch ($item['post_status']) {
                    case 0 : $item['post_status'] = "Waiting";
                        $item['status_css'] = 0;
                        break;
                    case 1 : $item['post_status'] = "Approved";
                        $item['status_css'] = 1;
                        break;
                    case 2 : $item['post_status'] = "Trash";
                        $item['status_css'] = 2;
                        break;
                }
                switch ($item['cat_id']) {
                    case 1 : $item['cat_title'] = "Thể thao";
                        break;
                    case 2 : $item['cat_title'] = "Xã hội";
                        break;
                    case 3 : $item['cat_title'] = "Chính trị";
                        break;
                    case 6 : $item['cat_title'] = "Công nghệ";
                        break;
                    default : $item['cat_title'] = "None";
                }

                $item['url_edit'] = "?mod=posts&action=editPost&id={$item['id']}";
                $item['url_move_trash'] = "?mod=posts&action=moveTrash&id={$item['id']}";
                $item['status_css'] = set_css_by_status($item['status_css']);
                $item['url_approve'] = "?mod=posts&action=approvePost&id={$item['id']}";
            }
            return $result;
        }
    }

    return false;
}

function check_role($username) {
    $result = db_fetch_row("SELECT * FROM `tbl_admin` WHERE `username` = '{$username}'");
    return $result['role'];
}
