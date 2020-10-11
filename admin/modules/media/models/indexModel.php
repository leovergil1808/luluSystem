<?php

# Function for Media

function add_media($data) {
    db_insert("tbl_media", $data);
}

function get_list_media($start, $num_per_page) {
    $result = db_fetch_array("SELECT * FROM `tbl_media` WHERE `status` = '0' LIMIT {$start} , {$num_per_page}");
    if (!empty($result)) {
        foreach ($result as &$item) {
            $item['url_edit'] = "?mod=media&action=edit&id={$item['id']}";
            $item['url_move_trash'] = "?mod=media&action=moveTrash&id={$item['id']}";
        }
        return $result;
    }

    return false;
}

function get_media_by_id($id) {
    $result = db_fetch_row("SELECT * FROM `tbl_media` WHERE `id` = '{$id}'");

    if (!empty($result)) {
        $result['url_edit'] = "?mod=posts&controller=index&action=editPost&id={$result['id']}";
        $result['url_move_trash'] = "?mod=posts&controller=index&action=moveTrash&id={$result['id']}";
        return $result;
    }
    return false;
}

function edit_media($data, $id) {
    $check = db_update("tbl_media", $data, "`id` = {$id}");
    if ($check)
        return true;

    return false;
}

function delete_media($id) {
    db_delete("tbl_media", "`id` = {$id}");
}

function get_trash_media($start, $num_per_page) {
    $result = db_fetch_array("SELECT * FROM `tbl_media` WHERE `status` = '1' LIMIT {$start}, {$num_per_page}");
    if (!empty($result)) {
        foreach ($result as &$item) {
            // $item['url_edit'] = "?mod=media&action=edit&id={$item['id']}";
            // $item['url_move_trash'] = "?mod=media&action=moveTrash&id={$item['id']}";
            $item['url_restore'] = "?mod=media&action=restore&id={$item['id']}";
            $item['url_delete'] = "?mod=media&action=delete&id={$item['id']}";
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
