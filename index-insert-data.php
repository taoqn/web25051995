<?php
	require 'connect/PDO.php';

	$conn = Connexion::bdd();

	if (isset($_GET['p'])) {
		if ( $_GET['p'] == 'getID' ) {
			$id = $_GET['id'];
			$table_name = $_GET['table'];
			$cmd = "SELECT MAX(`".$id."`) FROM `".$table_name."`";
			$query = $conn->prepare($cmd);
			$query->execute(); 
			$row = $query->fetch();
			echo $row[0];
		}
	}else {
		$columns_value = $_GET['columns_value'];
		$columns_name = $_GET['columns'];
		$table_name = $_GET['table'];
		$cmd = "INSERT INTO `".$table_name."`(";
		foreach ($columns_name as $key) {
			$cmd .= "`".$key."`, ";
		}
		$cmd = substr($cmd,0,(strlen($cmd)-2));
		$cmd .= ") VALUES (null,";
		$i = 0;
		foreach ($columns_value as $key) {
			if ($key != 'null') {
				$getUTF8 = 'SELECT `DATA_TYPE`,`CHARACTER_SET_NAME` FROM information_schema.`COLUMNS` WHERE table_name = "'.$table_name.'" AND column_name = "'.$columns_name[$i].'" ';
				$q = $conn->prepare($getUTF8);
				$q->execute(); 
				$r = $q->fetch();
				if ($r[0] == 'varchar') {
					if ($r[1] == 'utf8') {
						$cmd .= "N'".$key."', ";
					} else {
						$cmd .= "'".$key."', ";
					}
				} else if ($r[0] == 'text') {
					if ($r[1] == 'utf8') {
						$cmd .= "N'".$key."', ";
					} else {
						$cmd .= "'".$key."', ";
					}
				} else if ($r[0] == 'int') {
					$cmd .= $key.", ";
				}
			}
			$i++;
		}
		$cmd = substr($cmd,0,(strlen($cmd)-2));
		$cmd .= ")";
		$query = $conn->prepare($cmd);
		if ($query->execute()) {
			echo "true";
		}else{
			echo "false";
		}
	}
?>