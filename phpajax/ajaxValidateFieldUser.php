<?php

/* RECEIVE VALUE */
$validateValue=$_REQUEST['fieldValue'];
$validateId=$_REQUEST['fieldId'];


$validateError= "This username is already taken";
$validateSuccess= "This username is available";

include('../functions/functions.php');

		$sql = 'SELECT user_id FROM user WHERE username=\''.$validateValue.'\'';
		$result = mysql_query($sql);
		$mudvayne=mysql_num_rows($result);

	/* RETURN VALUE */
	$arrayToJs = array();
	$arrayToJs[0] = $validateId;

if(!$mudvayne){		// validate??
	$arrayToJs[1] = true;			// RETURN TRUE
	echo json_encode($arrayToJs);			// RETURN ARRAY WITH success
}else{
	for($x=0;$x<1000000;$x++){
		if($x == 990000){
			$arrayToJs[1] = false;
			echo json_encode($arrayToJs);		// RETURN ARRAY WITH ERROR
		}
	}
	
}

?>