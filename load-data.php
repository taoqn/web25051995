<?php
/*	require 'connect/PDO.php';
	
	$cmd = "SELECT * FROM `table1`";
	$query = Connexion::bdd()->prepare($cmd);
	$query->execute();

	$cmd = "ALTER TABLE `table1` AUTO_INCREMENT = 1";
	$query = Connexion::bdd()->prepare($cmd);
	$query->execute();

	$cmd = "INSERT INTO `table1`(`id`, `name`, `designation`, `email`, `mobile`) VALUES (null,N?,N?,?,?)";
	$countRow = 1000;
	$query = Connexion::bdd()->prepare($cmd);
	for ($i=1; $i <= $countRow; $i++) {
		$name = "Nguyễn Đình Tạo ".rand(1,$countRow);
		$designation = "Quy Nhơn - Bình Định ".rand(1,$countRow);
		$email = "nuthancooltaoqn".$i."@gmail.com";
		$mobile = "0".rand(100000000,999999999);

		$query->bindParam(1,$name);
		$query->bindParam(2,$designation);
		$query->bindParam(3,$email);
		$query->bindParam(4,$mobile);
		$query->execute();
	}
*/
	var_dump('success');
?>