<?

include('check.php');
check_login('3');

if(!isset($included))
include('functions/functions.php');

$posts = array_map("xss_clean",$_POST);
$gets = array_map("xss_clean",$_GET);

function delete_activity($id)
{
$sql="DELETE FROM activity WHERE activity_id=".$id;
$result=mysql_query($sql);

$sql="DELETE FROM event WHERE activity=".$id;
$result=mysql_query($sql);
}

function delete_project($id)
{
$sql="DELETE FROM project WHERE project_id=".$id;
$result=mysql_query($sql);

$sql="SELECT activity_id FROM activity WHERE project".$id;
$r=mysql_query($sql);

while($row = mysql_fetch_array($r,MYSQL_ASSOC))
		{	
		delete_activity($row['activity_id']);
		}
}

function delete_client($id)
{
$sql="DELETE FROM client WHERE client_id=".$id;
$result=mysql_query($sql);

$sql="SELECT project_id FROM project WHERE client=".$id;
$r3=mysql_query($sql);

while($row3 = mysql_fetch_array($r3,MYSQL_ASSOC))
		{	
		delete_project($row3['project_id']);
		}
}

function delete_user($id)
{
$sql="DELETE FROM user WHERE user_id=".$id;
$result=mysql_query($sql);

$sql="SELECT project_id FROM project WHERE manager=".$id;
$r4=mysql_query($sql);

while($row4 = mysql_fetch_array($r4,MYSQL_ASSOC))
		{	
		delete_project($row4['project_id']);
		}
		
$sql="SELECT activity_id FROM activity WHERE employee=".$id;
$r5=mysql_query($sql);

while($row5 = mysql_fetch_array($r5,MYSQL_ASSOC))
		{	
		delete_activity($row5['activity_id']);
		}
			
$sql="DELETE FROM event WHERE employee=".$id;
$r6=mysql_query($sql);

$sql="DELETE FROM working_on_project WHERE user=".$id;
$r7=mysql_query($sql);

}

function to_us($date)
{
//DD-MM-YYYY to YYYY-MM-DD

$bits=explode("-",$date);

return $bits[2]."-".$bits[1]."-".$bits[0];

}

function to_int($date)
{
//YYYY-MM-DD to DD-MM-YYYY

$bits=explode("-",$date);

return $bits[2]."-".$bits[1]."-".$bits[0];

}

function insert_working_users($project_id)
{
foreach ($_POST["working"] as $key=>$values){
$sql="INSERT INTO working_on_project (user,project) VALUES (".$values.",".$project_id.")";
$result = mysql_query($sql);
}
}

function encode_working_users($project_id)
{
		$sql = "SELECT user_id FROM user ORDER BY user_id ASC"; 
		$result = mysql_query($sql);
				
		while($row = mysql_fetch_array($result))
		{	
		$sql2="SELECT user FROM working_on_project WHERE project=".$project_id." AND user=".$row[0];
		$result2 = mysql_query($sql2);
		if(mysql_num_rows($result2))
		$e[]=1;
		else
		$e[]=0;
		}
return $e;
}


function encode_weekdays($id)
{
		$sql = "SELECT workday FROM working WHERE user=".$id;
		$result = mysql_query($sql);
		$w=array(0,0,0,0,0,0,0);
		while($row = mysql_fetch_array($result))
		{
			$w[$row[0]-1]=1;
		}
return implode($w);
}

function decode_weekdays($id)
{
$weekd="0000000";
for($m=1;$m<8;$m++)
{
if($_POST[$m.""]=="on")
{
$sql="INSERT INTO working (user,workday) VALUES (".$id.",".$m.")";
$result = mysql_query($sql);
$weekd[$m-1]=1;
}
}
return $weekd;
}

if($gets["domain"] == "user")
{

if($gets["action"] == "list")
{

		$sql = "SELECT * FROM user";
		$result = mysql_query($sql);
				
		$rows = array();
		while($row = mysql_fetch_array($result,MYSQL_ASSOC))
		{	
			$row["concatenated_id"]=$row["city"].$row["user_id"];
			$row["fullname"]=$row["fname"]." ".$row["lname"];
			//$row["birthdate"]=to_int($row["birthdate"]);
			$row["func"]=$row["function"];
			$row["Weekdays"]=encode_weekdays($row["user_id"]);
			$row["password"]=$row["passwordr"]="password";
		    $rows[] = $row;
		}

$jTableResult = array();
$jTableResult['Result'] = "OK";
$jTableResult['Records'] = $rows;
print json_encode($jTableResult);

}
elseif($gets["action"] == "update")
{

if($posts["password"]=="password")
{
$sql="UPDATE user SET user_active='" . $posts["user_active"] . "', fname='" . $posts["fname"] . "', lname='" . $posts["lname"] . "', email='" . $posts["email"] . "', sex='" . $posts["sex"] . "', birthdate='" . to_us($posts["birthdate"]) . "', address='" . $posts["address"] . "', zip='" . $posts["zip"] . "', residence='" . $posts["residence"] . "', hphone='" . $posts["hphone"] . "', mphone='" . $posts["mphone"] . "', function='" . $posts["func"] . "', department='" . $posts["department"] . "', d_employment='" . to_us($posts["d_employment"]) . "', d_service='" . to_us($posts["d_service"]) . "', hour_wage='" . $posts["hour_wage"] . "', tarrif='" . $posts["tarrif"] . "', min_hours='" . $posts["min_hours"] . "' WHERE user_id='" . $posts["user_id"] . "'";
}
else
{
$sql="UPDATE user SET user_active='" . $posts["user_active"] . "', fname='" . $posts["fname"] . "', lname='" . $posts["lname"] . "', email='" . $posts["email"] . "', sex='" . $posts["sex"] . "', birthdate='" . to_us($posts["birthdate"]) . "', address='" . $posts["address"] . "', zip='" . $posts["zip"] . "', residence='" . $posts["residence"] . "', hphone='" . $posts["hphone"] . "', mphone='" . $posts["mphone"] . "', function='" . $posts["func"] . "', department='" . $posts["department"] . "', d_employment='" . to_us($posts["d_employment"]) . "', d_service='" . to_us($posts["d_service"]) . "', hour_wage='" . $posts["hour_wage"] . "', tarrif='" . $posts["tarrif"] . "', min_hours='" . $posts["min_hours"] . "', password='" . md5($posts["password"]) . "' WHERE user_id='" . $posts["user_id"] . "'";
}

$result=mysql_query($sql);

$result2 = mysql_query("SELECT * FROM user WHERE user_id=".$posts["user_id"]);
$row = mysql_fetch_array($result2);
$row["concatenated_id"]=$row["city"].$row["user_id"];
$row["fullname"]=$row["fname"]." ".$row["lname"];
$row["func"]=$row["function"];
$row["password"]=$row["passwordr"]="password";
$result3 = mysql_query("DELETE FROM working WHERE user=".$posts["user_id"]);
decode_weekdays($row["user_id"]);


$jTableResult = array();
$jTableResult['Result'] = "OK";
$jTableResult['Records'] = $row;
print json_encode($jTableResult);

}
elseif($gets["action"] == "create")
{
$password=md5($posts["password"]);

$sql="INSERT INTO user (user_level, user_active, username, fname, lname, email, password, timestamp, sex, birthdate, address, zip, residence, hphone, mphone, function, department, d_employment, d_service, hour_wage, tarrif, min_hours, city) VALUES ('" . $posts["user_level"] . "', '" . $posts["user_active"] . "', '" . $posts["username"] . "', '" . $posts["fname"] . "', '" . $posts["lname"] . "', '" . $posts["email"] . "', '" . $password . "', now(), '" . $posts["sex"] . "', '" . to_us($posts["birthdate"]) . "', '" . $posts["address"] . "', '" . $posts["zip"] . "', '" . $posts["residence"] . "', '" . $posts["hphone"] . "', '" . $posts["mphone"] . "', '" . $posts["func"] . "', '" . $posts["department"] . "', '" . to_us($posts["d_employment"]) . "', '" . to_us($posts["d_service"]) . "', '" . $posts["hour_wage"] . "', '" . $posts["tarrif"] . "', '" . $posts["min_hours"] . "', '" . $posts["city"] . "');";

$result=mysql_query($sql);


if(mysql_affected_rows())
{
$result2 = mysql_query("SELECT * FROM user WHERE user_id = LAST_INSERT_ID();");
$row = mysql_fetch_array($result2);
$row["concatenated_id"]=$row["city"].$row["user_id"];
$row["fullname"]=$row["fname"]." ".$row["lname"];
$row["func"]=$row["function"];
$row["password"]=$row["passwordr"]="password";
$row["Weekdays"]=decode_weekdays($row["user_id"]);



$jTableResult = array();
$jTableResult['Result'] = "OK";
$jTableResult['Record'] = $row;
print json_encode($jTableResult);
}
}
elseif($gets["action"] == "function")
{
		$sql = "SELECT * FROM function"; 
		$result = mysql_query($sql);
				
		$rows = array();
		while($row = mysql_fetch_array($result))
		{	
			$row["Value"]=$row[0];
			$row["DisplayText"]=$row[1];
		    $rows[] = $row;
		}
		
$jTableResult = array();
$jTableResult['Result'] = "OK";
$jTableResult['Options'] = $rows;
print json_encode($jTableResult);
}
elseif($gets["action"] == "department")
{
		$sql = "SELECT * FROM department"; 
		$result = mysql_query($sql);
				
		$rows = array();
		while($row = mysql_fetch_array($result))
		{	
			$row["Value"]=$row[0];
			$row["DisplayText"]=$row[1];
		    $rows[] = $row;
		}
		
$jTableResult = array();
$jTableResult['Result'] = "OK";
$jTableResult['Options'] = $rows;
print json_encode($jTableResult);
}
elseif($gets["action"] == "city")
{
		$sql = "SELECT * FROM city"; 
		$result = mysql_query($sql);
				
		$rows = array();
		while($row = mysql_fetch_array($result))
		{	
			$row["Value"]=$row[0];
			$row["DisplayText"]=$row[1];
		    $rows[] = $row;
		}
		
$jTableResult = array();
$jTableResult['Result'] = "OK";
$jTableResult['Options'] = $rows;
print json_encode($jTableResult);
}
elseif($gets["action"] == "tarrif")
{
		$sql = "SELECT * FROM tariff"; 
		$result = mysql_query($sql);
				
		$rows = array();
		while($row = mysql_fetch_array($result))
		{	
			$row["Value"]=$row[0];
			$row["DisplayText"]=$row[1];
		    $rows[] = $row;
		}
		
$jTableResult = array();
$jTableResult['Result'] = "OK";
$jTableResult['Options'] = $rows;
print json_encode($jTableResult);
}
elseif($gets["action"] == "dependent")
{
		$sql = "SELECT activity_id,name FROM activity WHERE project=".$gets['project']; 
		$result = mysql_query($sql);
				
		$rows = array();
		while($row = mysql_fetch_array($result))
		{	
			$row["Value"]=$row[0];
			$row["DisplayText"]=$row[1];
		    $rows[] = $row;
		}
		
$jTableResult = array();
$jTableResult['Result'] = "OK";
$jTableResult['Options'] = $rows;
print json_encode($jTableResult);
}
elseif($gets["action"] == "delete")
{
		delete_user($posts["user_id"]);
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
}
}
if($gets["domain"] == "client")
{

if($gets["action"] == "list")
{

if(isset($posts['search']))
{
if($posts['search']=="")
	{
	$search="";
	}
	else
	{
	$search=' WHERE name LIKE \'%'.stripslashes($posts['search']).'%\'';	
	}
}
else
{
$search="";
}

		$sql = 'SELECT * FROM client'.$search.' ORDER BY '.$gets['jtSorting'].' LIMIT '.$gets['jtStartIndex'].','.$gets['jtPageSize'];
		
		$sql2 = 'SELECT * FROM client'.$search;
		$result = mysql_query($sql);
		$result2 = mysql_query($sql2);
		$total_rows=mysql_num_rows($result2);
				
		$rows = array();
		while($row = mysql_fetch_array($result,MYSQL_ASSOC))
		{	
			$row["contact_person"]=$row["fname"]." ".$row["lname"];
		    $rows[] = $row;
		}


$jTableResult = array();
$jTableResult['Result'] = "OK";
$jTableResult['TotalRecordCount'] = $total_rows;
$jTableResult['Records'] = $rows;
print json_encode($jTableResult);

}
elseif($gets["action"] == "update")
{

$sql="UPDATE client SET client_status='" . $posts["client_status"] . "', name='" . $posts["name"] . "', address='" . $posts["address"] . "', zip='" . $posts["zip"] . "', city='" . $posts["city"] . "', phone='" . $posts["phone"] . "', kvk='" . $posts["kvk"] . "', btw='" . $posts["btw"] . "', fname='" . $posts["fname"] . "', lname='" . $posts["lname"] . "', sex='" . $posts["sex"] . "', hphone='" . $posts["hphone"] . "', mphone='" . $posts["mphone"] . "', email='" . $posts["email"] . "', p_address='" . $posts["p_address"] . "', mailbox='" . $posts["mailbox"] . "', p_zip='" . $posts["p_zip"] . "', p_city='" . $posts["p_city"] . "' WHERE client_id='" . $posts["client_id"] . "'";


$result=mysql_query($sql);


$jTableResult = array();
$jTableResult['Result'] = "OK";
print json_encode($jTableResult);

}
elseif($gets["action"] == "create")
{


$sql="INSERT INTO client (client_status, name, address, zip, city, phone, kvk, btw, fname, lname, sex, hphone, mphone, email, p_address, mailbox, p_zip, p_city) VALUES ('" . $posts["client_status"] . "', '" . $posts["name"] . "', '" . $posts["address"] . "', '" . $posts["zip"] . "', '" . $posts["city"] . "', '" . $posts["phone"] . "', '" . $posts["kvk"] . "', '" . $posts["btw"] . "', '" . $posts["fname"] . "', '" . $posts["lname"] . "', '" . $posts["sex"] . "', '" . $posts["hphone"] . "', '" . $posts["mphone"] . "', '" . $posts["email"] . "', '" . $posts["p_address"] . "', '" . $posts["mailbox"] . "', '" . $posts["p_zip"] . "', '" . $posts["p_city"] . "');";

$result=mysql_query($sql);


if(mysql_affected_rows())
{
$result2 = mysql_query("SELECT * FROM client WHERE client_id = LAST_INSERT_ID();");
$row = mysql_fetch_array($result2);
$row["contact_person"]=$row["fname"]." ".$row["lname"];

$jTableResult = array();
$jTableResult['Result'] = "OK";
$jTableResult['Record'] = $row;
print json_encode($jTableResult);
}
}
elseif($gets["action"] == "delete")
{
		delete_client($posts["client_id"]);
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
}

}
elseif($gets["domain"] == "project")
{


if($gets["action"] == "list")
{


if(isset($posts['search']))
{
if($posts['search']=="")
	{
	$search="";
	}
	else
	{
	$search=' WHERE name LIKE \'%'.stripslashes($posts['search']).'%\'';	
	}
}
else
{
$search="";
}


		$sql = 'SELECT * FROM project'.$search.' ORDER BY '.$gets['jtSorting'].' LIMIT '.$gets['jtStartIndex'].','.$gets['jtPageSize'];
		$sql2 = 'SELECT * FROM project'.$search;
		$result = mysql_query($sql);
		$result2 = mysql_query($sql2);
		$total_rows=mysql_num_rows($result2);
		$rows = array();
		while($row = mysql_fetch_array($result,MYSQL_ASSOC))
		{	
			//$row["start"]=to_int($row["start"]);
			//$row["end"]=to_int($row["end"]);
			$row["working"]=encode_working_users($row["project_id"]);
		    $rows[] = $row;
		}

$jTableResult = array();
$jTableResult['Result'] = "OK";
$jTableResult['TotalRecordCount'] = $total_rows;
$jTableResult['Records'] = $rows;
print json_encode($jTableResult);

}
elseif($gets["action"] == "update")
{

$sql="UPDATE project SET name='" . $posts["name"] . "', description='" . $posts["description"] . "', type='" . $posts["type"] . "', client='" . $posts["client"] . "', price='" . $posts["price"] . "', manager='" . $posts["manager"] . "', code='" . $posts["code"] . "', start='" . to_us($posts["start"]) . "', end='" . to_us($posts["end"]) . "', status='" . $posts["status"] . "' WHERE project_id='" . $posts["project_id"] . "'";


$result=mysql_query($sql);

$sql2="DELETE FROM working_on_project WHERE project=".$posts["project_id"];
$result2=mysql_query($sql2);
insert_working_users($posts["project_id"]);
$jTableResult = array();
$jTableResult['Result'] = "OK";
print json_encode($jTableResult);

}
elseif($gets["action"] == "create")
{

$sql="INSERT INTO project (name, description, type, client, price, manager, code, start, end, status) VALUES ('" . $posts["name"] . "', '" . $posts["description"] . "', '" . $posts["type"] . "', '" . $posts["client"] . "', '" . $posts["price"] . "', '" . $posts["manager"] . "', '" . $posts["code"] . "', '" . to_us($posts["start"]) . "', '" . to_us($posts["end"]) . "', '" . $posts["status"] . "');";

$result=mysql_query($sql);


if(mysql_affected_rows())
{
$result2 = mysql_query("SELECT * FROM project WHERE project_id = LAST_INSERT_ID();");
$row = mysql_fetch_array($result2);
$row["start"]=to_int($row["start"]);
$row["end"]=to_int($row["end"]);
insert_working_users($row["project_id"]);
$row["working"]=encode_working_users($row["project_id"]);

$jTableResult = array();
$jTableResult['Result'] = "OK";
$jTableResult['Record'] = $row;
print json_encode($jTableResult);
}
}
elseif($gets["action"] == "delete")
{
		delete_project($posts["project_id"]);
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
}
elseif($gets["action"] == "client")
{
		$sql = "SELECT client_id,name FROM client"; 
		$result = mysql_query($sql);
				
		$rows = array();
		while($row = mysql_fetch_array($result))
		{	
			$row["Value"]=$row[0];
			$row["DisplayText"]=$row[1];
		    $rows[] = $row;
		}
		
$jTableResult = array();
$jTableResult['Result'] = "OK";
$jTableResult['Options'] = $rows;
print json_encode($jTableResult);
}
elseif($gets["action"] == "manager")
{
		$sql = "SELECT user_id,fname,lname FROM user WHERE user_level<3"; 
		$result = mysql_query($sql);
				
		$rows = array();
		while($row = mysql_fetch_array($result))
		{	
			$row["Value"]=$row[0];
			$row["DisplayText"]=$row[1]." ".$row[2];
		    $rows[] = $row;
		}
		
$jTableResult = array();
$jTableResult['Result'] = "OK";
$jTableResult['Options'] = $rows;
print json_encode($jTableResult);
}
elseif($gets["action"] == "e")
{
		$sql = "SELECT user_id,fname,lname FROM user"; 
		$result = mysql_query($sql);
				
		$rows = array();
		while($row = mysql_fetch_array($result))
		{	
			$row["Value"]=$row[0];
			$row["DisplayText"]=$row[1]." ".$row[2];
		    $rows[] = $row;
		}
		
$jTableResult = array();
$jTableResult['Result'] = "OK";
$jTableResult['Options'] = $rows;
print json_encode($jTableResult);
}
elseif($gets["action"] == "employee")
{
		$sql = "SELECT user_id,fname,lname FROM user ORDER BY user_id ASC"; 
		$result = mysql_query($sql);
				
		$rows = array();
		while($row = mysql_fetch_array($result))
		{	
			$row["selected"]=0;
			$row["Value"]=$row[0];
			$row["DisplayText"]=$row[1]." ".$row[2];
		    $rows[] = $row;
		}
$jTableResult = array();
$jTableResult['Result'] = "OK";
$jTableResult['Options'] = $rows;
print json_encode($jTableResult);
}


}
elseif($gets['domain']=="function")
{

if($gets["action"] == "list")
{

		$sql = "SELECT * FROM function";
		$result = mysql_query($sql);
				
		$rows = array();
		while($row = mysql_fetch_array($result,MYSQL_ASSOC))
		{	
					    $rows[] = $row;
		}

$jTableResult = array();
$jTableResult['Result'] = "OK";
$jTableResult['Records'] = $rows;
print json_encode($jTableResult);

}
elseif($gets["action"] == "update")
{

$sql="UPDATE function SET name='" . $posts["name"] . "' WHERE function_id='" . $posts["function_id"] . "'";


$result=mysql_query($sql);

$jTableResult = array();
$jTableResult['Result'] = "OK";
print json_encode($jTableResult);

}
elseif($gets["action"] == "create")
{


$sql="INSERT INTO function (name) VALUES ('" . $posts["name"] . "');";

$result=mysql_query($sql);


if(mysql_affected_rows())
{
$result2 = mysql_query("SELECT * FROM function WHERE function_id = LAST_INSERT_ID();");
$row = mysql_fetch_array($result2);

$jTableResult = array();
$jTableResult['Result'] = "OK";
$jTableResult['Record'] = $row;
print json_encode($jTableResult);
}
}
elseif($gets["action"] == "delete")
{
		$result = mysql_query("DELETE FROM function WHERE function_id = " . $posts["function_id"] . ";");
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
}




}
elseif($gets['domain']=="city")
{

if($gets["action"] == "list")
{

		$sql = "SELECT * FROM city";
		$result = mysql_query($sql);
				
		$rows = array();
		while($row = mysql_fetch_array($result,MYSQL_ASSOC))
		{	
					    $rows[] = $row;
		}

$jTableResult = array();
$jTableResult['Result'] = "OK";
$jTableResult['Records'] = $rows;
print json_encode($jTableResult);

}
elseif($gets["action"] == "update")
{

$sql="UPDATE city SET name='" . $posts["name"] . "' WHERE city_id='" . $posts["city_id"] . "'";


$result=mysql_query($sql);

$jTableResult = array();
$jTableResult['Result'] = "OK";
print json_encode($jTableResult);

}
elseif($gets["action"] == "create")
{


$sql="INSERT INTO city (name) VALUES ('" . $posts["name"] . "');";

$result=mysql_query($sql);


if(mysql_affected_rows())
{
$result2 = mysql_query("SELECT * FROM city WHERE city_id = LAST_INSERT_ID();");
$row = mysql_fetch_array($result2);

$jTableResult = array();
$jTableResult['Result'] = "OK";
$jTableResult['Record'] = $row;
print json_encode($jTableResult);
}
}
elseif($gets["action"] == "delete")
{
		$result = mysql_query("DELETE FROM city WHERE city_id = " . $posts["city_id"] . ";");
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
}




}
elseif($gets["domain"] == "cuser")
{

if($gets["action"] == "list")
{

		$sql = "SELECT * FROM client_users";
		$result = mysql_query($sql);
				
		$rows = array();
		while($row = mysql_fetch_array($result,MYSQL_ASSOC))
		{	
			$row["password"]=$row["passwordr"]="password";
		    $rows[] = $row;
		}

$jTableResult = array();
$jTableResult['Result'] = "OK";
$jTableResult['Records'] = $rows;
print json_encode($jTableResult);

}
elseif($gets["action"] == "update")
{

if($posts["password"]=="password")
{
$sql="UPDATE client_users SET client='" . $posts["client"] . "' WHERE id='" . $posts["id"] . "'";
}
else
{
$sql="UPDATE client_users SET client='" . $posts["client"] . "', password='" . md5($posts["password"]) . "' WHERE id='" . $posts["id"] . "'";
}

$result=mysql_query($sql);

$jTableResult = array();
$jTableResult['Result'] = "OK";
print json_encode($jTableResult);

}
elseif($gets["action"] == "create")
{
$password=md5($posts["password"]);

$sql="INSERT INTO client_users (username, password ,client) VALUES ('" . $posts["username"] . "', '" . md5($posts["password"]) . "', '" . $posts["client"] . "');";

$result=mysql_query($sql);


if(mysql_affected_rows())
{
$result2 = mysql_query("SELECT * FROM client_users WHERE id = LAST_INSERT_ID();");
$row = mysql_fetch_array($result2);
$row["password"]=$row["passwordr"]="password";



$jTableResult = array();
$jTableResult['Result'] = "OK";
$jTableResult['Record'] = $row;
print json_encode($jTableResult);
}
}
elseif($gets["action"] == "function")
{
		$sql = "SELECT * FROM function"; 
		$result = mysql_query($sql);
				
		$rows = array();
		while($row = mysql_fetch_array($result))
		{	
			$row["Value"]=$row[0];
			$row["DisplayText"]=$row[1];
		    $rows[] = $row;
		}
		
$jTableResult = array();
$jTableResult['Result'] = "OK";
$jTableResult['Options'] = $rows;
print json_encode($jTableResult);
}
elseif($gets["action"] == "client")
{
		$sql = "SELECT * FROM client"; 
		$result = mysql_query($sql);
				
		$rows = array();
		while($row = mysql_fetch_array($result))
		{	
			$row["Value"]=$row[0];
			$row["DisplayText"]=$row[2];
		    $rows[] = $row;
		}
		
$jTableResult = array();
$jTableResult['Result'] = "OK";
$jTableResult['Options'] = $rows;
print json_encode($jTableResult);
}
elseif($gets["action"] == "city")
{
		$sql = "SELECT * FROM city"; 
		$result = mysql_query($sql);
				
		$rows = array();
		while($row = mysql_fetch_array($result))
		{	
			$row["Value"]=$row[0];
			$row["DisplayText"]=$row[1];
		    $rows[] = $row;
		}
		
$jTableResult = array();
$jTableResult['Result'] = "OK";
$jTableResult['Options'] = $rows;
print json_encode($jTableResult);
}
elseif($gets["action"] == "tarrif")
{
		$sql = "SELECT * FROM tariff"; 
		$result = mysql_query($sql);
				
		$rows = array();
		while($row = mysql_fetch_array($result))
		{	
			$row["Value"]=$row[0];
			$row["DisplayText"]=$row[1];
		    $rows[] = $row;
		}
		
$jTableResult = array();
$jTableResult['Result'] = "OK";
$jTableResult['Options'] = $rows;
print json_encode($jTableResult);
}
elseif($gets["action"] == "dependent")
{
		$sql = "SELECT activity_id,name FROM activity WHERE project=".$gets['project']; 
		$result = mysql_query($sql);
				
		$rows = array();
		while($row = mysql_fetch_array($result))
		{	
			$row["Value"]=$row[0];
			$row["DisplayText"]=$row[1];
		    $rows[] = $row;
		}
		
$jTableResult = array();
$jTableResult['Result'] = "OK";
$jTableResult['Options'] = $rows;
print json_encode($jTableResult);
}
elseif($gets["action"] == "delete")
{
		$result = mysql_query("DELETE FROM client_users WHERE id = " . $posts["id"] . ";");
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
}
}
elseif($gets['domain']=="department")
{

if($gets["action"] == "list")
{

		$sql = "SELECT * FROM department";
		$result = mysql_query($sql);
				
		$rows = array();
		while($row = mysql_fetch_array($result,MYSQL_ASSOC))
		{	
					    $rows[] = $row;
		}

$jTableResult = array();
$jTableResult['Result'] = "OK";
$jTableResult['Records'] = $rows;
print json_encode($jTableResult);

}
elseif($gets["action"] == "update")
{

$sql="UPDATE department SET name='" . $posts["name"] . "' WHERE department_id='" . $posts["department_id"] . "'";

$result=mysql_query($sql);

$jTableResult = array();
$jTableResult['Result'] = "OK";
print json_encode($jTableResult);

}
elseif($gets["action"] == "create")
{


$sql="INSERT INTO department (name) VALUES ('" . $posts["name"] . "');";

$result=mysql_query($sql);


if(mysql_affected_rows())
{
$result2 = mysql_query("SELECT * FROM department WHERE department_id = LAST_INSERT_ID();");
$row = mysql_fetch_array($result2);

$jTableResult = array();
$jTableResult['Result'] = "OK";
$jTableResult['Record'] = $row;
print json_encode($jTableResult);
}
}
elseif($gets["action"] == "delete")
{
		$result = mysql_query("DELETE FROM department WHERE department_id = " . $posts["department_id"] . ";");
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
}




}
?>