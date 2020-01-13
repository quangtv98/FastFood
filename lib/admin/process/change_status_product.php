<?php
    session_start();
    require_once "../../function/connect.php";
    if((isset($_GET['id_pro']) && isset($_GET['status'])) || (isset($_GET['id_combo']) && isset($_GET['status']))){

        // Nhận biết id truyền vào là sản phẩm hay combo
        if(isset($_GET['id_pro'])){
            $id_pro=$_GET['id_pro'];
        }else{
            $id_pro=$_GET['id_combo'];
        }

        if(isset($_GET['page'])){
            $page=$_GET['page'];
        }

        if(isset($_GET['id_type'])){
            $id_type=$_GET['id_type'];
        }

        $status=$_GET['status'];
        if($status == 0){
            
            // Lấy ra d_type của sản phẩm muốn mở bán
            $stmt=$conn->prepare('SELECT id_type FROM product WHERE id_pro=:id_pro');
            $stmt->execute(['id_pro' => $id_pro]);
            $row=$stmt->fetch();
            $id_type=$row['id_type'];

            // Mở bán loại sản phẩm này
            $stmt_s=$conn->prepare('UPDATE product_type SET status="1" WHERE id_type=:id_type');
            $stmt_s->execute(['id_type' => $id_type]);
            // Mở bán sản phẩm
            $stmt=$conn->prepare('UPDATE product SET status=:status WHERE id_pro=:id_pro');
            $stmt->bindParam(':id_pro', $id_pro);
            $stmt->bindParam(':status', $status);
            $status=1;
        }else{
            // Ngưng bán sản phẩm
            $stmt=$conn->prepare('UPDATE product SET status=:status WHERE id_pro=:id_pro');
            $stmt->bindParam(':id_pro', $id_pro);
            $stmt->bindParam(':status', $status);
            $status=0;
        }

        $check=$stmt->execute();

        if($check){
            // Kiểm tra id truyền vào là sản phẩm thì chuyển về trang sản phẩm ngược lại chuyển về combo
            if(isset($_GET['id_pro'])){
                if(isset($_GET['page'])){
                    header("location:../../../admin.php?action=product&product&page=$page");
                }else if(isset($_GET['id_type'])){
                    header("location:../../../admin.php?action=product&product&id_type=$id_type");
                }else{
                    header("location:../../../admin.php?action=product&product");
                }
            }else{
                if(isset($_GET['page'])){
                    header("location:../../../admin.php?action=product&combo&page=$page");
                }else{
                    header("location:../../../admin.php?action=product&combo");
                }
            }
            if($status == 0){
                setcookie("success", "Đã ngưng bán sản phẩm này !!!", time()+1,"/","",0);
            }else{
                setcookie("success", "Đã mở bán sản phẩm này !!!", time()+1,"/","",0);
            }
        }
        else{
            // Kiểm tra id truyền vào là sản phẩm thì chuyển về trang sản phẩm ngược lại chuyển về combo
            if(isset($_GET['id_pro'])){
                if(isset($_GET['page'])){
                    header("location:../../../admin.php?action=product&product&page=$page");
                }else if(isset($_GET['id_type'])){
                    header("location:../../../admin.php?action=product&product&id_type=$id_type");
                }else{
                    header("location:../../../admin.php?action=product&product");
                }
            }else{
                if(isset($_GET['page'])){
                    header("location:../../../admin.php?action=product&combo&page=$page");
                }else{
                    header("location:../../../admin.php?action=product&combo");
                }
            }
            setcookie("error", "Có lỗi xảy ra trong quá trình xử lý !!!", time()+1,"/","",0);
        }
    }
    else{
        // Kiểm tra id truyền vào là sản phẩm thì chuyển về trang sản phẩm ngược lại chuyển về combo
        if(isset($_GET['id_pro'])){
            header("location:../../../admin.php?action=product&product");
        }else{
            header("location:../../../admin.php?action=product&combo");
        }
        setcookie("error", "có lỗi xảy ra trong qua trình xử lý !!!", time()+1,"/","",0);
    }
?>