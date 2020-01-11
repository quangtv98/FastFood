<?php 
    require_once "../function/MasterModel.php";
    $masterModel = new MasterModel();

    if(isset($_POST['choose'])){
        foreach($_POST['choose'] as $key => $id_pro){
            
        }
        $string.="<table class='table-hover text-center'>";
        $string.="<thead>";
        $string.="<th>STT</th>";
        $string.="<th>Hình ảnh</th>";
        $string.="<th>Tên</th>";
        $string.="<th>Giá</th>";
        $string.="<th>Giá sau giảm</th>";
        $string.="<th>Xóa</th>";
        $string.="</thead>";
        $string.="<tbody>";
        $string.="<tr><td colspan='6'><h6></h6></td></tr>";
        $i=0;
        foreach($_POST['choose'] as $key => $id_pro){
        $stmt=$conn->prepare('SELECT name_pro,images,price FROM product WHERE id_pro=:id_pro AND status=:status');
        $stmt->execute(['id_pro'=>$id_pro, 'status'=>'1']);
        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $row){
        $string.="<tr>";
        $string.="<td width='40px'>".($key+1)."</td>";
        $string.="<td width='100px'><img src='./images/".$row['images']."' class='border rounded' id='img_promotions'></td>";
        $string.="<td width='100px'>".$row['name_pro']."</td>";
        $string.="<td width='100px'>".number_format($row['price'])." <u>đ</u>'</td>";
        $string.="<td width='130px'><input type='number' class='form-control text-center' name='reduced_price".$id_pro."' value='' min='0' max='".$row['price']."' required></td>";
        $string.="<td width='100px'><a href='lib/admin/process/del_in_choose_promotions.php?id_pro=".$id_pro."' class='btn btn-outline-danger btn-sm'><i class='fas fa-trash-alt'></i></a></td>";
        $string.="</tr>";
        }}
        $string.="</tbody>";
        $string.="</table>";
        echo $string;
    }
?>