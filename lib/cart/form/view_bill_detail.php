<div class="container" id="bg-cart">
    <?php require_once "lib/function/function.php"; ?>
    <?php if(isset($_GET['id_bill']) && isset($_SESSION['id_user'])){
        $id_bill = $_GET['id_bill'];
        $id_user = $_SESSION['id_user'];
        $stmt = $conn->prepare('SELECT *, count(id_bill) AS total_record FROM bill WHERE id_bill=:id_bill AND id_user=:id_user');
        $stmt->execute(['id_bill' => $id_bill, 'id_user' => $id_user]);
        $bill = $stmt->fetch();
        if($bill['total_record'] > 0){
            $status = $bill['status'] ?>

            <div class="clearfix">
                <span class="float-left">Xem Chi tiết đơn hàng - <strong><?php echo status_bill_user($status) ?></strong></span>
                <?php if($status == 0){ ?>
                <span class="float-right"><a href="lib/cart/process/cancel_bill.php?id_bill=<?php echo $id_bill ?>">Hủy đơn hàng</a></span>
                <?php } ?>
            </div>
            <div class="d-flex row p-3">
                <div class="col-md-6 border p-3">
                    <span>Địa chỉ giao hàng</span>
                    <hr>
                    <strong><?php echo $bill['username'] ?></strong>
                    <div class="py-2">
                        <span class="font-italic">Địa chỉ : </span><?php echo $bill['address'] ?>
                        <br /> 
                        <span class="font-italic">Điện thoại : </span><?php echo $bill['phone'] ?>
                    </div>
                </div>
                <div class="col-md-3 border p-3">
                    <span>Ngày đặt</span>
                    <hr>
                    <span><?php echo date_format(date_create($bill['created_at'], new DateTimeZone('Asia/Bangkok')),"d-m-Y") ?></span>
                </div>
                <div class="col-md-3 border p-3">
                    <span>Ngày giao</span>
                    <hr>
                    <?php if($status==1) echo "Đã hủy"; else if($status==3) echo "Đơn hàng đã được chuyển giao sang bộ phận đi giao";else if($status==4) echo date_format(date_create($bill['updated_at'], new DateTimeZone('Asia/Bangkok')),"d-m-Y \L\ú\c H:i");else echo "Chưa giao"; ?>
                </div>
            </div>
            <div>
                <table class="table border text-center">
                    <thead>
                        <tr>
                            <td height="40px">STT</td>
                            <td>Hình ảnh</td>
                            <td>Tên</td>
                            <td>Giá bán</td>
                            <td>Số lượng</td>
                            <td>Thành tiền</td>
                        </tr>
                    </thead>
                    <tbody>        
                    <?php
                        $query="SELECT b.id_pro,b.qty,b.price,p.images,p.name_pro FROM bill_detail b INNER JOIN product p ON (b.id_pro=p.id_pro) WHERE b.id_bill=:id_bill";
                        $stmt=$conn->prepare($query);
                        $stmt->execute(['id_bill' => $id_bill]);
                        $result=$stmt->fetchAll(PDO::FETCH_ASSOC); 
                        $price=0;
                        $temp_price=0;
                        foreach($result as $key => $row){
                            $id_pro=$row['id_pro'];
                            $price=$row['qty'] * $row['price'];
                            $temp_price+=$price;
                            $stmt=$conn->prepare('SELECT price FROM bill_detail WHERE id_bill=:id_bill AND id_pro=:id_pro');
                            $stmt->execute(['id_bill' => $id_bill, 'id_pro' => $id_pro]);
                            $row_s=$stmt->fetch(); 

                        ?>
                        <tr>
                            <td><?php echo $key+1 ?></td>
                            <td><img src="./images/<?php echo $row['images'] ?>" class="img-thumbnail" id="img" alt=""></td>
                            <td class="text-uppercase"><?php echo $row['name_pro'] ?></td>
                            <td><?php echo number_format($row_s['price']) ?></td>
                            <td><?php echo $row['qty'] ?></td>
                            <td><?php echo number_format($price) ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div class="border p-3 mt-n3">
                    <div class="d-lex row">
                        <div class="col-md-10">
                            <p class="float-right">Tạm tính</p>
                        </div>
                        <div class="col-md-2">
                            <span class="float-right mr-4"><?php echo number_format(round($temp_price,-3)) ?> <u>đ</u></span>
                        </div>
                    </div>
                    <div class="d-lex row">
                        <div class="col-md-10">
                            <p class="float-right">Phí vận chuyển</p>
                        </div>
                        <div class="col-md-2">
                            <span class="float-right mr-4"><?php echo number_format($bill['ship']) ?> <u>đ</u></span>
                        </div>
                    </div>
                    <div class="d-lex row">
                        <div class="col-md-10">
                            <span class="float-right">Thành tiền</span>
                        </div>
                        <div class="col-md-2">
                            <span class="float-right text-danger lead mr-4"><?php echo number_format(round($bill['totalprice'],-3)) ?> <u>đ</u></span>
                        </div>
                    </div>
                </div>
            </div>
    <?php }else{
            header("location:index.php");
            setcookie("error", "Trang bạn yêu cầu không hợp lệ !!!", time()+1,"/","",0);
        }
    }
    else{
        header("location:index.php");
        setcookie("error", "Trang bạn yêu cầu không hợp lệ !!!", time()+1,"/","",0);
    } ?>
</div>