<?php
get_header();
?>
<div id="main-content-wp" class="add-cat-page">
    <div class="wrap clearfix">
        <?php get_sidebar(); ?>
        <div id="content" class="fl-right">      
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Thay đổi nội dung trang</h3>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <form method="POST" enctype="multipart/form-data">
                        <label for="title">Tiêu đề trang</label>
                        <input type="text" name="title" id="title" value="<?php echo $page['page_title']; ?>">
                        <p class="error"><?php echo form_error('page_title') ?></p>
                        <label for="title">Slug ( Friendly_url )</label>
                        <input type="text" name="slug" id="slug" value="<?php echo $page['slug']; ?>">
                        <p class="error"><?php echo form_error('slug') ?></p>
                        <label for="content">Nội dung trang</label>
                        <textarea name="content" id="content" class="ckeditor"><?php echo $page['page_content']; ?></textarea>
                        <p class="error"><?php echo form_error('page_content') ?></p>
                        <label for="desc">Mô tả trang</label>
                        <textarea name="desc" id="desc" class="ckeditor"><?php echo $page['page_desc']; ?></textarea>
                        <p class="error"><?php echo form_error('page_desc') ?></p>

                        <label>Hình ảnh</label>
                        <div id="uploadFile">
                            <input type="file" name="file" id="upload-thumb" onchange="show_upload_image()">
                            <input type="submit" name="btn-upload-thumb" value="Upload" id="btn-upload-thumb">
                            <img id="upload-image" src="<?php echo $page['page_thumbnail']; ?>">

                        </div>
                        <p class="error"><?php echo form_error('upload_image') ?></p>
                        <button type="submit" name="btn-submit" id="btn-submit">Thay đổi nội dung trang</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
?>