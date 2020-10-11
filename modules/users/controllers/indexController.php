<?php

function construct() {
    load_model('index');
    load('lib', 'validation');
}

function indexAction(){
    load('helper','string');
    $data['list_student'] = get_list_student();
    load_view('index', $data);
}

function startSystemAction(){

    $data['list_student'] = get_list_student();
    reset_student_status();
    load_view('startSystem', $data);
}

function registryAction(){
    load('helper','image');

    global $error, $fullname, $studentId;

    if(isset($_POST['btn_reg'])){
        $error = array();

        if(empty($_POST['fullname'])){
            $error['fullname'] = "氏名を入力してください";
        }else{
            $fullname = $_POST['fullname'];
        }

        if(empty($_POST['studentId'])){
            $error['studentId'] = "学籍番号を入力してください";
        }else{
            if(is_exists("tbl_student","student_id",$_POST['studentId'])){
                $error['studentId'] = "学籍番号が存在してます";
                $student_id = $_POST['studentId'];
            }else{
                $student_id = $_POST['studentId'];
            }
        }


        if(isset($_FILES['file']) && !empty($_FILES['file']['name']) && ($_FILES['file']['error'][0] == 0) && !empty($fullname)){
            $dir = "public/images/{$student_id}";
            if(!file_exists($dir)){
                if(!mkdir($dir)){
                    $error['upload'] = "エラーが発生";
                }else{
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
            }else{
                $error['upload'] = "フォルダー存在しいてます";
            }
        }

        if(empty($error)){
            if (!empty($file)) {
                $thumbnail = array();
                $num_images = count($file['file']['name']);

                for ($i = 0; $i < $num_images; $i++) {
                    $new_name = $i + 1;
                    $file['file']['name'][$i] = $new_name . ".jpg";
                    $name = $file['file']['name'][$i];
                    $tmp_name = $file['file']['tmp_name'][$i];
                    $dir = "public/images/{$student_id}/";
                    $type = pathinfo($file['file']['name'][$i], PATHINFO_EXTENSION);
                    $size = $file['file']['size'][$i];

                    $thumbnail = upload_multi_image($name, $tmp_name, $dir, $type);
                }
                $data = array(
                    'fullname' => $fullname,
                    'student_id' => $student_id
                );
                add_student($data);
                
            }
        }
    }
    load_view('registry');
}

// Ajax 
function getDataStudentAction(){
    $label = get_label();
    echo json_encode($label);
}

function rollCallAction(){
    $student_id = $_POST['studentId'];
    $time_roll_call = $_POST['timeRollCall'];

    if($time_roll_call == 0){
        if(check_student_status($student_id)){
            $data = array(
                'status' => "1",
            );
            roll_call($data, $student_id);
            $data = [
                'student_id' => $student_id,
                'time_roll_call' => $time_roll_call, 
            ];
            echo json_encode($data);
        }
    }elseif($time_roll_call == 1){
        if(check_student_status($student_id)){
            $data = array(
                'status' => "2",
            );
            roll_call($data, $student_id);
            $data = [
                'student_id' => $student_id,
                'time_roll_call' => $time_roll_call, 
            ];
            echo json_encode($data);
        }
    }
    
}

function editAjaxAction(){

    load('helper','string');
    $status = $_POST['status'];
    $student_id = $_POST['student_id'];
    $data = [
        'status' => $status,
    ];

    edit_status($data, $student_id);

    $data = [
        'status' => convert_status_to_string($status),
        'student_id' => $student_id
    ];
    echo json_encode($data);

}
