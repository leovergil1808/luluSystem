<?php

function construct() {
    load('lib', 'validation');
    load_model('index');
}

// Function for Products
#1 Control the products
function indexAction() {
    load('helper', 'format');
    load('lib', 'pagging');
    load('helper', 'css');
    load('helper', 'image');
    load('helper', 'string');

    if (isset($_GET['sm_s']) && !empty($_GET['s']) && !empty($_GET['search_by'])) {

        # Search Engine
        $s = $_GET['s'];
        $search_by = $_GET['search_by'];
        $mod = $_GET['mod'];

        # Calc Pagination
        $num_per_page = 4;
        $data['search_by'] = $search_by;
        $data['s'] = $s;

        $data['num_rows'] = get_num_rows("tbl_product", "`{$search_by}` LIKE '%{$s}%'");
        $data['num_page'] = ceil($data['num_rows'] / $num_per_page);
        $data['page'] = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $start = ($data['page'] - 1) * $num_per_page;


        $data['list_product'] = search_item("tbl_product", $search_by, $s, $start, $num_per_page);

        # Control the Checkbox by Value
        if (isset($_POST['sm_action'])) {
            if (!empty($_POST['checkItem'])) {
                # Checkbox = 1 : Edit Item, Checkbox = 2 : Move Trash Item, Checkbox = 3 : Stocking, Checkbox = 4 : Out of Stock, Checkbox = 5 : Temporary Out, Checkbox = 6 : Importing Goods
                if ($_POST['actions'] == 1) {
                    foreach ($_POST['checkItem'] as $item) {
                        $id = $item;
                        $product = get_product_by_id($id);
                        isset($_GET['page']) ? $page = "&page={$_GET['page']}" : null;

                        if (!empty($product) && $product['status'] == 1) {
                            $editor = get_admin_info($_SESSION['user_login']);
                            $edit_date = time();
                            $data = array(
                                'editor' => $editor,
                                'edit_date' => $edit_date,
                                'status' => '0',
                            );
                            edit_product($data, $id);
                            redirect("?mod=products&action=index{$page}");
                        } elseif (!empty($product) && $product['status'] == 2) {
                            $old_file_path = $product['thumbnail'];
                            $new_file_path = str_replace('trash/', '', $old_file_path);
                            copy($old_file_path, $new_file_path);
                            $data = array(
                                'status' => '0',
                                'thumbnail' => $new_file_path
                            );
                            edit_product($data, $id);
                            delete_image($old_file_path);
                            redirect("?mod=products&action=index&search_by={$search_by}&s={$s}&sm_s=Tìm+kiếm{$page}");
                        }
                    }
                } elseif ($_POST['actions'] == 2) {
                    foreach ($_POST['checkItem'] as $item) {
                        $id = $item;
                        $product = get_product_by_id($id);
                        isset($_GET['page']) ? $page = "&page={$_GET['page']}" : null;

                        if (!empty($product) && $product['status'] != 2) {
                            $old_file_path = $product['thumbnail'];
                            $new_file_path = str_replace('products', 'products/trash', $old_file_path);
                            copy($old_file_path, $new_file_path);
                            $data = array(
                                'status' => '2',
                                'thumbnail' => $new_file_path
                            );
                            edit_product($data, $id);
                            delete_image($old_file_path);
                            redirect("?mod=products&action=index&search_by={$search_by}&s={$s}&sm_s=Tìm+kiếm{$page}");
                        }
                    }
                } elseif ($_POST['actions'] == 3) {
                    foreach ($_POST['checkItem'] as $item) {
                        $id = $item;
                        $product = get_product_by_id($id);
                        isset($_GET['page']) ? $page = "&page={$_GET['page']}" : null;

                        if (!empty($product) && $product['tracking'] != 1) {
                            $editor = get_admin_info($_SESSION['user_login']);
                            $edit_date = time();
                            $data = array(
                                'editor' => $editor,
                                'edit_date' => $edit_date,
                                'tracking' => '1',
                            );
                            edit_product($data, $id);
                            redirect("?mod=products&action=index&search_by={$search_by}&s={$s}&sm_s=Tìm+kiếm{$page}");
                        }
                    }
                } elseif ($_POST['actions'] == 4) {
                    foreach ($_POST['checkItem'] as $item) {
                        $id = $item;
                        $product = get_product_by_id($id);
                        isset($_GET['page']) ? $page = "&page={$_GET['page']}" : null;

                        if (!empty($product) && $product['tracking'] != 2) {
                            $editor = get_admin_info($_SESSION['user_login']);
                            $edit_date = time();
                            $data = array(
                                'editor' => $editor,
                                'edit_date' => $edit_date,
                                'tracking' => '2',
                            );
                            edit_product($data, $id);
                            redirect("?mod=products&action=index&search_by={$search_by}&s={$s}&sm_s=Tìm+kiếm{$page}");
                        }
                    }
                } elseif ($_POST['actions'] == 5) {
                    foreach ($_POST['checkItem'] as $item) {
                        $id = $item;
                        $product = get_product_by_id($id);
                        isset($_GET['page']) ? $page = "&page={$_GET['page']}" : null;

                        if (!empty($product) && $product['tracking'] != 3) {
                            $editor = get_admin_info($_SESSION['user_login']);
                            $edit_date = time();
                            $data = array(
                                'editor' => $editor,
                                'edit_date' => $edit_date,
                                'tracking' => '3',
                            );
                            edit_product($data, $id);
                            redirect("?mod=products&action=index&search_by={$search_by}&s={$s}&sm_s=Tìm+kiếm{$page}");
                        }
                    }
                } elseif ($_POST['actions'] == 6) {
                    foreach ($_POST['checkItem'] as $item) {
                        $id = $item;
                        $product = get_product_by_id($id);
                        isset($_GET['page']) ? $page = "&page={$_GET['page']}" : null;

                        if (!empty($product) && $product['tracking'] != 4) {
                            $editor = get_admin_info($_SESSION['user_login']);
                            $edit_date = time();
                            $data = array(
                                'editor' => $editor,
                                'edit_date' => $edit_date,
                                'tracking' => '4',
                            );
                            edit_product($data, $id);
                            redirect("?mod=products&action=index&search_by={$search_by}&s={$s}&sm_s=Tìm+kiếm{$page}");
                        }
                    }
                }
            }
        }

        load_view('showSearchProduct', $data);
    } else {

        # Calc Pagination
        $data['num_rows'] = get_num_rows("tbl_product");
        $data['num_rows_approved'] = get_num_rows("tbl_product", "`status` = '1'");
        $data['num_rows_waiting'] = get_num_rows("tbl_product", "`status` = '0'");
        $data['num_rows_trash'] = get_num_rows("tbl_product", "`status` = '2'");

        $num_per_page = 4;
        $data['num_page'] = ceil($data['num_rows'] / $num_per_page);

        $data['page'] = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $start = ($data['page'] - 1) * $num_per_page;

        $data['list_product'] = get_list_product($start, $num_per_page);

        if (isset($_POST['sm_action'])) {
            if (!empty($_POST['checkItem'])) {
                if ($_POST['actions'] == 1) {
                    foreach ($_POST['checkItem'] as $item) {
                        $id = $item;
                        $product = get_product_by_id($id);
                        isset($_GET['page']) ? $page = "&page={$_GET['page']}" : null;

                        if (!empty($product) && $product['status'] == 1) {
                            $editor = get_admin_info($_SESSION['user_login']);
                            $edit_date = time();
                            $data = array(
                                'editor' => $editor,
                                'edit_date' => $edit_date,
                                'status' => '0',
                            );
                            edit_product($data, $id);
                            redirect("?mod=products&action=index{$page}");
                        } elseif (!empty($product) && $product['status'] == 2) {
                            $old_file_path = $product['thumbnail'];
                            $new_file_path = str_replace('trash/', '', $old_file_path);
                            copy($old_file_path, $new_file_path);
                            $data = array(
                                'status' => '0',
                                'thumbnail' => $new_file_path
                            );
                            edit_product($data, $id);
                            delete_image($old_file_path);
                            redirect("?mod=products&action=index{$page}");
                        }
                    }
                } elseif ($_POST['actions'] == 2) {
                    foreach ($_POST['checkItem'] as $item) {
                        $id = $item;
                        $product = get_product_by_id($id);
                        isset($_GET['page']) ? $page = "&page={$_GET['page']}" : null;

                        if (!empty($product) && $product['status'] != 2) {
                            $old_file_path = $product['thumbnail'];
                            $new_file_path = str_replace('products', 'products/trash', $old_file_path);
                            copy($old_file_path, $new_file_path);
                            $data = array(
                                'status' => '2',
                                'thumbnail' => $new_file_path
                            );
                            edit_product($data, $id);
                            delete_image($old_file_path);
                            redirect("?mod=products&action=index{$page}");
                        }
                    }
                } elseif ($_POST['actions'] == 3) {
                    foreach ($_POST['checkItem'] as $item) {
                        $id = $item;
                        $product = get_product_by_id($id);
                        isset($_GET['page']) ? $page = "&page={$_GET['page']}" : null;

                        if (!empty($product) && $product['tracking'] != 1) {
                            $editor = get_admin_info($_SESSION['user_login']);
                            $edit_date = time();
                            $data = array(
                                'editor' => $editor,
                                'edit_date' => $edit_date,
                                'tracking' => '1',
                            );
                            edit_product($data, $id);
                            redirect("?mod=products&action=index{$page}");
                        }
                    }
                } elseif ($_POST['actions'] == 4) {
                    foreach ($_POST['checkItem'] as $item) {
                        $id = $item;
                        $product = get_product_by_id($id);
                        isset($_GET['page']) ? $page = "&page={$_GET['page']}" : null;

                        if (!empty($product) && $product['tracking'] != 2) {
                            $editor = get_admin_info($_SESSION['user_login']);
                            $edit_date = time();
                            $data = array(
                                'editor' => $editor,
                                'edit_date' => $edit_date,
                                'tracking' => '2',
                            );
                            edit_product($data, $id);
                            redirect("?mod=products&action=index{$page}");
                        }
                    }
                } elseif ($_POST['actions'] == 5) {
                    foreach ($_POST['checkItem'] as $item) {
                        $id = $item;
                        $product = get_product_by_id($id);
                        isset($_GET['page']) ? $page = "&page={$_GET['page']}" : null;

                        if (!empty($product) && $product['tracking'] != 3) {
                            $editor = get_admin_info($_SESSION['user_login']);
                            $edit_date = time();
                            $data = array(
                                'editor' => $editor,
                                'edit_date' => $edit_date,
                                'tracking' => '3',
                            );
                            edit_product($data, $id);
                            redirect("?mod=products&action=index{$page}");
                        }
                    }
                } elseif ($_POST['actions'] == 6) {
                    foreach ($_POST['checkItem'] as $item) {
                        $id = $item;
                        $product = get_product_by_id($id);
                        isset($_GET['page']) ? $page = "&page={$_GET['page']}" : null;

                        if (!empty($product) && $product['tracking'] != 4) {
                            $editor = get_admin_info($_SESSION['user_login']);
                            $edit_date = time();
                            $data = array(
                                'editor' => $editor,
                                'edit_date' => $edit_date,
                                'tracking' => '4',
                            );
                            edit_product($data, $id);
                            redirect("?mod=products&action=index{$page}");
                        }
                    }
                }
            }
        }

        load_view('index', $data);
    }
}

function addProductAction() {
    load('helper', 'image');
    load('helper', 'slug');

    global $error, $product_title, $slug, $product_code, $product_price, $product_content, $product_description, $product_detail, $checked_featured, $checked_best_seller;

    $data['list_product_cat'] = get_list_product_cat();

    if (isset($_POST['btn-submit'])) {
        $error = array();

        if (empty($_POST['product_title'])) {
            $error['product_title'] = "Hãy nhập tên sản phẩm";
        } else {
            if (is_exists("tbl_product", "title", $_POST['product_title'])) {
                $error['product_title'] = "Sản phẩm đã tồn tại";
            } else {
                $product_title = $_POST['product_title'];
            }
        }

        if (empty($_POST['featured'])) {
            $checked = "";
        } else {
            $featured = $_POST['featured'];
            $checked_featured = "checked = 'checked'";
        }

        if (empty($_POST['best_seller'])) {
            $checked = "";
        } else {
            $best_seller = $_POST['best_seller'];
            $checked_best_seller = "checked = 'checked'";
        }

        if (empty($_POST['slug'])) {
            $error['slug'] = "Hãy nhập slug";
        } else {
            if (is_exists("tbl_product", "slug", create_slug($_POST['slug']))) {
                $error['slug'] = "Slug đã tồn tại";
            }
            $slug = create_slug($_POST['slug']);
        }

        if (!empty($_POST['product_code'])) {
            if (is_exists("tbl_product", "code", $_POST['product_code'])) {
                $error['product_code'] = "Mã đã tồn tại";
            } else {
                $product_code = $_POST['product_code'] . rand(1000, 9999);
            }
        }

        if (!empty($_POST['product_price'])) {
            $product_price = $_POST['product_price'];
        }

        if (!empty($_POST['product_content'])) {
            $product_content = $_POST['product_content'];
        }

        if (!empty($_POST['product_description'])) {
            $product_description = $_POST['product_description'];
        }

        if (!empty($_POST['product_detail'])) {
            $product_detail = $_POST['product_detail'];
        }

        if (isset($_FILES['file']) && !empty($_FILES['file']['name'])) {
            $type = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $size = $_FILES['file']['size'];
            if (!is_image($type, $size)) {
                $error['upload_image'] = "Size hoặc kiểu ảnh không đúng";
            } else {
                $product_thumbnail = upload_image('public/images/uploads/products/', $type);
                if (!$product_thumbnail) {
                    $error['upload_image'] = "Upload không thành công";
                }
            }
        }

        if (!empty($_POST['cat_id'])) {
            $cat_id = $_POST['cat_id'];
        }

        if (empty($error)) {
            $creator = get_admin_info($_SESSION['user_login']);
            $created_date = time();
            $slider_code = rand();
            $data = array(
                'title' => $product_title,
                'featured' => $featured,
                'best_seller' => $best_seller,
                'slug' => $slug,
                'code' => $product_code,
                'price' => $product_price,
                'content' => $product_content,
                'description' => $product_description,
                'detail' => $product_detail,
                'thumbnail' => $product_thumbnail,
                'creator' => $creator,
                'created_date' => $created_date,
                'cat_id' => $cat_id,
                'slider_code' => $slider_code
            );
            add_product($data);
            redirect("?mod=products&action=showWaitingProduct");
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
                redirect("?mod=products&controller=index&action=index");
            }
        } else {
            $error['upload_image'] = "Không có ảnh upload";
        }
    }
    load_view('addProduct', $data);
}

function approveProductAction() {
    if(is_login() && check_role($_SESSION['user_login']) <= 2){
        $id = (int) $_GET['id'];
        $approver = get_admin_info($_SESSION['user_login']);
        $approval_date = time();
        $data = array(
            'status' => '1',
            'approver' => $approver,
            'approval_date' => $approval_date,
        );
        if (approve_product($data, $id)) {
            redirect("?mod=products&action=showWaitingProduct");
        };
    }else{
        redirect("?mod=products&action=showWaitingProduct");
    }
    
}

function editProductAction() {
    load('helper', 'image');
    load('helper', 'slug');
    $id = (int) $_GET['id'];

    global $error, $checked_featured, $checked_best_seller, $featured, $best_seller;

    $product = get_product_by_id($id);
    $data['product'] = $product;
    $data['list_product_cat'] = get_list_product_cat();

    $featured = $product['featured'];
    $best_seller = $product['best_seller'];

    $featured == 1 ? $checked_featured = "checked = 'checked'" : $checked_featured = "";
    $best_seller == 1 ? $checked_best_seller = "checked = 'checked'" : $checked_best_seller = "";

    if (isset($_POST['btn-submit'])) {
        $error = array();

        if (empty($_POST['product_title'])) {
            $product_title = $product['title'];
        } else {
            $product_title = $_POST['product_title'];
        }

        if (!empty($_POST['featured'])) {
            $featured = $_POST['featured'];
        } else {
            $featured = 0;
        }

        if (!empty($_POST['best_seller'])) {
            $best_seller = $_POST['best_seller'];
        } else {
            $best_seller = 0;
        }

        if (empty($_POST['slug'])) {
            $slug = $product['slug'];
        } else {
            $slug = create_slug($_POST['slug']);
        }

        // if(empty($_POST['product_code'])){
        //     $product_code = $product['code'];
        // }else{
        //     $product_code = $_POST['product_code'] . rand(1000,9999);
        // }

        if (empty($_POST['product_price'])) {
            $product_price = $product['price'];
        } else {
            $product_price = $_POST['product_price'];
        }

        if (empty($_POST['old_price'])) {
            $old_price = $product['old_price'];
        } else {
            $old_price = $_POST['old_price'];
        }

        if (empty($_POST['product_content'])) {
            $product_content = $product['content'];
        } else {
            $product_content = $_POST['product_content'];
        }

        if (empty($_POST['product_description'])) {
            $product_description = $product['description'];
        } else {
            $product_description = $_POST['product_description'];
        }

        if (empty($_POST['product_detail'])) {
            $product_detail = $product['detail'];
        } else {
            $product_detail = $_POST['product_detail'];
        }

        if (isset($_FILES['file']) && !empty($_FILES['file']['name'])) {

            $type = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $size = $_FILES['file']['size'];

            if (!is_image($type, $size)) {
                $error['upload_image'] = "Size hoặc kiểu ảnh không đúng";
            } else {
                $old_thumbnail = $product['thumbnail'];
                if (!empty($old_thumbnail)) {
                    if (delete_image($old_thumbnail)) {
                        $product_thumbnail = upload_image('public/images/uploads/products/', $type);
                    } else {
                        $error['upload_image'] = "Xoá ảnh ko thành công";
                    }
                } else {
                    $product_thumbnail = upload_image('public/images/uploads/products/', $type);
                }
            }
        } else {
            $product_thumbnail = $product['thumbnail'];
        }

        if (empty($_POST['cat_id'])) {
            $cat_id = $product['cat_id'];
        } else {
            $cat_id = $_POST['cat_id'];
        }

        if (empty($error)) {
            $editor = get_admin_info($_SESSION['user_login']);
            $edit_date = time();
            $data = array(
                'title' => $product_title,
                'featured' => $featured,
                'best_seller' => $best_seller,
                'slug' => $slug,
                // 'code' => $product_code,
                'price' => $product_price,
                'old_price' => $old_price,
                'content' => $product_content,
                'description' => $product_description,
                'detail' => $product_detail,
                'thumbnail' => $product_thumbnail,
                'editor' => $editor,
                'edit_date' => $edit_date,
                'cat_id' => $cat_id
            );
            edit_product($data, $id);
            redirect("?mod=products&controller=index&action=index");
        }
    }
    load_view('editProduct', $data);
}

function moveTrashAction() {
    if(is_login() && check_role($_SESSION['user_login']) <= 2){
        load('helper', 'image');
        $id = $_GET['id'];
        $product = get_product_by_id($id);

        if (!empty($product)) {
            $old_file_path = $product['thumbnail'];
            $new_file_path = str_replace('products', 'products/trash', $old_file_path);

            copy($old_file_path, $new_file_path);
            $data = array(
                'status' => '2',
                'thumbnail' => $new_file_path
            );
            edit_product($data, $id);
            delete_image($old_file_path);
            redirect("?mod=products&action=index");
        }
        return false;
    }else{
        redirect("?mod=products&action=index");
    }
    
}

function restoreProductAction() {
    load('helper', 'image');
    $id = $_GET['id'];
    $product = get_product_by_id($id);
    if (!empty($product)) {
        $old_file_path = $product['thumbnail'];
        $new_file_path = str_replace('trash/', '', $old_file_path);

        copy($old_file_path, $new_file_path);
        $data = array(
            'status' => '0',
            'thumbnail' => $new_file_path
        );
        edit_product($data, $id);
        delete_image($old_file_path);
        redirect("?mod=products&controller=index&action=showTrashProduct");
    }
    return false;
}

function deleteProductAction() {
    if(is_login() && check_role($_SESSION['user_login']) <= 2){
        load('helper', 'image');
        $id = $_GET['id'];
        $product = get_product_by_id($id);
        if (!empty($product)) {
            delete_product($id);
            $file_path = $product['thumbnail'];
            delete_image($file_path);
            redirect("?mod=products&action=showTrashProduct");
        }
        return false;
    }else{
        redirect("?mod=products&action=showTrashProduct");
    }
    
}

#2 Show the Product

function showWaitingProductAction() {
    load('helper', 'format');
    load('lib', 'pagging');
    load('helper', 'css');
    load('helper', 'image');


    $data['num_rows'] = get_num_rows("tbl_product");
    $data['num_rows_approved'] = get_num_rows("tbl_product", "`status` = '1'");
    $data['num_rows_waiting'] = get_num_rows("tbl_product", "`status` = '0'");
    $data['num_rows_trash'] = get_num_rows("tbl_product", "`status` = '2'");

    $num_per_page = 4;
    $data['num_page'] = ceil($data['num_rows_waiting'] / $num_per_page);
    $data['page'] = isset($_GET['page']) ? $_GET['page'] : 1;
    $start = ($data['page'] - 1) * $num_per_page;

    $data['list_product'] = get_waiting_product($start, $num_per_page);

    if (isset($_POST['sm_action'])) {
        if (!empty($_POST['checkItem'])) {
            if ($_POST['actions'] == 1) {
                foreach ($_POST['checkItem'] as $item) {
                    $id = $item;
                    $product = get_product_by_id($id);
                    isset($_GET['page']) ? $page = "&page={$_GET['page']}" : null;

                    if (!empty($product)) {
                        $approver = get_admin_info($_SESSION['user_login']);
                        $approval_date = time();
                        $data = array(
                            'approver' => $approver,
                            'approval_date' => $approval_date,
                            'status' => '1'
                        );
                        edit_product($data, $id);
                        redirect("?mod=products&action=showWaitingProduct{$page}");
                    }
                }
            } elseif ($_POST['actions'] == 2) {
                foreach ($_POST['checkItem'] as $item) {
                    $id = $item;
                    $product = get_product_by_id($id);
                    isset($_GET['page']) ? $page = "&page={$_GET['page']}" : null;

                    if (!empty($product) && $product['status'] != 2) {
                        $old_file_path = $product['thumbnail'];
                        $new_file_path = str_replace('products', 'products/trash', $old_file_path);
                        copy($old_file_path, $new_file_path);
                        $data = array(
                            'status' => '2',
                            'thumbnail' => $new_file_path
                        );
                        edit_product($data, $id);
                        delete_image($old_file_path);
                        redirect("?mod=products&action=showWaitingProduct{$page}");
                    }
                }
            } elseif ($_POST['actions'] == 3) {
                foreach ($_POST['checkItem'] as $item) {
                    $id = $item;
                    $product = get_product_by_id($id);
                    isset($_GET['page']) ? $page = "&page={$_GET['page']}" : null;

                    if (!empty($product) && $product['tracking'] != 1) {
                        $editor = get_admin_info($_SESSION['user_login']);
                        $edit_date = time();
                        $data = array(
                            'editor' => $editor,
                            'edit_date' => $edit_date,
                            'tracking' => '1',
                        );
                        edit_product($data, $id);
                        redirect("?mod=products&action=showWaitingProduct{$page}");
                    }
                }
            } elseif ($_POST['actions'] == 4) {
                foreach ($_POST['checkItem'] as $item) {
                    $id = $item;
                    $product = get_product_by_id($id);
                    isset($_GET['page']) ? $page = "&page={$_GET['page']}" : null;

                    if (!empty($product) && $product['tracking'] != 2) {
                        $editor = get_admin_info($_SESSION['user_login']);
                        $edit_date = time();
                        $data = array(
                            'editor' => $editor,
                            'edit_date' => $edit_date,
                            'tracking' => '2',
                        );
                        edit_product($data, $id);
                        redirect("?mod=products&action=showWaitingProduct{$page}");
                    }
                }
            } elseif ($_POST['actions'] == 5) {
                foreach ($_POST['checkItem'] as $item) {
                    $id = $item;
                    $product = get_product_by_id($id);
                    isset($_GET['page']) ? $page = "&page={$_GET['page']}" : null;

                    if (!empty($product) && $product['tracking'] != 3) {
                        $editor = get_admin_info($_SESSION['user_login']);
                        $edit_date = time();
                        $data = array(
                            'editor' => $editor,
                            'edit_date' => $edit_date,
                            'tracking' => '3',
                        );
                        edit_product($data, $id);
                        redirect("?mod=products&action=showWaitingProduct{$page}");
                    }
                }
            } elseif ($_POST['actions'] == 6) {
                foreach ($_POST['checkItem'] as $item) {
                    $id = $item;
                    $product = get_product_by_id($id);
                    isset($_GET['page']) ? $page = "&page={$_GET['page']}" : null;

                    if (!empty($product) && $product['tracking'] != 4) {
                        $editor = get_admin_info($_SESSION['user_login']);
                        $edit_date = time();
                        $data = array(
                            'editor' => $editor,
                            'edit_date' => $edit_date,
                            'tracking' => '4',
                        );
                        edit_product($data, $id);
                        redirect("?mod=products&action=showWaitingProduct{$page}");
                    }
                }
            }
        }
    }

    load_view('showWaitingProduct', $data);
}

function showApprovedProductAction() {
    load('helper', 'format');
    load('lib', 'pagging');
    load('helper', 'css');
    load('helper', 'image');

    $data['num_rows'] = get_num_rows("tbl_product");
    $data['num_rows_approved'] = get_num_rows("tbl_product", "`status` = '1'");
    $data['num_rows_waiting'] = get_num_rows("tbl_product", "`status` = '0'");
    $data['num_rows_trash'] = get_num_rows("tbl_product", "`status` = '2'");

    $num_per_page = 4;
    $data['num_page'] = ceil($data['num_rows_approved'] / $num_per_page);

    $data['page'] = isset($_GET['page']) ? $_GET['page'] : 1;
    $start = ($data['page'] - 1) * $num_per_page;

    $data['list_product'] = get_approved_product($start, $num_per_page);

    if (isset($_POST['sm_action'])) {
        if (!empty($_POST['checkItem'])) {
            if ($_POST['actions'] == 1) {
                foreach ($_POST['checkItem'] as $item) {
                    $id = $item;
                    $product = get_product_by_id($id);
                    isset($_GET['page']) ? $page = "&page={$_GET['page']}" : null;

                    if (!empty($product)) {
                        $editor = get_admin_info($_SESSION['user_login']);
                        $edit_date = time();
                        $data = array(
                            'editor' => $editor,
                            'edit_date' => $edit_date,
                            'status' => '0'
                        );
                        edit_product($data, $id);
                        redirect("?mod=products&action=showApprovedProduct{$page}");
                    }
                }
            } elseif ($_POST['actions'] == 2) {
                foreach ($_POST['checkItem'] as $item) {
                    $id = $item;
                    $product = get_product_by_id($id);
                    isset($_GET['page']) ? $page = "&page={$_GET['page']}" : null;

                    if (!empty($product) && $product['status'] != 2) {
                        $old_file_path = $product['thumbnail'];
                        $new_file_path = str_replace('products', 'products/trash', $old_file_path);
                        copy($old_file_path, $new_file_path);
                        $data = array(
                            'status' => '2',
                            'thumbnail' => $new_file_path
                        );
                        edit_product($data, $id);
                        delete_image($old_file_path);
                        redirect("?mod=products&action=showApprovedProduct{$page}");
                    }
                }
            } elseif ($_POST['actions'] == 3) {
                foreach ($_POST['checkItem'] as $item) {
                    $id = $item;
                    $product = get_product_by_id($id);
                    isset($_GET['page']) ? $page = "&page={$_GET['page']}" : null;

                    if (!empty($product) && $product['tracking'] != 1) {
                        $editor = get_admin_info($_SESSION['user_login']);
                        $edit_date = time();
                        $data = array(
                            'editor' => $editor,
                            'edit_date' => $edit_date,
                            'tracking' => '1',
                        );
                        edit_product($data, $id);
                        redirect("?mod=products&action=showApprovedProduct{$page}");
                    }
                }
            } elseif ($_POST['actions'] == 4) {
                foreach ($_POST['checkItem'] as $item) {
                    $id = $item;
                    $product = get_product_by_id($id);
                    isset($_GET['page']) ? $page = "&page={$_GET['page']}" : null;

                    if (!empty($product) && $product['tracking'] != 2) {
                        $editor = get_admin_info($_SESSION['user_login']);
                        $edit_date = time();
                        $data = array(
                            'editor' => $editor,
                            'edit_date' => $edit_date,
                            'tracking' => '2',
                        );
                        edit_product($data, $id);
                        redirect("?mod=products&action=showApprovedProduct{$page}");
                    }
                }
            } elseif ($_POST['actions'] == 5) {
                foreach ($_POST['checkItem'] as $item) {
                    $id = $item;
                    $product = get_product_by_id($id);
                    isset($_GET['page']) ? $page = "&page={$_GET['page']}" : null;

                    if (!empty($product) && $product['tracking'] != 3) {
                        $editor = get_admin_info($_SESSION['user_login']);
                        $edit_date = time();
                        $data = array(
                            'editor' => $editor,
                            'edit_date' => $edit_date,
                            'tracking' => '3',
                        );
                        edit_product($data, $id);
                        redirect("?mod=products&action=showApprovedProduct{$page}");
                    }
                }
            } elseif ($_POST['actions'] == 6) {
                foreach ($_POST['checkItem'] as $item) {
                    $id = $item;
                    $product = get_product_by_id($id);
                    isset($_GET['page']) ? $page = "&page={$_GET['page']}" : null;

                    if (!empty($product) && $product['tracking'] != 4) {
                        $editor = get_admin_info($_SESSION['user_login']);
                        $edit_date = time();
                        $data = array(
                            'editor' => $editor,
                            'edit_date' => $edit_date,
                            'tracking' => '4',
                        );
                        edit_product($data, $id);
                        redirect("?mod=products&action=showApprovedProduct{$page}");
                    }
                }
            }
        }
    }

    load_view('showApprovedProduct', $data);
}

function showTrashProductAction() {
    load('helper', 'format');
    load('lib', 'pagging');
    load('helper', 'css');
    load('helper', 'image');

    $data['num_rows'] = get_num_rows("tbl_product");
    $data['num_rows_approved'] = get_num_rows("tbl_product", "`status` = '1'");
    $data['num_rows_waiting'] = get_num_rows("tbl_product", "`status` = '0'");
    $data['num_rows_trash'] = get_num_rows("tbl_product", "`status` = '2'");

    $num_per_page = 4;
    $data['num_page'] = ceil($data['num_rows_trash'] / $num_per_page);
    $data['page'] = isset($_GET['page']) ? $_GET['page'] : 1;

    $start = ($data['page'] - 1) * $num_per_page;
    $data['list_product'] = get_trash_product($start, $num_per_page);

    if (isset($_POST['sm_action'])) {
        if (!empty($_POST['checkItem'])) {
            if ($_POST['actions'] == 1) {
                foreach ($_POST['checkItem'] as $item) {
                    $id = $item;
                    $product = get_product_by_id($id);
                    isset($_GET['page']) ? $page = "&page={$_GET['page']}" : null;

                    // show_array($product);
                    if (!empty($product)) {
                        $old_file_path = $product['thumbnail'];
                        $new_file_path = str_replace('trash/', '', $old_file_path);

                        copy($old_file_path, $new_file_path);
                        $data = array(
                            'status' => '0',
                            'thumbnail' => $new_file_path
                        );
                        edit_product($data, $id);
                        delete_image($old_file_path);
                        redirect("?mod=products&action=showTrashProduct{$page}");
                    }
                }
            } elseif ($_POST['actions'] == 2) {
                foreach ($_POST['checkItem'] as $item) {
                    $id = $item;
                    $product = get_product_by_id($id);
                    isset($_GET['page']) ? $page = "&page={$_GET['page']}" : null;

                    if (!empty($product)) {
                        delete_product($id);
                        $file_path = $product['thumbnail'];
                        delete_image($file_path);
                        redirect("?mod=products&action=showTrashProduct{$page}");
                    }
                }
            } elseif ($_POST['actions'] == 3) {
                foreach ($_POST['checkItem'] as $item) {
                    $id = $item;
                    $product = get_product_by_id($id);
                    isset($_GET['page']) ? $page = "&page={$_GET['page']}" : null;

                    if (!empty($product) && $product['tracking'] != 1) {
                        $editor = get_admin_info($_SESSION['user_login']);
                        $edit_date = time();
                        $data = array(
                            'editor' => $editor,
                            'edit_date' => $edit_date,
                            'tracking' => '1',
                        );
                        edit_product($data, $id);
                        redirect("?mod=products&action=showTrashProduct{$page}");
                    }
                }
            } elseif ($_POST['actions'] == 4) {
                foreach ($_POST['checkItem'] as $item) {
                    $id = $item;
                    $product = get_product_by_id($id);
                    isset($_GET['page']) ? $page = "&page={$_GET['page']}" : null;

                    if (!empty($product) && $product['tracking'] != 2) {
                        $editor = get_admin_info($_SESSION['user_login']);
                        $edit_date = time();
                        $data = array(
                            'editor' => $editor,
                            'edit_date' => $edit_date,
                            'tracking' => '2',
                        );
                        edit_product($data, $id);
                        redirect("?mod=products&action=showTrashProduct{$page}");
                    }
                }
            } elseif ($_POST['actions'] == 5) {
                foreach ($_POST['checkItem'] as $item) {
                    $id = $item;
                    $product = get_product_by_id($id);
                    isset($_GET['page']) ? $page = "&page={$_GET['page']}" : null;

                    if (!empty($product) && $product['tracking'] != 3) {
                        $editor = get_admin_info($_SESSION['user_login']);
                        $edit_date = time();
                        $data = array(
                            'editor' => $editor,
                            'edit_date' => $edit_date,
                            'tracking' => '3',
                        );
                        edit_product($data, $id);
                        redirect("?mod=products&action=showTrashProduct{$page}");
                    }
                }
            } elseif ($_POST['actions'] == 6) {
                foreach ($_POST['checkItem'] as $item) {
                    $id = $item;
                    $product = get_product_by_id($id);
                    isset($_GET['page']) ? $page = "&page={$_GET['page']}" : null;

                    if (!empty($product) && $product['tracking'] != 4) {
                        $editor = get_admin_info($_SESSION['user_login']);
                        $edit_date = time();
                        $data = array(
                            'editor' => $editor,
                            'edit_date' => $edit_date,
                            'tracking' => '4',
                        );
                        edit_product($data, $id);
                        redirect("?mod=products&action=showTrashProduct{$page}");
                    }
                }
            }
        }
    }

    load_view('showTrashProduct', $data);
}

// Control the Product category list

function listProductCatAction() {
    load('helper', 'format');
    load('lib', 'pagging');


    $num_per_page = 15;
    $data['num_rows'] = get_num_rows("tbl_product_cat");
    $data['num_page'] = ceil($data['num_rows'] / $num_per_page);

    $data['page'] = isset($_GET['page']) ? $_GET['page'] : 1;
    $start = ($data['page'] - 1) * $num_per_page;

    $data['list_product_cat'] = get_list_product_cat_limit($start, $num_per_page);

    load_view('listProductCat', $data);
}

function addProductCatAction() {
    if(is_login() && check_role($_SESSION['user_login']) <= 2){
        load('helper', 'slug');

        global $error, $cat_title;

        if (isset($_POST['btn-submit'])) {
            $error = array();

            if (empty($_POST['title'])) {
                $error['cat_title'] = "Phải nhập tên danh mục";
            } else {
                if (is_exists("tbl_product_cat", "cat_title", $_POST['title'])) {
                    $error['cat_title'] = "Danh mục đã tồn tại";
                } else {
                    $cat_title = $_POST['title'];
                }
            }

            if (empty($_POST['slug'])) {
                $error['slug'] = "Phải nhập slug";
            } else {
                if (is_exists("tbl_product_cat", "slug", $_POST['slug'])) {
                    $error['slug'] = "Slug đã tồn tại";
                } else {
                    $slug = create_slug($_POST['slug']);
                }
            }

            if (empty($error)) {
                $creator = get_admin_info($_SESSION['user_login']);
                $created_date = time();
                $data = array(
                    'cat_title' => $cat_title,
                    'slug' => $slug,
                    'creator' => $creator,
                    'created_date' => $created_date
                );
                if (add_product_cat($data)) {
                    redirect("?mod=products&controller=index&action=listProductCat");
                }
            }
        }
        load_view('addProductCat');
    }else{
        redirect("?mod=products&controller=index&action=listProductCat");
    }
    
}

function editProductCatAction() {

    load('helper', 'slug');
    global $error;
    $cat_id = (int) $_GET['cat_id'];

    $data['list_product_cat'] = get_list_product_cat($cat_id);

    if (isset($_POST['btn-submit'])) {
        $error = array();

        if (empty($_POST['title'])) {
            $error['cat_title'] = "Phải nhập tên danh mục";
        } else {
            $cat_title = $_POST['title'];
        }

        if (empty($_POST['slug'])) {
            $error['slug'] = "Phải nhập slug";
        } else {
            $slug = create_slug($_POST['slug']);
        }

        if (empty($error)) {
            $editor = get_admin_info($_SESSION['user_login']);
            $edit_date = time();
            $data = array(
                'cat_title' => $cat_title,
                'slug' => $slug,
                'editor' => $editor,
                'edit_date' => $edit_date
            );
            if (edit_product_cat($data, $cat_id)) {
                redirect("?mod=products&action=listProductCat");
            };
        }
    }

    load_view('editProductCat', $data);
}

function deleteProductCatAction() {
    if(is_login() && check_role($_SESSION['user_login']) <= 2){
        $cat_id = (int) $_GET['cat_id'];

        if (delete_product_cat($cat_id)) {
            redirect("?mod=products&action=listProductCat");
        };
    }else{
        redirect("?mod=products&action=listProductCat");
    }
    
}
