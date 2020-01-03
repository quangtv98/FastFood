<?php
    session_start();
    require_once "../../function/connect.php";
    require_once "../../function/function.php";
    if(isset($_POST['submit'])){

        // Lấy thông tin khách hàng
        $child_name = addslashes($_POST['child_name']);
        $parent_name = addslashes($_POST['parent_name']);
        $email = addslashes($_POST['email']);
        $birthday = addslashes($_POST['birthday']);
        $_SESSION['birthday']=$birthday;
        $birthday = date_format(date_create($birthday),"Y-m-d");
        $date_organized = addslashes($_POST['date_organized']);
        $_SESSION['date_organized']=$date_organized;
        $date_organized = date_format(date_create($birthday),"Y-m-d");
        $phone = addslashes($_POST['phone']);
        $number = addslashes($_POST['number']);
        $required = addslashes($_POST['required']);
        $type = addslashes($_POST['type']);
        if($type == 1){
            // Lấy địa chỉ tổ chức tại cửa hàng
            $address = addslashes($_POST['address']);
        }
        else{
            // Lấy địa chỉ tổ chức bên ngoài cửa hàng
            $home = addslashes($_POST['home']);
            $_SESSION['home']=$home;
            $ward = addslashes($_POST['ward']);
            $district = addslashes($_POST['district']);
            $city = addslashes($_POST['city']);
            $address = $home.", ".$ward.", ".$district.", ".$city;
        }

        $_SESSION['child_name']=$child_name;
        $_SESSION['parent_name']=$parent_name;
        $_SESSION['email']=$email;
        $_SESSION['phone']=$phone;
        $_SESSION['number']=$number;
        $_SESSION['required']=$required;
        $_SESSION['type']=$type;

        if($number < 10){
            header("location:../../../index.php?page=book_party");
            setcookie("error", "Só lượng khách mời phải lớn hơn hoặc bằng 10 người !!!", time()+1,"/","",0);
        }
        // Kiểm tra tính hợp lệ của ngày đặt tiệc
        $current_datetime=current_datetime();
        $today=$current_datetime['created_at_date'];
        $sub_1=(strtotime($birthday) - strtotime($today))/86400;
        $sub_2=(strtotime($date_organized) - strtotime($today))/86400;
        if($sub_1 >= 0 && $sub_2 > 0){
            $query="INSERT INTO book_party(child_name,parent_name,email,type,address,birthday,date_organized,phone,number,required) VALUES (:child_name,:parent_name,:email,:type,:address,:birthday,:date_organized,:phone,:number,:required)";
            $stmt=$conn->prepare($query);
            $data=array('child_name'=>$child_name,'parent_name'=>$parent_name,'email'=>$email,'type'=>$type,'address'=>$address,'birthday'=>$birthday,'date_organized'=>$date_organized,'phone'=>$phone,'number'=>$number,'required'=>$required);
            $check=$stmt->execute($data);
            if($check){
                unset($_SESSION['child_name']);
                unset($_SESSION['parent_name']);
                unset($_SESSION['email']);
                if(isset($_SESSION['home'])){
                    unset($_SESSION['home']);
                }
                unset($_SESSION['birthday']);
                unset($_SESSION['date_organized']);
                unset($_SESSION['type']);
                unset($_SESSION['phone']);
                unset($_SESSION['number']);
                unset($_SESSION['required']);
                header("location:../../../index.php?page=book_party");
                setcookie("success", "Tiệc sinh nhật đã được ghi lại !!! Xin cả ơn quý khách !!!", time()+1,"/","",0);
            }
            else{
                header("location:../../../index.php?page=book_party");
                setcookie("error", "Có lỗi xảy ra trong quá trình xử lý !!!", time()+1,"/","",0);
            }
        }
        else{
            header("location:../../../index.php?page=book_party");
            if($sub_1 < 0){
                setcookie("error", "Ngày sinh nhật đã qua !!! Vui lòng kiểm tra lại !!!", time()+1,"/","",0);
            }
            if($sub_2 <= 0){
                setcookie("error", "Ngày bạn muốn đặt tiệc đã qua !!! Vui lòng kiểm tra lại !!!", time()+1,"/","",0);
            }
        }
    }
?>