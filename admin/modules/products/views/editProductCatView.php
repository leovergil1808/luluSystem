<?php
get_header();
// show_array($list_product_cat);
?>
<div id="main-content-wp" class="add-cat-page">
    <div class="wrap clearfix">
        <?php get_sidebar(); ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Chỉnh sửa danh mục sản phẩm</h3>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <form method="POST">
                        <label for="title">Tên danh mục</label>
                        <input type="text" name="title" id="title" value="<?php echo $list_product_cat['cat_title']; ?>">
                        <p class="error"><?php echo form_error('cat_title'); ?></p>

                        <label for="title">Slug ( Friendly_url )</label>
                        <input type="text" name="slug" id="slug" value="<?php echo $list_product_cat['slug']; ?>">
                        <p class="error"><?php echo form_error('slug'); ?></p>
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