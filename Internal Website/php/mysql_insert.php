<?php
function db_iconnect($dbName)
{
	$un="webuser";
	$pw="yourPassword";
	$db=$dbName;
	$hostname="localhost";
	$dblink=new mysqli($hostname,$un,$pw,$db);
	return $dblink;
}
$dblink=db_iconnect("test");
$fp=fopen("/home/ubuntu/equipment-part2.txt","r");
$count=0;
$time_start=microtime(true); 
while (($row=fgetcsv($fp)) !== FALSE) 
{
	$sql="Insert into `devices` (`device_type`,`manufacturer`,`serial_number`) values ('$row[0]','$row[1]','$row[2]')";
	$dblink->query($sql) or
		die("Something went wrong with $sql<br>\n".$dblink->error);
	$count++;
}
$time_end=microtime(true);
$seconds=$time_end-$time_start;
$execution_time=($seconds)/60;
echo "Execution time: $execution_time minutes or $seconds seconds.\n";
$rowsPerSecond=$count/$seconds;
echo "Insert rate: $rowsPerSecond per second\n";
fclose($fp);
?>