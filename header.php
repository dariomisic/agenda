<?php

session_start(); 

	$FullName="";
	$First="";
	$Function="";
	$Username="";
	$Sex="m";
	$Level=3;
	$User_ID=1;

	if(isset($_SESSION['username'])) {
    if(!$included)	
	include('functions/functions.php');

	$posts = array_map("xss_clean",$posts);
	$gets = array_map("xss_clean",$gets);
    
    $sql = "SELECT user.fname,user.lname,function.name,user.username,user.sex,user.user_level,user.user_id,user.layout,user.skin,user.avatar FROM user INNER JOIN function ON user.function=function.function_id WHERE user.username='" . $_SESSION['username'] . "'";

	$result = mysql_query($sql);
	 
	$rowCheck = mysql_num_rows($result); 
	
	if($rowCheck > 0) {
	$row = mysql_fetch_array($result);
	$FullName=$row[0]." ".$row[1];
	$First=$row[0];
	$Function=$row[2];
	$Username=$row[3];
	$Level=$row[5];
	$User_ID=$row[6];
    $Layout=$row[7];
    $Skin=$row[8];
    $Avatar=$row[9];
	if($row[4]=="M")
	$Sex="m";
	else
	$Sex="f";
    }
}


    $sql_u = "SELECT user_id FROM user";

	$result_u = mysql_query($sql_u);
	 
	$n_user=mysql_num_rows($result_u);
	
	$sql_p = "SELECT project_id FROM project";

	$result_p = mysql_query($sql_p);
	 
	$n_project=mysql_num_rows($result_p);
	
	$sql_c = "SELECT client_id FROM client";

	$result_c = mysql_query($sql_c);
	 
	$n_client=mysql_num_rows($result_c);



$page = basename($_SERVER['PHP_SELF']);


$menu = array('','','','','','');

switch ($page) {
case 'user.php':
$menu[1]='active';
$t='Users';
break;
case 'list_user.php':
$menu[1]='active';
$t='Users';
break;
case 'client.php':
$menu[2]='active';
$t='Clients';
break;
case 'list_client.php':
$menu[2]='active';
$t='Clients';
break;
case 'project.php':
$menu[3]='active';
$t='Projects';
break;
case 'list_project.php':
$menu[3]='active';
$t='Projects';
break;
case 'list_activity.php':
$menu[3]='active';
$t='Projects';
break;
case 'a.php':
$menu[4]='active';
$t='Appointments';
break;
case 'profile.php':
$menu[5]='active';
$t='Settings';
break;
case 'taxonomy.php':
$menu[5]='active';
$t='Settings';
break;
default:
$menu[0]='active';
$t='Dashboard';
break;
}



switch ($page) {
    case "profile.php":
    $title='Profile';
    $sub='Customize the look of your profile.';
    $breadcrumb='<li><a href="dashboard.php"><i class="fa fa-th-large"></i> Home</a></li><li class="active">Profile</li>';
        break;
    case "taxonomy.php":
    $title='Taxonomy';
    $sub='Add or edit basic categories.';
    $breadcrumb='<li><a href="dashboard.php"><i class="fa fa-th-large"></i> Home</a></li><li class="active">Taxonomy</li>';
        break;
    case "user.php":
    $title='Users';
    $sub='Manage existing clients or add new ones.';
    $breadcrumb='<li><a href="dashboard.php"><i class="fa fa-th-large"></i> Home</a></li><li class="active">Users</li>';
        break;
    case "a.php":
    $title='Appointments';
    $sub='Manage apointments or add a new one.';
    $breadcrumb='<li><a href="dashboard.php"><i class="fa fa-th-large"></i> Home</a></li><li class="active">Appointments</li>';
        break;
    case "appointment.php":
    $title='Appointment';
    $sub='Add a new appointment.';
    $breadcrumb='<li><a href="dashboard.php"><i class="fa fa-th-large"></i> Home</a></li><li class="active">Appointment</li>';
        break;
    case "employee_projects.php":
    $title='Project listing';
    $sub='Information about the project including statistics.';
    $breadcrumb='<li><a href="dashboard.php"><i class="fa fa-th-large"></i> Home</a></li><li class="active">Project view</li>';
        break;
    case "client.php":
    $title='Clients';
    $sub='Manage existing clients or add new ones.';
    $breadcrumb='<li><a href="dashboard.php"><i class="fa fa-th-large"></i> Home</a></li><li class="active">Clients</li>';
        break;
    case "project.php":
    $title='Projects';
    $sub='Manage existing projects or add new ones.';
    $breadcrumb='<li><a href="dashboard.php"><i class="fa fa-th-large"></i> Home</a></li><li class="active">Projects</li>';
        break;
    case "list_user.php":

    $sql_user = "SELECT fname,lname FROM user WHERE user_id=".$gets['id'];

    $result_user = mysql_query($sql_user);

    $row=mysql_fetch_array($result_user);

    $title='User Panel';
    $sub='View specific user info and statistics.';
    $breadcrumb='<li><a href="dashboard.php"><i class="fa fa-th-large"></i> Home</a></li><li><a href="user.php"><i class="fa fa-users"></i> Users</a></li><li class="active">'.$row[0].' '.$row[1].'</li>';
        break;
    case "list_client.php":

    $sql_user = "SELECT name FROM client WHERE client_id=".$gets['id'];

    $result_user = mysql_query($sql_user);

    $row=mysql_fetch_array($result_user);

    $title='Client Panel';
    $sub='View specific client info and statistics.';
    $breadcrumb='<li><a href="dashboard.php"><i class="fa fa-th-large"></i> Home</a></li><li><a href="client.php"><i class="fa fa-suitcase"></i> Clients</a></li><li class="active">'.$row[0].'</li>';
        break;
    case "list_project.php":

    $sql_user = "SELECT client.name,client.client_id,project.name FROM project INNER JOIN client ON client.client_id=project.client WHERE project.project_id=".$gets['id'];

    $result_user = mysql_query($sql_user);

    $row=mysql_fetch_array($result_user);

    $title='Project Panel';
    $sub='View specific project info and statistics.';
    $breadcrumb='<li><a href="dashboard.php"><i class="fa fa-th-large"></i> Home</a></li><li><a href="client.php"><i class="fa fa-suitcase"></i> Clients</a></li><li><a href="list_client.php?id='.$row[1].'">'.$row[0].'</a></li><li><a href="project.php"><i class="fa fa-folder-open"></i> Projects</a></li><li class="active">'.$row[2].'</li>';
        break;
    case "list_activity.php":

    $sql_user = "SELECT client.name,client.client_id,project.name,project.project_id,activity.name FROM activity INNER JOIN project on project.project_id=activity.project INNER JOIN client ON client.client_id=project.client WHERE activity.activity_id=".$gets['id'];

    $result_user = mysql_query($sql_user);

    $row=mysql_fetch_array($result_user);

    $title='Activity Panel';
    $sub='View specific activity info and manage associated files.';
    $breadcrumb='<li><a href="dashboard.php"><i class="fa fa-th-large"></i> Home</a></li><li><a href="client.php"><i class="fa fa-suitcase"></i> Clients</a></li><li><a href="list_client.php?id='.$row[1].'">'.$row[0].'</a></li><li><a href="project.php"><i class="fa fa-folder-open"></i> Projects</a></li><li><a href="list_project.php?id='.$row[3].'">'.$row[2].'</a></li><li class="active">'.$row[4].'</li>';
        break;
    default:
    $title='Dashboard';
    $sub='View status infomation and agenda in one place.';
    $breadcrumb='<li><a href="dashboard.php"><i class="fa fa-th-large"></i> Home</a></li>';
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $website_title; ?> | <?php echo $t; ?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="js/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="lib/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="lib/ion/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        
        <!-- Morris chart -->
        <link href="css/morris/morris.css" rel="stylesheet" type="text/css" />
        <!-- jvectormap -->
        <link href="css/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
        <!-- Date Picker -->
        <link href="css/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
        <!-- Daterange picker -->
        <link href="css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
        <!-- bootstrap wysihtml5 - text editor -->
        <link href="css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <link href="css/multi-select/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
        
        <link href="js/plugins/icon-picker/themes/bootstrap-theme/jquery.fonticonpicker.bootstrap.min.css" rel="stylesheet" type="text/css" />

        <link href="js/plugins/icon-picker/css/jquery.fonticonpicker.min.css" rel="stylesheet" type="text/css" />

        <link href="css/multi-select/validationEngine.jquery.css" rel="stylesheet" type="text/css" />

        <link href="icomoon/style.css" rel="stylesheet" type="text/css" />


        <link href="lib/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css" />
        <link href="lib/fullcalendar/fullcalendar.print.css" rel="stylesheet" type="text/css" media='print' />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
<?php

if($Skin=='dark')
{

?>
        <style>
        .pace-progress {

            background-color:#bbb !important;

        }
        </style>
<?php

}

?>
    </head>
    <body class="<?php if($Skin=='light') echo 'skin-blue'; else echo 'skin-black'; if($Layout=='fixed') echo 'fixed'; ?>">
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="dashboard.php" class="logo">
                <?php echo $website_title; ?>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                    <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php echo strtoupper($Username); ?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                    <div class="img-circle" style="background:#fff; width:85px; height:85px; margin: 0 auto;"><i class="<?php echo $Avatar; ?>" style="color:#ccc; line-height:85px; font-size:65px;"></i></div>
                                    <p>
                                        <?php echo $FullName; ?>
                                        <small><?php echo $Function; ?></small>
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="profile.php" class="btn btn-default btn-flat">Profile settings</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="logout.php" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <div class="img-circle" style="<?php if($Skin=='black') echo 'background:#fff;'; else echo 'background:#bbb;'; ?> width:50px; height:50px; text-align:center;"><i class="<?php echo $Avatar; ?>" style="<?php if($Skin=='dark') echo 'color:#404040;'; else echo 'color:#f4f4f4;'; ?> line-height:50px; font-size:35px;"></i></div>
                        </div>
                        <div class="pull-left info">
                            <p style="margin-top:10px;">Hello, <?php echo $First; ?></p>
                        </div>
                    </div>
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li class="<?php echo $menu[0]; ?>">
                            <a href="dashboard.php">
                                <i class="fa fa-th-large"></i> <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="<?php echo $menu[1]; ?>">
                            <a href="user.php">
                                <i class="fa fa-users"></i> <span>Users</span> <small class="badge pull-right"><?php echo $n_user; ?></small>
                            </a>
                        </li>
                        <li  class="<?php echo $menu[2]; ?>">
                            <a href="client.php">
                                <i class="fa fa-suitcase"></i> <span>Clients</span> <small class="badge pull-right"><?php echo $n_client; ?></small>
                            </a>
                        </li>
                        <li class="<?php echo $menu[3]; ?>">
                            <a href="project.php">
                                <i class="fa fa-folder-open"></i> <span>Projects</span> <small class="badge pull-right"><?php echo $n_project; ?></small>
                            </a>
                        </li>

<?php

if($Level<3)
{

                        echo '<li  class="'.$menu[4].'">
                            <a href="a.php">
                                <i class="fa fa-clock-o"></i> <span>Appointments</span>
                            </a>
                        </li>';

}

?>

                        <li class="treeview <?php echo $menu[5]; ?>">
                            <a href="#">
                                <i class="fa fa-cog"></i>
                                <span>Settings</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="profile.php"><i class="fa fa-angle-double-right"></i> Profile</a></li>
                                <li><a href="taxonomy.php"><i class="fa fa-angle-double-right"></i> Taxonomy</a></li>
                            </ul>
                        </li>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>
            
            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                    <?php echo $title; ?>
                        <small><?php echo $sub; ?></small>
                    </h1>
                    <ol class="breadcrumb">
                    <?php echo $breadcrumb; ?>
                    </ol>
                </section>