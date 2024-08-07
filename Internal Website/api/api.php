<?php
include("../functions.php");
/*$url=$_SERVER['REQUEST_URI'];
header('Content-Type: application/json');
header('HTTP/1.1 200 OK');
$output[]='Status: ERROR';
$output[]='MSG: System Disabled';
$output[]='Action: None';
//log_error($_SERVER['REMOTE_ADDR'],"SYSTEM DISABLED","SYSTEM DISABLED: $endPoint",$url,"api.php");*/
$url=$_SERVER['REQUEST_URI'];
$path = parse_url($url, PHP_URL_PATH);
$pathComponents = explode("/", trim($path, "/"));
$endPoint=$pathComponents[1];
switch($endPoint)
{
    case "add_equipment":
        $did=$_REQUEST['did'];
        $mid=$_REQUEST['mid'];
        $sn=$_REQUEST['sn'];
        include("add_equipment.php");
        break;
    case "add_manufacturer":
        $name=$_REQUEST['name'];
        include("add_manufacturer.php");
        break;
    case "add_device":
        $name=$_REQUEST['name'];
        include("add_device.php");
        break;
    case "query_device":
        $did=$_REQUEST['did'];
        $status=$_REQUEST['status'];
        include("query_device.php");
        break;
    case "query_manufacturer":
        $mid=$_REQUEST['mid'];
        $status=$_REQUEST['status'];
        include("query_manufacturer.php");
        break;
    case "query_device_manufacturer":
        $did=$_REQUEST['did'];
        $mid=$_REQUEST['mid'];
        include("query_device_manufacturer.php");
        break;
    case "query_serial":
        $sn=$_REQUEST['sn'];
        include("query_serial.php");
        break;
    case "list_devices":
        $check=$_REQUEST['check'];
        include("list_devices.php");
        break;
    case "list_manufacturers":
        $check=$_REQUEST['check'];
        include("list_manufacturers.php");
        break;
    case "modify_device":
        $did=$_REQUEST['did'];
        $rid=$_REQUEST['rid'];
        $status=$_REQUEST['status'];
        include("modify_device.php");
        break;
    case "modify_manufacturer":
        $mid=$_REQUEST['mid'];
        $rid=$_REQUEST['rid'];
        $status=$_REQUEST['status'];
        include("modify_manufacturer.php");
        break;
    case "modify_serial":
        $sn=$_REQUEST['sn'];
        $rsn=$_REQUEST['rsn'];
        $did=$_REQUEST['did'];
        $mid=$_REQUEST['mid'];
        include("modify_serial.php");
        break;
    default:
        header('Content-Type: application/json');
        header('HTTP/1.1 200 OK');
        $output[]='Status: ERROR';
        $output[]='MSG: Invalid or missing endpoint';
        $output[]='Action: None';
        $responseData=json_encode($output);
        echo $responseData;
        break;
}
die();
?>