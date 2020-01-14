<?php
    session_start();
    require_once "../../function/connect.php";
    if(isset($_SESSION['id_staff']) && isset($_SESSION['id_per'])){
        if(isset($_POST['submit']) && isset($_GET['id_promo'])){
            $id_promo = $_GET['id_promo'];
            $name_promo = addslashes($_POST['name_promo']);
            $date_start = addslashes($_POST['date_start']);
            $date_start = date_format(date_create($date_start),"Y-m-d");
            $date_end = addslashes($_POST['date_end']);
            $date_end = date_format(date_create($date_end),"Y-m-d");
            $status = $_POST['status'];
                
            // Cập nhật sản phẩm
            $query="UPDATE promotions SET name_promo=:name_promo, date_start=:date_start, date_end=:date_end, status=:status WHERE id_promo=:id_promo";
            $stmt=$conn->prepare($query);
            $data=array('name_promo'=>$name_promo, 'date_start'=>$date_start, 'date_end'=>$date_end, 'status' => $status, 'id_promo'=>$id_promo);
            $check=$stmt->execute($data);

            if($check){
                header("location:../../../admin.php?action=promotions&promotions");
                setcookie("success", "Cập nhật chương trình khuyến mãi thành công !!!", time()+1,"/","",0);
            }
            else{
                header("location:../../../admin.php?action=promotions&promotions");
                setcookie("error", "Có lỗi xảy ra trong quá trình xử lý !!!", time()+1,"/","",0);
            }
        }
    }
    else{
        header("location:../../../login.php");
        setcookie("error", "Trang bạn yêu cầu không hợp lệ !!!", time()+1,"/","",0);
    }
?>