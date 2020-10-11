<?php
get_header();
?>
<div id="main-content-wp" class="add-cat-page">
    <div class="wrap clearfix">
        <?php get_sidebar(); ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Chỉnh sửa bài viết</h3>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <?php
                    if (!empty($post)) {
                        ?>
                        <form method="POST" enctype="multipart/form-data">
                            <label for="title">Sửa tiêu đề</label>
                            <input type="text" name="title" id="title" value="<?php echo $post['post_title'] ?>">
                            <p class="error"><?php echo form_error('post_title'); ?></p>
                            <label for="slug">Sửa Slug ( Friendly_url )</label>
                            <input type="text" name="slug" id="slug" value="<?php echo $post['slug']; ?>">
                            <p class="error"><?php echo form_error('slug'); ?></p>
                            <label for="desc">Sửa nội dung bài viết</label>
                            <textarea name="post-content" id="desc" class="ckeditor"><?php echo $post['post_content']; ?></textarea>
                            <label for="desc">Sửa mô tả</label>
                            <textarea name="desc" id="desc" class="ckeditor"><?php echo $post['post_desc']; ?></textarea>
                            <label>Hình ảnh</label>
                            <div id="uploadFile">
                                <input type="file" name="file" id="upload-thumb" onchange="show_upload_image()">
                                <!-- <input type="submit" name="btn-upload-thumb" value="Upload" id="btn-upload-thumb"> -->
                                <img id="upload-image" src="<?php echo $post['post_thumbnail']; ?>">
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
                            <button type="submit" name="btn-submit" id="btn-submit">Sửa bài viết</button>
                        </form>
                        <?php
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
?>