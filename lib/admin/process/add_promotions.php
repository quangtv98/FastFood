<?php
    session_start();
    require_once "../../function/connect.php";
    require_once "../../function/function.php";
    if(isset($_POST['submit'])){
        $name_promo = addslashes($_POST['name_promo']);
        $date_start = addslashes($_POST['date_start']);
        $date_end = addslashes($_POST['date_end']);
        $type_promo = addslashes($_POST['type_promo']);
        if($type_promo != 3){
            $value = addslashes($_POST['value']);
            $_SESSION['value'] = $value;
        }

        $_SESSION['name_promo'] = $name_promo;
        $_SESSION['date_start'] = $date_start;
        $date_start = date_format(date_create($date_start),"Y-m-d");
        $_SESSION['date_end'] = $date_end;
        $date_end = date_format(date_create($date_end),"Y-m-d");
        $_SESSION['type_promo'] = $type_promo;

        // Kiểm tra tính hợp lệ của ngày diễn ra khuyến mãi
        $current_datetime=current_datetime();
        $today=$current_datetime['created_at_date'];
        $sub_1=(strtotime($date_start) - strtotime($today))/86400;
        $sub_2=(strtotime($date_end) - strtotime($date_start))/86400;
        if($sub_1 >= 0 && $sub_2 > 0){
            if($type_promo != 3){
                $query="INSERT INTO promotions(name_promo,date_start,date_end,type_promo,value)
                        VALUES (:name_promo,:date_start,:date_end,:type_promo,:value)";
                $stmt=$conn->prepare($query);
                $data=array('name_promo'=>$name_promo, 'date_start'=>$date_start, 'date_end'=>$date_end,
                            'type_promo'=>$type_promo, 'value'=>$value);
                $check=$stmt->execute($data);
            }else{
                if(count($_SESSION['choose_pro_in_promotion']) >= 1){
                    $query="INSERT INTO promotions(name_promo,date_start,date_end,type_promo)
                            VALUES (:name_promo,:date_start,:date_end,:type_promo)";
                    $stmt=$conn->prepare($query);
                    $data=array('name_promo'=>$name_promo, 'date_start'=>$date_start, 'date_end'=>$date_end,
                                'type_promo'=>$type_promo);
                    $check=$stmt->execute($data);

                    // Lấy ra id vừa insert vào
                    $id_promo = $conn->lastInsertId();
                    foreach($_POST['reduced_price'] as $id_pro => $reduced_price){
                        $query="INSERT INTO sale_product(id_promo,id_pro,reduced_price) VALUES (:id_promo,:id_pro,:reduced_price)";
                        $stmt=$conn->prepare($query);
                        $stmt->execute(['id_promo'=>$id_promo, 'id_pro'=>$id_pro, 'reduced_price'=>$reduced_price]);
                    }
                }
                else{
                    header("location:../../../admin.php?action=promotions&act");
                    setcookie("warning", "Bạn chưa chọn sản phẩm tham gia chương trình khuyến mãi !!!", time()+1,"/","",0);
                }
            }
            if($check){

                unset($_SESSION['name_promo']);
                unset($_SESSION['date_start']);
                unset($_SESSION['date_end']);
                unset($_SESSION['type_promo']);
                unset($_SESSION['value']);
                unset($_SESSION['rand']);
                unset($_SESSION['choose_s']);
                if(isset($_SESSION['choose_pro_in_promotion'])){
                    unset($_SESSION['choose_pro_in_promotion']);
                }

                header("location:../../../admin.php?action=promotions&promotions");
                setcookie("success", "Tạo chương trình khuyến mãi thành công !!!", time()+1,"/","",0);
            }
            else{
                header("location:../../../admin.php?action=promotions&act");
                setcookie("error", "Có lỗi xảy ra trong quá trình thêm !!!", time()+1,"/","",0);
            }
        }
        else{
            header("location:../../../admin.php?action=promotions&act");
            if($sub_1 < 0){
                setcookie("error", "Ngày bắt đầu phải lớn hơn hoặc bằng ngày hiện tại !!!", time()+1,"/","",0);
            }
            if($sub_2 <= 0){
                setcookie("error", "Ngày kết thúc phải lớn hơn ngày bắt đầu !!!", time()+1,"/","",0);
            }
        }
    }
    else{
        header("location:../../../admin.php?action=promotions&act");
        setcookie("error", "Có lỗi xảy ra trong quá trình xử lý !!!", time()+1,"/","",0);
    }
?>