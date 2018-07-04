<?php
	require 'connect/PDO.php';

	$conn = Connexion::bdd();

	$columns_name = $_GET['columns'];
	$table_name = $_GET['table'];
	$page = $_GET['page'];
	$limit = $_GET['limit'];
	$order = $_GET['order'];
	$type = $_GET['type'];
	$value = $_GET['value'];
	
	//$convert = iconv("UTF-8", "ISO-8859-1", $value);
	//$convert = mb_convert_encoding($value, "UTF-8", "EUC-JP");
	$cmd = "SELECT * FROM `".$table_name."` ";
	if ($value != '') {
		$cmd .= 'WHERE ';
		$convert = Connexion::convertUT8_unsigned($value);
		foreach ($columns_name as $key) {
			$getUTF8 = 'SELECT `DATA_TYPE`,`CHARACTER_SET_NAME` FROM information_schema.`COLUMNS` WHERE table_name = "'.$table_name.'" AND column_name = "'.$key.'" ';
			$q = $conn->prepare($getUTF8);
			$q->execute();
			$r = $q->fetch();
			if ($r[0] == 'varchar') {
				if ($r[1] == 'utf8') {
					$cmd .= "`".$key."` LIKE N'%".$value."%' OR ";
				} else {
					$cmd .= "`".$key."` LIKE '%".$convert."%' OR ";
				}
			} else if ($r[0] == 'text') {
				if ($r[1] == 'utf8') {
					$cmd .= "`".$key."` LIKE N'%".$value."%' OR ";
				} else {
					$cmd .= "`".$key."` LIKE '%".$convert."%' OR ";
				}
			} else if ($r[0] == 'int') {
				$cmd .= "`".$key."` LIKE '%".$convert."%' OR ";
			}
		}
		$cmd = substr($cmd,0,(strlen($cmd)-3));
	}
	$query = $conn->prepare($cmd);
    $query->execute();
    $countRow = $query->rowCount();
    $countPage = intval($countRow/$limit);
    if ($countRow % $limit != 0) {
    	$countPage = $countPage+1;
    }
    $numberRowLimit = intval(($page*$limit)-$limit);
	$cmd .= "ORDER BY `".$order."` ".$type." LIMIT ".$numberRowLimit.",".$limit;
	$i = $numberRowLimit+1;
    
    if(isset($_GET['p'])){
    	if ($_GET['p'] == 'getBody') {
		    foreach ($conn->query($cmd) as $row)
		    {
		    	echo '<tr>';
				echo '<td><input type="checkbox" value="'.$row[0].'" onclick="table_data_body_tbody_tr_td_input_click()" /></td>';
				echo '<td>'.$row[0].'</td>';
				echo '<td>'.$row[1].'</td>';
				echo '<td>'.$row[2].'</td>';
				echo '<td>'.$row[3].'</td>';
				echo '<td>'.$row[4].'</td>';
			    echo '</tr>';
		    	$i++;
		    }
    	}
    	if ($_GET['p'] == 'getFooter') {
	    	?>
	    		<div class="row">
					<div id="table-data-footer-page-number" class="col-lg-4">
						<div class="pull-left">
							<a href="javascript:number_page_change(<?php echo ($page-1); ?>);" aria-label="Previous">
								<button type="button" class="btn btn-xs"><span class="glyphicon glyphicon-backward" aria-hidden="true"></span></button>
							</a> 
							<span> Trang : </span>
							<input onchange="number_page_change($(this).val())" type="number" id="number-page" placeholder="Trang" min="1" max="<?php echo $countPage; ?>" step="1" value="<?php echo $page; ?>">
							<span><span class="glyphicon glyphicon-arrow-right"></span> <b><?php echo $countPage; ?></b> </span>
							<a href="javascript:number_page_change(<?php echo ($page+1); ?>);" aria-label="Next">
								<button type="button" class="btn btn-xs"><span class="glyphicon glyphicon-forward" aria-hidden="true"></span></button>
							</a> 
						</div>
					</div>
					<div id="table-data-footer-current-row-number" class="col-lg-4">
						<div class="text-center">
							<?php
								if ($countRow > 0) {
									$k = $i;
									foreach ($conn->query($cmd) as $row) $i++;
									echo '<h6><i>Hiển thị <b>'.$k.' - '.($i-1).'</b> trong tổng số <b>'.$countRow.'</b> hàng</i></h6>';
								}else{
									echo '<h6><i>Hiển thị <b>0 - 0</b> trong tổng số <b>0</b> hàng</i></h6>';
								}
							?>
						</div>
					</div>
					<div id="table-data-footer-number-row" class="col-lg-4">
						<div class="pull-right">
							<span class="">Số hàng hiển thị : </span>
							<input onchange="number_row_change()" type="number" id="number-row" placeholder="Số" min="10" max="200" step="10" value="<?php echo $limit; ?>">
						</div>
					</div>
				</div>
			<?php
    	}
    }
?>