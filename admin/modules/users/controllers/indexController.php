<?php

function construct() {
    load_model('index');
    load('lib', 'validation');
}

function indexAction() {
    $info_admin = get_admin(user_login());
    $data['info_admin'] = $info_admin;

    load_view('index', $data);
}

function loginAction() {
    // echo time();
    // echo date('d/m/y h:m:s');
    global $error, $username, $password;
    if (isset($_POST['btn_login'])) {
        $error = array();

        if (empty($_POST['username'])) {
            $error['username'] = "Không được để trống username";
        } else {
            if (!(strlen($_POST['username']) >= 6 && strlen($_POST['username']) <= 32)) {
                $error['username'] = "Số lượng yêu cầu từ 6 đến 32 ký tự";
            } else {
                if (!is_username($_POST['username'])) {
                    $error['username'] = "Username không đúng định dạng";
                } else {
                    $username = $_POST['username'];
                }
            }
        }

        if (empty($_POST['password'])) {
            $error['password'] = "Không được để trống password";
        } else {
            if (!(strlen($_POST['password']) >= 6 && strlen($_POST['password']) <= 32)) {
                $error['password'] = "Số lượng yêu cầu từ 6 đến 32 ký tự";
            } else {
                if (!is_password($_POST['password'])) {
                    $error['password'] = "Mật khẩu không đúng định dạng";
                } else {
                    $password = md5($_POST['password']);
                }
            }
        }
        # login processing
        if (empty($error)) {
            if (check_login($username, $password)) {
                # Set cookie
                if (isset($_POST['remember_me'])) {
                    setcookie('is_login', true, time() + 900);
                    setcookie('user_login', $username, time() + 900);
                }
                # Set session
                // $role = get_role();
                $_SESSION['is_login'] = true;
                $_SESSION['user_login'] = $username;

                redirect("?");
            } else {
                $error['account'] = "Tên đăng nhập hoặc mật khẩu không đúng";
            }
        }
    }
    load_view('login');
}

function logoutAction() {
    setcookie('is_login', true, time() - 900);
    setcookie('user_login', $username, time() - 900);
    unset($_SESSION['is_login']);
    unset($_SESSION['user_login']);
    redirect('?mod=users&controller=index&action=login');
}

function updateAction() {
    global $error, $tel, $address, $display_name;


    if (isset($_POST['btn-update'])) {
        $error = array();

        if (!empty($_POST['display-name'])) {
            $display_name = $_POST['display-name'];
        }

        if (!empty($_POST['tel'])) {
            if (!is_phone_number($_POST['tel'])) {
                $error['tel'] = "Số điện thoại không hợp lệ";
            } else {
                $tel = $_POST["tel"];
            }
        }

        if (!empty($_POST['address'])) {
            $address = $_POST['address'];
        }

        if (empty($error)) {
            $data = array(
                'display_name' => $display_name,
                'tel' => $tel,
                'address' => $address,
            );
            update_info_admin($data, user_login());
        }
    }

    $info_admin = get_admin(user_login());
    $data['info_admin'] = $info_admin;

    load_view('update', $data);
}

function changePassAction() {

    global $pass_old, $pass_new, $confirm_pass, $error;

    if (isset($_POST['btn-submit'])) {
        $error = array();

        if (empty($_POST['pass-old'])) {
            $error['pass_old'] = "Nhập mật khẩu cũ";
        } else {
            if (!is_password($_POST['pass-old'])) {
                $error['pass_old'] = "Mật khẩu không đúng định dạng";
            } else {
                if (!check_pass_old($_POST['pass-old'])) {
                    $error['pass_old'] = "Mật khẩu này không tồn tại";
                } else {
                    $pass_old = $_POST['pass-old'];
                }
            }
        }

        if (empty($_POST['pass-new'])) {
            $error['pass_new'] = "Nhập mật khẩu mới";
        } else {
            if (!is_password($_POST['pass-new'])) {
                $error['pass_new'] = "Mật khẩu không đúng định dạng";
            } else {
                $pass_new = $_POST['pass-new'];
            }
        }

        if (empty($_POST['confirm-pass'])) {
            $error['confirm_pass'] = "Nhập lại mật khẩu mới";
        } else {
            if (!is_password($_POST['confirm-pass'])) {
                $error['confirm_pass'] = "Mật khẩu không đúng định dạng";
            } else {
                $confirm_pass = $_POST['confirm-pass'];
            }
        }

        if ($pass_new != $confirm_pass) {
            $error['confirm_pass'] = "Mật khẩu xác nhận chưa trùng khớp";
        } else {
            $data['password'] = md5($confirm_pass);
        }

        if (empty($error)) {
            update_new_password($data, $pass_old);
            redirect("?mod=users&controller=index&action=login");
        }
    }
    load_view('changePass');
}