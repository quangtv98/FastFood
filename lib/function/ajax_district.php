<?php 

    require_once "MasterModel.php";
    //Lấy ra danh sách Quận / Huyện
    $masterModel = new MasterModel();
    if(isset($_POST['city'])){
        $city = $_POST['city'];
        $district = $masterModel->get_list_district($id_city);
        if(count($district) > 0){
            $string .="<option selected>--Quận / Huyện--</option>";
            foreach($district as $local){
                $string .= "<option value='" .$local['id_district']."'>".$local['name']."</option>";
            }
        }else{
            $string .= "<option selected>--Quận / Huyện--</option>";	
        }
        echo $string;	
    }
    else{
        header('Location:../../../user/form/profile.php');
    }
?>