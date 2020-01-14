<?php
    session_start();
    require_once "../../function/connect.php";
    require_once "../../function/function.php";
    if(isset($_SESSION['id_staff']) && isset($_SESSION['id_per'])){
        if(isset($_POST['submit'])){
            $status = addslashes($_POST['status']);
            $name_pro = addslashes($_POST['name_combo']);
            $price = addslashes($_POST['price']);
            $images=upload('images');
            $descript = addslashes($_POST['descript']);
                
            $query="SELECT name_pro FROM product WHERE name_pro=:name_pro";
            $stmt=$conn->prepare($query);
            $stmt->execute(['name_pro'=>$name_combo]);

            //kiểm tra tên sản phẩm này đã tồn tại hay chưa ?
            if($stmt->rowCount() > 0){
                header("location:../../../admin.php?action=product&combo");
                setcookie("error", "Tên combo sản phẩm này đã tồn tại !!!", time()+1,"/","",0);
            }
            else{
                if(count($_SESSION['choose']) >= 2){
                    $query="INSERT INTO product(name_pro,id_type,price,images,descript,status) VALUES (:name_pro,:id_type,:price,:images,:descript,:status)";
                    $stmt=$conn->prepare($query);
                    $data=array('name_pro'=>$name_pro, 'id_type'=>'1', 'price'=>$price, 'images'=>$images, 'descript'=>$descript, 'status'=>$status);
                    $check=$stmt->execute($data);
                    // Lấy ra hóa đơn vừa mới insert vào
                    $id_combo=$conn->lastInsertId();

                    if($check ){

                        // Cập nhật lại số lượng và insert vào Combo_detail
                        foreach ($_POST['qty'] as $id_pro => $qty) {
                            $qty=abs($qty);
                            $query="INSERT INTO combo_detail(id_combo, id_pro, qty) VALUES (:id_combo, :id_pro, :qty)";
                            $stmt=$conn->prepare($query);
                            $stmt->execute(['id_combo'=>$id_combo, 'id_pro'=>$id_pro, 'qty'=>$qty]);
                        }
                        
                        unset($_SESSION['choose']);
                        header("location:../../../admin.php?action=product&add_combo");
                        setcookie("success", "Thêm combo sản phẩm thành công !!!", time()+1,"/","",0);
                    }
                    else{
                        header("location:../../../admin.php?action=product&add_combo");
                        setcookie("error", "Có lỗi xảy ra trong quá trình thêm !!!", time()+1,"/","",0);
                    }
                }
                else{
                    header("location:../../../admin.php?action=product&add_combo");
                    setcookie("error", "Combo phải có trên 2 sản phẩm !!!", time()+1,"/","",0);
                }
            }
        }
    }
    else{
        header("location:../../../login.php");
        setcookie("error", "Trang bạn yêu cầu không hợp lệ !!!", time()+1,"/","",0);
    }
?>