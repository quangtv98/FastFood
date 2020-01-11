<div class="container text-center" id="bg">
    <?php require_once "lib/function/function.php"; ?>
    <div class="text-center">
        <h3 class="text-uppercase" id="font-color">Lịch sử đơn hàng</h3>
    </div>

    <div class="mt-4">
        <table class="table border">
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
                    echo '<td class="text-left">';
                    foreach($result as $key => $row_1){
                        $stmt=$conn->prepare('SELECT name_pro FROM product WHERE id_pro=:id_pro');
                        $stmt->execute(['id_pro' => $row_1['id_pro']]);
                        $row_2=$stmt->fetch();
                        echo $row_1['qty'].' '.$row_2['name_pro'];
                        if($key+1 == $num) echo '.'; else echo ', ';
                    } ?>
                    </td>
                    <td><?php echo number_format(round($row['totalprice'], -3)) ?> <u>đ</u></td>
                    <td><?php echo status_bill_user($row['status']) ?></td>
                    <td><a href="index.php?page=view_bill_detail&id_bill=<?php echo $row['id_bill'] ?>" id="button3">Xem</a></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>