<?php

function construct() {
    load('lib', 'validation');
    load_model('index');
}

# Function for Post
// 1. Control the post

function indexAction() {
    load('helper', 'format');
    load('lib', 'pagging');
    load('helper', 'css');
    load('helper', 'image');

    if (isset($_GET['sm_s']) && !empty($_GET['s']) && !empty($_GET['search_by'])) {

        # Search Engine
        $s = $_GET['s'];
        $search_by = $_GET['search_by'];

        $data['s'] = $s;
        $data['search_by'] = $search_by;

        # Calc Pagination
        $num_per_page = 5;
        $data['num_rows'] = get_num_rows("tbl_post", "`{$search_by}` LIKE '%{$s}%'");
        $data['num_page'] = ceil($data['num_rows'] / $num_per_page);
        $data['page'] = isset($_GET['page']) ? $_GET['page'] : 1;
        $start = ($data['page'] - 1) * $num_per_page;

        $data['list_post'] = search_item("tbl_post", $search_by, $s, $start, $num_per_page);

        # Control the Checkbox by Value
        if (isset($_POST['sm_action'])) {
            if (!empty($_POST['checkItem'])) {
                # Checkbox = 1 : Edit Item, Checkbox = 2 : Move Trash Item
                if ($_POST['actions'] == 1) {
                    foreach ($_POST['checkItem'] as $item) {
                        $id = $item;
                        $post = get_post_by_id($id);

                        if (!empty($post) && $post['post_status'] == 1) {
                            $editor = get_admin_info($_SESSION['user_login']);
                            $edit_date = time();
                            $data = array(
                                'editor' => $editor,
                                'edit_date' => $edit_date,
                                'post_status' => '0',
                            );
                            edit_post($data, $id);
                            redirect("?mod=posts&action=index&search_by={$search_by}&s={$s}&sm_s=Tìm+kiếm");
                        } elseif (!empty($post) && $post['post_status'] == 2) {
                            $old_file_path = $post['post_thumbnail'];
                            $new_file_path = str_replace('trash/', '', $old_file_path);
                            copy($old_file_path, $new_file_path);
                            $data = array(
                                'post_status' => '0',
                                'post_thumbnail' => $new_file_path
                            );
                            edit_post($data, $id);
                            delete_image($old_file_path);
                            redirect("?mod=posts&action=index&search_by={$search_by}&s={$s}&sm_s=Tìm+kiếm");
                        }
                    }
                } elseif ($_POST['actions'] == 2) {
                    foreach ($_POST['checkItem'] as $item) {
                        $id = $item;
                        $post = get_post_by_id($id);
                        if (!empty($post) && $post['post_status'] != 2) {
                            $old_file_path = $post['post_thumbnail'];
                            $new_file_path = str_replace('posts', 'posts/trash', $old_file_path);
                            copy($old_file_path, $new_file_path);
                            $data = array(
                                'post_status' => '2',
                                'post_thumbnail' => $new_file_path
                            );
                            edit_post($data, $id);
                            delete_image($old_file_path);
                            redirect("?mod=posts&action=index&search_by={$search_by}&s={$s}&sm_s=Tìm+kiếm");
                        }
                    }
                }
            }
        }

        load_view('showSearchPost', $data);
    } else {

        # Calc Pagination
        $data['num_rows_approved'] = get_num_rows("tbl_post", "`post_status` = '1'");
        $data['num_rows_waiting'] = get_num_rows("tbl_post", "`post_status` = '0'");
        $data['num_rows_trash'] = get_num_rows("tbl_post", "`post_status` = '2'");

        $num_per_page = 5;
        $data['num_rows'] = get_num_rows("tbl_post");
        $data['num_page'] = ceil($data['num_rows'] / $num_per_page);
        $data['page'] = isset($_GET['page']) ? $_GET['page'] : 1;
        $start = ($data['page'] - 1) * $num_per_page;

        $data['list_post'] = get_list_post($start, $num_per_page);

        # Control the Checkbox by Value
        if (isset($_POST['sm_action'])) {
            if (!empty($_POST['checkItem'])) {
                # Checkbox = 1 : Edit Item, Checkbox = 2 : Move Trash Item
                if ($_POST['actions'] == 1) {
                    foreach ($_POST['checkItem'] as $item) {
                        $id = $item;
                        $post = get_post_by_id($id);

                        if (!empty($post) && $post['post_status'] == 1) {
                            $editor = get_admin_info($_SESSION['user_login']);
                            $edit_date = time();
                            $data = array(
                                'editor' => $editor,
                                'edit_date' => $edit_date,
                                'post_status' => '0',
                            );
                            edit_post($data, $id);
                            redirect("?mod=posts&action=index");
                        } elseif (!empty($post) && $post['post_status'] == 2) {
                            $old_file_path = $post['post_thumbnail'];
                            $new_file_path = str_replace('trash/', '', $old_file_path);
                            copy($old_file_path, $new_file_path);
                            $data = array(
                                'post_status' => '0',
                                'post_thumbnail' => $new_file_path
                            );
                            edit_post($data, $id);
                            delete_image($old_file_path);
                            redirect("?mod=posts&action=index");
                        }
                    }
                } elseif ($_POST['actions'] == 2) {
                    foreach ($_POST['checkItem'] as $item) {
                        $id = $item;
                        $post = get_post_by_id($id);
                        if (!empty($post) && $post['post_status'] != 2) {
                            $old_file_path = $post['post_thumbnail'];
                            $new_file_path = str_replace('posts', 'posts/trash', $old_file_path);
                            copy($old_file_path, $new_file_path);
                            $data = array(
                                'post_status' => '2',
                                'post_thumbnail' => $new_file_path
                            );
                            edit_post($data, $id);
                            delete_image($old_file_path);
                            redirect("?mod=posts&action=index");
                        }
                    }
                }
            }
        }

        load_view('index', $data);
    }
}

function addPostAction() {
    load('helper', 'image');
    load('helper', 'slug');

    global $error, $post_title, $slug, $upload_thumb, $post_desc, $post_content;

    $data['list_post_cat'] = get_list_post_cat();

    if (isset($_POST['btn-submit'])) {
        $error = array();

        if (empty($_POST['title'])) {
            $error['post_title'] = "Hãy nhập tiêu đề bài viết";
        } else {
            if (is_exists("tbl_post", "post_title", $_POST['title'])) {
                $error['post_title'] = "Bài viết đã tồn tại";
            } else {
                $post_title = $_POST['title'];
            }
        }

        if (empty($_POST['slug'])) {
            $error['slug'] = "Hãy nhập slug";
        } else {
            if (is_exists("tbl_post", "slug", $_POST['slug'])) {
                $error['slug'] = "Slug đã tồn tại";
            } else {
                $slug = create_slug($_POST['slug']);
            }
        }

        if (!empty($_POST['post-content'])) {
            $post_content = $_POST['post-content'];
        }

        if (!empty($_POST['desc'])) {
            $post_desc = $_POST['desc'];
        }

        if (!empty($_POST['cat-id'])) {
            $cat_id = $_POST['cat-id'];
        }

        if (isset($_FILES['file']) && !empty($_FILES['file']['name'])) {
            $type = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $size = $_FILES['file']['size'];
            if (!is_image($type, $size)) {
                $error['upload_image'] = "Size hoặc kiểu ảnh không đúng";
            } else {
                $post_thumbnail = upload_image('public/images/uploads/posts/', $type);
                if (!$post_thumbnail) {
                    $error['upload_image'] = "Upload không thành công";
                }
            }
        }

        if (empty($error)) {
            $creator = get_admin_info($_SESSION['user_login']);
            $created_date = time();
            $data = array(
                'post_title' => $post_title,
                'slug' => $slug,
                'post_content' => $post_content,
                'post_desc' => $post_desc,
                'post_thumbnail' => $post_thumbnail,
                'creator' => $creator,
                'created_date' => $created_date,
                'cat_id' => $cat_id,
            );
            add_post($data);
            redirect("?mod=posts&action=index");
        }
    }

    if (isset($_POST['btn-upload-thumb'])) {
        if (isset($_FILES['file']) && !empty($_FILES['file']['name'])) {
            $type = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $size = $_FILES['file']['size'];
            if (!is_image($type, $size)) {
                $error['upload_image'] = "Size hoặc kiểu ảnh không đúng";
            } else {
                upload_image('public/images/uploads/', $type);
            }
        } else {
            $error['upload_image'] = "Không có ảnh upload";
        }
    }

    load_view('addPost', $data);
}

function editPostAction() {
    load('helper', 'image');
    load('helper', 'slug');

    global $error, $post_title;

    $id = (int) $_GET['id'];
    $data['list_post_cat'] = get_list_post_cat();
    $post = get_post_by_id($id);
    $data['post'] = $post;

    if (isset($_POST['btn-submit'])) {
        $error = array();

        if (empty($_POST['title'])) {
            $post_title = $post['post_title'];
        } else {
            $post_title = $_POST['title'];
        }

        if (empty($_POST['slug'])) {
            $lug = $post['slug'];
        } else {
            $slug = create_slug($_POST['slug']);
        }

        if (empty($_POST['post-content'])) {
            $post_content = $post['post_content'];
        } else {
            $post_content = $_POST['post-content'];
        }

        if (empty($_POST['desc'])) {
            $post_desc = $post['post_desc'];
        } else {
            $post_desc = $_POST['desc'];
        }

        if (empty($_POST['cat-id'])) {
            $cat_id = $post['cat_id'];
        } else {
            $cat_id = $_POST['cat-id'];
        }

        if (isset($_FILES['file']) && !empty($_FILES['file']['name'])) {
            $type = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $size = $_FILES['file']['size'];
            if (!is_image($type, $size)) {
                $error['upload_image'] = "Size hoặc kiểu ảnh không đúng";
            } else {
                $old_thumbnail = get_url_upload_image($id);
                if (!empty($old_thumbnail)) {
                    if (delete_image($old_thumbnail)) {
                        $post_thumbnail = upload_image('public/images/uploads/posts/', $type);
                    } else {
                        $error['upload_image'] = "Xoá ảnh ko thành công";
                    }
                } else {
                    $post_thumbnail = upload_image('public/images/uploads/posts/', $type);
                }
            }
        } else {
            $post_thumbnail = $post['post_thumbnail'];
        }

        if (empty($error)) {
            $editor = get_admin_info($_SESSION['user_login']);
            $edit_date = time();
            $data = array(
                'post_title' => $post_title,
                'slug' => $slug,
                'post_content' => $post_content,
                'post_desc' => $post_desc,
                'post_thumbnail' => $post_thumbnail,
                'editor' => $editor,
                'edit_date' => $edit_date,
                'cat_id' => $cat_id,
            );
            edit_post($data, $id);
            redirect("?mod=posts&action=index");
        }
    }

    load_view('editPost', $data);
}

function approvePostAction() {
    if(is_login() && check_role($_SESSION['user_login']) <= 2){
        $id = (int) $_GET['id'];
        $data = array(
            'post_status' => '1',
        );
        if (approve_post($data, $id)) {
            $approver = get_admin_info($_SESSION['user_login']);
            $approve_date = time();
            $data = array(
                'approver' => $approver,
                'approve_date' => $approve_date,
            );
            edit_post($data, $id);
            redirect("?mod=posts&action=showWaitingPost");
        };
    }else{
        redirect("?mod=posts&action=showWaitingPost");
    }
}

function moveTrashAction() {
    if(is_login() && check_role($_SESSION['user_login']) <= 2){
        load('helper', 'image');
        $id = $_GET['id'];
        $post = get_post_by_id($id);
        if (!empty($post) && $post['post_status'] != 2) {
            $old_file_path = $post['post_thumbnail'];
            $new_file_path = str_replace('posts', 'posts/trash', $old_file_path);
            copy($old_file_path, $new_file_path);
            $data = array(
                'post_status' => '2',
                'post_thumbnail' => $new_file_path
            );
            edit_post($data, $id);
            delete_image($old_file_path);
            redirect("?mod=posts&action=index");
        } else {
            redirect("?mod=posts&action=index");
        }
    }else{
        redirect("?mod=posts&action=index");
    }
}

function restorePostAction() {
    load('helper', 'image');
    $id = $_GET['id'];
    $post = get_post_by_id($id);
    if (!empty($post)) {
        $old_file_path = $post['post_thumbnail'];
        $new_file_path = str_replace('trash/', '', $old_file_path);
        copy($old_file_path, $new_file_path);
        $data = array(
            'post_status' => '0',
            'post_thumbnail' => $new_file_path
        );
        edit_post($data, $id);
        delete_image($old_file_path);
        redirect("?mod=posts&action=showTrashPost");
    }
    return false;
}

function deletePostAction() {
    if(is_login() && check_role($_SESSION['user_login']) <= 2){
        load('helper', 'image');
        $id = $_GET['id'];
        $post = get_post_by_id($id);
        if (!empty($post)) {
            delete_post($id);
            delete_image($post['post_thumbnail']);
            redirect("?mod=posts&action=showTrashPost");
        }
        return false;
    }else{
        redirect("?mod=posts&action=showTrashPost");
    }
    
}

#2 Show the Post

function showWaitingPostAction() {
    load('helper', 'format');
    load('lib', 'pagging');
    load('helper', 'image');

    $data['num_rows'] = get_num_rows("tbl_post");
    $data['num_rows_approved'] = get_num_rows("tbl_post", "`post_status` = '1'");
    $data['num_rows_waiting'] = get_num_rows("tbl_post", "`post_status` = '0'");
    $data['num_rows_trash'] = get_num_rows("tbl_post", "`post_status` = '2'");

    $num_per_page = 5;
    $data['num_page'] = ceil($data['num_rows_waiting'] / $num_per_page);
    $data['page'] = isset($_GET['page']) ? $_GET['page'] : 1;
    $start = ($data['page'] - 1) * $num_per_page;

    $data['list_post'] = get_waiting_post($start, $num_per_page);

    if (isset($_POST['sm_action'])) {
        if (!empty($_POST['checkItem'])) {
            if ($_POST['actions'] == 1) {
                foreach ($_POST['checkItem'] as $item) {
                    $id = $item;
                    $data = array(
                        'post_status' => '1',
                    );
                    if (approve_post($data, $id)) {
                        $approver = get_admin_info($_SESSION['user_login']);
                        $approve_date = time();
                        $data = array(
                            'approver' => $approver,
                            'approve_date' => $approve_date,
                        );
                        edit_post($data, $id);
                        redirect("?mod=posts&action=showWaitingPost");
                    };
                }
            } elseif ($_POST['actions'] == 2) {
                foreach ($_POST['checkItem'] as $item) {
                    $id = $item;
                    $post = get_post_by_id($id);
                    if (!empty($post)) {
                        $old_file_path = $post['post_thumbnail'];
                        $new_file_path = str_replace('posts', 'posts/trash', $old_file_path);
                        copy($old_file_path, $new_file_path);
                        $data = array(
                            'post_status' => '2',
                            'post_thumbnail' => $new_file_path
                        );
                        edit_post($data, $id);
                        delete_image($old_file_path);
                        redirect("?mod=posts&action=index");
                    }
                }
            }
        }
    }

    load_view('showWaitingPost', $data);
}

function showApprovedPostAction() {
    load('helper', 'format');
    load('lib', 'pagging');
    load('helper', 'image');

    $data['num_rows'] = get_num_rows("tbl_post");
    $data['num_rows_approved'] = get_num_rows("tbl_post", "`post_status` = '1'");
    $data['num_rows_waiting'] = get_num_rows("tbl_post", "`post_status` = '0'");
    $data['num_rows_trash'] = get_num_rows("tbl_post", "`post_status` = '2'");

    $num_per_page = 5;
    $data['num_page'] = ceil($data['num_rows_approved'] / $num_per_page);
    $data['page'] = isset($_GET['page']) ? $_GET['page'] : 1;
    $start = ($data['page'] - 1) * $num_per_page;

    $list_post = get_approved_post($start, $num_per_page);
    $data['list_post'] = $list_post;

    if (isset($_POST['sm_action'])) {
        if (!empty($_POST['checkItem'])) {
            if ($_POST['actions'] == 1) {
                foreach ($_POST['checkItem'] as $item) {
                    $id = $item;

                    $editor = get_admin_info($_SESSION['user_login']);
                    $edit_date = time();
                    $data = array(
                        'editor' => $editor,
                        'edit_date' => $edit_date,
                        'post_status' => '0',
                    );
                    edit_post($data, $id);
                    redirect("?mod=posts&action=showWaitingPost");
                }
            } elseif ($_POST['actions'] == 2) {
                foreach ($_POST['checkItem'] as $item) {
                    $id = $item;
                    $post = get_post_by_id($id);
                    if (!empty($post)) {
                        $old_file_path = $post['post_thumbnail'];
                        $new_file_path = str_replace('posts', 'posts/trash', $old_file_path);
                        copy($old_file_path, $new_file_path);
                        $data = array(
                            'post_status' => '2',
                            'post_thumbnail' => $new_file_path
                        );
                        edit_post($data, $id);
                        delete_image($old_file_path);
                        redirect("?mod=posts&action=index");
                    }
                }
            }
        }
    }

    load_view('showApprovedPost', $data);
}

function showTrashPostAction() {
    load('helper', 'format');
    load('lib', 'pagging');
    load('helper', 'image');


    $data['num_rows'] = get_num_rows("tbl_post");
    $data['num_rows_approved'] = get_num_rows("tbl_post", "`post_status` = '1'");
    $data['num_rows_waiting'] = get_num_rows("tbl_post", "`post_status` = '0'");
    $data['num_rows_trash'] = get_num_rows("tbl_post", "`post_status` = '2'");

    $num_per_page = 5;
    $data['num_page'] = ceil($data['num_rows_trash'] / $num_per_page);
    $data['page'] = isset($_GET['page']) ? $_GET['page'] : 1;
    $start = ($data['page'] - 1) * $num_per_page;

    $data['list_post'] = get_trash_post($start, $num_per_page);

    if (isset($_POST['sm_action'])) {
        if (!empty($_POST['checkItem'])) {
            if ($_POST['actions'] == 1) {
                foreach ($_POST['checkItem'] as $item) {
                    $id = $item;
                    $post = get_post_by_id($id);
                    if (!empty($post)) {
                        $old_file_path = $post['post_thumbnail'];
                        $new_file_path = str_replace('trash/', '', $old_file_path);
                        copy($old_file_path, $new_file_path);
                        $data = array(
                            'post_status' => '0',
                            'post_thumbnail' => $new_file_path
                        );
                        edit_post($data, $id);
                        delete_image($old_file_path);
                        redirect("?mod=posts&action=showTrashPost");
                    }
                }
            } elseif ($_POST['actions'] == 2) {
                foreach ($_POST['checkItem'] as $item) {
                    $id = $item;
                    $post = get_post_by_id($id);
                    if (!empty($post)) {
                        delete_post($id);
                        delete_image($post['post_thumbnail']);
                        redirect("?mod=posts&action=showTrashPost");
                    }
                    return false;
                }
            }
        }
    }

    load_view('showTrashPost', $data);
}

# Function for Post category

function addPostCatAction() {
    load('helper', 'slug');

    global $error;
    if (isset($_POST['btn-submit'])) {
        $error = array();

        if (empty($_POST['title'])) {
            $error['cat_title'] = "Hãy nhập tên danh mục";
        } else {
            if (is_exists("tbl_post_cat", "cat_title", $_POST['title'])) {
                $error['cat_title'] = "Danh mục đã tồn tại";
            } else {
                $cat_title = $_POST['title'];
            }
        }
        if (empty($_POST['slug'])) {
            $error['slug'] = "Hãy nhập slug";
        } else {
            if (is_exists("tbl_post_cat", "slug", $_POST['slug'])) {
                $error['slug'] = "Slug đã tồn tại";
            } else {
                $slug = create_slug($_POST['slug']);
            }
        }

        if (empty($error)) {
            $creator = get_admin_info($_SESSION['admin_login']);
            $created_date = time();
            $data = array(
                'cat_title' => $cat_title,
                'slug' => $slug,
                'created_date' => $created_date,
                'creator' => $creator
            );
            add_cat($data);
            redirect("?mod=posts&controller=index&action=listPostCat");
        }
    }
    load_view('addPostCat');
}

function listPostCatAction() {
    load('helper', 'format');
    load('lib', 'pagging');

    $num_per_page = 10;
    $data['num_rows'] = get_num_rows("tbl_product_cat");
    $data['num_page'] = ceil($data['num_rows'] / $num_per_page);

    $data['page'] = isset($_GET['page']) ? $_GET['page'] : 1;
    $start = ($data['page'] - 1) * $num_per_page;

    $data['list_post_cat'] = get_list_post_cat_limit($start, $num_per_page);

    load_view('listPostCat', $data);
}

function updateCatAction() {
    load('helper', 'slug');

    $cat_id = $_GET['cat_id'];

    global $error;

    if (isset($_POST['btn-submit'])) {
        $error = array();


        if (empty($_POST['title'])) {
            $error['cat_title'] = "Hãy nhập tên danh mục";
        } else {
            $cat_title = $_POST['title'];
        }

        if (empty($_POST['slug'])) {
            $error['slug'] = "Hãy nhập slug";
        } else {
            $slug = create_slug($_POST['slug']);
        }

        if (empty($error)) {
            $editor = get_admin_info($_SESSION['admin_login']);
            $update_date = time();
            $data = array(
                'cat_title' => $cat_title,
                'slug' => $slug,
                'update_date' => $update_date,
                'editor' => $editor
            );
            update_cat($data, $cat_id);
            redirect("?mod=posts&controller=index&action=listPostCat");
        }
    }

    load_view('updateCat');
}

function deleteCatAction() {

    $cat_id = $_GET['cat_id'];
    delete_cat($cat_id);
    redirect("?mod=posts&controller=index&action=listPostCat");
}
