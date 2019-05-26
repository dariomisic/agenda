<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Welcome | Setup</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="js/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="lib/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
<script>

function validateForm3() {
    var x1 = document.forms["setup"]["login_u"].value;
    var x2 = document.forms["setup"]["login_e"].value;
    var x3 = document.forms["setup"]["login_p"].value;
    
    if (x1 == null || x1 == "" || x2 == null || x2 == "" || x3 == null || x3 == "") {
        alert("You must enter all fields.");
        return false;
    }
    
    var atpos = x2.indexOf("@");
    var dotpos = x2.lastIndexOf(".");
    if (atpos< 1 || dotpos<atpos+2 || dotpos+2>=x2.length) {
        alert("Not a valid e-mail address");
        return false;
    }
}

function validateForm() {
    var x1 = document.forms["setup"]["server"].value;
    var x2 = document.forms["setup"]["username"].value;
    var x3 = document.forms["setup"]["password"].value;
    var x4 = document.forms["setup"]["database"].value;
    if (x1 == null || x1 == "" || x2 == null || x2 == "" || x3 == null || x3 == "" || x4 == null || x4 == "") {
        alert("You must enter all fields.");
        return false;
    }
}

</script>

<?php

if(isset($_POST['username']))
{

$s=$_SERVER['PHP_SELF'];

if (!mysql_connect($_POST['server'], $_POST['username'], $_POST['password'])||!mysql_select_db($_POST['database'])) {
  echo 'Cant connect to database.<br><br>Check the database parameters and <a href="'.$s.'">try again</a>.';
}
else
{
$templine = '';
$lines = file('setup/kubed.sql');
foreach ($lines as $line)
{
if (substr($line, 0, 2) == '--' || $line == '')
    continue;
$templine .= $line;
if (substr(trim($line), -1, 1) == ';')
{
    mysql_query($templine) or print('');
    $templine = '';
}
}


if(file_exists('functions/config.php'))
{
rename('functions/config.php','functions/config-backup.php');
}

$c='<?php define("SITE_PATH", "'.$_POST['address'].'");';
$c.=' $server="'.$_POST['server'].'";';
$c.=' $database="'.$_POST['database'].'";';
$c.=' $website_title="'.$_POST['title'].'";';
$c.=' $user="'.$_POST['username'].'";';
$c.=' $pass="'.$_POST['password'].'"; ?>';

file_put_contents('functions/config.php',$c);

?>
        <div class="form-box" id="login-box">
            <div class="header">Setup - Last step</div>
            <form action="<?php echo $_SERVER['PHP_SELF']."?server=".$_POST['server']."&username=".$_POST['username']."&password=".$_POST['password']."&database=".$_POST['database']; ?>" name="setup" onsubmit="return validateForm3()" method="post">
                <div class="body bg-gray-login">
                    <div class="form-group">
                        <input type="text" name="login_u" class="form-control" placeholder="Login Username"/>
                    </div>
                    <div class="form-group">
                        <input type="text" name="login_p" class="form-control" placeholder="Login Password"/>
                    </div>
                    <div class="form-group">
                        <input type="text" name="login_e" class="form-control" placeholder="Admin E-mail"/>
                    </div>            
                </div>
                <div class="footer bg-gray-login">                                                               
                    <button type="submit" class="btn bg-olive btn-block" name="finish">Finish</button>
                </div>
            </form>
        </div>    
         
<?php 

}
}
else if(isset($_POST['login_u']))
{

if (!mysql_connect($_GET['server'], $_GET['username'], $_GET['password'])||!mysql_select_db($_GET['database'])) {
  echo 'Cant connect to database.<br><br>Check the database parameters and <a href="'.$s.'">try again</a>.';
}
else
{

$sql='INSERT INTO user (user_level, user_active, username, fname, lname, email, password, timestamp, sex, birthdate, address, zip, residence, hphone, mphone, function, department, d_employment, d_service, hour_wage, tarrif, min_hours, city) VALUES ("1", "1", "'.$_POST['login_u'].'", "First", "Last", "'.$_POST['login_e'].'", "'.md5($_POST['login_p']).'", CURRENT_TIMESTAMP, "M", NOW(), "Default Address", "00000", "Default Residence", "00000", "00000", "1", "1", NOW(), NOW(), "0", "1", "0", "1");';

$r=mysql_query($sql);

$i=1;


for($b=1;$b<6;$b++)
{
mysql_query('INSERT INTO working (user, workday) VALUES ("'.$i.'", "'.$b.'");');
}

if(file_exists('index.php'))
rename('index.php','setup.php');

copy('main.php','index.php');

?>                   
    
<div class="row">

<div class="col-md-8 col-md-offset-2" style="margin-top:30px;">

    <div class="alert alert-success alert-dismissable body" style="text-align:center;">
                                        <i class="fa fa-lock"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        Script Installed, please <a href="main.php">login here</a> with your credentials.
    </div>
    
</div>

</div>    

<?php

}

}
else
{
?>      

<div class="form-box" id="login-box">
            <div class="header">Setup</div>
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" name="setup" onsubmit="return validateForm()" >
                <div class="body bg-gray-login">
                    <div class="form-group">
                        <input type="text" name="server" class="form-control" placeholder="MySQL server address"/>
                    </div>
                    <div class="form-group">
                        <input type="text" name="username" class="form-control" placeholder="MySQL server username"/>
                    </div>
                    <div class="form-group">
                        <input type="text" name="password" class="form-control" placeholder="MySQL server password"/>
                    </div>    
                    <div class="form-group">
                        <input type="text" name="database" class="form-control" placeholder="Database name"/>
                    </div>  
                    <div class="form-group">
                        <input type="text" name="address" class="form-control" placeholder="Website address"/>
                    </div> 
                    <div class="form-group">
                        <input type="text" name="title" class="form-control" placeholder="Website title"/>
                    </div>          
                </div>
                <div class="footer bg-gray-login">                                                               
                    <button type="submit" class="btn bg-olive btn-block" name="next">Next</button>
                </div>
            </form>
        </div>

<?php


}

?>           

<script src="Scripts/jquery-1.9.1.min.js"></script>
<script src="js/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>





</body>
</html>