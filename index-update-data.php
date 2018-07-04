<?php
	require 'connect/PDO.php';

	$conn = Connexion::bdd();
	
	$columns_value = $_GET['columns_value'];
	$columns_name = $_GET['columns'];
	$table_name = $_GET['table'];

	$cmd = "UPDATE `".$table_name."` SET ";

	for ($i=1; $i < count($columns_name); $i++) {
		$getUTF8 = 'SELECT `DATA_TYPE`,`CHARACTER_SET_NAME` FROM information_schema.`COLUMNS` WHERE table_name = "'.$table_name.'" AND column_name = "'.$columns_name[$i].'" ';
		$q = $conn->prepare($getUTF8);
		$q->execute(); 
		$r = $q->fetch();
		if ($r[0] == 'varchar') {
			if ($r[1] == 'utf8') {
				$cmd .= "`".$columns_name[$i]."` = N'".$columns_value[$i]."', ";
			} else {
				$cmd .= "`".$columns_name[$i]."` = '".$columns_value[$i]."', ";
			}
		} else if ($r[0] == 'text') {
			if ($r[1] == 'utf8') {
				$cmd .= "`".$columns_name[$i]."` = N'".$columns_value[$i]."', ";
			} else {
				$cmd .= "`".$columns_name[$i]."` = '".$columns_value[$i]."', ";
			}
		} else if ($r[0] == 'int') {
			$cmd .= "`".$columns_name[$i]."` = ".$columns_value[$i].", ";
		}
	}
	$cmd = substr($cmd,0,(strlen($cmd)-2));
	$cmd .= " WHERE `".$columns_name[0]."`= ".$columns_value[0];

	$query = $conn->prepare($cmd);
	if ($query->execute()) {
		echo "true";
	}else{
		echo "false";
	}
?>