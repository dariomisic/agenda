<?php

require('../functions/config.php');

function xss_clean($data)
{
        // Fix &entity\n;
        $data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
        $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
        $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
        $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');
 
        // Remove any attribute starting with "on" or xmlns
        $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);
 
        // Remove javascript: and vbscript: protocols
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);
 
        // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);
 
        // Remove namespaced elements (we do not need them)
        $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);
 
        do
        {
                // Remove really unwanted tags
                $old_data = $data;
                $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
        }
        while ($old_data !== $data);
 
        // we are done...
        return $data;
}

$posts = array_map("xss_clean",$_POST);
$gets = array_map("xss_clean",$_GET);

$link = mysql_connect($server,$user,$pass);
$link_vat = mysql_connect($server,$user,$pass);

mysql_select_db($database, $link);
mysql_select_db($database, $link);


    function getUserByEmailAndPassword($email,$password,$first) {
        $result = mysql_query('SELECT * FROM user WHERE username = \''.$email.'\'',$first) or die(mysql_error());
        // check for result 
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            $result = mysql_fetch_array($result);
            if (md5($password) == $result['password']) {
                // user authentication details are correct
                $result['created_at']='10.10.2014';
                $result['updated_at']='10.10.2014';
                return $result;
            }
        } else {
            // user not found
            return false;
        }
    }
    
    
    function getUserByEmailAndPasswordhash($email, $password,$first) {
        $result = mysql_query('SELECT * FROM user WHERE username = \''.$email.'\'',$first) or die(mysql_error());
        // check for result 
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            $result = mysql_fetch_array($result);
            if ($password == $result['password']) {
                // user authentication details are correct
                $result['created_at']='10.10.2014';
                $result['updated_at']='10.10.2014';
                return $result;
            }
        } else {
            // user not found
            return false;
        }
    }
    
    
    function getUserData($id,$first,$year,$week_no,$username) {



	$sql="SELECT user_id FROM user WHERE username='".$username."'";

	$result = mysql_query($sql);
	
	$id=mysql_fetch_array($result);
	
	

	$yy= (int) $year;
	$ww= (int) $week_no;


	
	$week_start = new DateTime();
    $week_start->setISODate($yy, $ww);

    $seven_day_week = array('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday','sunday');
    $week = array();

    for ($i = 0; $i < 7; $i++) {
        $day = $seven_day_week[$i];
        $week[$i] = $week_start->format('Y-m-d');
        $week_start->modify('+1 day');
    }
$c=0;
$i=0;
$m=0;
foreach($week as $w)
{
$c++;
if($c%2)
$margin="20";
else
$margin="0";
$sql="SELECT user.fname,user.lname,activity.name,HOUR(event.start),MINUTE(event.start),HOUR(event.end),MINUTE(event.end),allday FROM event INNER JOIN activity ON activity.activity_id=event.activity INNER JOIN user ON activity.employee=user.user_id  WHERE ( DATE(event.end)='".$w."' OR DATE(event.start)='".$w."' ) AND user.user_id='".$id[0]."'";

//echo '<div class="column_left" style="width:50% !important;"><div class="column_right_grid date_events" style="padding-bottom:5px !important; margin-top:20px; margin-right:'.$margin.'px;"> <h3>'.$seven_day_week[$c-1].'</h3><div class="scroll"><table class="tabela" cellspacing="0"><tbody>';
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result))
		{
		$f_name=$row[0]." ".$row[1];
		$activity_name=$row[2];
		if($row[4]==0)
		$row[4]="00";
		if($row[6]==0)
		$row[6]="00";
		$start=$row[3].":".$row[4];
		$end=$row[5].":".$row[6];
		if($row[7]=="1")
		{
			
		$start='';
		$end='AD';
		}

		
		//echo '<tr><td width="30%">'.$f_name.'</td><td width="50%">'.$activity_name.'</td><td width="10%">'.$start.'</td><td width="10%">'.$end.'</td></tr>';
		$a["name"]=$f_name;
		$a["activity"]=$activity_name;
		if($end!="AD")
		$a["t"]=$start."-".$end;
		else
		$a["t"]=$end;
		$a["day"]=$seven_day_week[$c-1];
		$a["type"]="0";
		
		$final['data'][$i]=$a;
        $i++;	
		
	
		} 
		
		
		
		
		
		$sql2="SELECT user.fname,user.lname,event.title,HOUR(event.start),MINUTE(event.start),HOUR(event.end),MINUTE(event.end),event.allday FROM event INNER JOIN user ON event.employee=user.user_id WHERE event.activity=0 AND event.place IS NULL AND (DATE(event.end)='".$w."' OR DATE(event.start)='".$w."') AND user.user_id='".$id[0]."'";

		$result2 = mysql_query($sql2);
		while($row2 = mysql_fetch_array($result2))
		{
		$f_name=$row2[0]." ".$row2[1];
		$activity_name=$row2[2];
		if($row2[4]==0)
		$row2[4]="00";
		if($row2[6]==0)
		$row2[6]="00";
		$start2=$row2[3].":".$row2[4];
		$end2=$row2[5].":".$row2[6];
		if($row2[7]=="1")
		{
		$start2='';
		$end2='AD';
		}

		
		//echo '<tr><td width="30%">'.$f_name.'</td><td width="50%">'.$activity_name.'</td><td width="10%">'.$start2.'</td><td width="10%">'.$end2.'</td></tr>';
		$a["name"]=$f_name;
		$a["activity"]=$activity_name;
		if($end2!="AD")
		$a["t"]=$start2."-".$end2;
		else
		$a["t"]=$end2;
		$a["day"]=$seven_day_week[$c-1];
		$a["type"]="0";
		
		
		$final['data'][$i]=$a;
        $i++;	
		} 
		
	 $sql3="SELECT user.fname,user.lname,event.title,HOUR(event.start),MINUTE(event.start),HOUR(event.end),MINUTE(event.end),event.allday,event.place,event.phone FROM event INNER JOIN user ON event.employee=user.user_id WHERE event.activity=0 AND event.place IS NOT NULL AND (DATE(event.end)='".$w."' OR DATE(event.start)='".$w."') AND user.user_id='".$id[0]."'";

		$result3 = mysql_query($sql3);
		while($row3 = mysql_fetch_array($result3))
		{
		$f_name=$row3[0]." ".$row3[1];
		$activity_name=$row3[2];
		if($row3[4]==0)
		$row3[4]="00";
		if($row3[6]==0)
		$row3[6]="00";
		$start3=$row3[3].":".$row3[4];
		$end3=$row3[5].":".$row3[6];
		if($row3[7]=="1")
		{
		$start3='';
		$end3='AD';
		}

		
		//echo '<tr><td width="30%">'.$f_name.'</td><td width="50%">APP:'.$activity_name.'<br>LOC: '.$row3[8].'<br>PHONE: '.$row3[9].'</td><td width="10%">'.$start3.'</td><td width="10%">'.$end3.'</td></tr>';
		$a["name"]=$f_name;
		$a["activity"]=$activity_name;
		if($end3!="AD")
		$a["t"]=$start3."-".$end3;
		else
		$a["t"]=$end3;
		$a["day"]=$seven_day_week[$c-1];
		$a["type"]="1";
		
		$final['data'][$i]=$a;
        $i++;	
		
		} 		
        		
}


if($final)
{
return $final;
}
else
{
return false;
}



    }
 
    /**
     * Check user is existed or not
     */
    function isUserExisted($email) {
        $result = mysql_query("SELECT email from users WHERE email = '$email'",$first);
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            // user existed 
            return true;
        } else {
            // user not existed
            return false;
        }
    }
    
    
    
    
    
    
    if (isset($_REQUEST['tag']) && $_REQUEST['tag'] != '') {
    // get tag
    $tag = $_REQUEST['tag'];
 

    // response Array
    $response = array("tag" => $tag, "success" => 0, "error" => 0);
 
    // check for tag type
    if ($tag == 'login') {
        // Request type is check Login
        $email = $_REQUEST['email'];
        $password = $_REQUEST['password'];
         
        // check for user
        $user = getUserByEmailAndPassword($email, $password,$link);
        if ($user != false) {
            // user found
            // echo json with success = 1
            $response["success"] = 1;
            $response["uid"] = $user["user_id"];
            $response["user"]["name"] = $user["fname"]." ".$user["lname"];
            $response["user"]["email"] = $user["username"];
            $response["user"]["created_at"] = $user["created_at"];
            $response["user"]["updated_at"] = $user["updated_at"];
            echo json_encode($response);
        } else {
            // user not found
            // echo json with error = 1
            $response["error"] = 1;
            $response["error_msg"] = "Incorrect email or password!";
            echo json_encode($response);
        }
    } else if ($tag == 'data') {
    
    
    // Request type is check Login
        $email = $_REQUEST['email'];
        $password = $_REQUEST['password'];
        $id = $_REQUEST['id'];
		$year=$posts['y'];
		$week_no=$posts['w'];

         
        // check for user
        $user = getUserByEmailAndPasswordhash($email,$password,$link);
        if ($user != false) {
            // user found
            // echo json with success = 1
			$response=getUserData($id,$link,$year,$week_no,$email);
			echo json_encode($response);

        } else {
            // user not found
            // echo json with error = 1
            $response["error"] = 1;
            $response["error_msg"] = "Incorrect email or password!";
            echo json_encode($response);
        }
    
    } else {
        echo "Invalid Request";
    }
} else {
    echo "Access Denied";
}
    
    
mysql_close($link);
mysql_close($link_vat);
    
    
?>