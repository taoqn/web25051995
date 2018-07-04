<?php
	require 'connect/PDO.php';

	$title_table = "Test Bootstrap 2017";
	$number_show_row = 20;
	$table_name = "table1";
	$table_as = "`id` AS 'Mã', `name` AS 'Họ và tên', `designation` AS 'Địa chỉ', `email` AS 'Email', `mobile` AS 'Số điện thoại'";

	$cmd_name_columns_mysql = "SELECT * FROM ".$table_name;
	$cmd_name_columns_real = "SELECT ".$table_as." FROM ".$table_name;

	$query_name_columns_mysql = Connexion::bdd()->prepare($cmd_name_columns_mysql);
	$query_name_columns_mysql->execute();

	$query_name_columns_real = Connexion::bdd()->prepare($cmd_name_columns_real);
	$query_name_columns_real->execute();

	$col_count = $query_name_columns_mysql->columnCount();// Lấy số cột trong bảng

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
    	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    	<title><?php echo $title_table; ?></title>
    	<!-- Bootstrap -->
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">
    	<!-- Optional theme -->
    	<!--[if lt IE 9]>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.css" rel="stylesheet">
    	<![endif]-->
		<link href="css/main.css" rel="stylesheet" id="theme-css">
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-96450748-1', 'auto');
  ga('send', 'pageview');

</script>
	</head>
	<body>
		<nav class="navbar navbar-fixed-bottom navbar-default">
		    <div class="container-fluid">
				<div class="navbar-header">
					<span class="navbar-text">Chọn giao diện : </span>
				</div>
				<div class="navbar-btn">
					<div class="btn-group">
				        <button type="button" class="btn3d btn btn-default btn-sm" id="button-theme-light">Light</button>
				        <button type="button" class="btn btn-primary btn-sm btn3d" id="button-theme-dark">Dark</button>
					</div>
					<div class="nav navbar-nav navbar-right">
						<div class="btn-group">
							<button type="button" class="btn btn-default" id="button-insert-data" data-toggle="modal" data-target="#modal-insert-data"><span class="glyphicon glyphicon-plus"></span> Thêm</button>
							<button type="button" class="btn btn-default" id="button-update-data" onclick="button_update_data()"><span class="glyphicon glyphicon-edit"></span> Sửa</button>
							<button type="button" class="btn btn-default" id="button-delete-data" data-toggle="modal" data-target="#modal-delete-data"><span class="glyphicon glyphicon-trash"></span> Xóa</button>
						</div>
					</div>
				</div>
			</div>
		</nav>


		<div class="container-fluid">
			<div class="page-header">
				<h1><?php echo $title_table; ?></h1>
			</div>

			<div class="btn-group">

				<button type="button" class="btn btn-default" id="button-insert-data" data-toggle="modal" data-target="#modal-insert-data"><span class="glyphicon glyphicon-plus"></span> Thêm</button>
				<!-- Modal insert data -->
				<div id="modal-insert-data" class="modal fade" tabindex="-1" role="dialog">
					<div class="modal-dialog">
				    	<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Thêm dữ liệu</h4>
							</div>
							<div class="modal-body">
								<?php
                					for ($i=0; $i < $col_count; $i++) {
                						$meta_name_columns_mysql = $query_name_columns_mysql->getColumnMeta($i);
                						$meta_name_columns_real = $query_name_columns_real->getColumnMeta($i);
                						if ($i == 0) {
                							echo '<div class="form-group" hidden>';
											echo '<label for="input-Column-insert-data-'.$meta_name_columns_mysql['name'].'">'.$meta_name_columns_real['name'].'</label>';
											echo '<input type="number" class="form-control" id="input-Column-insert-data-'.$meta_name_columns_mysql['name'].'" placeholder="'.$meta_name_columns_real['name'].'">';
											echo '</div>';
                						}else {
                							if ($meta_name_columns_real['native_type'] == 'LONG') {
	                							echo '<div class="form-group">';
												echo '<label for="input-Column-insert-data-'.$meta_name_columns_mysql['name'].'">'.$meta_name_columns_real['name'].'</label>';
												echo '<input type="number" class="form-control" id="input-Column-insert-data-'.$meta_name_columns_mysql['name'].'" placeholder="'.$meta_name_columns_real['name'].'">';
												echo '</div>';
	                						}
	                						if ($meta_name_columns_real['native_type'] == "VAR_STRING") {
	                							echo '<div class="form-group">';
												echo '<label for="input-Column-insert-data-'.$meta_name_columns_mysql['name'].'">'.$meta_name_columns_real['name'].'</label>';
												echo '<input type="text" class="form-control" id="input-Column-insert-data-'.$meta_name_columns_mysql['name'].'" placeholder="'.$meta_name_columns_real['name'].'">';
												echo '</div>';
	                						}
	                						if ($meta_name_columns_real['native_type'] == "BLOB") {
	                							echo '<div class="form-group">';
												echo '<label for="input-Column-insert-data-'.$meta_name_columns_mysql['name'].'">'.$meta_name_columns_real['name'].'</label>';
												echo '<textarea class="form-control" id="input-Column-insert-data-'.$meta_name_columns_mysql['name'].'" placeholder="'.$meta_name_columns_real['name'].'"></textarea>';
												echo '</div>';
	                						}
                						}
                					}
                				?>
					    	</div>
							<div class="modal-footer">
					        	<button type="button" class="btn btn-default" data-dismiss="modal" id="modal-button-close-insert-data"><span class="glyphicon glyphicon-off"></span> Đóng</button>
					        	<button type="button" class="btn btn-primary" id="modal-button-save-insert-data" onclick=""><span class="glyphicon glyphicon-plus"></span> Thêm</button>
							</div>
				    	</div>
					</div>
				</div>

				<button type="button" class="btn btn-default" id="button-update-data" onclick="button_update_data()"><span class="glyphicon glyphicon-edit"></span> Sửa</button>
				<!-- Modal update data -->
				<div id="modal-update-data" class="modal fade" tabindex="-1" role="dialog">
					<div class="modal-dialog">
				    	<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Chỉnh sửa dữ liệu</h4>
							</div>
							<div class="modal-body">
								<?php
                					for ($i=0; $i < $col_count; $i++) {
                						$meta_name_columns_mysql = $query_name_columns_mysql->getColumnMeta($i);
                						$meta_name_columns_real = $query_name_columns_real->getColumnMeta($i);
                						if ($i == 0) {
                							echo '<div class="form-group" hidden>';
											echo '<label for="input-Column-update-data-'.$meta_name_columns_mysql['name'].'">'.$meta_name_columns_real['name'].'</label>';
											echo '<input type="text" class="form-control" id="input-Column-update-data-'.$meta_name_columns_mysql['name'].'" placeholder="'.$meta_name_columns_real['name'].'">';
											echo '</div>';
                						}else{
	                						if ($meta_name_columns_real['native_type'] == 'LONG') {
	                							echo '<div class="form-group">';
												echo '<label for="input-Column-update-data-'.$meta_name_columns_mysql['name'].'">'.$meta_name_columns_real['name'].'</label>';
												echo '<input type="number" class="form-control" id="input-Column-update-data-'.$meta_name_columns_mysql['name'].'" placeholder="'.$meta_name_columns_real['name'].'">';
												echo '</div>';
	                						}
	                						if ($meta_name_columns_real['native_type'] == "VAR_STRING") {
	                							echo '<div class="form-group">';
												echo '<label for="input-Column-update-data-'.$meta_name_columns_mysql['name'].'">'.$meta_name_columns_real['name'].'</label>';
												echo '<input type="text" class="form-control" id="input-Column-update-data-'.$meta_name_columns_mysql['name'].'" placeholder="'.$meta_name_columns_real['name'].'">';
												echo '</div>';
	                						}
	                						if ($meta_name_columns_real['native_type'] == "BLOB") {
	                							echo '<div class="form-group">';
												echo '<label for="input-Column-update-data-'.$meta_name_columns_mysql['name'].'">'.$meta_name_columns_real['name'].'</label>';
												echo '<textarea class="form-control" id="input-Column-update-data-'.$meta_name_columns_mysql['name'].'" placeholder="'.$meta_name_columns_real['name'].'"></textarea>';
												echo '</div>';
	                						}
                						}
                					}
                				?>
				    		</div>
							<div class="modal-footer">
				        		<button type="button" class="btn btn-default" data-dismiss="modal" id="modal-button-close-update-data"><span class="glyphicon glyphicon-off"></span> Đóng</button>
				        		<button type="button" class="btn btn-primary" id="modal-button-save-update-data" onclick=""><span class="glyphicon glyphicon-floppy-disk"></span> Lưu</button>
							</div>
				    	</div>
				  	</div>
				</div>

				<button type="button" class="btn btn-default" id="button-delete-data" data-toggle="modal" data-target="#modal-delete-data"><span class="glyphicon glyphicon-trash"></span> Xóa</button>
				<!-- Modal delete data -->
				<div id="modal-delete-data" class="modal fade" tabindex="-1" role="dialog">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Xóa dữ liệu</h4>
							</div>
							<div class="modal-body">
								<p>Bạn thật sự muốn xóa ?</p>
							</div>
							<div class="modal-footer">
							    <button type="button" class="btn btn-default" data-dismiss="modal" id="modal-button-no-delete-data" ><span class="glyphicon glyphicon-remove"></span> Không</button>
							    <button type="button" class="btn btn-danger" id="modal-button-yes-delete-data"><span class="glyphicon glyphicon-ok"></span> Có</button>
							</div>
						</div>
					</div>
				</div>

			</div>

			<div id="page-alert">

			</div>

			<!-- Bảng dữ liệu -->
			<div id="table-data">

				<!-- Phần đầu bảng -->
				<div id="table-data-header">
					<div class="row">
				        <div class="col-xs-8 col-xs-offset-2">
						    <div class="input-group">
				                <div class="input-group-btn search-panel">
				                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
				                    	<span id="table-data-header-search-concept">Chọn</span>
				                    	<span class="caret"></span>
				                    </button>
				                    <ul class="dropdown-menu" role="menu">
										<?php
		                					for ($i=0; $i < $col_count; $i++) {
		                						$meta_name_columns_real = $query_name_columns_real->getColumnMeta($i);
		                						echo "<li><a href=\"javascript:table_data_header_search(".$i.",'".$meta_name_columns_real['name']."');\">".$meta_name_columns_real['name']."</a></li>";
		                					}
		                				?>
				                    	<li class="divider"></li>
				                    	<li>
				                    		<a href="javascript:table_data_header_search(-1,'Mọi giá trị');">Mọi giá trị</a>
				                    	</li>
				                    </ul>
				                </div>       
				                <input type="text" class="form-control" id="table-data-header-value-search" placeholder="Tìm kiếm ...">
				                <span class="input-group-btn">
				                    <button class="btn btn-default" type="button" id="table-data-header-button-search"><span class="glyphicon glyphicon-search"></span></button>
				                </span>
				            </div>
				        </div>
					</div>
				</div>

				<!-- Phần giửa bảng -->
				<table id="table-data-body" class="table table-bordred table-tbody">
                	<thead id="table-data-body-thead">
                		<th id="table-data-body-thead-th-0"><input type="checkbox" id="table-data-body-thead-th-check-all"/></th>
                		<?php
                			for ($i=0; $i < $col_count; $i++) { 
                				$meta = $query_name_columns_real->getColumnMeta($i);
								echo '<th id="table-data-body-thead-th-'.($i+1).'" class="header">'.$meta['name'].'</th>';
                			}
                		?>
                	</thead>
                	<tbody id="table-data-body-tbody">
                		<?php
	                		for ($i=0; $i < 10; $i++) {
	                			echo "<tr>";
	                			$nm = $col_count;
	                			while ($nm >= 0) {
	                				echo "<td> . </td>";
	                				$nm--;
	                			}
	                			echo "</tr>";
	                		}
                		?>
					</tbody>
				</table>

				<div id="table-data-footer">
					<div class="row">
						<div id="table-data-footer-page-number" class="col-lg-4">
							<div class="pull-left">
								<a href="" aria-label="Previous">
									<button type="button" class="btn btn-xs"><span class="glyphicon glyphicon-backward" aria-hidden="true"></span></button>
								</a> 
								<span class=""> Trang : </span>
								<input type="number" id="number-page" placeholder="Trang" name="quantity" min="1" max="100" value="1">
								<a href="" aria-label="Next">
									<button type="button" class="btn btn-xs"><span class="glyphicon glyphicon-forward" aria-hidden="true"></span></button>
								</a> 
							</div>
						</div>
						<div id="table-data-footer-current-row-number" class="col-lg-4">
							<div class="text-center">
								<h6><i>Hiển thị</i></h6>
							</div>
						</div>
						<div id="table-data-footer-number-row" class="col-lg-4">
							<div class="pull-right">
								<span class="">Số hàng hiển thị : </span>
								<input type="number" id="number-row" placeholder="Số" name="quantity" min="10" max="200" step="10" value="<?php echo $number_show_row; ?>">
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>

		<div class="jumbotron"></div>
    	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    	<!--[if lt IE 9]>
    	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    	<![endif]-->
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    	<!-- Include all compiled plugins (below), or include individual files as needed -->
<!-- Latest compiled and minified JavaScript -->
<script src="bootstrap/js/bootstrap.min.js"></script>

    	<script type="text/javascript">
			<?php
				
				$text = "";
				for ($i=0; $i < $col_count; $i++) {
					$meta = $query_name_columns_mysql->getColumnMeta($i);
					$text .= ',"'.$meta['name'].'"';
				}
				echo 'var column_name = ['.substr($text,-1*(strlen($text)-1)).'];';
				echo "var table_name = '".$table_name."';\n";
			?>
    	</script>
    	<script src="js/main.min.js"></script>
	</body>
</html>