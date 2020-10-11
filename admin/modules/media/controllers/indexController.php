<?php

function construct() {
    load('lib', 'validation');
    load_model('index');
}

# Function for Media
// 1. Control the media

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
        $data['num_rows_trash'] = get_num_rows("tbl_media", "`status` = '1'");

        # Calc Pagination

        $num_per_page = 5;
        $data['num_rows'] = get_num_rows("tbl_media", "`status` = '0'");
        $data['num_page'] = ceil($data['num_rows'] / $num_per_page);
        $data['page'] = isset($_GET['page']) ? $_GET['page'] : 1;
        $start = ($data['page'] - 1) * $num_per_page;

        $data['list_media'] = get_list_media($start, $num_per_page);

        # Control the Checkbox by Value
        if (isset($_POST['sm_action'])) {
            if (!empty($_POST['checkItem'])) {
                # Checkbox = 1 : Edit Item, Checkbox = 2 : Move Trash Item
                if ($_POST['actions'] == 1) {
                    foreach ($_POST['checkItem'] as $item) {
                        $id = $item;
                        $media = get_media_by_id($id);

                        if (!empty($media) && empty($media['thumbnail'])) {
                            $editor = get_admin_info($_SESSION['user_login']);
                            $edit_date = time();
                            $data = array(
                                'editor' => $editor,
                                'edit_date' => $edit_date,
                                'status' => '1',
                            );
                            edit_media($data, $id);
                            redirect("?mod=media&action=index");
                        } elseif (!empty($media) && !empty($media['thumbnail'])) {
                            $old_file_path = $media['thumbnail'];
                            $new_file_path = str_replace('media', 'media/trash', $old_file_path);
                            copy($old_file_path, $new_file_path);
                            $data = array(
                                'status' => '1',
                                'thumbnail' => $new_file_path
                            );
                            edit_media($data, $id);
                            delete_image($old_file_path);
                            redirect("?mod=media&action=index");
                        }
                    }
                }
            }
        }

        load_view('index', $data);
    }
}

function addMediaAction() {
    load('helper', 'image');
    load('helper', 'slug');

    global $error, $title;


    if (isset($_POST['btn-submit'])) {
        $error = array();

        if (empty($_POST['title'])) {
            $error['title'] = "Hãy nhập tên Media";
        } else {
            if (is_exists("tbl_media", "title", $_POST['title'])) {
                $error['title'] = "Media đã tồn tại";
            } else {
                $title = $_POST['title'];
            }
        }

        if (isset($_FILES['file']) && !empty($_FILES['file']['name']) && $_FILES['file']['error'] != 4) {
            $type = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $size = $_FILES['file']['size'];
            if (!is_image($type, $size)) {
                $error['upload_image'] = "Size hoặc kiểu ảnh không đúng";
            } else {
                $thumbnail = upload_image('public/images/uploads/media/', $type);
                if (!$thumbnail) {
                    $error['upload_image'] = "Upload không thành công";
                }
            }
        }

        if (!empty($_POST['media_type'])) {
            $media_type = $_POST['media_type'];
        }

        if (empty($error)) {
            $creator = get_admin_info($_SESSION['user_login']);
            $created_date = time();
            $data = array(
                'title' => $title,
                'thumbnail' => $thumbnail,
                'type' => $media_type,
                'creator' => $creator,
                'created_date' => $created_date,
            );
            add_media($data);
            redirect("?mod=media&action=index");
        }
    }

    // if (isset($_POST['btn-upload-thumb'])) {
    //     if (isset($_FILES['file']) && !empty($_FILES['file']['name'])) {
    //         $type = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
    //         $size = $_FILES['file']['size'];
    //         if (!is_image($type, $size)) {
    //             $error['upload_image'] = "Size hoặc kiểu ảnh không đúng";
    //         } else {
    //             upload_image('public/images/uploads/', $type);
    //         }
    //     } else {
    //         $error['upload_image'] = "Không có ảnh upload";
    //     }
    // }

    load_view('addMedia');
}

function editAction() {
    load('helper', 'image');

    global $error, $title;

    $id = (int) $_GET['id'];

    $media = get_media_by_id($id);
    $data['media'] = $media;

    if (isset($_POST['btn-submit'])) {
        $error = array();

        if (empty($_POST['title'])) {
            $title = $media['title'];
        } else {
            $title = $_POST['title'];
        }

        if (isset($_FILES['file']) && !empty($_FILES['file']['name']) && $_FILES['file']['error'] != 4) {
            $type = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $size = $_FILES['file']['size'];
            if (!is_image($type, $size)) {
                $error['upload_image'] = "Size hoặc kiểu ảnh không đúng";
            } else {
                $old_thumbnail = $media['thumbnail'];
                if (!empty($old_thumbnail)) {
                    if (delete_image($old_thumbnail)) {
                        $thumbnail = upload_image('public/images/uploads/media/', $type);
                    } else {
                        $error['upload_image'] = "Xoá ảnh ko thành công";
                    }
                } else {
                    $thumbnail = upload_image('public/images/uploads/media/', $type);
                }
            }
        } else {
            $thumbnail = $media['thumbnail'];
        }

        if (empty($_POST['media_type'])) {
            $media_type = $media['type'];
        } else {
            $media_type = $_POST['media_type'];
        }

        if (empty($error)) {
            $editor = get_admin_info($_SESSION['user_login']);
            $edit_date = time();
            $data = array(
                'title' => $title,
                'thumbnail' => $thumbnail,
                'type' => $media_type,
                'editor' => $editor,
                'edit_date' => $edit_date,
            );

            edit_media($data, $id);
            redirect("?mod=media&action=index");
        }
    }

    load_view('editMedia', $data);
}

function moveTrashAction() {
    load('helper', 'image');
    $id = $_GET['id'];

    $media = get_media_by_id($id);
    if (!empty($media)) {
        $old_file_path = $media['thumbnail'];
        $new_file_path = str_replace('media', 'media/trash', $old_file_path);

        copy($old_file_path, $new_file_path);
        $data = array(
            'status' => '2',
            'thumbnail' => $new_file_path
        );
        edit_media($data, $id);
        delete_image($old_file_path);
        redirect("?mod=media&action=index");
    } else {
        redirect("?mod=media&action=index");
    }
}

function restoreAction() {
    load('helper', 'image');
    $id = $_GET['id'];
    $media = get_media_by_id($id);
    if (!empty($media)) {
        $old_file_path = $media['thumbnail'];
        $new_file_path = str_replace('trash/', '', $old_file_path);
        copy($old_file_path, $new_file_path);

        $data = array(
            'status' => '0',
            'thumbnail' => $new_file_path
        );
        edit_media($data, $id);
        delete_image($old_file_path);
        redirect("?mod=media&action=showTrashMedia");
    }
    return false;
}

function deleteAction() {
    load('helper', 'image');
    $id = $_GET['id'];
    $media = get_media_by_id($id);

    if (!empty($media)) {
        delete_media($id);
        delete_image($media['thumbnail']);
        redirect("?mod=media&action=showTrashMedia");
    }
    return false;
}

#2 Show the media

function showTrashMediaAction() {
    load('helper', 'format');
    load('lib', 'pagging');
    load('helper', 'image');


    $data['num_rows'] = get_num_rows("tbl_media", "`status` = '0'");
    $data['num_rows_trash'] = get_num_rows("tbl_media", "`status` = '1'");

    $num_per_page = 5;
    $data['num_page'] = ceil($data['num_rows_trash'] / $num_per_page);
    $data['page'] = isset($_GET['page']) ? $_GET['page'] : 1;
    $start = ($data['page'] - 1) * $num_per_page;

    $data['list_media'] = get_trash_media($start, $num_per_page);

    if (isset($_POST['sm_action'])) {
        if (!empty($_POST['checkItem'])) {
            if ($_POST['actions'] == 1) {
                foreach ($_POST['checkItem'] as $item) {
                    $id = $item;
                    $media = get_media_by_id($id);
                    if (!empty($media) && !empty($media['thumbnail'])) {
                        $old_file_path = $media['thumbnail'];
                        $new_file_path = str_replace('trash/', '', $old_file_path);
                        copy($old_file_path, $new_file_path);
                        $data = array(
                            'status' => '0',
                            'thumbnail' => $new_file_path
                        );
                        edit_media($data, $id);
                        delete_image($old_file_path);
                        redirect("?mod=media&action=showTrashMedia");
                    } elseif (!empty($media) && empty($media['thumnail'])) {
                        $data = array(
                            'status' => '0',
                        );
                        edit_media($data, $id);
                        redirect("?mod=media&action=showTrashMedia");
                    }
                }
            } elseif ($_POST['actions'] == 2) {
                foreach ($_POST['checkItem'] as $item) {
                    $id = $item;
                    $media = get_media_by_id($id);
                    if (!empty($media)) {
                        delete_media($id);
                        delete_image($media['thumbnail']);
                    }
                    redirect("?mod=media&action=showTrashMedia");
                }
            }
        }
    }

    load_view('showTrashMedia', $data);
}
