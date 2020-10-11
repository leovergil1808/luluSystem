<?php
get_header();
?>
<div id="main-content-wp" class="add-cat-page">
    <div class="wrap clearfix">
        <?php get_sidebar(); ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Thêm mới bài viết</h3>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <form method="POST" enctype="multipart/form-data">
                        <label for="title">Tiêu đề</label>
                        <input type="text" name="title" id="title" value="<?php echo set_value('post_title') ?>">
                        <p class="error"><?php echo form_error('post_title'); ?></p>
                        <label for="title">Slug ( Friendly_url )</label>
                        <input type="text" name="slug" id="slug" value="<?php echo set_value('slug'); ?>">
                        <p class="error"><?php echo form_error('slug'); ?></p>
                        <label for="desc">Nội dung bài viết</label>
                        <textarea name="post-content" id="desc" class="ckeditor"><?php echo set_value('post_content') ?></textarea>
                        <p class="error"><?php echo form_error('post_content'); ?></p>
                        <label for="desc">Mô tả</label>
                        <textarea name="desc" id="desc" class="ckeditor"><?php echo set_value('post_desc') ?></textarea>
                        <p class="error"><?php echo form_error('post_desc'); ?></p>
                        <label>Hình ảnh</label>
                        <div id="uploadFile">
                            <input type="file" name="file" id="upload-thumb" onchange="show_upload_image()">
                            <input type="submit" name="btn-upload-thumb" value="Upload" id="btn-upload-thumb">
                            <img id="upload-image" >
                        </div>
                        <p class="error"><?php echo form_error('upload_image'); ?></p>
                        <label>Danh mục</label>
                        <select name="cat-id">
                            <option value="">-- Chọn danh mục --</option>
                            <?php
                            if (!empty($list_post_cat)) {
                                foreach ($list_post_cat as $category) {
                                    ?>
                                    <option value="<?php echo $category['cat_id']; ?>"><?php echo $category['cat_title']; ?></option>
                                    <?php
                                }
                                ?>
                                <?php
                            }
                            ?>

                        </select>
                        <p class="error"><?php echo form_error('cat_id'); ?></p>
                        <button type="submit" name="btn-submit" id="btn-submit">Thêm mới bài viết</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
?>