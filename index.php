<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Welcome | Sign in</title>
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

        <div class="form-box" id="login-box">
            <div class="header">Sign In</div>
            <form action="do_login.php" method="post">
                <div class="body bg-gray-login">
                    <div class="form-group">
                        <input type="text" name="username" class="form-control" placeholder="Username"/>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Password"/>
                    </div>          
                    <div class="form-group">
                        <input type="checkbox" name="remember_me"/> Remember me
                    </div>
                </div>
                <div class="footer bg-gray-login">                                                               
                    <button type="submit" class="btn bg-olive btn-block" name="login">Sign me in</button>
                </div>
            </form>
        </div>

        <script src="Scripts/jquery-1.9.1.min.js"></script>
        <script src="js/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

<div class="row">

<div class="col-md-8 col-md-offset-2" style="margin-top:30px;">

<?php 
                           if(isset($_GET['error'])||isset($_GET['logout']))
                           {
                           echo '<div class="alert alert-danger alert-dismissable" style="text-align:center;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
                           if($_GET['error']=="0")
                           echo "Cannot sign you in. Please check your credentials.";
                           elseif($_GET['error']=="1")
                           echo "Cannot sign you in. Please check your credentials.";
                           elseif(isset($_GET['logout']))
                           echo "You have been logged out, please log in again.";
                           echo '</div>';
                           }
?>

</div>
</div>

</body>
</html>