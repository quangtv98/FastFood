<?php if(in_array(1, $_SESSION['id_per']) || in_array(7, $_SESSION['id_per'])){ ?>
<div class="container text-center mt-4">
    <div id="accordion">
        <a class="btn btn-info btn-sm" id="button2" data-toggle="collapse" href="#collapseOne"><i class="far fa-paper-plane">&nbsp;</i>Gửi thông báo</a>
        <a class="btn btn-info btn-sm" id="button2" data-toggle="collapse" href="#collapseTwo">Quản lý thông báo</a>
        <!-- form gửi thông báo nội bộ -->
        <div id="collapseOne" class="collapse text-center <?php if(isset($_GET['send'])) echo 'show' ?>" data-parent="#accordion">
            <div class="d-flex justify-content-center mt-4">
                <form action="lib/admin/process/send_notify.php" method="POST">
                    <div class="form-group text-left">
                        <label for="title">Tiêu đề : </label>
                        <input type="text" name="title" id="title" class="form-control" value="<?php if(isset($_SESSION['title'])) echo $_SESSION['title'] ?>" required="required">
                    </div>
                    <div class="form-group text-left">
                        <label for="message">Nội dung : </label>
                        <textarea name="message" id="message" class="form-control" cols="30" rows="10" required="required"><?php if(isset($_SESSION['message'])) echo $_SESSION['message'] ?></textarea>
                        <script>
                            CKEDITOR.replace('message',{
                                filebrowserBrowseUrl : 'ckfinder/ckfinder.html',
                                filebrowserImageBrowseUrl : 'ckfinder/ckfinder.html?type=Images',
                                filebrowserFlashBrowseUrl : 'ckfinder/ckfinder.html?type=Flash',
                                filebrowserUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                                filebrowserImageUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                                filebrowserFlashUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
                            });
                        </script>
                    </div>
                    <div class="form-group form-inline">
                        <label for="type_receiver">Gửi tới :</label>
                        <select name="type_receiver" id="type_receiver" class="form-control mx-2">
                            <option value="1">Khách hàng</option>
                            <option value="2">Nhân viên</option>
                            <option value="3">Tất cả</option>
                        </select>
                        <input type="submit" id="button3" class="btn btn-danger btn-sm ml-auto" name="submit" value="Gửi">
                    </div>
                </form>
            </div>
        </div>
    
        <!-- Quản lý thông báo nội bộ -->
        <?php
            // Tính tổng số cột
            $stmt=$conn->prepare('SELECT count(id_notify) AS total_record FROM notify');
            $stmt->execute();
            $row=$stmt->fetch();
            $total_record=$row['total_record'];
            if($total_record > 0){ ?>
            <div id="collapseTwo" class="collapse text-center <?php if(isset($_GET['news'])) echo 'show' ?>" data-parent="#accordion">
                <div class="d-flex justify-content-center mt-4">
                    <table class="table-hover table-bordered col-md-12 shadow">
                        <thead>
                            <tr>
                                <td>Tiêu đề</td>
                                <td width="450px">Nội dung</td>
                                <td>Đối tượng nhận</td>
                                <td>Ngày gửi</td>
                                <td width="50px">Cập nhật</td>
                                <td width="50px">Xóa</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                // Tính limit và current_page
                                $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                                $limit=10;
                                // Tính tổng số trang
                                $total_page=ceil($total_record / $limit);
                                // Giới hạn current_page trong khoảng 1 đến total_page
                                if ($current_page > $total_page){
                                    $current_page = $total_page;
                                }
                                else if ($current_page < 1){
                                    $current_page = 1;
                                }
                                // Tìm Start
                                $start = ($current_page - 1) * $limit;
                                $stmt=$conn->prepare('SELECT * FROM notify ORDER BY id_notify DESC LIMIT :start, :limit');
                                $stmt->bindValue(':start', $start, PDO::PARAM_INT);
                                $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
                                $stmt->execute();
                                $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
                                foreach($result as $key=>$row){
                            ?>
                            <tr>
                                <td><?php echo $row['title'] ?></td>
                                <td class="text-left"><?php echo $row['message'] ?></td>
                                <td><?php echo object($row['type_receiver']) ?></td>
                                <td><?php echo date_format(date_create($row['date_send'], new DateTimeZone('Asia/Bangkok')),"d-m-Y") ?></td>
                                <td><a href="" class="text-info" data-toggle="modal" data-target="#<?php echo 'update'.$row['id_notify'] ?>" data-toggle="tooltip" title="Cập nhật trạng thái đơn hàng"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
                                <td><a href="lib/admin/process/del_news.php?id_notify=<?php echo $row['id_notify'] ?>" class="text-danger" onclick="return confirmDel()"><i class="fa fa-trash-o px-1" aria-hidden="true"></i></a></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php if($total_record > $limit){ ?>
                <!-- Tiến hành phân trang -->
                <?php pagination($current_page, $total_page,"admin.php?action=notify&notify&page=") ?>
            <?php }} ?>
        </div>
    </div>
</div>
<?php } ?>

<!-- Hộp thoại dialog được gọi đến nếu ấn cập nhật thông báo -->
<?php
    $stmt=$conn->prepare('SELECT * FROM notify');
    $stmt->execute();
    $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $key => $row) {
        $id_notify=$row['id_notify'];
?>
    <!-- form Cập nhật combo sản phẩm -->
    <div class="modal" id="<?php echo 'update'.$id_notify ?>">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-danger text-white">
                    <h6 class="modal-title">Cập nhật chương trình khuyến mãi</h6>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                
                <!-- Modal body -->
                <div class="modal-body text-center">
                    <form action="lib/admin/process/update_notify.php?id_notify=<?php echo $id_notify ?>" method="POST">
                        <div class="border rounded p-3 text-left">
                            <div class="form-group">
                                <label for="title" class="pl-3">Tiêu đề :</label>
                                <input type="text" name="title" id="title" class="form-control" value="<?php echo $row['title'] ?>" placeholder="Tên combo" required="required">
                            </div>
                            <div class="form-group">
                                <label for="message<?php echo $id_notify ?>" class="pl-3">Nội dung :</label>
                                <textarea name="message" id="message<?php echo $id_notify ?>" class="form-control" placeholder="Nội dung" cols="30" rows="6"><?php echo $row['message'] ?></textarea><script>
                                CKEDITOR.replace('message<?php echo $id_notify ?>',{
                                    filebrowserBrowseUrl : 'ckfinder/ckfinder.html',
                                    filebrowserImageBrowseUrl : 'ckfinder/ckfinder.html?type=Images',
                                    filebrowserFlashBrowseUrl : 'ckfinder/ckfinder.html?type=Flash',
                                    filebrowserUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                                    filebrowserImageUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                                    filebrowserFlashUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
                                });
                        </script>
                            </div>
                        </div>
                        <div class="mt-3">
                            <input type="submit" class="btn btn-danger btn-sm px-4" name="submit" value="Cập nhật">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
