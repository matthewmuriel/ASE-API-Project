<?php
if ($name==NULL)//missing name
{
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Invalid or missing name.';
    $output[]='Action: none';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}

//check the length of the name
if (strlen($name) > 24)
{
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Name is too long';
    $output[]='Action: none';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}

//change letters to lowercase
$name=strtolower($name);

if (device_check($name) == true) //device exists already
{
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Device already exists';
    $output[]='Action: none';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}

//add the device to the database

$dblink=db_connect("equipment");
$sql="Insert into `devices` (`name`) values ('$name')";
$dblink->query($sql) or
     die("<p>Something went wrong with $sql<br>".$dblink->error);

header('Content-Type: application/json');
header('HTTP/1.1 200 OK');
$output[]='Status: Success';
$output[]='MSG: Device added';
$output[]='Action: none';
$responseData=json_encode($output);
echo $responseData;
die();

?>