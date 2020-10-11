<?php

function construct() {
    load('lib', 'validation');
    load_model('index');
}

function indexAction() {
    load('helper', 'format');
    $data['list_admin'] = get_list_user(1);
    $data['list_editor'] = get_list_user(2);
    $data['list_worker'] = get_list_user(3);
    $data['num_rows'] = get_num_rows('tbl_admin');
    

    load_view('teamIndex', $data);
}

function addAdminAction() {
    $role = check_role($_SESSION['user_login']);

    if (is_login() && $role == 1) {
        global $error, $username, $password, $email, $fullname, $tel, $address;

        if (isset($_POST['btn_reg_admin'])) {
            $error = array();

            if (empty($_POST['fullname'])) {
                $error['fullname'] = "Không được để trống fullname";
            } else {
                $fullname = $_POST['fullname'];
            }

            if (empty($_POST['username'])) {
                $error['username'] = "Không được để trống username";
            } else {
                if (!(strlen($_POST['username']) >= 6 && strlen($_POST['username']) <= 32)) {
                    $error['username'] = "Số lượng yêu cầu từ 6 đến 32 ký tự";
                } else {
                    $partten = "/^[A-Za-z0-9_\.]{6,32}$/";
                    if (!is_username($_POST['username'])) {
                        $error['username'] = "Username không đúng định dạng";
                    } else {
                        $username = $_POST['username'];
                    }
                }
            }

            if (empty($_POST['password'])) {
                $error['password'] = "Không được để trống password";
            } else {
                if (!(strlen($_POST['password']) >= 6 && strlen($_POST['password']) <= 32)) {
                    $error['password'] = "Số lượng yêu cầu từ 6 đến 32 ký tự";
                } else {
                    $partten = "/^([A-Z]){1}([\w_\.!@#$%^&*()]+){5,31}$/";
                    if (!is_password($_POST['password'])) {
                        $error['password'] = "Mật khẩu không đúng định dạng";
                    } else {
                        $password = md5($_POST['password']);
                    }
                }
            }

            if (empty($_POST['email'])) {
                $error['email'] = 'Không được để trống';
            } else {
                if (!is_email($_POST['email'])) {
                    $error['email'] = "Email không đúng định dạng";
                } else {
                    $email = $_POST['email'];
                }
            }

            if (empty($_POST['tel'])) {
                $error['tel'] = "Phải nhập số điện thoại";
            } else {
                if (!is_phone_number($_POST['tel'])) {
                    $error['tel'] = "Số điện thoại không hợp lệ";
                } else {
                    $tel = $_POST['tel'];
                }
            }

            if (empty($_POST['address'])) {
                $error['address'] = "Phải nhập địa chỉ";
            } else {
                $address = $_POST['address'];
            }


            if (empty($error)) {
                if (!admin_exists($username, $email)) {
                    $created_date = time();
                    // $active_token = md5($username.time());
                    // $subject = 'Kích hoạt tài khoản Admin';
                    $data = array(
                        'fullname' => $fullname,
                        'username' => $username,
                        'password' => $password,
                        'email' => $email,
                        'tel' => $tel,
                        'address' => $address,
                        'created_date' => $created_date,
                            // 'active_token' => $active_token, 
                    );
                    add_admin($data);

                    // $link_active = base_url("?mod=users&controller=index&action=active&active_token={$active_token}");
                    // $content = "<p>Click vào {$link_active} để chứng thực tài khoản người quản lý </p>";
                    // send_mail($email,$fullname,$subject,$content);

                    redirect("?mod=users&controller=team&action=index");
                } else {
                    $error['account'] = "Username hoặc email đã tồn tại ";
                }
            }
        }
        load_view('addAdmin');
    } else {
        redirect("?mod=users&controller=team&action=index");
    }
}

function showPermissionsAction() {

    $role = check_role($_SESSION['user_login']);

    if (is_login() && $role == 1) {
        $data['list_admin'] = get_list_user();
        $data['num_rows'] = get_num_rows("tbl_admin");

        if (isset($_POST['btn-submit'])) {
            $username = $_POST['username'];
            $update_role = $_POST['update_role'];
            $data = array(
                'role' => $update_role,
            );

            update_role($data, $username);
            redirect("?mod=users&controller=team&action=index");
        }
        load_view('showPermissions', $data);
    } else {
        redirect("?mod=users&controller=team&action=index");
    }
}