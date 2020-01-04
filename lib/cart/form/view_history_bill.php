<div class="container text-center" id="bg-cart">
    <?php require_once "lib/function/function.php"; ?>
    <div class="text-center">
        <h3 class="text-uppercase" id="font-color">Lịch sử đơn hàng</h3>
    </div>

    <div class="mt-4">
        <table class="table shadow">
            <thead>
                <th>Mã Đơn hàng</th>
                <th>Ngày mua</th>
                <th>Sản phẩm</th>
                <th>Tổng tiền</th>
                <th>Trạng thái đơn hàng</th>
                <th>Xem</th>
            </thead>
            <tbody>
            <?php
                $stmt=$conn->prepare('SELECT * FROM bill WHERE id_user=:id_user ORDER BY id_bill DESC');
                $stmt->execute(['id_user' => $_SESSION['id_user']]);
                $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($result as $row) { ?>
                <tr>
                    <td><?php echo $row['id_bill'] ?></td>
                    <td><?php echo date_format(date_create($row['created_at'], new DateTimeZone('Asia/Bangkok')),"d-m-Y") ?></td>
                    <!-- Thông tin tóm tắt đơn hàng -->
                    <?php 
                    $stmt=$conn->prepare('SELECT * FROM bill_detail WHERE id_bill=:id_bill');
                    $stmt->execute(['id_bill' => $row['id_bill']]);
                    $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
                    $num=$stmt->rowCount();
                    echo '<td>';
                    foreach($result as $key => $row_1){
                        $stmt=$conn->prepare('SELECT name_pro FROM product WHERE id_pro=:id_pro');
                        $stmt->execute(['id_pro' => $row_1['id_pro']]);
                        $row_2=$stmt->fetch();
                        echo $row_1['qty'].' '.$row_2['name_pro'];
                        if($key+1 == $num) echo '.'; else echo ', ';
                    } ?>
                    </td>
                    <td><?php echo number_format($row['totalprice']) ?> <u>đ</u></td>
                    <?php if($row['status']=="0"){ ?>
                    <td><a href="lib/cart/process/cancel_bill.php?id_bill=<?php echo $row['id_bill'] ?>" onclick="return confirmCancel()" class="btn btn-info btn-sm">Hủy đơn hàng</a></td>
                    <?php }else{ ?>
                    <td><?php echo status_bill_user($row['status']) ?></td>
                    <?php } ?>
                    <td><a href="" class="btn btn-danger btn-sm" id="button3" data-toggle="modal" data-target="#<?php echo 'view'.$row['id_bill'] ?>" data-toggle="tooltip" title="Xem đơn hàng"><i class="fa fa-tripadvisor" aria-hidden="true"> <span class="d-none d-lg-inline-block">Xem</span></i></a></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

<?php 
    // Khởi tạo tất cả các form xem hóa đơn
    $stmt=$conn->prepare('SELECT id_bill, status FROM bill WHERE id_user=:id_user');
    $stmt->execute(['id_user' => $_SESSION['id_user']]);
    $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach($result as $row){ 
        $id_bill=$row['id_bill'];
        $status = $row['status'] ?>
    <!-- Xem chi tiết đơn hàng -->
    <div class="modal" id="<?php echo 'view'.$id_bill ?>">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-danger text-white">
                    <h6 class="modal-title">Chi tiết đơn hàng</h6>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                
                <!-- Modal body -->
                <div class="col-md-12 modal-body text-center">
                <?php
                    // Kiểm tra xem có sử dụng khuyến mãi không
                    $stmt_s=$conn->prepare('SELECT * FROM bill WHERE id_bill=:id_bill');
                    $stmt_s->execute(['id_bill' => $id_bill]);
                    $row_s=$stmt_s->fetch();
                    $ship=$row_s['ship'];
                    $totalprice=$row_s['totalprice']; ?>

                    <table class="border w-100">
                        <thead>
                            <tr><td colspan="6" class="py-2"></td></tr>
                            <tr>
                                <td></td>
                                <td height="40px">Thời gian đặt : </td>
                                <td><?php echo date_format(date_create($row_s['created_at'], new DateTimeZone('Asia/Bangkok')),"d-m-Y") ?></td>
                                <td>Thời gian giao : </td>
                                <td><?php if($row['status']=="1") echo "Đã hủy"; else if($row['status']=="3") echo "Dự kiến giao sau 30 phút";else if($row['status']=="4") echo date_format(date_create($row_s['updated_at'], new DateTimeZone('Asia/Bangkok')),"d-m-Y \L\ú\c H:i");else echo "Chưa giao"; ?></td>
                                <td><?php if($row['status']=="0"){ ?><a href="lib/cart/process/cancel_bill.php?id_bill=<?php echo $id_bill ?>" onclick="return confirmCancel()" class="btn btn-danger btn-sm">Hủy đơn hàng</a><?php } ?>
                                </td>
                            </tr>
                            <tr><td colspan="6" class="py-2"></td></tr>
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
                            $query_s="SELECT b.id_pro,b.qty,b.price,p.images,p.name_pro FROM bill_detail b INNER JOIN product p ON (b.id_pro=p.id_pro) WHERE b.id_bill=:id_bill";
                            $stmt_s=$conn->prepare($query_s);
                            $stmt_s->execute(array('id_bill' => $id_bill));
                            $result_s=$stmt_s->fetchAll(PDO::FETCH_ASSOC); 
                            $price=0;
                            $origin_price=0;
                            foreach($result_s as $key => $row_s){
                                $id_pro=$row_s['id_pro'];
                                $price=$row_s['qty'] * $row_s['price'];
                                $origin_price+=$price;
                            ?>
                            <tr>
                                <td><?php echo $key+1 ?></td>
                                <td><img src="./images/<?php echo $row_s['images'] ?>" class="img-thumbnail" id="img" alt=""></td>
                                <td class="text-uppercase"><?php echo $row_s['name_pro'] ?></td>
                                <td><?php echo number_format($row_s['price']) ?></td>
                                <td><?php echo $row_s['qty'] ?></td>
                                <td><?php echo number_format($price) ?></td>
                            </tr>
                            <tr><td colspan="6" class="py-2"></td></tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <div class="border p-3">
                        <div class="clearfix px-3">
                            <span class="float-left">Phí vận chuyển</span>
                            <span class="float-right"><?php echo number_format($ship) ?> <u>đ</u></span>
                        </div>
                        <div class="clearfix px-3">
                            <span class="float-left">Thành tiền</span>
                            <span class="float-right text-danger lead"><?php echo number_format(round($totalprice,-3)) ?> <u>đ</u></span>
                        </div>
                        <div class="clearfix px-3">
                            <span class="float-left">Trạng thái đơn hàng</span>
                            <span class="float-right text-primary"><?php echo status_bill_user($status) ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
</div>