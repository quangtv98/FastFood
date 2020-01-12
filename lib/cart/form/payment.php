<?php
    if(isset($_SESSION['id_user'])){
        $id_user=$_SESSION['id_user'];

        // Lấy ra thông tin cá nhân
        $stmt=$conn->prepare('SELECT * FROM user WHERE id_user=:id_user');
        $stmt->execute(['id_user' => $id_user]);
        $user=$stmt->fetch();

        // Lấy ra địa chỉ đã chọn để giao hàng
        $id_address = $_SESSION['id_address'];
        $stmt=$conn->prepare('SELECT * FROM address WHERE id_address=:id_address');
        $stmt->execute(['id_address' => $id_address]);
        $address=$stmt->fetch(); ?>

        <div class="container" id="bg">
            <h5><strong>3. Chọn hình thức thanh toán</strong></h5>
            <div class="d-lex row mt-3">
                <div class="col-md-5">
                    <form action="lib/cart/process/payment.php" method="POST">
                        <div class="border p-3">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="customRadio_1" name="method" value="1" checked>
                                <label class="custom-control-label" for="customRadio_1">Thanh toán tiền mặt khi nhận hàng</label>
                            </div>
                            <br/>
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="customRadio_2" name="method" value="2">
                                <label class="custom-control-label" for="customRadio_2">Thanh toán bằng thẻ ATM nội địa / Internet Banking</label>
                            </div>
                            <div class="col-md-12 border p-3 mt-3" id="atm" style="display: none">
                                <div class="d-flex row">
                                    <div class="col-md-4 zoom"><a href=""><img class="img-thumbnail" src="./images/Viettin-Bank.jpg" alt=""></a></div>
                                    <div class="col-md-4 zoom"><a href=""><img class="img-thumbnail" src="./images/HD-Bank.jpg" alt=""></a></div>
                                    <div class="col-md-4 zoom"><a href=""><img class="img-thumbnail" src="./images/Techcom-Bank.jpg" alt=""></a></div>
                                    <div class="col-md-4 zoom mt-3"><a href=""><img class="img-thumbnail" src="./images/DongA-Bank.jpg" alt=""></a></div>
                                    <div class="col-md-4 zoom mt-3"><a href=""><img class="img-thumbnail" src="./images/VIB-Bank.jpg" alt=""></a></div>
                                    <div class="col-md-4 zoom mt-3"><a href=""><img class="img-thumbnail" src="./images/Vietcom-Bank.jpg" alt=""></a></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-3 text-center">
                            <input type="submit" name="submit" id="submit" class="btn btn-danger form-control" value="Đặt mua">
                            <label for="submit">(Xin vui lòng kiểm tra lại đơn hàng trước khi đặt mua)</label>
                        </div>
                    </form>
                </div>
                <div class="col-md-6 text-monospace ml-auto">
                    <!-- Thông tin địa chỉ giao hàng -->
                    <div class="border p-3">
                        <div class="clearfix">
                            <span>Địa chỉ giao hàng</span>
                            <a href="index.php?page=delivery_address" class="btn btn-light btn-sm border px-3 float-right">Sửa</a>
                        </div>
                        <hr>
                        <strong><?php echo $user['username'] ?></strong>
                        <div class="py-2">
                            <span class="font-italic">Địa chỉ : </span><?php echo $address['name_address'] ?>
                            <br /> 
                            <span class="font-italic">Điện thoại : </span><?php echo $user['phone'] ?>
                        </div>
                    </div>
                    <!-- Thông tin giỏ hàng -->
                    <div class="border p-3 mt-3">
                        <div class="clearfix">
                            <span>Đơn hàng (<?php echo count($_SESSION['cart']) ?> sản phẩm)</span>
                            <a href="index.php?page=cart" class="btn btn-light btn-sm border px-3 float-right">Sửa</a>
                        </div>
                        <?php 
                        if(isset($_SESSION['cart'])){
                            $query="SELECT id_pro,name_pro,price FROM product WHERE id_pro IN (";
                                foreach($_SESSION['cart'] as $id_pro => $value) { 
                                    $query.=$id_pro.","; 
                                } 
                            $query=rtrim($query,',').")";
                            // $query=substr($query, 0, -1).")";
                            $stmt=$conn->prepare($query);
                            $stmt->execute();
                            $result=$stmt->fetchAll(PDO::FETCH_ASSOC); ?>
                            <table class="col-md-12 table text-center mt-3">
                                <thead>
                                    <tr>
                                        <td>STT</td>
                                        <td>Tên</td>
                                        <td>Giá bán</td>
                                        <td>Số lượng</td>
                                        <td>Thành tiền</td>
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
                                        <td class="text-uppercase"><?php echo $row['name_pro'] ?></td>
                                        <td><?php echo number_format(round($_SESSION['cart'][$id_pro]['price'],-3)) ?></td>
                                        <td><?php echo $_SESSION['cart'][$id_pro]['qty'] ?></td>
                                        <td><?php echo number_format(round($price,-3)) ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <hr class="mt-n3">
                            <div class="clearfix px-3">
                                <span>Tạm tính</span>
                                <span class="float-right"><?php echo number_format(round($total_price,-3)) ?> <u>đ</u></span>
                            </div>
                            <div class="clearfix px-3">
                            <?php 
                                $stmt = $conn->prepare('SELECT * FROM ship WHERE status=:status');
                                $stmt->execute(['status'=>1]);
                                $row = $stmt->fetch();
                                $ship = $row['ship'];
                                $total_price += $ship;
                                $_SESSION['totalprice']=$total_price;
                            ?>
                                <span>Phí vận chuyển</span>
                                <span class="float-right"><?php echo number_format($ship) ?> <u>đ</u></span>
                            </div>
                            <hr>
                            <div class="clearfix px-3">
                                <span>Thành tiền</span>
                                <span class="float-right text-danger lead"><?php echo number_format(round($total_price,-3)) ?> <u>đ</u></span>
                            </div>
                            <div class="text-right px-3">
                                <span class="font-italic">(Đã bao gồm thuế VAT nếu có)</span>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
<?php }
    else{
        header("location:index.php");
        setcookie("error", "Trang bạn yêu cầu không hợp lệ !!!", time()+1,"/","",0);
    } ?>

<script>
    $(document).ready(function(){
        $("#customRadio_1").click(function(){
            $("#atm").slideUp("slow");
        });
    });
</script>

<script>
    $(document).ready(function(){
        $("#customRadio_2").click(function(){
            $("#atm").slideDown("slow");
        });
    });
</script>