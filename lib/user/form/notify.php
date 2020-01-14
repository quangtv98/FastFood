<div class="container text-center p-0" id="bg">
    <div class="text-center pb-3">
        <h3 class="text-uppercase" id="font-color">Thông báo</h3>
    </div>
    <?php 
        if(isset($_SESSION['id_user'])){
            $id_user=$_SESSION['id_user'];
            $stmt=$conn->prepare('SELECT id_notify, status FROM notify_user WHERE id_user=:id_user ORDER BY id_notify DESC');
            $stmt->execute(['id_user' => $id_user]);
            $num = $stmt->rowCount();
            if($num > 0){
            $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <table class="table">
            <thead>
                <th width="100px">Ngày gửi</th>
                <th width="150px">Tiêu đề</th>
                <th width="250px">Nội dung</th>
                <th width="150px">Thao tác</th>
                <th width="50px">Xóa</th>
            </thead>
            <tbody>
            <?php 
            foreach($result as $row_s){
                $id_notify = $row_s['id_notify'];
                $stmt=$conn->prepare('SELECT * FROM notify WHERE id_notify=:id_notify');
                $stmt->execute(['id_notify' => $id_notify]);
                $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach($result as $row){ ?>
                <tr>
                    <td><?php echo date_format(date_create($row['date_send'], new DateTimeZone('Asia/Bangkok')),"d-m-Y") ?></td>
                    <td><?php echo $row['title'] ?></td>
                    <td class="text-left"><?php echo $row['message'] ?></td>
                    <?php if($row_s['status'] == 0){ ?>
                    <td><a href="lib/user/process/mark_notify.php?id_notify=<?php echo $row['id_notify'] ?>" class="text-info">Đánh dấu là đã đọc</a></td>
                    <?php }else{ ?>
                    <td><p>Đã Xem</p></td>
                    <?php } ?>
                    <td><a href="lib/user/process/del_notify.php?id_notify=<?php echo $row['id_notify'] ?>" class="text-danger"><i class="fa fa-trash-o px-1" aria-hidden="true"></i></a></td>
                </tr>
            <?php }} ?>
            </tbody>
        </table>
    <?php }} ?>
</div>