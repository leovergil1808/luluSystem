<!DOCTYPE html>
<html>
    <head>
        <title>Đăng nhập admin</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="public/reset.css" rel="stylesheet" type="text/css" />
        <link href="public/style.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <div id="wp-login">
            <div id="wp-form-login">
                <h1 class="page-title">ĐĂNG NHẬP</h1>
                <form id="form-login" action="" method="post">
                    <input type="text" name="username" id="username" value="<?php echo set_value('username') ?>" placeholder="Username"> <br>
                    <p class="error"><?php echo form_error('username'); ?></p>
                    <input type="password" name="password" id="password" placeholder="Password">
                    <p class="error"><?php echo form_error('password'); ?></p>
                    <input type="checkbox" name="remember_me" id="">Ghi nhớ đăng nhập <br>
                    <input type="submit" name="btn_login" id="btn_login" value="Đăng nhập">
                    <p class="error"><?php echo form_error('account'); ?></p>
                </form>
                <!-- <a href="?mod=users&controller=index&action=resetPass&reset_token" id="lost_pass">Quên mật khẩu ?</a><br> -->
                <!-- <a href="?">Trở về trang chủ</a> -->
            </div>
        </div>

    </body>

</html>