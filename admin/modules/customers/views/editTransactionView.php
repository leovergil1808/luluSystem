<?php
get_header();
?>
<div id="main-content-wp" class="add-cat-page">
    <div class="wrap clearfix">
        <?php get_sidebar(); ?>
        <div id="content" class="fl-right">      
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Chỉnh sửa thông tin giao dịch</h3>
                </div>
            </div>

            <div class="section" id="detail-page">
                <div class="section-detail">
                    <form method="POST" enctype="multipart/form-data">
                        <label for="fullname">Tên khách hàng</label>
                        <input type="text" name="fullname" id="username" value="<?php echo $transaction_info['fullname']; ?>">
                        <p class="error"><?php echo form_error('username'); ?></p>

                        <label for="address">Địa chỉ chuyển hàng</label>
                        <textarea name="address" id="address"><?php echo $transaction_info['address']; ?></textarea>
                        <p class="error"><?php echo form_error('address'); ?></p>

                        <button type="submit" name="btn-submit" id="btn-submit">Xác nhận chỉnh sửa</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
?>