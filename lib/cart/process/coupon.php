<?php
    session_start();
    require_once "../../function/connect.php";
    require_once "../../function/function.php";
    if(isset($_POST['submit'])){
        $coupon = addslashes($_POST['coupon']);

        $stmt=$conn->prepare('SELECT * FROM promotions WHERE status="1"');
        $check = $stmt->execute();
        if($check){
            $row = $stmt->fetch();
            
            $_SESSION['id_promo']=$row['id_promo'];
            $id_coupon = $row['id_coupon'];
            $type_promo = $row['type_promo'];
            $value = $row['value'];
            $date_start = $row['date_start'];
            $date_start = date_format(date_create($date_start),"Y-m-d");
            $date_end = $row['date_end'];
            $date_end = date_format(date_create($date_end),"Y-m-d");
            
            $current_date = current_datetime();
            $today = $current_date['created_at_date'];
            $sub_1 = (strtotime($today) - strtotime($date_start)) / 86400;
            $sub_2 = (strtotime($date_end) - strtotime($today)) / 86400;
            if($sub_1 >=0 && $sub_2 >=0){
                if($coupon == $id_coupon){
                    if(isset($_SESSION['id_promo'])){
                        header("location:../../../index.php?page=payment");
                        setcookie("error", "Xin lỗi !!! Mã khuyến mãi đang được áp dụng !!!", time()+1,"/","",0);
                    }
                    else{
                        if($type_promo == '0'){
                            $_SESSION['totalprice'] -= $value;
                        }
                        else if($type_promo == '1'){
                            $_SESSION['totalprice'] -= $_SESSION['totalprice'] * $value / 100;
                            $_SESSION['totalprice'] = round($_SESSION['totalprice'],-3);
                        }
                        else{
                            $_SESSION['ship'] = $value;
                            $stmt=$conn->prepare('SELECT * FROM ship');
                            $stmt->execute();
                            $row=$stmt->fetch();
                            $ship=$row['ship'];
                            $_SESSION['totalprice'] -= $ship;
                        }
                        header("location:../../../index.php?page=payment");
                    }
                }else{
                    header("location:../../../index.php?page=payment");
                    setcookie("error", "Xin lỗi !!! Mã khuyến mãi không đúng !!!", time()+1,"/","",0);
                }
            }
        }
        else{
            header("location:../../../index.php?page=payment");
            setcookie("error", "Xin lỗi !!! Hiện tại không có chương trình khuyến mãi !!!", time()+1,"/","",0);
        }
    }
?>