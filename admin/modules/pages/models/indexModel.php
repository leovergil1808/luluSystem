<?php

# Function for Page

function add_page($data) {
    db_insert("tbl_page", $data);
}

function get_page_by_id($id) {
    $result = db_fetch_row("SELECT * FROM `tbl_page` WHERE `id` = '{$id}'");
    if (!empty($result)) {
        $result['url_edit'] = "?mod=pages&controller=index&action=editPage&id={$result['id']}";
        $result['url_move_trash'] = "?mod=pages&controller=index&action=moveTrash&id={$result['id']}";
        return $result;
    }
    return false;
}

function get_list_page($start, $num_per_page) {
    $result = db_fetch_array("SELECT * FROM `tbl_page` WHERE `page_status` != 'trash' LIMIT {$start}, {$num_per_page}");
    if (!empty($result)) {
        foreach ($result as &$item) {
            switch ($item['page_status']) {
                case 0 : $item['page_status'] = "Waiting";
                    $item['status_css'] = 0;
                    break;
                case 1 : $item['page_status'] = "Approved";
                    $item['status_css'] = 1;
                    break;
                case 2 : $item['page_status'] = "Trash";
                    $item['status_css'] = 2;
                    break;
            }
            $item['url_edit'] = "?mod=pages&controller=index&action=editPage&id={$item['id']}";
            $item['url_move_trash'] = "?mod=pages&controller=index&action=moveTrash&id={$item['id']}";
            $item['status_css'] = set_css_by_status($item['status_css']);
        }
        return $result;
    }
    return false;
}

function edit_page($data, $id) {
    db_update("tbl_page", $data, "`id` = {$id}");
}

function delete_page($id) {
    db_delete("tbl_page", "`id` = {$id}");
}

function approve_page($data, $id) {
    $check = db_update("tbl_page", $data, "`id` = $id");
    if ($check)
        return true;
    return false;
}

function get_waiting_page($start, $num_per_page) {
    $result = db_fetch_array("SELECT * FROM `tbl_page` WHERE `page_status` = '0' LIMIT {$start}, {$num_per_page}");
    if ($result > 0) {
        foreach ($result as &$item) {
            switch ($item['page_status']) {
                case 0 : $item['page_status'] = "Waiting";
                    $item['status_css'] = 0;
                    break;
                case 1 : $item['page_status'] = "Approved";
                    $item['status_css'] = 1;
                    break;
                case 2 : $item['page_status'] = "Trash";
                    $item['status_css'] = 2;
                    break;
            }
            $item['url_edit'] = "?mod=pages&controller=index&action=editPage&id={$item['id']}";
            $item['url_move_trash'] = "?mod=pages&controller=index&action=moveTrash&id={$item['id']}";
            $item['url_approve'] = "?mod=pages&controller=index&action=approvePage&id={$item['id']}";
        }
        return $result;
    }
}

function get_approved_page($start, $num_per_page) {
    $result = db_fetch_array("SELECT * FROM `tbl_page` WHERE `page_status` = '1' LIMIT {$start}, {$num_per_page}");
    if (!empty($result)) {
        foreach ($result as &$item) {
            switch ($item['page_status']) {
                case 0 : $item['page_status'] = "Waiting";
                    $item['status_css'] = 0;
                    break;
                case 1 : $item['page_status'] = "Approved";
                    $item['status_css'] = 1;
                    break;
                case 2 : $item['page_status'] = "Trash";
                    $item['status_css'] = 2;
                    break;
            }
            $item['url_edit'] = "?mod=pages&controller=index&action=editPage&id={$item['id']}";
            $item['url_move_trash'] = "?mod=pages&controller=index&action=moveTrash&id={$item['id']}";
        }
        return $result;
    }
}

function get_trash_page($start, $num_per_page) {
    $result = db_fetch_array("SELECT * FROM `tbl_page` WHERE `page_status` = '2' LIMIT {$start}, {$num_per_page}");
    if ($result > 0) {
        foreach ($result as &$item) {
            switch ($item['page_status']) {
                case 0 : $item['page_status'] = "Waiting";
                    $item['status_css'] = 0;
                    break;
                case 1 : $item['page_status'] = "Approved";
                    $item['status_css'] = 1;
                    break;
                case 2 : $item['page_status'] = "Trash";
                    $item['status_css'] = 2;
                    break;
            }
            $item['url_edit'] = "?mod=pages&controller=index&action=editPage&id={$item['id']}";
            $item['url_move_trash'] = "?mod=pages&controller=index&action=moveTrash&id={$item['id']}";
            $item['url_restore'] = "?mod=pages&controller=index&action=restorePage&id={$item['id']}";
            $item['url_delete'] = "?mod=pages&controller=index&action=deletePage&id={$item['id']}";
        }
        return $result;
    }
}

# Function global for all

function get_admin_info($username) {
    $result = db_fetch_row("SELECT * FROM `tbl_admin` WHERE `username` = '{$username}'");
    return $result['fullname'];
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

function get_url_upload_image($id) {
    $result = db_fetch_row("SELECT * FROM `tbl_page` WHERE `id` = {$id}");
    return $result['page_thumbnail'];
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
                switch ($item['page_status']) {
                    case 0 : $item['page_status'] = "Waiting";
                        $item['status_css'] = 0;
                        break;
                    case 1 : $item['page_status'] = "Approved";
                        $item['status_css'] = 1;
                        break;
                    case 2 : $item['page_status'] = "Trash";
                        $item['status_css'] = 2;
                        break;
                }

                $item['url_edit'] = "?mod=pages&action=editPage&id={$item['id']}";
                $item['url_move_trash'] = "?mod=pages&action=moveTrash&id={$item['id']}";
                $item['status_css'] = set_css_by_status($item['status_css']);
                $item['url_approve'] = "?mod=pages&action=approvePage&id={$item['id']}";
            }
            return $result;
        }
    }

    return false;
}
