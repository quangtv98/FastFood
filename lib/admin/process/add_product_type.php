<?php
    session_start();
    require_once "../../function/connect.php";
    require_once "../../function/function.php";
    if(isset($_POST['submit'])){
        $name_type = addslashes($_POST['name_type']);
		$images=upload('images');
        $status = addslashes($_POST['status']);

        $_SESSION['name_type']=$name_type;
            
        $stmt=$conn->prepare('SELECT name_type FROM product_type WHERE name_type=:name_type');
        $stmt->bindParam(':name_type', $name_type);
        $stmt->execute();

        //kiểm tra loại sản phẩm này đã tồn tại hay chưa ?
        if($stmt->rowCount() > 0){
            header("location:../../../admin.php?action=product&add_type");
			setcookie("error", "Tên loại sản phẩm này đã tồn tại !!!", time()+1,"/","",0);
        }
        else{
            $query="INSERT INTO product_type(name_type,images,status) VALUES ('$name_type','$images','$status')";
            $stmt=$conn->prepare($query);
            $check=$stmt->execute();

            unset($_SESSION['name_type']);

            if($check){
                header("location:../../../admin.php?action=product&add_type");
                setcookie("success", "Thêm loại sản phẩm thành công !!!", time()+1,"/","",0);
            }
            else{
                header("location:../../../admin.php?action=product&add_type");
                setcookie("error", "Có lỗi xảy ra trong quá trình thêm !!!", time()+1,"/","",0);
            }
        }
    }
    else{
        header("location:../../../admin.php?action=product&add_type");
        setcookie("error", "Có lỗi xảy ra trong qua trình xử lý !!!", time()+1,"/","",0);
    }
?>