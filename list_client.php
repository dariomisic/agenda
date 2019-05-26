<?
 
include('check.php');
check_login('3');

include('header.php');

if(isset($_GET['id']))
{

if(!isset($included))
include('functions/functions.php');

$posts = array_map("xss_clean",$_POST);
$gets = array_map("xss_clean",$_GET);
    
    $sql = "SELECT * FROM client WHERE client_id=".$gets['id'];
    
	$result = mysql_query($sql);
	
	$row = mysql_fetch_array($result);
	

	$content.='<tr><td>CLIENT NAME</td><td>'.$row[2].'</td></tr>';
	$content.='<tr><td>ADDRESS</td><td>'.$row[3].'</td></tr>';
	$content.='<tr><td>POSTAL CODE</td><td>'.$row[4].'</td></tr>';
	$content.='<tr><td>CITY</td><td>'.$row[5].'</td></tr>';
	$content.='<tr><td>PHONE</td><td>'.$row[6].'</td></tr>';
	$content.='<tr><td>KVK #</td><td>'.$row[7].'</td></tr>';
	$content.='<tr><td>BTW #</td><td>'.$row[8].'</td></tr>';

	$contentc.='<tr><td>NAME</td><td>'.$row[9].' '.$row[10].'</td></tr>';
	$contentc.='<tr><td>GENDER</td><td>'.$row[11].'</td></tr>';
	$contentc.='<tr><td>HOME PHONE</td><td>'.$row[12].'</td></tr>';
	$contentc.='<tr><td>MOBILE PHONE</td><td>'.$row[13].'</td></tr>';
	$contentc.='<tr><td>E-MAIL</td><td>'.$row[14].'</td></tr>';
	$contentc.='<tr><td>P. ADDRESS</td><td>'.$row[15].'</td></tr>';
	$contentc.='<tr><td>MAILBOX</td><td>'.$row[16].'</td></tr>';
	$contentc.='<tr><td>POSTAL CODE</td><td>'.$row[17].'</td></tr>';
	$contentc.='<tr><td>CITY</td><td>'.$row[18].'</td></tr>';


	include('sc.php');

?>

<section class="content">
<div class="row">
<div class="col-md-4">
<div class="box"><div class="box-header"><i class="fa fa-suitcase"></i><h3 class="box-title">Client info</h3></div><div class="box-body"><table class="table">
<?php echo $content; ?>
</table></div></div></div>


<div class="col-md-4">
<div class="box"><div class="box-header"><i class="fa fa-envelope"></i><h3 class="box-title">Contact person info</h3></div><div class="box-body"><table class="table">
<?php echo $contentc; ?>
</table></div></div></div>


<div class="col-md-4">
<div class="box"><div class="box-header"><i class="fa fa-folder-open"></i><h3 class="box-title">Active projects</h3></div><div class="box-body">
<div style="width:100%; font-size:60px; text-align:center;">
<?php 
						            
						            $sql="SELECT COUNT(name) FROM project WHERE client='" . $gets['id'] . "'";

									$result = mysql_query($sql);
									$row = mysql_fetch_array($result);
									echo $row[0];
						            
?>
</div>
</div></div></div>


</div>

<?
	
}

include('footer.php');

?>