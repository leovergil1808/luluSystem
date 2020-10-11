<?php
get_header();
?>
<div id="main-content-wp" class="info-account-page">
    <div class="section" id="title-page">
        <div class="clearfix">
            <a href="?mod=users&controller=team&action=addAdmin" title="" id="add-new" class="fl-left">Thêm quản trị viên</a>
            <h3 id="index" class="fl-left">Cập nhật thông tin</h3>
        </div>
    </div>
    <div class="wrap clearfix">
        <?php get_sidebar('users'); ?>
        <div id="content" class="fl-right">                       
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <form method="POST">
                        <label for="display-name">Tên hiển thị</label>
                        <input type="text" name="display-name" id="display-name" value="<?php echo $info_admin['display_name']; ?>">

                        <label for="fullname">Tên đầy đủ</label>
                        <input type="text" name="fullname" id="fullname" value="<?php echo $info_admin['fullname']; ?>">

                        <label for="username">Tên đăng nhập</label>
                        <input type="text" name="username" id="username" value="<?php echo $info_admin['username']; ?>" readonly="readonly">

                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" value="<?php echo $info_admin['email']; ?>" readonly="readonly">

                        <label for="tel">Số điện thoại</label>
                        <input type="tel" name="tel" id="tel" value="<?php echo $info_admin['tel']; ?>">
                        <p class="error"><?php echo form_error('tel') ?></p>

                        <label for="address">Địa chỉ</label>
                        <textarea name="address" id="address"><?php echo $info_admin['address']; ?></textarea>

                        <button type="submit" name="btn-update" id="btn-update">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
?>