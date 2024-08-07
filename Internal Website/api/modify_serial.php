<?php

    if ($sn == NULL){
        header('Content-Type: application/json');
        header('HTTP/1.1 200 OK');
        $output[]='Status: ERROR';
        $output[]='MSG: Missing Serial Number.';
        $output[]='Action: none';
        $responseData=json_encode($output);
        echo $responseData;
        die();
    }

    if (($rsn==NULL && $did==NULL && $mid==NULL))//missing serial number
    {
        header('Content-Type: application/json');
        header('HTTP/1.1 200 OK');
        $output[]='Status: ERROR';
        $output[]='MSG: Missing Manufacturer ID, Device ID, or Serial Number Modification.';
        $output[]='Action: none';
        $responseData=json_encode($output);
        echo $responseData;
        die();
    }

    //check if $sn is a valid serial number to modify
    if (serial_check($sn) == false)
    {
        header('Content-Type: application/json');
        header('HTTP/1.1 200 OK');
        $output[]='Status: ERROR';
        $output[]='MSG: Serial number not found';
        $output[]='Action: none';
        $responseData=json_encode($output);
        echo $responseData;
        die();
    }

    //check if the length of the new serial number is no more than 70 characters
    if ($rsn != NULL && strlen($rsn) > 70)
    {
        header('Content-Type: application/json');
        header('HTTP/1.1 200 OK');
        $output[]='Status: ERROR';
        $output[]='MSG: Serial number is too long';
        $output[]='Action: none';
        $responseData=json_encode($output);
        echo $responseData;
        die();
    }

    //check if $did is a valid device id to modify
    if ($did != NULL && device_check($did) == false)
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

    //check if $mid is a valid manufacturer id to modify
    if ($mid != NULL && manufacturer_check($mid) == false)
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

    //check if the new serial number already exists
    if ($rsn != NULL && serial_check($rsn) == true)
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

    // if did is not numeric then get the device auto_id from the device table
    if ($did != NULL && !is_numeric($did))
    {
        $dblink=db_connect("equipment");
        $sql="Select `auto_id` from `devices` where `name`='$did'";
        $result=$dblink->query($sql) or
            die("<p>Something went wrong with $sql<br>".$dblink->error);
        $row=$result->fetch_assoc();
        $did=$row['auto_id'];
    }

    // if mid is not numeric then get the manufacturer auto_id from the manufacturer table
    if ($mid != NULL && !is_numeric($mid))
    {
        $dblink=db_connect("equipment");
        $sql="Select `auto_id` from `manufacturers` where `name`='$mid'";
        $result=$dblink->query($sql) or
            die("<p>Something went wrong with $sql<br>".$dblink->error);
        $row=$result->fetch_assoc();
        $mid=$row['auto_id'];
    }

    //if both the new serial number, device id, and manufacturer id are not null, then update the serial number, device id, and manufacturer id
    if ($rsn != NULL && $did != NULL && $mid != NULL)
    {
        $dblink = db_connect("equipment");
        $sql="UPDATE `serials` SET `serial_number`='$rsn', `device_id`='$did', `manufacturer_id`='$mid' WHERE `serial_number`='$sn'";
        $result=$dblink->query($sql) or
            die("<p>Something went wrong with $sql<br>".$dblink->error);

        header('Content-Type: application/json');
        header('HTTP/1.1 200 OK');
        $output[]='Status: Success';
        $output[]='MSG: Serial number, device id, and manufacturer id updated';
        $output[]='Action: none';
        $responseData=json_encode($output);
        echo $responseData;
        die();
    }

    //if only the new serial number and device id are not null, then update the serial number and device id
    if ($rsn != NULL && $did != NULL)
    {
        $dblink = db_connect("equipment");
        $sql="UPDATE `serials` SET `serial_number`='$rsn', `device_id`='$did' WHERE `serial_number`='$sn'";
        $result=$dblink->query($sql) or
            die("<p>Something went wrong with $sql<br>".$dblink->error);

        header('Content-Type: application/json');
        header('HTTP/1.1 200 OK');
        $output[]='Status: Success';
        $output[]='MSG: Serial number and device id updated';
        $output[]='Action: none';
        $responseData=json_encode($output);
        echo $responseData;
        die();
    }

    //if only the new serial number and manufacturer id are not null, then update the serial number and manufacturer id

    if ($rsn != NULL && $mid != NULL)
    {
        $dblink = db_connect("equipment");
        $sql="UPDATE `serials` SET `serial_number`='$rsn', `manufacturer_id`='$mid' WHERE `serial_number`='$sn'";
        $result=$dblink->query($sql) or
            die("<p>Something went wrong with $sql<br>".$dblink->error);

        header('Content-Type: application/json');
        header('HTTP/1.1 200 OK');
        $output[]='Status: Success';
        $output[]='MSG: Serial number and manufacturer id updated';
        $output[]='Action: none';
        $responseData=json_encode($output);
        echo $responseData;
        die();
    }

    //if only the device id and manufacturer id are not null, then update the device id and manufacturer id

    if ($did != NULL && $mid != NULL)
    {
        $dblink = db_connect("equipment");
        $sql="UPDATE `serials` SET `device_id`='$did', `manufacturer_id`='$mid' WHERE `serial_number`='$sn'";
        $result=$dblink->query($sql) or
            die("<p>Something went wrong with $sql<br>".$dblink->error);

        header('Content-Type: application/json');
        header('HTTP/1.1 200 OK');
        $output[]='Status: Success';
        $output[]='MSG: Device id and manufacturer id updated';
        $output[]='Action: none';
        $responseData=json_encode($output);
        echo $responseData;
        die();
    }

    //if only the new serial number is not null, then update the serial number
    if ($rsn != NULL)
    {
        $dblink = db_connect("equipment");
        $sql="UPDATE `serials` SET `serial_number`='$rsn' WHERE `serial_number`='$sn'";
        $result=$dblink->query($sql) or
            die("<p>Something went wrong with $sql<br>".$dblink->error);

        header('Content-Type: application/json');
        header('HTTP/1.1 200 OK');
        $output[]='Status: Success';
        $output[]='MSG: Serial number updated';
        $output[]='Action: none';
        $responseData=json_encode($output);
        echo $responseData;
        die();
    }

    //if only the device id is not null, then update the device id
    if ($did != NULL)
    {
        $dblink = db_connect("equipment");
        $sql="UPDATE `serials` SET `device_id`='$did' WHERE `serial_number`='$sn'";
        $result=$dblink->query($sql) or
            die("<p>Something went wrong with $sql<br>".$dblink->error);

        header('Content-Type: application/json');
        header('HTTP/1.1 200 OK');
        $output[]='Status: Success';
        $output[]='MSG: Device id updated';
        $output[]='Action: none';
        $responseData=json_encode($output);
        echo $responseData;
        die();
    }

    //if only the manufacturer id is not null, then update the manufacturer id
    if ($mid != NULL)
    {
        $dblink = db_connect("equipment");
        $sql="UPDATE `serials` SET `manufacturer_id`='$mid' WHERE `serial_number`='$sn'";
        $result=$dblink->query($sql) or
            die("<p>Something went wrong with $sql<br>".$dblink->error);

        header('Content-Type: application/json');
        header('HTTP/1.1 200 OK');
        $output[]='Status: Success';
        $output[]='MSG: Manufacturer id updated';
        $output[]='Action: none';
        $responseData=json_encode($output);
        echo $responseData;
        die();
    }


?>