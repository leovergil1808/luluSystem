<?php

# Function for Product

function add_product($data) {
    db_insert("tbl_product", $data);
}

function get_product_by_id($id) {
    $result = db_fetch_row("SELECT * FROM `tbl_product` WHERE `id`= '{$id}'");
    return $result;
}

function get_list_product($start, $num_per_page) {
    $result = db_fetch_array("SELECT * FROM `tbl_product` LIMIT {$start}, {$num_per_page}");
    if (!empty($result)) {
        foreach ($result as &$item) {
            switch ($item['tracking']) {
                case 1 : $item['tracking'] = "Stocking";
                    $item['tracking_css'] = 1;
                    break;
                case 2 : $item['tracking'] = "Out of Stock";
                    $item['tracking_css'] = 2;
                    break;
                case 3 : $item['tracking'] = "Temporary Out";
                    $item['tracking_css'] = 3;
                    break;
                case 4 : $item['tracking'] = "Importing goods";
                    $item['tracking_css'] = 4;
                    break;
                default : $item['tracking'] = "Checking";
            }
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
            switch ($item['cat_id']) {
                case 1 : $item['cat_title'] = "Điện thoại";
                    break;
                case 2 : $item['cat_title'] = "Máy tính bảng";
                    break;
                case 3 : $item['cat_title'] = "Laptop";
                    break;
                case 4 : $item['cat_title'] = "Tai nghe";
                    break;
                case 5 : $item['cat_title'] = "Thời trang";
                    break;
                case 6 : $item['cat_title'] = "Đồ gia dụng";
                    break;
                case 7 : $item['cat_title'] = "Thiết bị văn phòng";
                    break;
                default : $item['cat_title'] = "None";
            }
            $item['url_edit'] = "?mod=products&controller=index&action=editProduct&id={$item['id']}";
            $item['url_move_trash'] = "?mod=products&controller=index&action=moveTrash&id={$item['id']}";
            $item['url_approve'] = "?mod=products&controller=index&action=approveProduct&id={$item['id']}";
            $item['status_css'] = set_css_by_status($item['status_css']);
            $item['tracking_css'] = set_css_by_tracking($item['tracking_css']);
        }
        return $result;
    }
}

function approve_product($data, $id) {
    $check = db_update("tbl_product", $data, "`id` = $id");
    if ($check) {
        return true;
    }
    return false;
}

function edit_product($data, $id) {
    db_update("tbl_product", $data, "`id` = {$id}");
}

function delete_product($id) {
    db_delete("tbl_product", "`id` = {$id}");
}

function get_waiting_product($start, $num_per_page) {
    $result = db_fetch_array("SELECT * FROM `tbl_product` WHERE `status` = '0' LIMIT {$start} , {$num_per_page}");
    if (!empty($result)) {
        foreach ($result as &$item) {
            switch ($item['tracking']) {
                case 1 : $item['tracking'] = "Stocking";
                    $item['tracking_css'] = 1;
                    break;
                case 2 : $item['tracking'] = "Out of Stock";
                    $item['tracking_css'] = 2;
                    break;
                case 3 : $item['tracking'] = "Temporary Out";
                    $item['tracking_css'] = 3;
                    break;
                case 4 : $item['tracking'] = "Importing goods";
                    $item['tracking_css'] = 4;
                    break;
                default : $item['tracking'] = "Checking";
            }
            switch ($item['cat_id']) {
                case 1 : $item['cat_title'] = "Điện thoại";
                    break;
                case 2 : $item['cat_title'] = "Máy tính bảng";
                    break;
                case 3 : $item['cat_title'] = "Laptop";
                    break;
                case 4 : $item['cat_title'] = "Tai nghe";
                    break;
                case 5 : $item['cat_title'] = "Thời trang";
                    break;
                case 6 : $item['cat_title'] = "Đồ gia dụng";
                    break;
                case 7 : $item['cat_title'] = "Thiết bị văn phòng";
                    break;
                default : $item['cat_title'] = "None";
            }
            $item['url_edit'] = "?mod=products&controller=index&action=editProduct&id={$item['id']}";
            $item['url_move_trash'] = "?mod=products&controller=index&action=moveTrash&id={$item['id']}";
            $item['url_approve'] = "?mod=products&controller=index&action=approveProduct&id={$item['id']}";
            $item['tracking_css'] = set_css_by_tracking($item['tracking_css']);
        }
        return $result;
    }
}

function get_approved_product($start, $num_per_page) {
    $result = db_fetch_array("SELECT * FROM `tbl_product` WHERE `status` = '1' LIMIT {$start} , {$num_per_page}");
    if (!empty($result)) {
        foreach ($result as &$item) {
            switch ($item['tracking']) {
                case 1 : $item['tracking'] = "Stocking";
                    $item['tracking_css'] = 1;
                    break;
                case 2 : $item['tracking'] = "Out of Stock";
                    $item['tracking_css'] = 2;
                    break;
                case 3 : $item['tracking'] = "Temporary Out";
                    $item['tracking_css'] = 3;
                    break;
                case 4 : $item['tracking'] = "Importing goods";
                    $item['tracking_css'] = 4;
                    break;
                default : $item['tracking'] = "Checking";
                    $item['tracking_css'] = 5;
            }
            switch ($item['cat_id']) {
                case 1 : $item['cat_id'] = "Điện thoại";
                    break;
                case 2 : $item['cat_id'] = "Máy tính bảng";
                    break;
                case 3 : $item['cat_id'] = "Laptop";
                    break;
                case 4 : $item['cat_id'] = "Tai nghe";
                    break;
                case 5 : $item['cat_id'] = "Thời trang";
                    break;
                case 6 : $item['cat_id'] = "Đồ gia dụng";
                    break;
                case 7 : $item['cat_id'] = "Thiết bị văn phòng";
                    break;
                default : $item['cat_id'] = "None";
            }
            $item['url_edit'] = "?mod=products&controller=index&action=editProduct&id={$item['id']}";
            $item['url_move_trash'] = "?mod=products&controller=index&action=moveTrash&id={$item['id']}";
            $item['tracking_css'] = set_css_by_tracking($item['tracking_css']);
        }
        return $result;
    }
}

function get_trash_product($start, $num_per_page) {
    $result = db_fetch_array("SELECT * FROM `tbl_product` WHERE `status` = '2' LIMIT {$start} , {$num_per_page}");
    if (!empty($result)) {
        foreach ($result as &$item) {
            switch ($item['tracking']) {
                case 1 : $item['tracking'] = "Stocking";
                    $item['tracking_css'] = 1;
                    break;
                case 2 : $item['tracking'] = "Out of Stock";
                    $item['tracking_css'] = 2;
                    break;
                case 3 : $item['tracking'] = "Temporary Out";
                    $item['tracking_css'] = 3;
                    break;
                case 4 : $item['tracking'] = "Importing goods";
                    $item['tracking_css'] = 4;
                    break;
                default : $item['tracking'] = "Checking";
            }
            switch ($item['cat_id']) {
                case 1 : $item['cat_id'] = "Điện thoại";
                    break;
                case 2 : $item['cat_id'] = "Máy tính bảng";
                    break;
                case 3 : $item['cat_id'] = "Laptop";
                    break;
                case 4 : $item['cat_id'] = "Tai nghe";
                    break;
                case 5 : $item['cat_id'] = "Thời trang";
                    break;
                case 6 : $item['cat_id'] = "Đồ gia dụng";
                    break;
                case 7 : $item['cat_id'] = "Thiết bị văn phòng";
                    break;
                default : $item['cat_id'] = "None";
            }
            $item['url_edit'] = "?mod=products&controller=index&action=editProduct&id={$item['id']}";
            $item['url_move_trash'] = "?mod=products&controller=index&action=moveTrash&id={$item['id']}";
            $item['url_restore'] = "?mod=products&controller=index&action=restoreProduct&id={$item['id']}";
            $item['url_delete'] = "?mod=products&controller=index&action=deleteProduct&id={$item['id']}";
            $item['tracking_css'] = set_css_by_tracking($item['tracking_css']);
        }
        return $result;
    }
}

# Function for Product category

function get_list_product_cat($cat_id = '') {
    if (empty($cat_id)) {
        $result = db_fetch_array("SELECT * FROM `tbl_product_cat`");
        if (!empty($result)) {
            foreach ($result as &$item) {
                $item['url_edit'] = "?mod=products&action=editProductCat&cat_id={$item['cat_id']}";
                $item['url_delete'] = "?mod=products&action=deleteProductCat&cat_id={$item['cat_id']}";
            }
            return $result;
        }
    } else {
        $result = db_fetch_row("SELECT * FROM `tbl_product_cat` WHERE `cat_id` = {$cat_id}");
        if (!empty($result)) {
            return $result;
        }
    }
}

function get_list_product_cat_limit($start, $num_per_page) {
    $result = db_fetch_array("SELECT * FROM `tbl_product_cat` LIMIT {$start},{$num_per_page}");
    if (!empty($result)) {
        foreach ($result as &$item) {
            $item['url_edit'] = "?mod=products&action=editProductCat&cat_id={$item['cat_id']}";
            $item['url_delete'] = "?mod=products&action=deleteProductCat&cat_id={$item['cat_id']}";
        }
        return $result;
    }
}

function add_product_cat($data) {
    $check = db_insert("tbl_product_cat", $data);
    if ($check) {
        return true;
    }
    return false;
}

function edit_product_cat($data, $cat_id) {
    $check = db_update("tbl_product_cat", $data, "`cat_id` = {$cat_id}");
    if ($check) {
        return true;
    }
    return false;
}

function delete_product_cat($cat_id) {
    $check = db_delete("tbl_product_cat", "`cat_id` = {$cat_id}");

    if ($check) {
        return true;
    }
    return false;
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

function search_item($table, $search_by = '', $s, $start, $num_per_page) {

    if (!empty($s)) {
        $result = db_fetch_array("SELECT * FROM `{$table}` WHERE {$search_by} LIKE '%{$s}%' LIMIT {$start} , {$num_per_page}");
        if (!empty($result)) {
            foreach ($result as &$item) {
                switch ($item['tracking']) {
                    case 1 : $item['tracking'] = "Stocking";
                        $item['tracking_css'] = 1;
                        break;
                    case 2 : $item['tracking'] = "Out of Stock";
                        $item['tracking_css'] = 2;
                        break;
                    case 3 : $item['tracking'] = "Temporary Out";
                        $item['tracking_css'] = 3;
                        break;
                    case 4 : $item['tracking'] = "Importing goods";
                        $item['tracking_css'] = 4;
                        break;
                    default : $item['tracking'] = "Checking";
                }
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
                switch ($item['cat_id']) {
                    case 1 : $item['cat_title'] = "Điện thoại";
                        break;
                    case 2 : $item['cat_title'] = "Máy tính bảng";
                        break;
                    case 3 : $item['cat_title'] = "Laptop";
                        break;
                    case 4 : $item['cat_title'] = "Tai nghe";
                        break;
                    case 5 : $item['cat_title'] = "Thời trang";
                        break;
                    case 6 : $item['cat_title'] = "Đồ gia dụng";
                        break;
                    case 7 : $item['cat_title'] = "Thiết bị văn phòng";
                        break;
                    default : $item['cat_title'] = "None";
                }

                $item['url_edit'] = "?mod=products&controller=index&action=editProduct&id={$item['id']}";
                $item['url_move_trash'] = "?mod=products&controller=index&action=moveTrash&id={$item['id']}";
                $item['status_css'] = set_css_by_status($item['status_css']);
                $item['tracking_css'] = set_css_by_tracking($item['tracking_css']);
                $item['url_approve'] = "?mod=products&controller=index&action=approveProduct&id={$item['id']}";
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
