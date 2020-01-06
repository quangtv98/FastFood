<?php
    session_start();
    require_once "../../function/connect.php";
    if(isset($_POST['submit'])){
        $id_pro=$_GET['id_pro'];
        $name_pro=addslashes($_POST['name_pro']);
        $price=addslashes($_POST['price']);
        $qty=addslashes($_POST['qty']);

        $query="SELECT name_pro FROM product WHERE name_pro=:name_pro AND id_pro <> :id_pro";
        $stmt=$conn->prepare($query);
        $stmt->execute(['name_pro'=>$name_pro, 'id_pro'=>$id_pro]);

        //kiểm tra tên sản phẩm này đã tồn tại hay chưa ?
        if($stmt->rowCount() > 0){        
            if(isset($_GET['page'])){
                $page=$_GET['page'];
                header("location:../../../admin.php?action=product&product&page=$page");
            }else{
                $id_type=$_GET['id_type'];
                header("location:../../../admin.php?action=product&product&id_type=$id_type");
            }
			setcookie("error", "Tên sản phẩm này đã tồn tại !!!", time()+1,"/","",0);
        }
        else{
            
            // Cập nhật sản phẩm
            $stmt=$conn->prepare('UPDATE product SET name_pro=:name_pro, price=:price, qty=:qty WHERE id_pro=:id_pro');
            $check=$stmt->execute(['name_pro'=>$name_pro, 'price'=>$price, 'qty'=>$qty, 'id_pro'=>$id_pro]);
    
            if($check){
                if(isset($_GET['page'])){
                    $page=$_GET['page'];
                    header("location:../../../admin.php?action=product&product&page=$page");
                }else{
                    $id_type=$_GET['id_type'];
                    header("location:../../../admin.php?action=product&product&id_type=$id_type");
                }
                setcookie("success", "Đã cập nhật sản phẩm thành công !!!", time()+1,"/","",0);
            }
            else{
                if(isset($_GET['page'])){
                    $page=$_GET['page'];
                    header("location:../../../admin.php?action=product&product&page=$page");
                }else{
                    $id_type=$_GET['id_type'];
                    header("location:../../../admin.php?action=product&product&id_type=$id_type");
                }
                setcookie("error", "Có lỗi xảy ra trong quá trình xử lý !!!", time()+1,"/","",0);
            }
        }
    }
    else{
        header("location:../../../admin.php?action=product&product");
        setcookie("error", "Có lỗi xảy ra trong quá trình xử lý !!!", time()+1,"/","",0);
    }
?>