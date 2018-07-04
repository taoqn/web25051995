<?php
	require 'connect/PDO.php';
	
	$columns_id = $_GET['columns_id'];
	$columns_name = $_GET['columns'];
	$table_name = $_GET['table'];

	$cmd = "DELETE FROM `".$table_name."` WHERE ";

	foreach ($columns_id as $key) {
		$cmd .= "`".$columns_name[0]."` = ".$key." OR ";
	}

	$cmd = substr($cmd,0,(strlen($cmd)-3));

	$query = Connexion::bdd()->prepare($cmd);
	if ($query->execute()) {
		echo "true";
	}else{
		echo "false";
	}
?>