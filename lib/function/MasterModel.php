<?php

    class MasterModel{
	
		public function get_list_district($id_city){
            require_once "connect.php";
            if(isset($_POST['city'])){
                $id_city=$_POST['city'];
            }
            $stmt=$conn->prepare('SELECT * FROM district WHERE id_city=:id_city ORDER BY name');
            $stmt->execute(['id_city' => $id_city]);
            $district=$stmt->fetchAll(PDO::FETCH_ASSOC);
            return $district;
        }
	
		public function get_list_ward($id_district){
            require_once "connect.php";
            if(isset($_POST['district'])){
                $id_district=$_POST['district'];
            }
            $stmt=$conn->prepare('SELECT * FROM ward WHERE id_district=:id_district ORDER BY name');
            $stmt->execute(['id_district' => $id_district]);
            $ward=$stmt->fetchAll(PDO::FETCH_ASSOC);
            return $ward;
        }
	}
?>