<?php

# Function for Slider

function add_slider($data) {
    db_insert("tbl_slider", $data);
}

function edit_slider($data, $id) {
    db_update("tbl_slider", $data, "`id` = {$id}");
}

function get_list_slider($start, $num_per_page) {
    $result = db_fetch_array("SELECT * FROM `tbl_slider` LIMIT {$start}, {$num_per_page}");
    if (!empty($result)) {
        foreach ($result as &$item) {
            switch ($item['status']) {
                case 0 : $item['status'] = "Waiting";
                    $item['status_css'] = 0;
                    break;
                case 1 : $item['status'] = "Approved";
                    $item['status_css'] = 1;
                    break;
                case 2 : $item['status'] = "Trash";
                    $item['status_css'] = 2;
                    break;
            }
            $item['url_edit'] = "?mod=slider&action=editSlider&id={$item['id']}";
            $item['url_move_trash'] = "?mod=slider&action=moveTrash&id={$item['id']}";
            $item['url_approve'] = "?mod=slider&action=approveSlider&id={$item['id']}";
            $item['status_css'] = set_css_by_status($item['status_css']);
        }
        return $result;
    }
}

function get_slider_by_id($id) {
    $result = db_fetch_row("SELECT * FROM `tbl_slider` WHERE `id`= '{$id}'");
    if (!empty($result))
        return $result;

    return false;
}

function approve_slider($data, $id) {
    $check = db_update("tbl_slider", $data, "`id` = $id");
    if ($check)
        return true;

    return false;
}

function delete_slider($id) {
    db_delete("tbl_slider", "`id` = {$id}");
}

# Function for Slider Thumbnail

function add_slider_thumbnail($data) {
    db_insert("tbl_slider_thumbnail", $data);
}

function edit_slider_thumbnail($data, $thumbnail) {
    db_update("tbl_slider_thumbnail", $data, "`thumbnail` = '{$thumbnail}'");
}

function get_list_slider_thumbnail($slider_code) {
    $result = db_fetch_array("SELECT `thumbnail` FROM `tbl_slider_thumbnail` WHERE `slider_code` = '{$slider_code}'");

    if (!empty($result))
        return $result;

    return false;
}

function delete_slider_thumbnail($thumbnail) {
    db_delete("tbl_slider_thumbnail", "`thumbnail` = '{$thumbnail}'");
}

# Function for show Slider

function get_waiting_slider($start, $num_per_page) {
    $result = db_fetch_array("SELECT * FROM `tbl_slider` WHERE `status` = '0' LIMIT {$start} , {$num_per_page}");
    if (!empty($result)) {
        foreach ($result as &$item) {
            $item['url_edit'] = "?mod=slider&action=editSlider&id={$item['id']}";
            $item['url_move_trash'] = "?mod=slider&action=moveTrash&id={$item['id']}";
            $item['url_approve'] = "?mod=slider&action=approveSlider&id={$item['id']}";
        }
        return $result;
    }
    return false;
}

function get_approved_slider($start, $num_per_page) {
    $result = db_fetch_array("SELECT * FROM `tbl_slider` WHERE `status` = '1' LIMIT {$start} , {$num_per_page}");
    if (!empty($result)) {
        foreach ($result as &$item) {
            $item['url_edit'] = "?mod=slider&action=editSlider&id={$item['id']}";
            $item['url_move_trash'] = "?mod=slider&action=moveTrash&id={$item['id']}";
        }
        return $result;
    }
    return false;
}

function get_trash_slider($start, $num_per_page) {
    $result = db_fetch_array("SELECT * FROM `tbl_slider` WHERE `status` = '2' LIMIT {$start} , {$num_per_page}");
    if (!empty($result)) {
        foreach ($result as &$item) {
            $item['url_restore'] = "?mod=slider&action=restoreSlider&id={$item['id']}";
            $item['url_delete'] = "?mod=slider&action=deleteSlider&id={$item['id']}";
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
    if ($check > 0)
        return true;
    return false;
}

function search_item($table, $search_by = '', $s, $start, $num_per_page) {

    if (!empty($s)) {
        $result = db_fetch_array("SELECT * FROM `{$table}` WHERE {$search_by} LIKE '%{$s}%' LIMIT {$start} , {$num_per_page}");
        if (!empty($result)) {
            foreach ($result as &$item) {
                switch ($item['status']) {
                    case 0 : $item['status'] = "Waiting";
                        $item['status_css'] = 0;
                        break;
                    case 1 : $item['status'] = "Approved";
                        $item['status_css'] = 1;
                        break;
                    case 2 : $item['status'] = "Trash";
                        $item['status_css'] = 2;
                        break;
                }

                $item['url_edit'] = "?mod=slider&action=editSlider&id={$item['id']}";
                $item['url_move_trash'] = "?mod=slider&action=moveTrash&id={$item['id']}";
                $item['status_css'] = set_css_by_status($item['status_css']);
                $item['url_approve'] = "?mod=products&controller=index&action=approveProduct&id={$item['id']}";
            }
            return $result;
        }
    }

    return false;
}