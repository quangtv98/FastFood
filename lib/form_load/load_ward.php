<?php

    require_once "../function/MasterModel.php";
    $masterModel = new MasterModel();

    //Lấy ra danh sách Phường / Xã
    if(isset($_POST['district'])){
        $id_district = $_POST['district'];
        $ward = $masterModel->get_list_ward($id_district);
        if(count($ward) > 0){
            $string .= "<option selected>--Phường / Xã--</option>";
            foreach($ward as $local){
                $string .= "<option value='" .$local['id_ward']."'>".$local['name']."</option>";
            }
        }else{
            $string .= "<option selected>--Phường / Xã--</option>";
        }
        echo $string;		
    }
?>