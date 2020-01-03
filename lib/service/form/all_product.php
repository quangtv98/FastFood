<div class="container">
    <?php
    // var_dump($id_type);
        $query="SELECT id_type,name_type,images FROM product_type WHERE status='1'";
        $stmt=$conn->prepare($query);
        $stmt->execute();
        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
        $num=$stmt->rowCount();
        foreach($result as $key => $row){
            if($key != 0){ echo "<hr>"; } ?>
            <div class="d-flex row shadow pb-4">
                <div class="col-md-12 mt-3">
                    <h4 class="text-uppercase text-center" id="font-color"><strong><?php echo $row['name_type'] ?></strong></h4>
                </div>
                <!-- Nếu chẵn thì đảo hình ra trước -->
                <?php if($key % 2 == 0){ ?>
                <div class="col-md-4 align-self-center">
                    <img src="./images/<?php echo $row['images'] ?>" class="rounded img-thumbnail w-100 border-warning" alt="">
                </div>
                <?php } ?>
                <div class="col-md-8">
                <?php 
                $id_type=$row['id_type'];
                $stmt=$conn->prepare('SELECT * FROM product WHERE id_type=:id_type AND status="1"');
                $stmt->execute(['id_type' => $id_type]);
                $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach($result as $row_s){ 
                    $id_pro = $row_s['id_pro'];
                    $price = $row_s['price'];
                    // Kiểm tra xem có chương trình khuyến mãi không ? Nếu có thì hiển thị giá khuyến mãi
                    $stmt_1=$conn->prepare('SELECT *, count(id_promo) AS total_record FROM promotions WHERE status=:status');
                    $stmt_1->execute(['status' => 2]);
                    $row_1 = $stmt_1->fetch();
                    $total_record = $row_1['total_record'];
                    if($total_record > 0){
                        $type_promo = $row_1['type_promo'];

                        if($type_promo == 1){
                            // Lấy ra giá ban đầu để show ra
                            $Initial_price[$id_pro] = $row_s['price'];
                            // Giảm theo giá tiền
                            $price = $price - $row_1['value'];
                        }
                        else if($type_promo == 2){
                            // Lấy ra giá ban đầu để show ra
                            $Initial_price[$id_pro] = $row_s['price'];
                            // Giảm theo phần trăm
                            $price = $price - $price * $row_1['value'] / 100;
                        }
                        else if($type_promo == 3){
                            // Giảm theo từng sản phẩm
                            // Có sản phẩm có có sản phẩm không ? Nếu có thì lấy giá sau khi giảm 
                            $id_promo = $row_1['id_promo'];
                            $stmt_2 = $conn->prepare('SELECT * FROM sale_product WHERE id_promo=:id_promo AND id_pro=:id_pro');
                            $stmt_2->execute(['id_promo' => $id_promo, 'id_pro' => $id_pro]);
                            $row_2 = $stmt_2->fetch();
                            if($id_pro = $row_2['id_pro']){
                                // Lấy ra giá ban đầu để show ra
                                $Initial_price[$id_pro] = $row_s['price'];
                                $price = $row_2['reduced_price'];
                            }
                        }
                        $id_pro = $row_s['id_pro'];
                    } ?>

                    <div class="col-md-6 d-inline-flex row">
                        <div class="col d-flex row">
                            <?php if(isset($Initial_price[$id_pro])){ ?>
                            <span class="btn btn-danger rounded-circle position-absolute py-0" style="left:131px">sale</span>
                            <?php } ?>
                            <img src="./images/<?php echo $row_s['images'] ?>" class="rounded img-thumbnail border-warning mb-1" width="100%" style="height : 140px" alt="<?php echo $row_s['name_pro'] ?>">
                            <a class="btn btn-sm px-3 m-auto" id="theme" href="" data-toggle="modal" data-target="<?php echo '#product'.$id_pro ?>" data-toggle="tooltip" title="Mua và thanh toán">Đặt mua</a>
                        </div>
                        <div class="col d-inline-flex row py-4" id="font-color">
                            <strong class="text-center w-100"><?php echo $row_s['name_pro'] ?></strong>
                            <strong class="text-center w-100"><del class="text-black-50 mr-2"><?php if(isset($Initial_price[$id_pro])) echo number_format($Initial_price[$id_pro]) ?></del><?php echo number_format(round($price,-3))."<u>đ</u>" ?></strong>
                        </div>
                    </div>
                    
                    <!-- Hộp thoại sẽ xuất hiện khi ấn nút đặt mua -->
                    <div class="modal" id="<?php echo 'product'.$id_pro ?>">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header bg-danger text-white">
                                    <h6 class="modal-title">Thay đổi số lượng sản phẩm</h6>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                
                                <!-- Modal body -->
                                <div class="modal-body text-center">
                                    <form action="lib/cart/process/add_cart.php?id_pro=<?php echo $id_pro ?>&delivery" method="POST">
                                    <p>Phần ăn chính</p>
                                    <table class="table table-hover text-center border">
                                        <tr>
                                            <td width="200px">Tên sản phẩm</td>
                                            <td width="200px">Số lượng</td>
                                            <td width="200px">Thành tiền</td>
                                        </tr>
                                        <tr>
                                            <td><?php echo $row_s['name_pro'] ?></td>
                                            <td><input type="number" name="qty" class="text-center rounded" min="1" max="100" pattern="[0-9]" value="1" required="required"></td>
                                            <td><?php echo number_format(round($price,-3)) ?> <u>đ</u></td>
                                        </tr>
                                    </table>
                                    <input type="submit" name="submit_payment" class="btn btn-danger btn-sm py-2" id="button2" value="Thanh toán">
                                    <input type="submit" name="submit_add" class="btn btn-info btn-sm py-2" id="button2" value="Thêm vào giỏ hàng">
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                </div>
                <!-- Nếu lẻ thì đảo hình ra sau -->
                <?php if($key%2!=0){ ?>
                <div class="col-md-4 align-self-center">
                    <img src="./images/<?php echo $row['images'] ?>" class="rounded img-thumbnail w-100 border-warning" alt="">
                </div>
                <?php } ?>
            </div>
        <?php } ?>
</div>