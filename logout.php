<?

session_start(); 

$ref = "index.php?logout=1";
 
if(isset($_SESSION['username'])){ 
session_unset(); 
session_destroy();
header("Location: ".$ref); 

} else { header("Location: ".$ref); }

?>