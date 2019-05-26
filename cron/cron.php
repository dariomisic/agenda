<?php     

     function week_shift()
     {
     $now = time();
     $your_date = strtotime("2014-11-17");
     $datediff = $now - $your_date;
     $days=floor($datediff/(60*60*24));
     return floor($days/7);
     }

if($_REQUEST['name']=="mirza")
{
     
include('../functions/functions.php');
     
if (!mysql_connect($server,$user,$pass)||!mysql_select_db($database)) {
echo 'Cant connect to database.<br><br>Check the database parameters and <a href="'.$s.'">try again</a>.';
}
else
{
$templine = '';
$lines = file('cron.sql');
foreach ($lines as $line)
{
if (substr($line, 0, 2) == '--' || $line == '')
    continue;
$templine .= $line;
if (substr(trim($line), -1, 1) == ';')
{
    mysql_query($templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
    $templine = '';
}
}

$sql1='UPDATE event SET start = DATE_ADD(start, INTERVAL '.week_shift().' WEEK);';
$sql2='UPDATE event SET end = DATE_ADD(end, INTERVAL '.week_shift().' WEEK);';
mysql_query($sql1);
mysql_query($sql2);

echo "success:".week_shift();
}

}


?>