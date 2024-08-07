<?php
include("functions.php");
$dblink=db_connect("test");
echo "Hello from php process $argv[1] about to process file:$argv[2]\n";
$fp=fopen("/home/ubuntu/parts/$argv[2]","r");
$count=0;
$time_start=microtime(true); 
echo "PHP ID:$argv[1]-Start time is: $time_start\n";
while (($row=fgetcsv($fp)) !== FALSE) 
{
	$sql="Insert into `devices` (`device_type`,`manufacturer`,`serial_number`) values ('$row[0]','$row[1]','$row[2]')";
	$dblink->query($sql) or
		die("Something went wrong with $sql<br>\n".$dblink->error);
	$count++;
}
$time_end=microtime(true);
echo "PHP ID:$argv[1]-End Time:$time_end\n";
$seconds=$time_end-$time_start;
$execution_time=($seconds)/60;
echo "PHP ID:$argv[1]-Execution time: $execution_time minutes or $seconds seconds.\n";
$rowsPerSecond=$count/$seconds;
echo "PHP ID:$argv[1]-Insert rate: $rowsPerSecond per second\n";
fclose($fp);
?>