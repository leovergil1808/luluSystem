<?php
get_header();
?>
<div id="main-content-wp" class="add-cat-page slider-page">
    <div class="wrap clearfix">
        <?php get_sidebar(); ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Thêm Slider</h3>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">

                    <form method="POST"  enctype="multipart/form-data" action="">
                        <label for="title">Tên slider</label>
                        <input type="text" name="title" id="title" value="<?php echo set_value('title'); ?>">
                        <p class="error"><?php echo form_error('title'); ?></p>

                        <label for="product_code">Mã sản phẩm</label>
                        <input type="text" name="product_code" id="title" value="<?php echo set_value('product_code'); ?>">
                        <p class="error"><?php echo form_error('product_code'); ?></p>

                        <!-- <label for="title">Link</label>
                        <input type="text" name="slug" id="slug"> -->

                        <label for="desc">Mô tả</label>
                        <textarea name="desc" id="desc" class="ckeditor"><?php echo set_value('desc'); ?></textarea>
                        <p class="error"><?php echo form_error('desc'); ?></p>

                        <!-- <label for="title">Thứ tự</label>
                        <input type="text" name="num_order" id="num-order"> -->

                        <label>Hình ảnh</label>
                        <div id="uploadFile">
                            <input type="file" name="file[]" id="upload-thumb" multiple="" onchange="show_upload_multi_image()">
                            <div id="slider-thumb" class="clearfix">

                            </div>
                        </div>
                        <?php echo form_error('upload_image'); ?>

                        <!-- <label>Trạng thái</label>
                        <select name="status">
                            <option value="">-- Chọn trạng thái --</option>
                            <option value="1">Công khai</option>
                            <option value="2">Chờ duyệt</option>
                        </select> -->
                        <button type="submit" name="btn-submit" id="btn-submit">Thêm slider</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
?>