<?php

require_once "connect.php";

    // upload file ảnh cho sản phẩm
    function upload($file_name){
        if($_FILES["$file_name"]['error'] >0){
            echo "Upload file thất bại !!!";
            setcookie("error","Thất bại. Kích thước ảnh quá lớn !!!", time()+1);
        }else{
            $path = $_FILES["$file_name"]['tmp_name'];
            $name = $_FILES["$file_name"]['name'];
            $dir = "../../../images/{$name}";
            move_uploaded_file($path,$dir);
            return $name;
        }
    }

    // lấy ra thời gian hiện tại
    function current_datetime(){
        date_default_timezone_set("Asia/Bangkok");
        $data = [
            'created_at_date'=>date('Y-m-d'),
            'created_at_datetime'=>date('Y-m-d H:i:s'),
            'updated_at_datetime'=>date('Y-m-d H:i:s'),
        ];
        return $data;
    }

    // Trạng thái của đơn hàng phía admin
    function status_bill_admin($status){
        switch($status){
            case 0 : return "Chưa xử lý";
                break;
            case 1 : return "Đã hủy";
                break;
            case 2 : return "Đã xác nhận";
                break;
            case 3 : return "Đang giao";
                break;
            case 4 : return "Đã hoàn tất";
                break;
            default : return "Có lỗi xảy ra !!!";
        }
        return $status;
    }
    
    // Trạng thái của đơn hàng phía user
    function status_bill_user($status){
        switch($status){
            case 0 : return "Đơn hàng đang chờ xử lý";
                break;
            case 1 : return "Đơn hàng bị đã hủy";
                break;
            case 2 : return "Đơn hàng đã được xác nhận";
                break;
            case 3 : return "Đơn hàng đang đi giao";
                break;
            case 4 : return "Giao hàng thành công";
                break;
            default : return "Có lỗi xảy ra !!!";
        }
    }

    // Trạng thái của đơn giao hàng
    function status_delivery($status){
        switch($status){
            case 0 : return "Chưa giao";
                break;
            case 1 : return "Đang đi giao";
                break;
            case 2 : return "Đã hoàn tất";
                break;
            default : return "Có lỗi xảy ra !!!";
        }
    }

    // Chức vụ của nhân viên
    function role_staff($arr_per){
        $num = count($arr_per);
        $str_role="";
        if(in_array(1, $arr_per)){
            $str_role.="Quản trị viên";
            if($num > 1) $str_role.='<br />';
        }
        if(in_array(2, $arr_per)){
            $str_role.="Quản lý người dùng";
            if($num > 1) $str_role.='<br />';
        }
        if(in_array(3, $arr_per)){
            $str_role.="Quản lý sản phẩm";
            if($num > 1) $str_role.='<br />';
        }
        if(in_array(4, $arr_per)){
            $str_role.="Quản lý đơn hàng";
            if($num > 1) $str_role.='<br />';
        }
        if(in_array(5, $arr_per)){
            $str_role.="Quản lý khuyến mãi";
            if($num > 1) $str_role.='<br />';
        }
        if(in_array(6, $arr_per)){
            $str_role.="Quản lý thông báo";
            if($num > 1) $str_role.='<br />';
        }
        if(in_array(7, $arr_per)){
            $str_role.="Chưa phân quyền";
            if($num > 1) $str_role.='<br />';
        }
        return $str_role;
    }
    
    // Trạng thái hoạt động
    function status_active($status){
        if($status == 0){
            return "<i class='far fa-circle'></i>";
        }else{
            return "<i class='fas fa-circle'></i>";
        }
    }
    
    // Loại khuyến mãi
    function name_type_promotions($type_promo){
        switch($type_promo){
            case 1 : return "Giảm số tiền";
                break;
            case 2 : return "Giảm phần trăm";
                break;
            case 3 : return "Giảm theo sản phẩm";
                break;
            default : return "Có lỗi xảy ra !!!";
        }
    }   
    
    // Đơn vị tính khuyến mãi
    function unit_promotions($type_promo,$value){
        switch($type_promo){
            case 1 : return "$value <u>đ</u>";
                break;
            case 2 : return "$value %";
                break;
            case 3 : return "Tùy sản phẩm";
                break;
            default : return "Có lỗi xảy ra !!!";
        }
    }

    // Trạng thái của chương trình khuyến mãi
    function status_promotions($type_promo){
        switch($type_promo){
            case 1 : return "Chưa bắt đầu";
                break;
            case 2 : return "Đang diến ra";
                break;
            case 3 : return "Đã kết thúc";
                break;
            default : return "Có lỗi xảy ra !!!";
        }
    }    
    
    // Đối tượng nhận là ai
    function object($type_receiver){
        switch($type_receiver){
            case 1 : return "Khách hàng";
                break;
            case 2 : return "Nhân viên";
                break;
            case 3 : return "Tất cả";
                break;
            default : return "Có lỗi xảy ra !!!";
        }
    }    

    // Phân trang
    function pagination($current_page, $total_page, $link){
        echo '<ul class="pagination pagination-sm d-flex justify-content-center">';
            // nếu current_page > 1 và total_page > 1 mới hiển thị nút prev
            if ($current_page > 1 && $total_page > 1){
                echo '<li class="page-item"><a class="page-link" href="'.$link.($current_page-1).'"><i class="fas fa-angle-double-left"></i></a></li>';
            }
            // Lặp khoảng giữa
            for ($i = 1; $i <= $total_page; $i++){
                // Nếu là trang hiện tại thì loại bỏ link
                // ngược lại hiển thị thẻ a
                if ($i == $current_page){
                    echo '<li class="page-item"><a class="page-link">'.$i.'</a></li>';
                }else{
                    echo '<li class="page-item"><a class="page-link" href="'.$link.$i.'">'.$i.'</a></li>';
                }}
            // nếu current_page < $total_page và total_page > 1 mới hiển thị nút prev
            if ($current_page < $total_page && $total_page > 1){
                echo '<li class="page-item"><a class="page-link" href="'.$link.($current_page+1).'"><i class="fas fa-angle-double-right"></i></a></li>';
            }
            echo '</ul>';
    }

    // Cấu hình gửi mail
    function sendMail($title, $content, $nTo, $mTo,$diachicc=''){
        $nFrom = 'FastFood';
        $mFrom = 'quangquangquang715@gmail.com';  //dia chi email cua ban 
        $mPass = '98.trinhquang';                 //mat khau email cua ban
        $mail             = new PHPMailer();
        $body             = $content;
        $mail->IsSMTP(); 
        $mail->CharSet    = "utf-8";
        $mail->SMTPDebug  = 0;                    // enables SMTP debug information (for testing)
        $mail->SMTPAuth   = true;                 // enable SMTP authentication
        $mail->SMTPSecure = "ssl";                // sets the prefix to the servier
        $mail->Host       = "smtp.gmail.com";        
        $mail->Port       = 465;
        $mail->Username   = $mFrom;               // GMAIL username
        $mail->Password   = $mPass;               // GMAIL password
        $mail->SetFrom($mFrom, $nFrom);
        //chuyen chuoi thanh mang
        $ccmail = explode(',', $diachicc);
        $ccmail = array_filter($ccmail);
        if(!empty($ccmail)){
            foreach ($ccmail as $k => $v) {
                $mail->AddCC($v);
            }
        }
        $mail->Subject    = $title;
        $mail->MsgHTML($body);
        $address = $mTo;
        $mail->AddAddress($address, $nTo);
        $mail->AddReplyTo('quangquangquang715@gmail.com', 'Nanoeat');
        if(!$mail->Send()) {
            return 0;
        } else {
            return 1;
        }
    }
?>