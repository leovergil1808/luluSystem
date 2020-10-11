<?php

function construct() {
    load('lib', 'validation');
    load_model('index');
}

// Function for Page
#1 Control the page
function indexAction() {
    load('helper', 'format');
    load('lib', 'pagging');
    load('helper', 'css');
    load('helper', 'image');

    if (isset($_GET['sm_s']) && !empty($_GET['search_by']) && !empty($_GET['s'])) {

        $s = $_GET['s'];
        $search_by = $_GET['search_by'];

        if (!empty($search_by)) {
            switch ($search_by) {
                case 1 : $search_by = "page_title";
                    break;
                case 2 : $search_by = "creator";
                    break;
            }
        }

        $data['s'] = $s;
        $data['search_by'] = $search_by;

        # Calc Pagination
        $num_per_page = 5;
        $data['num_rows'] = get_num_rows("tbl_page", "`{$search_by}` LIKE '%{$s}%'");
        $data['num_page'] = ceil($data['num_rows'] / $num_per_page);
        $data['page'] = isset($_GET['page']) ? $_GET['page'] : 1;
        $start = ($data['page'] - 1) * $num_per_page;

        # Control the Checkbox by Value
        if (isset($_POST['sm_action'])) {
            if (!empty($_POST['checkItem'])) {
                # Checkbox = 1 : Edit Item , # Checkbox = 2 : Delete Item, # Checkbox = 3 : Approve Item
                if ($_POST['actions'] == 1) {
                    foreach ($_POST['checkItem'] as $item) {
                        $id = $item;
                        $result = get_page_by_id($id);
                        isset($_GET['page']) ? $page = "&page={$_GET['page']}" : null;

                        if (!empty($result) && $result['page_status'] == 1) {
                            $editor = get_admin_info($_SESSION['user_login']);
                            $edit_date = time();
                            $data = array(
                                'editor' => $editor,
                                'edit_date' => $edit_date,
                                'page_status' => '0',
                            );
                            edit_page($data, $id);
                            redirect("?mod=pages&action=index&search_by={$search_by}&s={$s}&sm_s=Tìm+kiếm{$page}");
                        } elseif (!empty($result) && $result['page_status'] == 2) {
                            $old_file_path = $result['page_thumbnail'];
                            $new_file_path = str_replace('trash/', '', $old_file_path);
                            copy($old_file_path, $new_file_path);
                            $data = array(
                                'page_status' => '0',
                                'page_thumbnail' => $new_file_path
                            );
                            edit_page($data, $id);
                            delete_image($old_file_path);
                            redirect("?mod=pages&action=index&search_by={$search_by}&s={$s}&sm_s=Tìm+kiếm{$page}");
                        }
                    }
                } elseif ($_POST['actions'] == 2) {
                    foreach ($_POST['checkItem'] as $item) {
                        $id = $item;
                        $result = get_page_by_id($id);
                        isset($_GET['page']) ? $page = "&page={$_GET['page']}" : null;

                        if (!empty($result) && $result['page_status'] != 2) {
                            $old_file_path = $result['page_thumbnail'];
                            $new_file_path = str_replace('pages', 'pages/trash', $old_file_path);
                            copy($old_file_path, $new_file_path);
                            $data = array(
                                'page_status' => '2',
                                'page_thumbnail' => $new_file_path
                            );
                            edit_page($data, $id);
                            delete_image($old_file_path);
                            redirect("?mod=pages&action=index&search_by={$search_by}&s={$s}&sm_s=Tìm+kiếm{$page}");
                        }
                    }
                } elseif ($_POST['actions'] == 3) {
                    foreach ($_POST['checkItem'] as $item) {
                        $id = $item;
                        $result = get_page_by_id($id);
                        isset($_GET['page']) ? $page = "&page={$_GET['page']}" : null;

                        if (!empty($result) && $result['page_status'] == 0) {
                            $data = array(
                                'page_status' => '1',
                            );
                            if (approve_page($data, $id)) {
                                $approver = get_admin_info($_SESSION['user_login']);
                                $approval_date = time();
                                $data = array(
                                    'approver' => $approver,
                                    'approval_date' => $approval_date,
                                );
                                edit_page($data, $id);
                                redirect("?mod=pages&action=index&search_by={$search_by}&s={$s}&sm_s=Tìm+kiếm{$page}");
                            };
                        }
                    }
                }
            }
        }

        $data['list_page'] = search_item("tbl_page", $search_by, $s, $start, $num_per_page);
        load_view('showSearchPage', $data);
    } else {

        # Calc pagination
        $data['num_rows'] = get_num_rows("tbl_page");
        $data['num_rows_approved'] = get_num_rows("tbl_page", "`page_status` = '1'");
        $data['num_rows_waiting'] = get_num_rows("tbl_page", "`page_status` = '0'");
        $data['num_rows_trash'] = get_num_rows("tbl_page", "`page_status` = '2'");

        $num_per_page = 5;
        $data['num_page'] = ceil($data['num_rows'] / $num_per_page);
        $data['page'] = isset($_GET['page']) ? $_GET['page'] : 1;
        $start = ($data['page'] - 1) * $num_per_page;

        $list_page = get_list_page($start, $num_per_page);

        # Control the Checkbox by Value
        if (isset($_POST['sm_action'])) {
            if (!empty($_POST['checkItem'])) {
                # Checkbox = 1 : Edit Item , # Checkbox = 2 : Delete Item
                if ($_POST['actions'] == 1) {
                    foreach ($_POST['checkItem'] as $item) {
                        $id = $item;
                        $result = get_page_by_id($id);
                        isset($_GET['page']) ? $page = "&page={$_GET['page']}" : null;

                        if (!empty($result) && $result['page_status'] == 1) {
                            $editor = get_admin_info($_SESSION['user_login']);
                            $edit_date = time();
                            $data = array(
                                'editor' => $editor,
                                'edit_date' => $edit_date,
                                'page_status' => '0',
                            );
                            edit_page($data, $id);
                            redirect("?mod=pages&action=index{$page}");
                        } elseif (!empty($result) && $result['page_status'] == 2) {
                            $old_file_path = $result['page_thumbnail'];
                            $new_file_path = str_replace('trash/', '', $old_file_path);
                            copy($old_file_path, $new_file_path);
                            $data = array(
                                'page_status' => '0',
                                'page_thumbnail' => $new_file_path
                            );
                            edit_page($data, $id);
                            delete_image($old_file_path);
                            redirect("?mod=pages&action=index{$page}");
                        }
                    }
                } elseif ($_POST['actions'] == 2) {
                    foreach ($_POST['checkItem'] as $item) {
                        $id = $item;
                        $result = get_page_by_id($id);
                        isset($_GET['page']) ? $page = "&page={$_GET['page']}" : null;

                        if (!empty($result) && $result['page_status'] != 2) {
                            $old_file_path = $result['page_thumbnail'];
                            $new_file_path = str_replace('pages', 'pages/trash', $old_file_path);
                            copy($old_file_path, $new_file_path);
                            $data = array(
                                'page_status' => '2',
                                'page_thumbnail' => $new_file_path
                            );
                            edit_page($data, $id);
                            delete_image($old_file_path);
                            redirect("?mod=pages&action=index{$page}");
                        }
                    }
                }
            }
        }

        $data['list_page'] = $list_page;
        load_view('index', $data);
    }
}

function addPageAction() {
    load('helper', 'image');
    load('helper', 'slug');
    load('lib', 'pagging');

    global $error, $page_title, $slug, $page_content, $page_thumbnail;

    if (isset($_POST['btn-submit'])) {
        $error = array();

        if (empty($_POST['title'])) {
            $error['page_title'] = "Hãy nhập tiêu đề bài viết";
        } else {
            if (is_exists("tbl_page", "page_status", $_POST['title'])) {
                $error['page_title'] = "Trang đã tồn tại";
            } else {
                $page_title = $_POST['title'];
            }
        }

        if (empty($_POST['slug'])) {
            $error['slug'] = "Hãy nhập slug";
        } else {
            if (is_exists("tbl_page", "slug", $_POST['slug'])) {
                $error['slug'] = "Slug đã tồn tại";
            } else {
                $slug = create_slug($_POST['slug']);
            }
        }

        if (!empty($_POST['content'])) {
            $page_content = $_POST['content'];
        }

        if (!empty($_POST['desc'])) {
            $page_desc = $_POST['desc'];
        }

        if (isset($_FILES['file']) && !empty($_FILES['file']['name'])) {
            $type = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $size = $_FILES['file']['size'];
            if (!is_image($type, $size)) {
                $error['upload_image'] = "Size hoặc kiểu ảnh không đúng";
            } else {
                $page_thumbnail = upload_image('public/images/uploads/pages/', $type);
                if (!$page_thumbnail) {
                    $error['upload_image'] = "Upload không thành công";
                }
            }
        }

        if (empty($error)) {
            $creator = get_admin_info($_SESSION['user_login']);
            $created_date = time();
            $data = array(
                'page_title' => $page_title,
                'slug' => $slug,
                'page_content' => $page_content,
                'page_thumbnail' => $page_thumbnail,
                'creator' => $creator,
                'created_date' => $created_date,
            );
            add_page($data);
            redirect("?mod=pages&controller=index&action=index");
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
                redirect("?mod=pages&controller=index&action=index");
            }
        } else {
            $error['upload_image'] = "Không có ảnh upload";
        }
    }
    load_view('addPage');
}

function editPageAction() {
    load('helper', 'image');
    load('helper', 'slug');

    $id = (int) $_GET['id'];

    global $error;

    $page = get_page_by_id($id);
    $data['page'] = $page;

    if (isset($_POST['btn-submit'])) {
        $error = array();

        if (empty($_POST['title'])) {
            $page_title = $page['post_title'];
        } else {
            $page_title = $_POST['title'];
        }

        if (empty($_POST['slug'])) {
            $lug = $page['slug'];
        } else {
            $slug = create_slug($_POST['slug']);
        }

        if (empty($_POST['content'])) {
            $page_content = $page['post_content'];
        } else {
            $page_content = $_POST['content'];
        }

        if (empty($_POST['desc'])) {
            $page_desc = $page['post_desc'];
        } else {
            $page_desc = $_POST['desc'];
        }

        if (isset($_FILES['file']) && !empty($_FILES['file']['name'])) {
            $type = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $size = $_FILES['file']['size'];
            if (!is_image($type, $size)) {
                $error['upload_image'] = "Size hoặc kiểu ảnh không đúng";
            } else {
                $old_thumbnail = get_url_upload_image($id);
                if (!empty($old_thumbnail) && $page['page_status'] != 2) {
                    if (delete_image($old_thumbnail)) {
                        $page_thumbnail = upload_image('public/images/uploads/pages/', $type);
                    } else {
                        $error['upload_image'] = "Xoá ảnh ko thành công";
                    }
                } elseif (!empty($old_thumbnail) && $page['page_status'] == 2) {
                    if (delete_image($old_thumbnail)) {
                        $page_thumbnail = upload_image('public/images/uploads/pages/trash/', $type);
                    } else {
                        $error['upload_image'] = "Xoá ảnh ko thành công";
                    }
                } elseif (empty($old_thumbnail) && $page['page_status'] == 2) {
                    $page_thumbnail = upload_image('public/images/uploads/pages/trash/', $type);
                } else {
                    $page_thumbnail = upload_image('public/images/uploads/pages/', $type);
                }
            }
        } else {
            $page_thumbnail = $page['page_thumbnail'];
        }

        if (empty($error)) {
            $editor = get_admin_info($_SESSION['user_login']);
            $edit_date = time();
            $data = array(
                'page_title' => $page_title,
                'slug' => $slug,
                'page_content' => $page_content,
                'page_desc' => $page_desc,
                'page_thumbnail' => $page_thumbnail,
                'editor' => $editor,
                'edit_date' => $edit_date,
            );
            edit_page($data, $id);
            redirect("?mod=pages&controller=index&action=index");
        }
    }
    load_view('editPage', $data);
}

function moveTrashAction() {
    load('helper', 'image');
    $id = $_GET['id'];
    $page = get_page_by_id($id);
    if (!empty($page)) {
        $old_file_path = $page['page_thumbnail'];
        $new_file_path = str_replace('pages', 'pages/trash', $old_file_path);
        copy($old_file_path, $new_file_path);
        $data = array(
            'page_status' => '2',
            'page_thumbnail' => $new_file_path
        );
        edit_page($data, $id);
        delete_image($old_file_path);
        redirect("?mod=pages&action=index");
    }
    return false;
}

function restorePageAction() {
    load('helper', 'image');
    $id = $_GET['id'];
    $page = get_page_by_id($id);
    if (!empty($page)) {
        $old_file_path = $page['page_thumbnail'];
        $new_file_path = str_replace('trash/', '', $old_file_path);
        copy($old_file_path, $new_file_path);
        $data = array(
            'page_status' => '0',
            'page_thumbnail' => $new_file_path
        );
        edit_page($data, $id);
        delete_image($old_file_path);
        redirect("?mod=pages&controller=index&action=showTrashPage");
    }
    return false;
}

function approvePageAction() {
    $id = (int) $_GET['id'];
    $data = array(
        'page_status' => '1',
    );
    if (approve_page($data, $id)) {
        $approver = get_admin_info($_SESSION['user_login']);
        $approval_date = time();
        $data = array(
            'approver' => $approver,
            'approval_date' => $approval_date,
        );
        edit_page($data, $id);
        redirect("?mod=pages&action=showWaitingPage");
    };
}

function deletePageAction() {
    load('helper', 'image');
    $id = $_GET['id'];
    $page = get_page_by_id($id);
    if (!empty($page)) {
        delete_page($id);
        delete_image($page['page_thumbnail']);
        redirect("?mod=pages&controller=index&action=showTrashPage");
    }
}

#2 Show the Page

function showWaitingPageAction() {
    load('helper', 'format');
    load('lib', 'pagging');
    load('helper', 'image');

    # Calc Pagination
    $data['num_rows'] = get_num_rows("tbl_page");
    $data['num_rows_approved'] = get_num_rows("tbl_page", "`page_status` = '1'");
    $data['num_rows_waiting'] = get_num_rows("tbl_page", "`page_status` = '0'");
    $data['num_rows_trash'] = get_num_rows("tbl_page", "`page_status` = '2'");

    $num_per_page = 5;
    $data['num_page'] = ceil($data['num_rows_waiting'] / $num_per_page);
    $data['page'] = isset($_GET['page']) ? $_GET['page'] : 1;
    $start = ($data['page'] - 1) * $num_per_page;

    $data['list_page'] = get_waiting_page($start, $num_per_page);

    # Control the Checkbox by Value
    if (isset($_POST['sm_action'])) {
        if (!empty($_POST['checkItem'])) {
            # Checkbox = 1 : Approve the Item , Checkbox = 2 : Delete Item
            if ($_POST['actions'] == 1) {
                foreach ($_POST['checkItem'] as $item) {
                    $id = $item;
                    isset($_GET['page']) ? $page = "&page={$_GET['page']}" : null;
                    $data = array(
                        'page_status' => '1',
                    );
                    if (approve_page($data, $id)) {
                        $approver = get_admin_info($_SESSION['user_login']);
                        $approval_date = time();
                        $data = array(
                            'approver' => $approver,
                            'approval_date' => $approval_date,
                        );
                        edit_page($data, $id);
                        redirect("?mod=pages&action=showWaitingPage{$page}");
                    };
                }
            } elseif ($_POST['actions'] == 2) {
                foreach ($_POST['checkItem'] as $item) {
                    $id = $item;
                    $result = get_page_by_id($id);
                    isset($_GET['page']) ? $page = "&page={$_GET['page']}" : null;

                    if (!empty($result)) {
                        $old_file_path = $result['page_thumbnail'];
                        $new_file_path = str_replace('pages', 'pages/trash', $old_file_path);
                        copy($old_file_path, $new_file_path);
                        $data = array(
                            'page_status' => '2',
                            'page_thumbnail' => $new_file_path
                        );
                        edit_page($data, $id);
                        delete_image($old_file_path);
                        redirect("?mod=pages&action=showWaitingPage{$page}");
                    }
                }
            }
        }
    }

    load_view('showWaitingPage', $data);
}

function showApprovedPageAction() {
    load('helper', 'format');
    load('lib', 'pagging');
    load('helper', 'image');

    # Calc Pagination
    $data['num_rows'] = get_num_rows("tbl_page");
    $data['num_rows_approved'] = get_num_rows("tbl_page", "`page_status` = '1'");
    $data['num_rows_waiting'] = get_num_rows("tbl_page", "`page_status` = '0'");
    $data['num_rows_trash'] = get_num_rows("tbl_page", "`page_status` = '2'");

    $num_per_page = 5;
    $data['num_page'] = ceil($data['num_rows_approved'] / $num_per_page);
    $data['page'] = isset($_GET['page']) ? $_GET['page'] : 1;
    $start = ($data['page'] - 1) * $num_per_page;

    $list_page = get_approved_page($start, $num_per_page);
    $data['list_page'] = $list_page;

    # Control the Checkbox by Value
    if (isset($_POST['sm_action'])) {
        # Checkbox = 1 : Edit the Item , Checkbox = 2 : Delete Item
        if (!empty($_POST['checkItem'])) {
            if ($_POST['actions'] == 1) {
                foreach ($_POST['checkItem'] as $item) {
                    $id = $item;
                    $result = get_page_by_id($id);
                    isset($_GET['page']) ? $page = "&page={$_GET['page']}" : null;

                    if (!empty($result) && $result['page_status'] == 1) {
                        $editor = get_admin_info($_SESSION['user_login']);
                        $edit_date = time();
                        $data = array(
                            'editor' => $editor,
                            'edit_date' => $edit_date,
                            'page_status' => '0',
                        );
                        edit_page($data, $id);
                        redirect("?mod=pages&action=showApprovedPage{$page}");
                    } elseif (!empty($result) && $result['page_status'] == 2) {
                        $old_file_path = $result['page_thumbnail'];
                        $new_file_path = str_replace('trash/', '', $old_file_path);
                        copy($old_file_path, $new_file_path);
                        $data = array(
                            'page_status' => '0',
                            'page_thumbnail' => $new_file_path
                        );
                        edit_page($data, $id);
                        delete_image($old_file_path);
                        redirect("?mod=pages&action=showApprovedPage{$page}");
                    }
                }
            } elseif ($_POST['actions'] == 2) {
                foreach ($_POST['checkItem'] as $item) {
                    $id = $item;
                    $result = get_page_by_id($id);
                    isset($_GET['page']) ? $page = "&page={$_GET['page']}" : null;

                    if (!empty($result) && $result['page_status'] != 2) {
                        $old_file_path = $result['page_thumbnail'];
                        $new_file_path = str_replace('pages', 'pages/trash', $old_file_path);
                        copy($old_file_path, $new_file_path);
                        $data = array(
                            'page_status' => '2',
                            'page_thumbnail' => $new_file_path
                        );
                        edit_page($data, $id);
                        delete_image($old_file_path);
                        redirect("?mod=pages&action=showApprovedPage{$page}");
                    }
                }
            }
        }
    }

    load_view('showApprovedPage', $data);
}

function showTrashPageAction() {
    load('helper', 'format');
    load('lib', 'pagging');
    load('helper', 'image');

    # Calc Pagination
    $data['num_rows'] = get_num_rows("tbl_page");
    $data['num_rows_approved'] = get_num_rows("tbl_page", "`page_status` = '1'");
    $data['num_rows_waiting'] = get_num_rows("tbl_page", "`page_status` = '0'");
    $data['num_rows_trash'] = get_num_rows("tbl_page", "`page_status` = '2'");

    $num_per_page = 5;
    $data['num_page'] = ceil($data['num_rows_trash'] / $num_per_page);
    $data['page'] = isset($_GET['page']) ? $_GET['page'] : 1;
    $start = ($data['page'] - 1) * $num_per_page;

    $data['list_page'] = get_trash_page($start, $num_per_page);

    # Control the Checkbox by Value
    if (isset($_POST['sm_action'])) {
        # Checkbox = 1 : Restore the Item , Checkbox = 2 : Delete Item
        if (!empty($_POST['checkItem'])) {
            if ($_POST['actions'] == 1) {
                foreach ($_POST['checkItem'] as $item) {
                    $id = $item;
                    $result = get_page_by_id($id);
                    isset($_GET['page']) ? $page = "&page={$_GET['page']}" : null;

                    if (!empty($result)) {
                        $old_file_path = $result['page_thumbnail'];
                        $new_file_path = str_replace('trash/', '', $old_file_path);
                        copy($old_file_path, $new_file_path);
                        $data = array(
                            'page_status' => '0',
                            'page_thumbnail' => $new_file_path
                        );
                        edit_page($data, $id);
                        delete_image($old_file_path);
                        redirect("?mod=pages&action=showTrashPage{$page}");
                    }
                }
            } elseif ($_POST['actions'] == 2) {
                foreach ($_POST['checkItem'] as $item) {
                    $id = $item;
                    $result = get_page_by_id($id);
                    isset($_GET['page']) ? $page = "&page={$_GET['page']}" : null;

                    if (!empty($result)) {
                        delete_page($id);
                        delete_image($result['page_thumbnail']);
                        redirect("?mod=pages&action=showTrashPage{$page}");
                    }
                }
            }
        }
    }

    load_view('showTrashPage', $data);
}
