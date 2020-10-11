<?php
get_header();
?>
<div id="main-content-wp" class="add-cat-page slider-page">
    <div class="wrap clearfix">
        <?php get_sidebar(); ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Chỉnh sửa Slider</h3>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">

                    <form method="POST"  enctype="multipart/form-data" action="">
                        <label for="title">Tên slider</label>
                        <input type="text" name="title" id="title" value="<?php echo $slider['title']; ?>">
                        <p class="error"><?php echo form_error('title'); ?></p>

                        <label for="title">Mã sản phẩm</label>
                        <input type="text" name="product_code" id="title" value="<?php echo $slider['product_code']; ?>" readonly="readonly">
                        <p class="error"><?php echo form_error('product_code'); ?></p>

                        <!-- <label for="title">Link</label>
                        <input type="text" name="slug" id="slug"> -->

                        <label for="desc">Mô tả</label>
                        <textarea name="desc" id="desc" class="ckeditor"><?php echo $slider['description']; ?></textarea>
                        <p class="error"><?php echo form_error('desc'); ?></p>

                        <!-- <label for="title">Thứ tự</label>
                        <input type="text" name="num_order" id="num-order"> -->

                        <label>Hình ảnh</label>
                        <div id="uploadFile">
                            <?php
                            if (!empty($list_slider_thumbnail)) {
                                ?>
                                <div class="clearfix">
                                    <?php
                                    foreach ($list_slider_thumbnail as $item) {
                                        ?>
                                        <img class ='fl-left' style="margin-right: 5px" src='<?php echo $item['thumbnail']; ?>'>
                                        <?php
                                    }
                                    ?>
                                </div><br>
                                <?php
                            }
                            ?>

                            <input type="file" name="file[]" id="upload-thumb" multiple="" onchange="show_upload_multi_image()">
                            <input type="submit" name="btn-upload-thumb" value="Upload" id="btn-upload-thumb">
                            <div id="slider-thumb" class="clearfix"></div>

                        </div>
                        <?php echo form_error('upload_image'); ?>

                        <!-- <label>Trạng thái</label>
                        <select name="status">
                            <option value="">-- Chọn trạng thái --</option>
                            <option value="1">Công khai</option>
                            <option value="2">Chờ duyệt</option>
                        </select> -->
                        <button type="submit" name="btn-submit" id="btn-submit">Sửa Slider</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
?>