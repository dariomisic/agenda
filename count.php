<?php
if(!isset($included))
include('functions/functions.php');

$posts = array_map("xss_clean",$_POST);
$gets = array_map("xss_clean",$_GET);

if(isset($User_ID))
{
$posts['id']=$User_ID;
}

if(isset($posts['y'])&&isset($posts['w']))
{
$year=$posts['y'];
$week_no=$posts['w'];
}
else
{
$year=date("Y");
$week_no=date("W");
}

    $week_start = new DateTime();
    $week_start->setISODate($year, $week_no);

    $seven_day_week = array('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday','sunday');
    $week = array();

    for ($i = 0; $i < 7; $i++) {
        $day = $seven_day_week[$i];
        $week[$i] = $week_start->format('Y-m-d');
        $week_start->modify('+1 day');
    }
$c=0;
$pp=0;
$ee=0;
$aa=0;
foreach($week as $w)
{
$c++;
if($c%2)
$margin="20";
else
$margin="0";
$sql="SELECT user.fname,user.lname,activity.name,HOUR(event.start),MINUTE(event.start),HOUR(event.end),MINUTE(event.end),allday FROM event INNER JOIN activity ON activity.activity_id=event.activity INNER JOIN user ON activity.employee=user.user_id  WHERE ( DATE(event.end)='".$w."' OR DATE(event.start)='".$w."' ) AND user.user_id='".$posts['id']."'";
		
		$result = mysql_query($sql);
		$pp=$pp+mysql_num_rows($result);		
		
		
		$sql2="SELECT user.fname,user.lname,event.title,HOUR(event.start),MINUTE(event.start),HOUR(event.end),MINUTE(event.end),event.allday FROM event INNER JOIN user ON event.employee=user.user_id WHERE event.activity=0 AND event.place IS NULL AND (DATE(event.end)='".$w."' OR DATE(event.start)='".$w."') AND user.user_id='".$posts['id']."'";

		$result2 = mysql_query($sql2);
		$ee=$ee+mysql_num_rows($result2);

		
	 $sql3="SELECT user.fname,user.lname,event.title,HOUR(event.start),MINUTE(event.start),HOUR(event.end),MINUTE(event.end),event.allday,event.place,event.phone FROM event INNER JOIN user ON event.employee=user.user_id WHERE event.activity=0 AND event.place IS NOT NULL AND (DATE(event.end)='".$w."' OR DATE(event.start)='".$w."') AND user.user_id='".$posts['id']."'";

		$result3 = mysql_query($sql3);
		$aa=$aa+mysql_num_rows($result3);
}

	$sql4 = "SELECT DISTINCT project.project_id,project.name,project.end from project INNER JOIN activity ON project.project_id=activity.project WHERE activity.employee=".$posts['id'];
    
	$result4 = mysql_query($sql4);
	
	$ap=mysql_num_rows($result4);

?>

<!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-red">
                                <div class="inner inner-fix">
                                    <h3>
                                    <?php echo $pp; ?>
                                    </h3>
                                    <p>
                                        Project Event<?php if($pp>1||$pp==0) echo 's'; ?>
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-social-buffer"></i>
                                </div>
                                <div class="pad"></div>
                            </div>
                        </div><!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-aqua">
                                <div class="inner inner-fix">
                                    <h3>
                                        <?php echo $ee; ?>
                                    </h3>
                                    <p>
                                        Free Event<?php if($ee>1||$ee==0) echo 's'; ?>
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-calendar"></i>
                                </div>
                                <div class="pad"></div>
                            </div>
                        </div><!-- ./col -->
                           <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-yellow">
                                <div class="inner inner-fix">
                                    <h3>
                                        <?php echo $aa; ?>
                                    </h3>
                                    <p>
                                        Appointment<?php if($aa>1||$aa=0) echo 's'; ?>
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-clock"></i>
                                </div>
                                <div class="pad"></div>
                            </div>
                        </div><!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-green">
                                <div class="inner inner-fix">
                                    <h3>
                                    <?php echo $ap; ?>
                                    </h3>
                                    <p>
                                        Active Project<?php if($ap>1||$ap==0) echo 's'; ?>
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-ios-pulse-strong"></i>
                                </div>
                                <div class="pad"></div>
                            </div>
                        </div><!-- ./col -->
                    </div><!-- /.row -->