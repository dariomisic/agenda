<?
error_reporting(E_ERROR);
session_start();
if(!isset($included))
{
include('functions/functions.php');
$included=1;
}

$posts = array_map("xss_clean",$_POST);
$gets = array_map("xss_clean",$_GET);
		
if(isset($_SESSION['username'])){

	function check_login($level) {
					
		$username_s = $_SESSION['username']; 
		
		$sql = "SELECT user_level FROM user WHERE username = '$username_s'"; 
		$result = mysql_query($sql);
				
		$row = mysql_fetch_array($result);
		$user_level = $row['user_level'];
		
		if($user_level <= $level) {		
		
		} else {
		
			include('user_level.php');
			exit();
		
		}
	
	}

} else {

	function check_login($level) { exit(); }
	
	exit();
	
}

?> 