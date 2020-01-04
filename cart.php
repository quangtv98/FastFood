<div class="container text-center" id="bg-cart">
    <div class="pb-3">
        <h3 class="text-uppercase" id="font-color">Giỏ hàng</h3>
    </div>

<?php
    if(isset($_SESSION['cart'])){
        $query="SELECT id_pro,name_pro,price,images FROM product WHERE id_pro IN (";
            foreach($_SESSION['cart'] as $id_pro => $value) { 
                $query.=$id_pro.","; 
            } 
        $query=substr($query, 0, -1).")";
        $stmt=$conn->prepare($query);
        $stmt->execute();
        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <form action="lib/cart/process/update_qty.php" method="POST">
        <table class="col-md-12 table">
            <thead>
                <tr>
                    <td>STT</td>
                    <td>Hình ảnh</td>
                    <td>Tên</td>
                    <td>Giá bán</td>
                    <td>Số lượng</td>
                    <td>Thành tiền</td>
                    <td>Thay đổi</td>
                </tr>
            </thead>
            <tbody>        
                <?php
                    $price=0;
                    $total_price=0;
                    foreach($result as $key => $row){ 
                        $id_pro =$row['id_pro'];
                        $price = $row['price'];
                        // Kiểm tra xem có chương trình khuyến mãi không ? Nếu có thì hiển thị giá khuyến mãi ngược lại trả về giá gốc
                        $stmt=$conn->prepare('SELECT count(id_promo) AS total_record FROM promotions WHERE status=:status');
                        $stmt->execute(['status' => 2]);
                        $total_record = $stmt->fetch();
                        if(count($total_record) > 0){
                            $stmt_1=$conn->prepare('SELECT * FROM promotions WHERE status=:status');
                            $stmt_1->execute(['status' => 2]);
                            $row_1 = $stmt_1->fetch();
                            $type_promo = $row_1['type_promo'];

                            if($type_promo == 1){
                                // Giảm theo giá tiền
                                $price = $price - $row_1['value'];
                            }
                            else if($type_promo == 2){
                                // Giảm theo phần trăm
                                $price = $price - $price * $row_1['value'] / 100;
                            }
                            else if($type_promo == 3){
                                // Giảm theo từng sản phẩm
                                // Có sản phẩm có có sản phẩm không ? Nếu có thì lấy giá sau khi giảm 
                                $id_promo = $row_1['id_promo'];
                                $stmt_2=$conn->prepare('SELECT * FROM sale_product WHERE id_promo=:id_promo AND id_pro=:id_pro');
                                $stmt_2->execute(['id_promo' => $id_promo, 'id_pro' => $id_pro]);
                                $row_2 = $stmt_2->fetch();
                                if($id_pro = $row_2['id_pro']){
                                    // Lấy ra giá ban đầu để show ra
                                    $price = $row_2['reduced_price'];
                                }
                            }
                            $price = floor(number_format($price))*1000;
                            $_SESSION['cart'][$id_pro]['price'] = $price;
                        }else{
                            $_SESSION['cart'][$id_pro]['price'] = $row['price'];
                        }
                        $price = $_SESSION['cart'][$id_pro]['price'];
                        $into_money = $_SESSION['cart'][$id_pro]['qty'] * $price;
                        $total_price += $into_money;
                ?>
                <tr>
                    <td><?php echo $key+1 ?></td>
                    <td><img src="./images/<?php echo $row['images'] ?>" class="img-thumbnail" id="img" alt=""></td>
                    <td class="text-uppercase"><?php echo $row['name_pro'] ?></td>
                    <td><?php echo number_format(round($price,-3)) ?></td>
                    <td><input type="number" name="qty[<?php echo $id_pro ?>]" class="rounded text-center" value="<?php echo $_SESSION['cart'][$id_pro]['qty'] ?>" min="1" max="100" pattern="[0-9]"></td>
                    <td><?php echo number_format(round($into_money,-3)) ?></td>
                    <td><a href="lib/cart/process/del_product_cart.php?id_pro=<?php echo $id_pro ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash-o" aria-hidden="true"> <span class="d-none d-lg-inline-block">Xóa</span></i></a></td>
                </tr>
                <?php } ?>
                <tr>
                    <td colspan="3"></td>
                    <td class="text-left"><button type="submit" name="submit" class="btn btn-danger btn-sm">Cập nhật lại giỏ hàng</button></td>
                    <td>Tổng tiền:</td>
                    <td><?php echo number_format(round($total_price,-3)) ?> <u>đ</u></td>
                    <td><a href="lib/cart/process/add_cart.php?action" class="btn btn-danger btn-sm px-3">Thanh toán</a></td>
                </tr>
                </tr>
                <tr>
                    <td colspan="7" id="font-color">
                        <p>Chú ý !</p>
                        <p>Chỉ giao hàng cho phần ăn trên 100,000 <u>đ</u></p>
                        <p>Thời gian giao hàng từ 9h sáng đến 22h tối</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
    <?php }else{ ?>
    <div>
        <p class="pt-3 lead">Giỏ hàng của bạn không có sản phẩm nào !!!</p>
        <p class="pt-3"><i class="fa fa-hand-o-right pr-4 m-n4" aria-hidden="true">&nbsp</i> <a href="index.php?page=menu" class="btn btn-danger btn-sm px-4">Tiếp tục mua hàng</a></p>
    </div>
    <?php } ?>
</div>