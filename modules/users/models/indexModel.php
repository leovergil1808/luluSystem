<?php
# Function for student

function add_student($data){
    db_insert('tbl_student', $data);
};

function get_list_student(){
    $result = db_fetch_array("SELECT * FROM `tbl_student`");

    if(!empty($result)) return $result;

    return false;
}

function get_label(){
    $result = db_fetch_array("SELECT `student_id` FROM `tbl_student`");

    if(!empty($result)) return $result;
};

function check_student_status($student_id){
    $result = db_num_rows("SELECT * FROM `tbl_student` WHERE `student_id` = '{$student_id}' AND `status` = '0'");

    if($result > 0) return true;
    
    return false;
}

function roll_call($data, $student_id){
    
    db_update("tbl_student", $data, "`student_id` = $student_id");
}

function edit_status($data, $student_id){
    db_update("tbl_student", $data, "`student_id` = '$student_id'");
}

function reset_student_status(){
    $data = [
        'status' => 0,
    ];
    db_update("tbl_student", $data, "`status` != '0'");
}

function edit_time_roll_call($data){
    db_update("tbl_student", $data, "`time_roll_call` != ''");
}

# Function global for all

function get_num_rows($table, $where = '') {
    if (empty($where)) {
        $result = db_num_rows("SELECT * FROM `{$table}`");
        return $result;
    } else {
        $result = db_num_rows("SELECT * FROM `{$table}` WHERE {$where}");
        return $result;
    }
}

function search_item($table, $search_by = '', $s, $start, $num_per_page) {

    if (!empty($s)) {
        $result = db_fetch_array("SELECT * FROM `{$table}` WHERE {$search_by} LIKE '%{$s}%' LIMIT {$start} , {$num_per_page}");
        if (!empty($result)) {
            foreach ($result as &$item) {
                switch ($item['tracking']) {
                    case 1 : $item['tracking'] = "Stocking";
                        $item['tracking_css'] = 1;
                        break;
                    case 2 : $item['tracking'] = "Out of Stock";
                        $item['tracking_css'] = 2;
                        break;
                    case 3 : $item['tracking'] = "Temporary Out";
                        $item['tracking_css'] = 3;
                        break;
                    case 4 : $item['tracking'] = "Importing goods";
                        $item['tracking_css'] = 4;
                        break;
                    default : $item['tracking'] = "Checking";
                }
                switch ($item['status']) {
                    case 0 : $item['status'] = "Waiting";
                        $item['status_css'] = 0;
                        break;
                    case 1 : $item['status'] = "Approved";
                        $item['status_css'] = 1;
                        break;
                    case 2 : $item['status'] = "Trash";
                        $item['status_css'] = 2;
                        break;
                }
                switch ($item['cat_id']) {
                    case 1 : $item['cat_title'] = "?i�?n thoa?i";
                        break;
                    case 2 : $item['cat_title'] = "Ma?y ti?nh ba?ng";
                        break;
                    case 3 : $item['cat_title'] = "Laptop";
                        break;
                    case 4 : $item['cat_title'] = "Tai nghe";
                        break;
                    case 5 : $item['cat_title'] = "Th??i trang";
                        break;
                    case 6 : $item['cat_title'] = "?�? gia du?ng";
                        break;
                    case 7 : $item['cat_title'] = "Thi�?t bi? v?n pho?ng";
                        break;
                    default : $item['cat_title'] = "None";
                }

                $item['url_edit'] = "?mod=products&controller=index&action=editProduct&id={$item['id']}";
                $item['url_move_trash'] = "?mod=products&controller=index&action=moveTrash&id={$item['id']}";
                $item['status_css'] = set_css_by_status($item['status_css']);
                $item['tracking_css'] = set_css_by_tracking($item['tracking_css']);
                $item['url_approve'] = "?mod=products&controller=index&action=approveProduct&id={$item['id']}";
            }
            return $result;
        }
    }

    return false;
}

function is_exists($table,$key ,$value){
    $result = db_num_rows("SELECT * FROM `{$table}` WHERE `$key` = '{$value}'");

    if($result > 0) return true;
    return false;
}

