<?php
get_header();
?>
<div id="main-content-wp" class="add-cat-page">
    <div class="wrap clearfix">
        <?php get_sidebar(); ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Chỉnh sửa thông tin khách hàng</h3>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <form method="POST">
                        <label for="fullname">Họ và tên</label>
                        <input type="text" name="fullname" id="username" value="<?php echo $user['fullname']; ?>">
                        <p class="error"><?php echo form_error('fullname'); ?></p>

                        <label for="tel">Số điện thoại</label>
                        <input type="number" name="tel" id="username" value="<?php echo $user['tel']; ?>">
                        <p class="error"><?php echo form_error('tel'); ?></p>

                        <label for="address">Địa chỉ</label>
                        <input type="text" name="address" id="username" value="<?php echo $user['address']; ?>">
                        <p class="error"><?php echo form_error('address'); ?></p>

                        <!-- <label for="desc">Mô tả</label>
                        <textarea name="desc" id="desc" class="ckeditor"></textarea>
                        <label>Hình ảnh</label>
                        <div id="uploadFile">
                            <input type="file" name="file" id="upload-thumb">
                            <input type="submit" name="btn-upload-thumb" value="Upload" id="btn-upload-thumb">
                            <img src="public/images/img-thumb.png">
                        </div>
                        <label>Danh mục cha</label>
                        <select name="parent-Cat">
                            <option value="">-- Chọn danh mục --</option>
                            <option value="1">Thể thao</option>
                            <option value="2">Xã hội</option>
                            <option value="3">Tài chính</option>
                        </select> -->
                        <button type="submit" name="btn-submit" id="btn-submit">Chỉnh sửa danh mục</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
?>