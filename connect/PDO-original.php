<?php
	class Connexion {
		public static function bdd() {
			$file_path = 'connect/my_setting.ini';
			if(file_exists($file_path)) {
				$config = parse_ini_file($file_path, true);
				$driver   = $config['database']['driver'];
				$host     = $config['database']['host'];
				$port     = $config['database']['port'];
				$database = $config['database']['schema'];
				$user     = $config['database']['username'];
				$pass     = $config['database']['password'];
				$options = array(
					PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
				); 
				try {
					if($port == ''){
						$bdd = new PDO($driver .':host='. $host .';dbname='. $database, $user, $pass, $options);
					}else{
						$bdd = new PDO($driver .':host='. $host .';port='.$port.';dbname='. $database, $user, $pass, $options);
					}
					$bdd->query("SET session max_allowed_packet=33554432");
					$bdd->query("SET session wait_timeout=28800");
					$bdd->query("SET session interactive_timeout=28800");
					$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				}catch (Exception $e) {
					die('Lỗi : '. $e->getMessage());
				}
				return $bdd;
			}
		}
		function convertUT8_unsigned($str) {
			$str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/",'a',$str);
			$str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/",'e',$str);
			$str = preg_replace("/(ì|í|ị|ỉ|ĩ)/",'i',$str);
			$str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/",'o',$str);
			$str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/",'u',$str);
			$str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/",'y',$str);
			$str = preg_replace("/(đ)/",'d',$str);    
			$str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/",'A',$str);
			$str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/",'E',$str);
			$str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/",'I',$str);
			$str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/",'O',$str);
			$str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/",'U',$str);
			$str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/",'Y',$str);
			$str = preg_replace("/(Đ)/",'D',$str);
			return $str;
		}
	}
?>