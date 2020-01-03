<?php
	session_start();
	if(isset($_SESSION['id_staff']) && isset($_SESSION['id_per'])){
        session_destroy();
		if(isset($_COOKIE['id_staff'])){
			setcookie("id_staff",$_SESSION['id_staff'], time()-1,"/","",0);
			setcookie("staffname",$_SESSION['staffname'], time()-1,"/","",0);
			setcookie("id_per",$_SESSION['id_per'], time()-1,"/","",0);
		}
		header("location:../../../login.php");
	}
?>