<?php
get_header();
?>

<div id="main-content-wp" class="change-pass-page">
    <div class="section" id="title-page">
        <div class="clearfix">
            <a href="?mod=users&controller=team&action=addAdmin" title="" id="add-new" class="fl-left">Thêm quản trị viên</a>
            <h3 id="index" class="fl-left">Đổi mật khẩu</h3>
        </div>
    </div>
    <div class="wrap clearfix">
        <?php get_sidebar('users'); ?>
        <div id="content" class="fl-right">                       
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <form method="POST">
                        <label for="old-pass">Mật khẩu cũ</label>
                        <input type="password" name="pass-old" id="pass-old">
                        <p class="error"><?php echo form_error('pass_old') ?></p>
                        <label for="new-pass">Mật khẩu mới</label>
                        <input type="password" name="pass-new" id="pass-new">
                        <p class="error"><?php echo form_error('pass_new') ?></p>
                        <label for="confirm-pass">Xác nhận mật khẩu</label>
                        <input type="password" name="confirm-pass" id="confirm-pass">
                        <p class="error"><?php echo form_error('confirm_pass') ?></p>

                        <button type="submit" name="btn-submit" id="btn-submit">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
?>