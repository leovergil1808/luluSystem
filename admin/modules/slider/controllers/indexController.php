<?php

function construct() {
    load('lib', 'validation');
    load_model('index');
}

// Function for Slider
#1 Control the Slider
function indexAction() {
    load('helper', 'format');
    load('lib', 'pagging');
    load('helper', 'css');
    load('helper', 'image');
    load('helper', 'string');

    if (isset($_GET['sm_s']) && !empty($_GET['s'])) {
        $s = $_GET['s'];
        $search_by = "title";
        $mod = $_GET['mod'];

        $num_per_page = 4;
        $data['search_by'] = $search_by;
        $data['s'] = $s;

        $data['num_rows'] = get_num_rows("tbl_slider", "`{$search_by}` LIKE '%{$s}%'");
        $data['num_page'] = ceil($data['num_rows'] / $num_per_page);
        $data['page'] = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $start = ($data['page'] - 1) * $num_per_page;


        $data['list_slider'] = search_item("tbl_slider", $search_by, $s, $start, $num_per_page);

        if (isset($_POST['sm_action'])) {
            if (!empty($_POST['checkItem'])) {
                if ($_POST['actions'] == 1) {
                    foreach ($_POST['checkItem'] as $item) {
                        $id = $item;
                        $slider = get_slider_by_id($id);
                        isset($_GET['page']) ? $page = "&page={$_GET['page']}" : null;
                        // show_array($slider);
                        if (!empty($slider) && $slider['status'] == 1) {
                            $editor = get_admin_info($_SESSION['user_login']);
                            $edit_date = time();
                            $data = array(
                                'editor' => $editor,
                                'edit_date' => $edit_date,
                                'status' => '0',
                            );
                            edit_slider($data, $id);
                            redirect("?mod=slider&action=index{$page}");
                        } elseif (!empty($slider) && $slider['status'] == 2) {
                            $slider_code = $slider['slider_code'];
                            $slider_thumbnail = get_list_slider_thumbnail($slider_code);

                            if (!empty($slider_thumbnail)) {
                                foreach ($slider_thumbnail as $item) {
                                    $old_file_path = $item['thumbnail'];
                                    $new_file_path = str_replace('trash/', '', $old_file_path);
                                    copy($old_file_path, $new_file_path);

                                    $data = array(
                                        'status' => '0',
                                    );
                                    edit_slider($data, $id);

                                    $data = array(
                                        'thumbnail' => $new_file_path
                                    );
                                    edit_slider_thumbnail($data, $old_file_path);

                                    delete_image($old_file_path);
                                }
                            } else {
                                $data = array(
                                    'status' => '0',
                                );
                                edit_slider($data, $id);
                            }
                            redirect("?mod=slider&action=index{$page}");
                        }
                    }
                } elseif ($_POST['actions'] == 2) {
                    foreach ($_POST['checkItem'] as $item) {
                        $id = $item;
                        $slider = get_slider_by_id($id);
                        isset($_GET['page']) ? $page = "&page={$_GET['page']}" : null;

                        if (!empty($slider) && $slider['status'] != 2) {
                            $slider_code = $slider['slider_code'];
                            $slider_thumbnail = get_list_slider_thumbnail($slider_code);
                            if (!empty($slider_thumbnail)) {
                                foreach ($slider_thumbnail as $item) {
                                    $old_file_path = $item['thumbnail'];
                                    $new_file_path = str_replace('products', 'products/trash', $old_file_path);
                                    copy($old_file_path, $new_file_path);

                                    $data = array(
                                        'status' => '2',
                                    );
                                    edit_slider($data, $id);

                                    $data = array(
                                        'thumbnail' => $new_file_path
                                    );
                                    edit_slider_thumbnail($data, $old_file_path);
                                    delete_image($old_file_path);
                                }
                            } else {
                                $data = array(
                                    'status' => '2',
                                );
                                edit_slider($data, $id);
                            }

                            redirect("?mod=slider&action=index{$page}");
                        }
                    }
                }
            }
        }

        load_view('showSearchSlider', $data);
    } else {
        $data['num_rows'] = get_num_rows("tbl_slider");
        $data['num_rows_approved'] = get_num_rows("tbl_slider", "`status` = '1'");
        $data['num_rows_waiting'] = get_num_rows("tbl_slider", "`status` = '0'");
        $data['num_rows_trash'] = get_num_rows("tbl_slider", "`status` = '2'");

        $num_per_page = 15;
        $data['num_page'] = ceil($data['num_rows'] / $num_per_page);

        $data['page'] = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $start = ($data['page'] - 1) * $num_per_page;

        $data['list_slider'] = get_list_slider($start, $num_per_page);

        if (isset($_POST['sm_action'])) {
            if (!empty($_POST['checkItem'])) {
                if ($_POST['actions'] == 1) {
                    foreach ($_POST['checkItem'] as $item) {
                        $id = $item;
                        $slider = get_slider_by_id($id);
                        isset($_GET['page']) ? $page = "&page={$_GET['page']}" : null;
                        // show_array($slider);
                        if (!empty($slider) && $slider['status'] == 1) {
                            $editor = get_admin_info($_SESSION['user_login']);
                            $edit_date = time();
                            $data = array(
                                'editor' => $editor,
                                'edit_date' => $edit_date,
                                'status' => '0',
                            );
                            edit_slider($data, $id);
                            redirect("?mod=slider&action=index{$page}");
                        } elseif (!empty($slider) && $slider['status'] == 2) {
                            $slider_code = $slider['slider_code'];
                            $slider_thumbnail = get_list_slider_thumbnail($slider_code);

                            if (!empty($slider_thumbnail)) {
                                foreach ($slider_thumbnail as $item) {
                                    $old_file_path = $item['thumbnail'];
                                    $new_file_path = str_replace('trash/', '', $old_file_path);
                                    copy($old_file_path, $new_file_path);

                                    $data = array(
                                        'status' => '0',
                                    );
                                    edit_slider($data, $id);

                                    $data = array(
                                        'thumbnail' => $new_file_path
                                    );
                                    edit_slider_thumbnail($data, $old_file_path);

                                    delete_image($old_file_path);
                                }
                            } else {
                                $data = array(
                                    'status' => '0',
                                );
                                edit_slider($data, $id);
                            }
                            redirect("?mod=slider&action=index{$page}");
                        }
                    }
                } elseif ($_POST['actions'] == 2) {
                    foreach ($_POST['checkItem'] as $item) {
                        $id = $item;
                        $slider = get_slider_by_id($id);
                        isset($_GET['page']) ? $page = "&page={$_GET['page']}" : null;

                        if (!empty($slider) && $slider['status'] != 2) {
                            $slider_code = $slider['slider_code'];
                            $slider_thumbnail = get_list_slider_thumbnail($slider_code);
                            if (!empty($slider_thumbnail)) {
                                foreach ($slider_thumbnail as $item) {
                                    $old_file_path = $item['thumbnail'];
                                    $new_file_path = str_replace('products', 'products/trash', $old_file_path);
                                    copy($old_file_path, $new_file_path);

                                    $data = array(
                                        'status' => '2',
                                    );
                                    edit_slider($data, $id);

                                    $data = array(
                                        'thumbnail' => $new_file_path
                                    );
                                    edit_slider_thumbnail($data, $old_file_path);
                                    delete_image($old_file_path);
                                }
                            } else {
                                $data = array(
                                    'status' => '2',
                                );
                                edit_slider($data, $id);
                            }
                            redirect("?mod=slider&action=index{$page}");
                        }
                    }
                }
            }
        }
        load_view('index', $data);
    }
}

function addSliderAction() {
    load('helper', 'image');

    global $error, $title, $desc;
    if (isset($_POST['btn-submit'])) {
        $error = array();

        if (empty($_POST['title'])) {
            $error['title'] = "Hãy nhập tên slider";
        } else {
            if (is_exists("tbl_slider", "title", $_POST['title'])) {
                $error['title'] = "Slider đã tồn tại";
            } else {
                $title = $_POST['title'];
            }
        }

        // if (empty($_POST['slug'])) {
        //     $error['slug'] = "Hãy nhập slug";
        // } else {
        //     if (is_exists("tbl_product", "slug", create_slug($_POST['slug']))) {
        //         $error['slug'] = "Slug đã tồn tại";
        //     }
        //     $slug = create_slug($_POST['slug']);
        // }

        if (empty($_POST['product_code'])) {
            $error['product_code'] = "Hãy nhập mã sản phẩm";
        } else {
            if (is_exists("tbl_slider", "product_code", $_POST['product_code'])) {
                $error['product_code'] = "Mã sản phẩm đã tồn tại";
            } else {
                $product_code = $_POST['product_code'];
            }
        }

        if (!empty($_POST['desc'])) {
            $desc = $_POST['desc'];
        }

        if (isset($_FILES['file']) && !empty($_FILES['file']['name']) && ($_FILES['file']['error'][0] != 4)) {

            $num_images = count($_FILES['file']['name']);
            for ($i = 0; $i < $num_images; $i++) {

                $type = pathinfo($_FILES['file']['name'][$i], PATHINFO_EXTENSION);
                $size = $_FILES['file']['size'][$i];

                if (!is_image($type, $size)) {
                    $error['upload_image'] = "Có hình không hợp lệ";
                } else {
                    $file = $_FILES;
                }
            }
        }


        if (empty($error)) {
            $creator = get_admin_info($_SESSION['user_login']);
            $created_date = time();
            $slider_code = rand();

            if (!empty($file)) {
                $thumbnail = array();
                $num_images = count($file['file']['name']);

                for ($i = 0; $i < $num_images; $i++) {

                    $name = $file['file']['name'][$i];
                    $tmp_name = $file['file']['tmp_name'][$i];
                    $dir = 'public/images/uploads/slider/products/';
                    $type = pathinfo($file['file']['name'][$i], PATHINFO_EXTENSION);
                    $size = $file['file']['size'][$i];

                    $thumbnail = upload_multi_image($name, $tmp_name, $dir, $type);
                    $data = array(
                        'slider_code' => $slider_code,
                        'thumbnail' => $thumbnail,
                    );
                    add_slider_thumbnail($data);
                }
                $data = array(
                    'title' => $title,
                    'product_code' => $product_code,
                    // 'slug' => $slug,
                    'description' => $desc,
                    'creator' => $creator,
                    'created_date' => $created_date,
                    'slider_code' => $slider_code
                );
                add_slider($data);
            } else {
                $data = array(
                    'title' => $title,
                    'product_code' => $product_code,
                    // 'slug' => $slug,
                    'description' => $desc,
                    'creator' => $creator,
                    'created_date' => $created_date,
                    'slider_code' => $slider_code,
                );
                add_slider($data);
            }
            redirect("?mod=slider&action=index");
        }
    }
    load_view('addSlider');
}

function editSliderAction() {
    load('helper', 'image');

    $id = (int) $_GET['id'];

    global $error, $title, $desc, $product_code;

    $slider = get_slider_by_id($id);

    if ($slider['status'] == 2) {
        redirect("?mod=slider&action=index");
    }
    $list_slider_thumbnail = get_list_slider_thumbnail($slider['slider_code']);
    $data['list_slider_thumbnail'] = $list_slider_thumbnail;
    $data['slider'] = $slider;

    if (isset($_POST['btn-submit'])) {
        $error = array();

        if (empty($_POST['title'])) {
            $title = $slider['title'];
        } else {
            $title = $_POST['title'];
        }

        if (empty($_POST['product_code'])) {
            $product_code = $slider['product_code'];
        } else {
            $product_code = $_POST['product_code'];
        }

        if (empty($_POST['desc'])) {
            $desc = $slider['description'];
        } else {
            $desc = $_POST['desc'];
        }

        if (isset($_FILES['file']) && !empty($_FILES['file']['name']) && ($_FILES['file']['error'][0] != 4)) {

            $num_images = count($_FILES['file']['name']);
            for ($i = 0; $i < $num_images; $i++) {

                $type = pathinfo($_FILES['file']['name'][$i], PATHINFO_EXTENSION);
                $size = $_FILES['file']['size'][$i];

                if (!is_image($type, $size)) {
                    $error['upload_image'] = "Có hình không hợp lệ";
                }
            }
            if (empty($error['upload_image'])) {
                $file = $_FILES;
            }
        }

        if (empty($error)) {
            $editor = get_admin_info($_SESSION['user_login']);
            $edit_date = time();

            if (!empty($file)) {

                $num_images = count($file['file']['name']);
                for ($i = 0; $i < $num_images; $i++) {

                    $name = $file['file']['name'][$i];
                    $tmp_name = $file['file']['tmp_name'][$i];
                    $dir = 'public/images/uploads/slider/products/';
                    $type = pathinfo($file['file']['name'][$i], PATHINFO_EXTENSION);
                    $size = $file['file']['size'][$i];

                    $thumbnail = upload_multi_image($name, $tmp_name, $dir, $type);
                    $data = array(
                        'slider_code' => $slider['slider_code'],
                        'thumbnail' => $thumbnail,
                    );
                    add_slider_thumbnail($data);
                }

                $num_images = count($list_slider_thumbnail);
                foreach ($list_slider_thumbnail as $item) {
                    $old_image_url = $item['thumbnail'];
                    if (delete_image($old_image_url)) {
                        delete_slider_thumbnail($old_image_url);
                    }
                }

                $data = array(
                    'title' => $title,
                    // 'slug' => $slug,
                    'description' => $desc,
                    'editor' => $editor,
                    'edit_date' => $edit_date,
                    'product_code' => $product_code
                );
                edit_slider($data, $id);
            } else {
                $data = array(
                    'title' => $title,
                    'description' => $desc,
                    'editor' => $editor,
                    'edit_date' => $edit_date,
                    'product_code' => $product_code
                );
                edit_slider($data, $id);
            }
            redirect("?mod=slider&action=index");
        }
    }

    load_view('editSlider', $data);
}

function approveSliderAction() {
    $id = (int) $_GET['id'];
    $approver = get_admin_info($_SESSION['user_login']);
    $approval_date = time();
    $data = array(
        'status' => '1',
        'approver' => $approver,
        'approval_date' => $approval_date,
    );
    if (approve_slider($data, $id)) {
        redirect("?mod=slider&action=showWaitingSlider");
    };
}

function moveTrashAction() {
    load('helper', 'image');
    $id = $_GET['id'];
    $slider = get_slider_by_id($id);
    $slider_code = $slider['slider_code'];
    $list_slider_thumbnail = get_list_slider_thumbnail($slider_code);

    if ($slider['status'] == 2) {
        redirect("?mod=slider&action=index");
    } else {
        if (!empty($slider)) {
            if (!empty($list_slider_thumbnail)) {
                foreach ($list_slider_thumbnail as $item) {
                    $old_file_path = $item['thumbnail'];
                    $new_file_path = str_replace('products', 'products/trash', $old_file_path);
                    copy($old_file_path, $new_file_path);

                    $data = array(
                        'status' => '2',
                    );
                    edit_slider($data, $id);

                    $data = array(
                        'thumbnail' => $new_file_path,
                    );
                    edit_slider_thumbnail($data, $old_file_path);
                    delete_image($old_file_path);
                }
            } else {
                $data = array(
                    'status' => '2',
                );
                edit_slider($data, $id);
            }

            redirect("?mod=slider&action=index");
        }
        return false;
    }
}

function restoreSliderAction() {
    load('helper', 'image');
    $id = $_GET['id'];
    $slider = get_slider_by_id($id);
    $slider_code = $slider['slider_code'];
    $list_slider_thumbnail = get_list_slider_thumbnail($slider_code);

    if (!empty($slider)) {
        if (!empty($list_slider_thumbnail)) {
            foreach ($list_slider_thumbnail as &$item) {
                $old_file_path = $item['thumbnail'];
                $new_file_path = str_replace('trash/', '', $old_file_path);

                $data = array(
                    'thumbnail' => $new_file_path,
                );
                edit_slider_thumbnail($data, $old_file_path);

                copy($old_file_path, $new_file_path);
                delete_image($old_file_path);

                $data = array(
                    'status' => '0',
                );
                edit_slider($data, $id);
            }
        } else {
            $data = array(
                'status' => '0',
            );
            edit_slider($data, $id);
        }

        redirect("?mod=slider&action=showTrashSlider");
    }
    return false;
}

function deleteSliderAction() {
    load('helper', 'image');
    $id = $_GET['id'];
    $slider = get_slider_by_id($id);
    $slider_code = $slider['slider_code'];
    $list_slider_thumbnail = get_list_slider_thumbnail($slider_code);

    if (!empty($slider)) {
        if (!empty($list_slider_thumbnail)) {
            foreach ($list_slider_thumbnail as $item) {
                $file_path = $item['thumbnail'];
                delete_image($file_path);
                delete_slider_thumbnail($file_path);
            }
        }
        delete_slider($id);
        redirect("?mod=slider&action=showTrashSlider");
    }
    return false;
}

#2 Show the Slider

function showWaitingSliderAction() {
    load('helper', 'format');
    load('lib', 'pagging');
    load('helper', 'css');
    load('helper', 'image');


    $data['num_rows'] = get_num_rows("tbl_slider");
    $data['num_rows_approved'] = get_num_rows("tbl_slider", "`status` = '1'");
    $data['num_rows_waiting'] = get_num_rows("tbl_slider", "`status` = '0'");
    $data['num_rows_trash'] = get_num_rows("tbl_slider", "`status` = '2'");

    $num_per_page = 15;
    $data['num_page'] = ceil($data['num_rows_waiting'] / $num_per_page);
    $data['page'] = isset($_GET['page']) ? $_GET['page'] : 1;
    $start = ($data['page'] - 1) * $num_per_page;

    $data['list_slider'] = get_waiting_slider($start, $num_per_page);

    if (isset($_POST['sm_action'])) {
        if (!empty($_POST['checkItem'])) {
            if ($_POST['actions'] == 1) {
                foreach ($_POST['checkItem'] as $item) {
                    $id = $item;
                    $slider = get_slider_by_id($id);
                    isset($_GET['page']) ? $page = "&page={$_GET['page']}" : null;

                    if (!empty($slider)) {
                        $approver = get_admin_info($_SESSION['user_login']);
                        $approval_date = time();
                        $data = array(
                            'approver' => $approver,
                            'approval_date' => $approval_date,
                            'status' => '1'
                        );
                        edit_slider($data, $id);
                        redirect("?mod=slider&action=showWaitingSlider{$page}");
                    }
                }
            } elseif ($_POST['actions'] == 2) {
                foreach ($_POST['checkItem'] as $item) {
                    $id = $item;
                    $slider = get_slider_by_id($id);
                    isset($_GET['page']) ? $page = "&page={$_GET['page']}" : null;

                    if (!empty($slider) && $slider['status'] != 2) {
                        $slider_code = $slider['slider_code'];
                        $slider_thumbnail = get_list_slider_thumbnail($slider_code);

                        if (!empty($slider_thumbnail)) {
                            foreach ($slider_thumbnail as $item) {
                                $old_file_path = $item['thumbnail'];
                                $new_file_path = str_replace('products', 'products/trash', $old_file_path);
                                copy($old_file_path, $new_file_path);
                                $data = array(
                                    'status' => '2',
                                );
                                edit_slider($data, $id);

                                $data = array(
                                    'thumbnail' => $new_file_path
                                );
                                edit_slider_thumbnail($data, $old_file_path);
                                delete_image($old_file_path);
                            }
                        } else {
                            $data = array(
                                'status' => '2',
                            );
                            edit_slider($data, $id);
                        }
                        redirect("?mod=slider&action=showWaitingSlider{$page}");
                    }
                }
            }
        }
    }

    load_view('showWaitingSlider', $data);
}

function showApprovedSliderAction() {
    load('helper', 'format');
    load('lib', 'pagging');
    load('helper', 'css');
    load('helper', 'image');

    $data['num_rows'] = get_num_rows("tbl_slider");
    $data['num_rows_approved'] = get_num_rows("tbl_slider", "`status` = '1'");
    $data['num_rows_waiting'] = get_num_rows("tbl_slider", "`status` = '0'");
    $data['num_rows_trash'] = get_num_rows("tbl_slider", "`status` = '2'");

    $num_per_page = 15;
    $data['num_page'] = ceil($data['num_rows_approved'] / $num_per_page);

    $data['page'] = isset($_GET['page']) ? $_GET['page'] : 1;
    $start = ($data['page'] - 1) * $num_per_page;

    $data['list_slider'] = get_approved_slider($start, $num_per_page);

    if (isset($_POST['sm_action'])) {
        if (!empty($_POST['checkItem'])) {
            if ($_POST['actions'] == 1) {
                foreach ($_POST['checkItem'] as $item) {
                    $id = $item;
                    $slider = get_slider_by_id($id);
                    isset($_GET['page']) ? $page = "&page={$_GET['page']}" : null;

                    if (!empty($slider) && $slider['status'] == 1) {
                        $editor = get_admin_info($_SESSION['user_login']);
                        $edit_date = time();
                        $data = array(
                            'editor' => $editor,
                            'edit_date' => $edit_date,
                            'status' => '0',
                        );
                        edit_slider($data, $id);
                        redirect("?mod=slider&action=index{$page}");
                    }
                }
            } elseif ($_POST['actions'] == 2) {
                foreach ($_POST['checkItem'] as $item) {
                    $id = $item;
                    $slider = get_slider_by_id($id);
                    isset($_GET['page']) ? $page = "&page={$_GET['page']}" : null;

                    if (!empty($slider) && $slider['status'] != 2) {
                        $slider_code = $slider['slider_code'];
                        $slider_thumbnail = get_list_slider_thumbnail($slider_code);
                        if (!empty($slider_thumbnail)) {
                            foreach ($slider_thumbnail as $item) {
                                $old_file_path = $item['thumbnail'];
                                $new_file_path = str_replace('products', 'products/trash', $old_file_path);
                                copy($old_file_path, $new_file_path);

                                $data = array(
                                    'status' => '2',
                                );
                                edit_slider($data, $id);

                                $data = array(
                                    'thumbnail' => $new_file_path
                                );
                                edit_slider_thumbnail($data, $old_file_path);
                                delete_image($old_file_path);
                            }
                        } else {
                            $data = array(
                                'status' => '2',
                            );
                            edit_slider($data, $id);
                        }

                        redirect("?mod=slider&action=index{$page}");
                    }
                }
            }
        }
    }

    load_view('showApprovedSlider', $data);
}

function showTrashSliderAction() {
    load('helper', 'format');
    load('lib', 'pagging');
    load('helper', 'css');
    load('helper', 'image');

    $data['num_rows'] = get_num_rows("tbl_slider");
    $data['num_rows_approved'] = get_num_rows("tbl_slider", "`status` = '1'");
    $data['num_rows_waiting'] = get_num_rows("tbl_slider", "`status` = '0'");
    $data['num_rows_trash'] = get_num_rows("tbl_slider", "`status` = '2'");

    $num_per_page = 15;
    $data['num_page'] = ceil($data['num_rows_trash'] / $num_per_page);
    $data['page'] = isset($_GET['page']) ? $_GET['page'] : 1;

    $start = ($data['page'] - 1) * $num_per_page;
    $data['list_slider'] = get_trash_slider($start, $num_per_page);

    if (isset($_POST['sm_action'])) {
        if (!empty($_POST['checkItem'])) {
            if ($_POST['actions'] == 1) {
                foreach ($_POST['checkItem'] as $item) {
                    $id = $item;
                    $slider = get_slider_by_id($id);
                    isset($_GET['page']) ? $page = "&page={$_GET['page']}" : null;

                    if (!empty($slider)) {
                        $slider_code = $slider['slider_code'];
                        $slider_thumbnail = get_list_slider_thumbnail($slider_code);

                        if (!empty($slider_thumbnail)) {
                            foreach ($slider_thumbnail as $item) {
                                $old_file_path = $item['thumbnail'];
                                $new_file_path = str_replace('trash/', '', $old_file_path);
                                copy($old_file_path, $new_file_path);

                                $data = array(
                                    'status' => '0',
                                );
                                edit_slider($data, $id);

                                $data = array(
                                    'thumbnail' => $new_file_path
                                );
                                edit_slider_thumbnail($data, $old_file_path);
                                delete_image($old_file_path);
                            }
                        } else {
                            $data = array(
                                'status' => '0',
                            );
                            edit_slider($data, $id);
                        }
                        redirect("?mod=slider&action=showTrashSlider{$page}");
                    }
                }
            } elseif ($_POST['actions'] == 2) {
                foreach ($_POST['checkItem'] as $item) {
                    $id = $item;
                    $slider = get_slider_by_id($id);
                    isset($_GET['page']) ? $page = "&page={$_GET['page']}" : null;
                    if (!empty($slider)) {
                        $slider_code = $slider['slider_code'];
                        $slider_thumbnail = get_list_slider_thumbnail($slider_code);

                        if (!empty($slider_thumbnail)) {
                            foreach ($slider_thumbnail as $item) {
                                $file_path = $item['thumbnail'];
                                delete_slider_thumbnail($file_path);
                                delete_slider($id);
                                delete_image($file_path);
                            }
                        } else {
                            delete_slider($id);
                        }

                        redirect("?mod=slider&action=showTrashSlider{$page}");
                    }
                }
            }
        }
    }

    load_view('showTrashSlider', $data);
}