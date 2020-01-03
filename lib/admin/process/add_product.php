<?php
    session_start();
    require_once "../../function/connect.php";
    require_once "../../function/function.php";
    if(isset($_POST['submit'])){
        $status = addslashes($_POST['status']);
        $id_type = addslashes($_POST['id_type']);
        $name_pro = addslashes($_POST['name_pro']);
        $price = addslashes($_POST['price']);
		$images=upload('images');
        $descript = addslashes($_POST['descript']);

        $_SESSION['id_type']=$id_type;
        $_SESSION['name_pro']=$name_pro;
        $_SESSION['price']=$price;
        $_SESSION['descript']=$descript;
            
        $stmt=$conn->prepare('SELECT name_pro FROM product WHERE name_pro=:name_pro');
        $stmt->execute(['name_pro' => $name_pro]);

        //kiểm tra tên sản phẩm này đã tồn tại hay chưa ?
        if($stmt->rowCount() > 0){
            header("location:../../../admin.php?action=product&add_pro");
			setcookie("error", "Tên sản phẩm này đã tồn tại !!!", time()+1,"/","",0);
        }
        else{
            $stmt=$conn->prepare('INSERT INTO product(id_type,name_pro,price,images,descript,status) VALUES (:id_type, :name_pro, :price, :images, :descript, :status
            )');
            $data=array('id_type'=>$id_type, 'name_pro'=>$name_pro, 'price'=>$price, 'images'=>$images,'descript'=>$descript, 'status'=>$status);
            $check=$stmt->execute($data);

            if($check){
                
                unset($_SESSION['id_type']);
                unset($_SESSION['name_pro']);
                unset($_SESSION['price']);
                unset($_SESSION['descript']);
    
                header("location:../../../admin.php?action=product&add_pro");
                setcookie("success", "Thêm sản phẩm thành công !!!", time()+1,"/","",0);
            }
            else{
                header("location:../../../admin.php?action=product&add_pro");
                setcookie("error", "Có lỗi xảy ra trong quá trình thêm !!!", time()+1,"/","",0);
            }
        }
    }
    else{
        header("location:../../../admin.php?action=product&add_pro");
        setcookie("error", "Có lỗi xảy ra trong quá trình xử lý !!!", time()+1,"/","",0);
    }
?>