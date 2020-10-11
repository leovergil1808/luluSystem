<?php
get_header();
?>
<div id="main-content-wp" class="add-cat-page">
    <div class="wrap clearfix">
        <?php get_sidebar(); ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Thêm sản phẩm mới</h3>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <form method="POST" enctype="multipart/form-data">
                        <label for="product-title">Tên sản phẩm</label>
                        <input type="text" name="product_title" id="product-name" value="<?php echo set_value('product_title'); ?>">
                        <p class="error"><?php echo form_error('product_title'); ?></p>

                        <label for="featured">Nổi bật</label>
                        <input type="checkbox" <?php echo set_value('checked_featured'); ?> name="featured" value ="1" >
                        <label for="best_seller">Bán chạy</label>
                        <input type="checkbox" <?php echo set_value('checked_best_seller'); ?> name="best_seller" value ="1" > 

                        <label for="slug">Slug ( Friendly_url )</label>
                        <input type="text" name="slug" id="slug" value="<?php echo set_value('slug'); ?>">
                        <p class="error"><?php echo form_error('slug'); ?></p>

                        <label for="product_code">Mã sản phẩm</label>
                        <input type="text" name="product_code" id="product-code" value="<?php echo set_value('product_code'); ?>">
                        <p class="error"><?php echo form_error('product_code'); ?></p>

                        <label for="product_price">Giá sản phẩm</label>
                        <input type="number" name="product_price" id="price" value="<?php echo set_value('product_price'); ?>">
                        <p class="error"><?php echo form_error('product_price'); ?></p>

                        <label for="product_content">Nội dung sản phẩm</label>
                        <textarea name="product_content" id="content" class="ckeditor"><?php echo set_value('product_content'); ?></textarea>
                        <p class="error"><?php echo form_error('product_content'); ?></p>

                        <label for="product_description">Mô tả ngắn</label>
                        <textarea name="product_description" id="desc" class="ckeditor"><?php echo set_value('product_description'); ?></textarea>
                        <p class="error"><?php echo form_error('product_description'); ?></p>

                        <label for="product_detail">Chi tiết sản phẩm</label>
                        <textarea name="product_detail" id="detail" class="ckeditor"><?php echo set_value('product_detail'); ?></textarea>
                        <p class="error"><?php echo form_error('product_detail'); ?></p>

                        <label>Hình ảnh</label>
                        <div id="uploadFile">
                            <input type="file" name="file" id="upload-thumb" onchange="show_upload_image()">
                            <input type="submit" name="btn-upload-thumb" value="Upload" id="btn-upload-thumb">
                            <img id="upload-image">
                        </div>
                        <p class="error"><?php echo form_error('upload_image'); ?></p>

                        <label>Danh mục sản phẩm</label>
                        <?php
                        if (!empty($list_product_cat)) {
                            ?>
                            <select name="cat_id">
                                <option value="">-- Chọn danh mục --</option>
                                <?php
                                foreach ($list_product_cat as $product_cat) {
                                    ?>
                                    <option value="<?php echo $product_cat['cat_id']; ?>"><?php echo $product_cat['cat_title'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <?php
                        }
                        ?>

                        <!-- <label>Trạng thái</label>
                        <select name="status">
                            <option value="0">-- Chọn danh mục --</option>
                            <option value="1">Chờ duyệt</option>
                            <option value="2">Đã đăng</option>
                        </select> -->
                        <button type="submit" name="btn-submit" id="btn-submit">Thêm mới</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
?>