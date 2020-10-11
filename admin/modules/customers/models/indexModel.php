<?php

# Function for Order

function get_list_order_product($transaction_code) {

    $list_order_product = array();

    $transaction_order = db_fetch_array("SELECT * FROM `tbl_order` WHERE `transaction_code` = '{$transaction_code}'");

    foreach ($transaction_order as $item) {
        $id = $item['product_id'];
        $list_order_product[] = array(
            'detail' => db_fetch_row("SELECT * FROM `tbl_product` WHERE `id` = '{$id}'"),
            'quantity' => $item['quantity'],
            'sub_total' => $item['sub_total'],
        );
    }
    return $list_order_product;
}

function delete_order_product($transaction_code) {
    db_delete("tbl_order", "`transaction_code` = {$transaction_code}");
}

# Function for Transaction

function get_list_transaction($start, $num_per_page) {
    $result = db_fetch_array("SELECT * FROM `tbl_transaction` LIMIT {$start} , {$num_per_page}");
    if (!empty($result)) {
        foreach ($result as &$item) {
            switch ($item['status']) {
                case 0 : $item['status'] = "Đang chờ";
                    $item['status_css'] = 0;
                    break;
                case 1 : $item['status'] = "Đang chuyển";
                    $item['status_css'] = 1;
                    break;
                case 2 : $item['status'] = "Đã chuyển";
                    $item['status_css'] = 2;
                    break;
            }
            $item['url_edit'] = "?mod=customers&action=editTransaction&transaction={$item['transaction_code']}";
            $item['url_delete'] = "?mod=customers&action=deleteTransaction&transaction={$item['transaction_code']}";
            $item['url_detail'] = "?mod=customers&action=detailOrder&transaction={$item['transaction_code']}";
            $item['status_css'] = set_css_by_status($item['status_css']);
        }
        return $result;
    }
    return false;
}

function get_transaction_info($transaction_code) {

    $result = db_fetch_row("SELECT * FROM `tbl_transaction` WHERE `transaction_code` = '{$transaction_code}'");
    if (!empty($result)) {
        switch ($result['status']) {
            case 0 : $result['status'] = "Đang chờ";
                break;
            case 1 : $result['status'] = "Đang chuyển";
                break;
            case 2 : $result['status'] = "Đã chuyển";
                break;
        }
        return $result;
    }
    return false;
}

function edit_transaction($data, $transaction_code) {
    db_update("tbl_transaction", $data, "`transaction_code` = {$transaction_code}");
}

function delete_transaction($transaction_code) {
    db_delete("tbl_transaction", "`transaction_code` = {$transaction_code}");
}

function update_transaction($data, $transaction_code) {
    db_update("tbl_transaction", $data, "`transaction_code` = '{$transaction_code}'");
}

function get_transaction($id) {
    $result = db_fetch_row("SELECT * FROM `tbl_transaction` WHERE `id` = '{$id}'");
    if (!empty($result))
        return $result;

    return false;
}

# Show the Transaction

function get_waiting_transaction($start, $num_per_page) {
    $result = db_fetch_array("SELECT * FROM `tbl_transaction` WHERE `status` = '0' LIMIT {$start} , {$num_per_page}");
    if (!empty($result)) {
        foreach ($result as &$item) {
            switch ($item['status']) {
                case 0 : $item['status'] = "Đang chờ";
                    break;
                case 1 : $item['status'] = "Đang chuyển";
                    break;
                case 2 : $item['status'] = "Đã chuyển";
                    break;
            }
            $item['url_edit'] = "?mod=customers&action=editTransaction&id={$item['id']}";
            $item['url_delete'] = "?mod=customers&action=editTransaction&id={$item['id']}";
            $item['url_detail'] = "?mod=customers&action=detailOrder&transaction={$item['transaction_code']}";
        }
        return $result;
    }
    return false;
}

function get_delivering_transaction($start, $num_per_page) {
    $result = db_fetch_array("SELECT * FROM `tbl_transaction` WHERE `status` = '1' LIMIT {$start} , {$num_per_page}");
    if (!empty($result)) {
        foreach ($result as &$item) {
            switch ($item['status']) {
                case 0 : $item['status'] = "Đang chờ";
                    break;
                case 1 : $item['status'] = "Đang chuyển";
                    break;
                case 2 : $item['status'] = "Đã chuyển";
                    break;
            }
            $item['url_edit'] = "?mod=customers&action=editTransaction&id={$item['id']}";
            $item['url_delete'] = "?mod=customers&action=editTransaction&id={$item['id']}";
            $item['url_detail'] = "?mod=customers&action=detailOrder&transaction={$item['transaction_code']}";
        }
        return $result;
    }
    return false;
}

function get_delivered_transaction($start, $num_per_page) {
    $result = db_fetch_array("SELECT * FROM `tbl_transaction` WHERE `status` = '2' LIMIT {$start} , {$num_per_page}");
    if (!empty($result)) {
        foreach ($result as &$item) {
            switch ($item['status']) {
                case 0 : $item['status'] = "Đang chờ";
                    break;
                case 1 : $item['status'] = "Đang chuyển";
                    break;
                case 2 : $item['status'] = "Đã chuyển";
                    break;
            }
            $item['url_edit'] = "?mod=customers&action=editTransaction&id={$item['id']}";
            $item['url_delete'] = "?mod=customers&action=editTransaction&id={$item['id']}";
            $item['url_detail'] = "?mod=customers&action=detailOrder&transaction={$item['transaction_code']}";
        }
        return $result;
    }
    return false;
}

# Function for Customers

function get_list_customer($start, $num_per_page) {
    $result = db_fetch_array("SELECT * FROM `tbl_user` LIMIT {$start}, {$num_per_page}");
    if (!empty($result)) {
        foreach ($result as &$user) {
            $user['url_edit'] = "?mod=customers&action=editUser&id={$user['id']}";
            $user['url_delete'] = "?mod=customers&action=deleteUser&id={$user['id']}";
        }
        return $result;
    };
    return false;
}

function get_user_by_id($id) {
    $result = db_fetch_row("SELECT * FROM `tbl_user` WHERE `id` = {$id}");
    if (!empty($result))
        return $result;
    return false;
}

function edit_user($data, $id) {
    $check = db_update("tbl_user", $data, "`id` = {$id}");
    if ($check)
        return true;
    return false;
}

function delete_user($id) {
    $check = db_delete("tbl_user", "`id` = {$id}");
    if ($check)
        return true;
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
                // switch ($item['tracking']) {
                //     case 1 : $item['tracking'] = "Stocking";
                //         $item['tracking_css'] = 1;
                //         break;
                //     case 2 : $item['tracking'] = "Out of Stock";
                //         $item['tracking_css'] = 2;
                //         break;
                //     case 3 : $item['tracking'] = "Temporary Out";
                //         $item['tracking_css'] = 3;
                //         break;
                //     case 4 : $item['tracking'] = "Importing goods";
                //         $item['tracking_css'] = 4;
                //         break;
                //     default : $item['tracking'] = "Checking";
                // }
                switch ($item['status']) {
                    case 0 : $item['status'] = "Đang chờ";
                        $item['status_css'] = 0;
                        break;
                    case 1 : $item['status'] = "Đang chuyển";
                        $item['status_css'] = 1;
                        break;
                    case 2 : $item['status'] = "Đã chuyển";
                        $item['status_css'] = 2;
                        break;
                }
                // switch ($item['cat_id']) {
                //     case 1 : $item['cat_title'] = "Điện thoại";
                //         break;
                //     case 2 : $item['cat_title'] = "Máy tính bảng";
                //         break;
                //     case 3 : $item['cat_title'] = "Laptop";
                //         break;
                //     case 4 : $item['cat_title'] = "Tai nghe";
                //         break;
                //     case 5 : $item['cat_title'] = "Thời trang";
                //         break;
                //     case 6 : $item['cat_title'] = "Đồ gia dụng";
                //         break;
                //     case 7 : $item['cat_title'] = "Thiết bị văn phòng";
                //         break;
                //     default : $item['cat_title'] = "None";
                // }

                $item['url_edit'] = "?mod=products&controller=index&action=editProduct&id={$item['id']}";
                $item['url_move_trash'] = "?mod=products&controller=index&action=moveTrash&id={$item['id']}";
                $item['status_css'] = set_css_by_status($item['status_css']);
                // $item['tracking_css'] = set_css_by_tracking($item['tracking_css']);
                $item['url_detail'] = "?mod=customers&action=detailOrder&transaction={$item['transaction_code']}";
                $item['url_approve'] = "?mod=products&controller=index&action=approveProduct&id={$item['id']}";
            }
            return $result;
        }
    }

    return false;
}
