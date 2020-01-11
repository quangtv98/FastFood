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
        $date_organized = date_format(date_create($date_organized),"Y-m-d");
        $phone = addslashes($_POST['phone']);
        $number = addslashes($_POST['number']);
        if(isset($_POST['required'])){
            $required = addslashes($_POST['required']);
            $_SESSION['required']=$required;
        }
        $type = addslashes($_POST['type']);
        if($type == 1){
            // Lấy địa chỉ tổ chức tại cửa hàng
            $address = addslashes($_POST['address']);
        }
        else{
            // Lấy địa chỉ tổ chức bên ngoài cửa hàng
            $id_city = $_POST['city'];
            $id_district = $_POST['district'];
            $id_ward = $_POST['ward'];
            $name_home = trim(rtrim($_POST['home'], ','));

            // lấy ra tên thành phố
            $stmt = $conn->prepare('SELECT name FROM city WHERE id_city=:id_city');
            $stmt->execute(['id_city' => $id_city]);
            $result = $stmt->fetch();
            $name_city = $result['name'];
            
            // lấy ra tên thành phố quận / huyện
            $stmt = $conn->prepare('SELECT name FROM district WHERE id_district=:id_district');
            $stmt->execute(['id_district' => $id_district]);
            $result = $stmt->fetch();
            $name_district = $result['name'];
            
            // lấy ra tên phường / xã
            $stmt = $conn->prepare('SELECT name FROM ward WHERE id_ward=:id_ward');
            $stmt->execute(['id_ward' => $id_ward]);
            $result = $stmt->fetch();
            $name_ward = $result['name'];

            $address = $name_home.", ".$name_ward.", ".$name_district.", ".$name_city.", Việt Nam";
        }

        $_SESSION['child_name']=$child_name;
        $_SESSION['parent_name']=$parent_name;
        $_SESSION['email']=$email;
        $_SESSION['phone']=$phone;
        $_SESSION['number']=$number;
        $_SESSION['type']=$type;

        if($number < 10){
            header("location:../../../index.php?page=book_party&book");
            setcookie("error", "Só lượng khách mời phải lớn hơn hoặc bằng 10 người !!!", time()+1,"/","",0);
        }
        // Kiểm tra tính hợp lệ của ngày đặt tiệc
        $current_datetime=current_datetime();
        $today=$current_datetime['created_at_date'];
        $sub=(strtotime($date_organized) - strtotime($today))/86400;
        if($sub > 0){
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
                if(isset($_SESSION['required'])){
                    unset($_SESSION['required']);
                }
                header("location:../../../index.php?page=book_party");
                setcookie("success", "Tiệc sinh nhật đã được ghi lại !!! Xin cả ơn quý khách !!!", time()+1,"/","",0);
            }
            else{
                header("location:../../../index.php?page=book_party&book");
                setcookie("error", "Có lỗi xảy ra trong quá trình xử lý !!!", time()+1,"/","",0);
            }
        }
        else{
            header("location:../../../index.php?page=book_party&book");
            setcookie("error", "Ngày bạn muốn đặt tiệc đã qua !!! Vui lòng kiểm tra lại !!!", time()+1,"/","",0);
        }
    }
?>