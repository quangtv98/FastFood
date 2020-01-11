<?php
    session_start();
    require_once "../../function/connect.php";
    require_once "../../function/function.php";
    if(isset($_POST['submit'])){
        if(isset($_SESSION['id_user'])){
            $id_city = $_POST['city'];
            $id_district = $_POST['district'];
            $id_ward = $_POST['ward'];
            $name_home = trim(rtrim($_POST['home'], ','));
            if(isset($_GET['page'])){
                $page = $_GET['page'];
            }

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

            $name_address = $name_home.", ".$name_ward.", ".$name_district.", ".$name_city.", Việt Nam";
            $id_user = $_SESSION['id_user'];

            // Kiểm tra xem đã có địa chỉ nào chưa. Nếu chưa thì chọn địa chỉ này làm địa chỉ mặc định
            $stmt = $conn->prepare('SELECT count(id_address) AS total_record FROM address WHERE id_user=:id_user');
            $stmt->execute(['id_user' => $id_user]);
            $result = $stmt->fetch();
            if($result['total_record'] > 0){
                $status = 0;
            }else{
                $status = 1;
            }
            // Tùy chọn chọn địa chỉ này làm địa chỉ mặc định
            if(isset($_POST['active'])){
                $status = 1;
                // Thêm địa chỉ vào theo id_user
                $stmt = $conn->prepare('UPDATE address SET status=:status WHERE id_user=:id_user');
                $stmt->execute(['status' => 0, 'id_user' => $id_user]);
                $stmt = $conn->prepare('INSERT INTO address(id_user, name_address, status) VALUES (:id_user, :name_address, :status)');
                $check = $stmt->execute(['id_user' => $id_user, 'name_address' => $name_address, 'status' => $status]);
            }else{
                // Thêm địa chỉ vào theo id_user
                $stmt = $conn->prepare('INSERT INTO address(id_user, name_address, status) VALUES (:id_user, :name_address, :status)');
                $check = $stmt->execute(['id_user' => $id_user, 'name_address' => $name_address, 'status' => $status]);
            }
            if($check){

                // Nếu đang ở sổ địa chỉ quay về sổ địa chỉ nếu đang thanh toán thì quay về chọn địa chit thanh toán
                if(isset($_GET['page']) && $_GET['page'] == "delivery_address"){
                    header("location:../../../index.php?page=delivery_address");
                }else{
                    header("location:../../../index.php?page=address");
                }
                setcookie("success", "Thêm địa chỉ mới thành công !!!", time()+1,"/","",0);
            }else{
                // Nếu đang ở sổ địa chỉ quay về sổ địa chỉ nếu đang thanh toán thì quay về chọn địa chit thanh toán
                if(isset($_GET['page']) && $_GET['page'] == "delivery_address"){
                    header("location:../../../index.php?page=delivery_address");
                }else{
                    header("location:../../../index.php?page=address");
                }
                setcookie("error", "Thêm địa chỉ mới thất bại !!!", time()+1,"/","",0);
            }
        }
        else{
            header("location:../../../index.php");
            setcookie("error", "Có lỗi xảy ra trong quá trình xử lý !!!", time()+1,"/","",0);
        }
    }
    else{
        header("location:../../../index.php");
        setcookie("error", "Có lỗi xảy ra trong quá trình xử lý !!!", time()+1,"/","",0);
    }
?>