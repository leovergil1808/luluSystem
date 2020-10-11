<?php

function construct() {
    load('lib', 'validation');
    load_model('index');
    load('helper', 'css');
}

# Function for Transaction - Order
// 1. Control the Transaction

function indexAction() {
    load('helper', 'format');
    load('lib', 'pagging');

    if (isset($_GET['sm_s']) && !empty($_GET['s'])) {

        # Search Engine
        $s = $_GET['s'];

        $mod = $_GET['mod'];

        # Calc Pagination
        $num_per_page = 10;
        $data['s'] = $s;

        $num_rows = get_num_rows("tbl_transaction", "`username` LIKE '%{$s}%'");

        if (!empty($num_rows)) {
            $data['num_rows'] = $num_rows;
            $data['num_page'] = ceil($data['num_rows'] / $num_per_page);
            $data['page'] = isset($_GET['page']) ? (int) $_GET['page'] : 1;
            $start = ($data['page'] - 1) * $num_per_page;

            $data['s'] = $s;
            $data['search_by'] = 'username';

            $data['list_transaction'] = search_item("tbl_transaction", 'username', $s, $start, $num_per_page);
        } else {

            $data['num_rows'] = get_num_rows("tbl_transaction", "`transaction_code` LIKE '%{$s}%'");
            $data['num_page'] = ceil($data['num_rows'] / $num_per_page);
            $data['page'] = isset($_GET['page']) ? (int) $_GET['page'] : 1;
            $start = ($data['page'] - 1) * $num_per_page;

            $data['s'] = $s;
            $data['search_by'] = 'transaction_code';

            $data['list_transaction'] = search_item("tbl_transaction", 'transaction_code', $s, $start, $num_per_page);
        }
        if (isset($_POST['sm_action'])) {
            if (!empty($_POST['checkItem'])) {
                # Checkbox = 1 : Confirm, Checkbox = 2 : Edit, Checkbox = 3 : Finish 
                if ($_POST['actions'] == 1) {
                    foreach ($_POST['checkItem'] as $item) {
                        $id = $item;
                        $transaction = get_transaction($id);
                        $transaction_code = $transaction['transaction_code'];
                        isset($_GET['page']) ? $page = "&page={$_GET['page']}" : null;

                        if (!empty($transaction) && $transaction['status'] != 1) {
                            $approver = get_admin_info($_SESSION['user_login']);
                            $approval_date = time();
                            $data = array(
                                'approver' => $approver,
                                'approval_date' => $approval_date,
                                'status' => '1',
                            );
                            edit_transaction($data, $transaction_code);
                            redirect("?mod=customers&action=index&s={$s}&sm_s=Tìm+kiếm{$page}");
                        }
                    }
                } elseif ($_POST['actions'] == 2) {
                    foreach ($_POST['checkItem'] as $item) {
                        $id = $item;
                        $transaction = get_transaction($id);
                        $transaction_code = $transaction['transaction_code'];
                        isset($_GET['page']) ? $page = "&page={$_GET['page']}" : null;

                        if (!empty($transaction) && $transaction['status'] != 0) {
                            $editor = get_admin_info($_SESSION['user_login']);
                            $edit_date = time();
                            $data = array(
                                'editor' => $editor,
                                'edit_date' => $edit_date,
                                'status' => '0',
                            );
                            edit_transaction($data, $transaction_code);
                            redirect("?mod=customers&action=index&s={$s}&sm_s=Tìm+kiếm{$page}");
                        }
                    }
                } elseif ($_POST['actions'] == 3) {
                    foreach ($_POST['checkItem'] as $item) {
                        $id = $item;
                        $transaction = get_transaction($id);
                        $transaction_code = $transaction['transaction_code'];
                        isset($_GET['page']) ? $page = "&page={$_GET['page']}" : null;

                        if (!empty($transaction) && $transaction['status'] != 2) {
                            $checker = get_admin_info($_SESSION['user_login']);
                            $checked_date = time();
                            $data = array(
                                'checker' => $checker,
                                'checked_date' => $checked_date,
                                'status' => '2',
                            );
                            edit_transaction($data, $transaction_code);
                            redirect("?mod=customers&action=index&s={$s}&sm_s=Tìm+kiếm{$page}");
                        }
                    }
                }
            }
        }

        load_view('showSearchTransaction', $data);
    } else {
        $data['num_rows'] = get_num_rows("tbl_transaction");

        $data['num_rows_delivering'] = get_num_rows("tbl_transaction", "`status` = '1'");
        $data['num_rows_waiting'] = get_num_rows("tbl_transaction", "`status` = '0'");
        $data['num_rows_delivered'] = get_num_rows("tbl_transaction", "`status` = '2'");

        $num_per_page = 5;
        $data['num_page'] = ceil($data['num_rows'] / $num_per_page);

        $data['page'] = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $start = ($data['page'] - 1) * $num_per_page;

        $data['list_transaction'] = get_list_transaction($start, $num_per_page);

        if (isset($_POST['sm_action'])) {
            if (!empty($_POST['checkItem'])) {
                # Checkbox = 1 : Confirm, Checkbox = 2 : Edit, Checkbox = 3 : Finish 
                if ($_POST['actions'] == 1) {
                    foreach ($_POST['checkItem'] as $item) {
                        $id = $item;
                        $transaction = get_transaction($id);
                        $transaction_code = $transaction['transaction_code'];

                        if (!empty($transaction) && $transaction['status'] != 1) {
                            $approver = get_admin_info($_SESSION['user_login']);
                            $approval_date = time();
                            $data = array(
                                'approver' => $approver,
                                'approval_date' => $approval_date,
                                'status' => '1',
                            );
                            edit_transaction($data, $transaction_code);
                            redirect("?mod=customers&action=index");
                        }
                    }
                } elseif ($_POST['actions'] == 2) {
                    foreach ($_POST['checkItem'] as $item) {
                        $id = $item;
                        $transaction = get_transaction($id);
                        $transaction_code = $transaction['transaction_code'];

                        if (!empty($transaction) && $transaction['status'] != 0) {
                            $editor = get_admin_info($_SESSION['user_login']);
                            $edit_date = time();
                            $data = array(
                                'editor' => $editor,
                                'edit_date' => $edit_date,
                                'status' => '0',
                            );
                            edit_transaction($data, $transaction_code);
                            redirect("?mod=customers&action=index");
                        }
                    }
                } elseif ($_POST['actions'] == 3) {
                    foreach ($_POST['checkItem'] as $item) {
                        $id = $item;
                        $transaction = get_transaction($id);
                        $transaction_code = $transaction['transaction_code'];

                        if (!empty($transaction) && $transaction['status'] != 2) {
                            $checker = get_admin_info($_SESSION['user_login']);
                            $checked_date = time();
                            $data = array(
                                'checker' => $checker,
                                'checked_date' => $checked_date,
                                'status' => '2',
                            );
                            edit_transaction($data, $transaction_code);
                            redirect("?mod=customers&action=index");
                        }
                    }
                }
            }
        }

        load_view('index', $data);
    }
}

function detailOrderAction() {
    load('helper', 'format');

    $transaction_code = $_GET['transaction'];

    $data['transaction_info'] = get_transaction_info($transaction_code);
    $data['list_order_product'] = get_list_order_product($transaction_code);

    if (isset($_POST['sm_status']) && $_POST['status'] != 'none') {
        $status = $_POST['status'];
        $data = array(
            'status' => $status,
        );
        update_transaction($data, $transaction_code);
        redirect("?mod=customers&action=detailOrder&transaction={$transaction_code}");
    }

    load_view('detailOrder', $data);
}

function editTransactionAction() {

    $transaction_code = $_GET['transaction'];

    $transaction_info = get_transaction_info($transaction_code);
    $data['transaction_info'] = $transaction_info;

    if (isset($_POST['btn-submit'])) {
        $error = array();

        if (empty($_POST['fullname'])) {
            $fullname = $transaction_info['fullname'];
        } else {
            $fullname = $_POST['fullname'];
        }

        if (empty($_POST['address'])) {
            $address = $transaction_info['address'];
        } else {
            $address = $_POST['address'];
        }

        if (empty($error)) {
            $editor = get_admin_info($_SESSION['user_login']);
            $edit_date = time();
            $data = array(
                'fullname' => $fullname,
                'address' => $address,
                'editor' => $editor,
                'edit_date' => $edit_date
            );
            edit_transaction($data, $transaction_code);
            redirect("?mod=customers&action=index");
        }
    }
    load_view('editTransaction', $data);
}

function deleteTransactionAction() {
    $transaction_code = $_GET['transaction'];

    $transaction_info = get_transaction_info($transaction_code);
    $list_order_product = get_list_order_product($transaction_code);

    if (!empty($transaction_info)) {
        delete_transaction($transaction_code);
        delete_order_product($transaction_code);
        redirect("?mod=customers&action=index");
    } else {
        echo "Lỗi";
    }
}

// 2. Show the Transaction
function showWaitingAction() {
    load('helper', 'format');
    load('lib', 'pagging');

    $data['num_rows'] = get_num_rows("tbl_transaction");

    $data['num_rows_delivering'] = get_num_rows("tbl_transaction", "`status` = '1'");
    $data['num_rows_waiting'] = get_num_rows("tbl_transaction", "`status` = '0'");
    $data['num_rows_delivered'] = get_num_rows("tbl_transaction", "`status` = '2'");

    $num_per_page = 5;
    $data['num_page'] = ceil($data['num_rows_waiting'] / $num_per_page);
    $data['page'] = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $start = ($data['page'] - 1) * $num_per_page;

    $data['list_transaction'] = get_waiting_transaction($start, $num_per_page);

    if (isset($_POST['sm_action'])) {
        if (!empty($_POST['checkItem'])) {
            # Checkbox = 1 : Confirm, Checkbox = 2 : Edit, Checkbox = 3 : Finish 
            if ($_POST['actions'] == 1) {
                foreach ($_POST['checkItem'] as $item) {
                    $id = $item;
                    $transaction = get_transaction($id);
                    $transaction_code = $transaction['transaction_code'];

                    if (!empty($transaction) && $transaction['status'] != 1) {
                        $approver = get_admin_info($_SESSION['user_login']);
                        $approval_date = time();
                        $data = array(
                            'approver' => $approver,
                            'approval_date' => $approval_date,
                            'status' => '1',
                        );
                        edit_transaction($data, $transaction_code);
                        redirect("?mod=customers&action=showWaiting");
                    }
                }
            }
        }
    }

    load_view('showWaiting', $data);
}

function showDeliveringAction() {
    load('helper', 'format');
    load('lib', 'pagging');

    $data['num_rows'] = get_num_rows("tbl_transaction");

    $data['num_rows_delivering'] = get_num_rows("tbl_transaction", "`status` = '1'");
    $data['num_rows_waiting'] = get_num_rows("tbl_transaction", "`status` = '0'");
    $data['num_rows_delivered'] = get_num_rows("tbl_transaction", "`status` = '2'");

    $num_per_page = 5;
    $data['num_page'] = ceil($data['num_rows_delivered'] / $num_per_page);
    $data['page'] = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $start = ($data['page'] - 1) * $num_per_page;

    $data['list_transaction'] = get_delivering_transaction($start, $num_per_page);

    if (isset($_POST['sm_action'])) {
        if (!empty($_POST['checkItem'])) {
            # Checkbox = 1 : Confirm, Checkbox = 2 : Edit, Checkbox = 3 : Finish 

            if ($_POST['actions'] == 2) {
                foreach ($_POST['checkItem'] as $item) {
                    $id = $item;
                    $transaction = get_transaction($id);
                    $transaction_code = $transaction['transaction_code'];

                    if (!empty($transaction) && $transaction['status'] != 0) {
                        $editor = get_admin_info($_SESSION['user_login']);
                        $edit_date = time();
                        $data = array(
                            'editor' => $editor,
                            'edit_date' => $edit_date,
                            'status' => '0',
                        );
                        edit_transaction($data, $transaction_code);
                        redirect("?mod=customers&action=showDelivering");
                    }
                }
            } elseif ($_POST['actions'] == 3) {
                foreach ($_POST['checkItem'] as $item) {
                    $id = $item;
                    $transaction = get_transaction($id);
                    $transaction_code = $transaction['transaction_code'];

                    if (!empty($transaction) && $transaction['status'] != 2) {
                        $checker = get_admin_info($_SESSION['user_login']);
                        $checked_date = time();
                        $data = array(
                            'checker' => $checker,
                            'checked_date' => $checked_date,
                            'status' => '2',
                        );
                        edit_transaction($data, $transaction_code);
                        redirect("?mod=customers&action=showDelivering");
                    }
                }
            }
        }
    }

    load_view('showDelivering', $data);
}

function showDeliveredAction() {
    load('helper', 'format');
    load('lib', 'pagging');

    $data['num_rows'] = get_num_rows("tbl_transaction");

    $data['num_rows_delivering'] = get_num_rows("tbl_transaction", "`status` = '1'");
    $data['num_rows_waiting'] = get_num_rows("tbl_transaction", "`status` = '0'");
    $data['num_rows_delivered'] = get_num_rows("tbl_transaction", "`status` = '2'");

    $num_per_page = 5;
    $data['num_page'] = ceil($data['num_rows_delivered'] / $num_per_page);
    $data['page'] = isset($_GET['page']) ? $_GET['page'] : 1;
    $start = ($data['page'] - 1) * $num_per_page;

    $data['list_transaction'] = get_delivered_transaction($start, $num_per_page);


    load_view('showDelivered', $data);
}

# Function for Customer

function listCustomerAction() {
    load('lib', 'pagging');
    load('helper', 'format');

    $num_per_page = 10;
    $data['num_rows'] = get_num_rows("tbl_user");
    $data['num_page'] = ceil($data['num_rows'] / $num_per_page);
    $data['page'] = isset($_GET['page']) ? $_GET['page'] : 1;
    $start = ($data['page'] - 1) * $num_per_page;

    $data['list_customer'] = get_list_customer($start, $num_per_page);

    load_view('listCustomer', $data);
}

function editUserAction() {

    global $error;
    $id = (int) $_GET['id'];

    $user = get_user_by_id($id);
    $data['user'] = $user;

    $fullname = $user['fullname'];
    $tel = $tel = $_POST['tel'];
    $address = $user['address'];

    if (isset($_POST['btn-submit'])) {

        $error = array();

        if (empty($_POST['fullname'])) {
            $error['fullname'] = "Phải nhập Họ và tên";
        } else {
            $fullname = $_POST['fullname'];
        }

        if (empty($_POST['tel'])) {
            $error['tel'] = "Phải nhập sdt";
        } else {
            $tel = $_POST['tel'];
        }

        if (empty($_POST['address'])) {
            $error['address'] = "Phải địa chỉ";
        } else {
            $address = $_POST['address'];
        }

        if (empty($error)) {
            $data = array(
                'fullname' => $fullname,
                'tel' => $tel,
                'address' => $address
            );

            if (edit_user($data, $id)) {
                redirect("?mod=customers&action=listCustomer");
            };
        }
    }

    load_view('editUser', $data);
}

function deleteUserAction() {

    $id = $_GET['id'];

    if (delete_user($id)) {
        redirect("?mod=customers&action=listCustomer");
    }
}
