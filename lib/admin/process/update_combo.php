<?php
    session_start();
    require_once "../../function/connect.php";
    require_once "../../function/function.php";
    if(isset($_SESSION['id_staff']) && isset($_SESSION['id_per'])){
        if(isset($_POST['submit'])){
            $id_pro=$_GET['id_pro'];
            $name_pro = addslashes($_POST['name_pro']);
            $price = addslashes($_POST['price']);
            $qty = addslashes($_POST['quantity']);
            $descript = addslashes($_POST['descript']);
                
            $query="SELECT name_pro FROM product WHERE name_pro=:name_pro AND id_pro <> :id_pro";
            $stmt=$conn->prepare($query);
            $stmt->execute(['name_pro'=>$name_pro, 'id_pro'=>$id_pro]);

            //kiểm tra tên sản phẩm này đã tồn tại hay chưa ?
            if($stmt->rowCount() > 0){
                header("location:../../../admin.php?action=product");
                setcookie("error", "Tên combo sản phẩm này đã tồn tại !!!", time()+1,"/","",0);
            }
            else{
                $query="UPDATE product SET name_pro=:name_pro,price=:price,qty=:qty,descript=:descript WHERE id_pro=:id_pro";
                $stmt=$conn->prepare($query);
                $data=array('name_pro'=>$name_pro, 'price'=>$price, 'qty' => $qty, 'descript'=>$descript, 'id_pro'=>$id_pro);
                $check=$stmt->execute($data);

                if($check ){

                    // Cập nhật lại số lượng và insert vào Combo_detail
                    foreach ($_POST['qty'] as $id_pro => $qty) {
                        $qty=abs($qty);
                        $query="UPDATE combo_detail SET qty=:qty WHERE id_pro=:id_pro";
                        $stmt=$conn->prepare($query);
                        $stmt->execute(['qty'=>$qty, 'id_pro'=>$id_pro]);
                    }

                    header("location:../../../admin.php?action=product&combo");
                    setcookie("success", "Cập nhật combo sản phẩm thành công !!!", time()+1,"/","",0);
                }
                else{
                    header("location:../../../admin.php?action=product&combo");
                    setcookie("error", "Có lỗi xảy ra trong quá trình cập nhật !!!", time()+1,"/","",0);
                }
            }
        }
    }
    else{
        header("location:../../../login.php");
        setcookie("error", "Trang bạn yêu cầu không hợp lệ !!!", time()+1,"/","",0);
    }
?>