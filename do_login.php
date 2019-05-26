<?

session_start();

$ref = "dashboard.php";

include('functions/functions.php');

$posts = array_map("xss_clean",$_POST);
$gets = array_map("xss_clean",$_GET);

if(isset($_SESSION['username'])) {

	header( "Location: logout.php" );
	
	exit();
}

$error = $gets['e'];

if($error == 1) {
    $error = '<div class="error_message">You are not logged-in.</div>';
}


if(isset($posts['login'])) {

	$username = $posts['username']; 
	$password = $posts['password']; 

	if (!isset($username) || !isset($password)) { 
	header( "Location: index.php?error=1" ); 
	exit();
	
	} 
	elseif (empty($username) || empty($password)) { 
	header( "Location: index.php?error=1" );
	exit();
	
	} else { 
	 
	$user = addslashes($posts['username']); 
	$pass = md5($posts['password']); 
	
	
	$sql = "SELECT * FROM user WHERE username='$user' AND password='$pass'";
	
	$result = mysql_query($sql);
	
	$rowCheck = mysql_num_rows($result); 
	
	if($rowCheck > 0) { 

	if($row = mysql_fetch_array($result)) {
	  
	  $_SESSION['username'] = $row["username"];
	  
	  header( "Location: ".$ref); 
	  exit();
	
	  } 
	
	  }
	  else { 
	  header( "Location: index.php?error=1");
	  }
	  
	  } 
}

echo $error;

?>