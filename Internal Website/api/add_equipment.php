<?php
if ($did==NULL)//decive id is missing
{
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Invalid or missing device id.';
    $output[]='Action: query_device';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}
if ($mid==NULL)//missing manufacturer id
{
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Invalid or missing manufacturer id.';
    $output[]='Action: query_manufacturer';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}
if ($sn==NULL)//missing serial number
{
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Invalid or missing serial number.';
    $output[]='Action: none';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}

if (serial_check($sn) == true) //serial number exists already
{
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Serial number already exists';
    $output[]='Action: none';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}

if (device_check($did) == false) //device id does not exist
{
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Device not found';
    $output[]='Action: none';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}

if (manufacturer_check($mid) == false) //manufacturer id does not exist
{
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Manufacturer not found';
    $output[]='Action: none';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}

//if manufacturer is not numeric then convert it to auto_id from the manufacturers table
if (!is_numeric($mid)) {
    $dblink=db_connect("equipment");
    $sql= "Select `auto_id` from `manufacturers` where `name`='$mid'";
    $rst=$dblink->query($sql) or
        die("<p>Something went wrong with $sql<br>".$dblink->error);
    $data=$rst->fetch_array(MYSQLI_ASSOC);
    $mid=$data['auto_id'];
}

//if device is not numeric then convert it to auto_id from the devices table
if (!is_numeric($did)) {
    $dblink=db_connect("equipment");
    $sql= "Select `auto_id` from `devices` where `name`='$did'";
    $rst=$dblink->query($sql) or
        die("<p>Something went wrong with $sql<br>".$dblink->error);
    $data=$rst->fetch_array(MYSQLI_ASSOC);
    $did=$data['auto_id'];
}

$dblink = db_connect("equipment");
$sql="Insert into `serials` (`serial_number`, `device_id`, `manufacturer_id`) values ('$sn', '$did', '$mid')";
$dblink->query($sql) or
     die("<p>Something went wrong with $sql<br>".$dblink->error);

header('Content-Type: application/json');
header('HTTP/1.1 200 OK');
$output[]='Status: Success';
$output[]='MSG: Serial added';
$output[]='Action: none';
$responseData=json_encode($output);
echo $responseData;
die();

?>