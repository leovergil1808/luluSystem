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
        <div id="wp-reg-admin">
            <div id="wp-form-reg-admin">
                <h1 class="page-title">Thêm admin mới</h1>
                <form id="form-reg-admin" action="" method="post">
                    <input type="text" name="fullname" id="fullname" value="<?php echo set_value('fullname') ?>" placeholder="Fullname">
                    <p class="error"><?php echo form_error('fullname'); ?></p>
                    <input type="text" name="username" id="username" value="<?php echo set_value('username') ?>" placeholder="Username">
                    <p class="error"><?php echo form_error('username'); ?></p>
                    <input type="password" name="password" id="password" placeholder="Password">
                    <p class="error"><?php echo form_error('password'); ?></p>
                    <input type="email" name="email" id="email" placeholder="Email" value="<?php echo set_value('email') ?>">
                    <p class="error"><?php echo form_error('email'); ?></p>
                    <input type="text" name="tel" id="tel" placeholder="Tel" value="<?php echo set_value('tel') ?>">
                    <p class="error"><?php echo form_error('tel'); ?></p>
                    <textarea name="address" id="address" placeholder="Address"></textarea>
                    <p class="error"><?php echo form_error('address'); ?></p>
                    <!-- <select name="gender" id="gender">
                        <option value="">--Chọn giới tính--</option>
                        <option value="male">Nam</option>
                        <option value="female">Nữ</option>
                    </select>
                    <p class="error"><?php //echo form_error('gender');       ?></p> -->

                    <input type="submit" name="btn_reg_admin" id="btn_reg_admin" value="Thêm mới">
                    <p class="error"><?php echo form_error('account'); ?></p>
                </form>

                <a href="?">Trở về trang chủ</a>
            </div>
        </div>

    </body>

</html>