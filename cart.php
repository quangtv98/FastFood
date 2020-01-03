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
                        $id_pro=$row['id_pro'];
                        $price=$_SESSION['cart'][$id_pro]['qty']*$_SESSION['cart'][$id_pro]['price'];
                        $total_price+=$price;
                ?>
                <tr>
                    <td><?php echo $key+1 ?></td>
                    <td><img src="./images/<?php echo $row['images'] ?>" class="img-thumbnail" id="img" alt=""></td>
                    <td class="text-uppercase"><?php echo $row['name_pro'] ?></td>
                    <td><?php echo number_format($row['price']) ?></td>
                    <td><input type="number" name="qty[<?php echo $id_pro ?>]" class="rounded text-center" value="<?php echo $_SESSION['cart'][$id_pro]['qty'] ?>" min="1" max="100" pattern="[0-9]"></td>
                    <td><?php echo number_format($price) ?></td>
                    <td><a href="lib/cart/process/del_product_cart.php?id_pro=<?php echo $id_pro ?>" class="btn btn-danger btn-sm" onclick="return confirmDel()"><i class="fa fa-trash-o" aria-hidden="true"> <span class="d-none d-lg-inline-block">Xóa</span></i></a></td>
                </tr>
                <?php } ?>
                <tr>
                    <?php $_SESSION['totalprice']=$total_price ?>
                    <td colspan="3"></td>
                    <td class="text-left"><button type="submit" name="submit" class="btn btn-danger btn-sm">Cập nhật lại giỏ hàng</button></td>
                    <td>Tổng tiền:</td>
                    <td><?php echo number_format($total_price) ?> <u>đ</u></td>
                    <td><a href="lib/cart/process/add_cart.php?action=buy" class="btn btn-danger btn-sm px-3">Thanh toán</a></td>
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