<?php
include("functions.php");
$dblink=db_connect("test");
$sql="Select * from `devices`";
$result=$dblink->query($sql) or
	die("Something went wrong with $sql<br>".$dblink->error);
if ($result->num_rows<=0)
	echo "<p>There are no rows in the table devices!</p>";
else
{
	while($data=$result->fetch_array(MYSQLI_ASSOC))
	{
		echo '<p>Device Type: '.$data['device_type'].' Manufacturer: '.$data['manufacturer'].' Serial Number: '.$data['serial_number'].'</p>';
	}
}
?>