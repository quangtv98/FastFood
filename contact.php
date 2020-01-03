<div class="container text-center" id="bg-cart">    
    <div class="pb-3" id="font-color">
        <h3 class="text-uppercase">Các cơ sở của cửa hàng</h3>
    </div>
    <table class="col-md-9 table shadow m-auto">
        <thead>
            <th>STT</th>
            <th>Địa chỉ</th>
            <th>Liên hệ</th>
        </thead>
        <tbody>
        <?php 
            $stmt=$conn->prepare('SELECT * FROM branch');
            $stmt->execute();
            $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $key => $row) { ?>
            <tr>
                <td><?php echo $key+1 ?></td>
                <td class="text-left"><?php echo $row['local'] ?></td>
                <td><?php echo $row['hotline'] ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>