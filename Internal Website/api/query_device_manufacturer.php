<?php

    if ($did==NULL)
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
    if ($mid==NULL)
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

    //check if $did is a valid device id
    if (device_check($did) == false)
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

    //check if $mid is a valid manufacturer id
    if (manufacturer_check($mid) == false)
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

    //if did or mid are not numeric, then convert then search the table for the device id and manufacturer id
    if (!is_numeric($did) || !is_numeric($mid))
    {
        $dblink=db_connect("equipment");
        if (!is_numeric($did))
        {
            $sql= "Select `auto_id` from `devices` where `device_id`='$did'";
            $rst=$dblink->query($sql) or
                die("<p>Something went wrong with $sql<br>".$dblink->error);
            $data=$rst->fetch_array(MYSQLI_ASSOC);
            $did=$data['auto_id'];
        }
        if (!is_numeric($mid))
        {
            $sql= "Select `auto_id` from `manufacturers` where `name`='$mid'";
            $rst=$dblink->query($sql) or
                die("<p>Something went wrong with $sql<br>".$dblink->error);
            $data=$rst->fetch_array(MYSQLI_ASSOC);
            $mid=$data['auto_id'];
        }
    }

    $dblink=db_connect("equipment");
    $sql="Select * from `serials` where `device_id`='$did' and `manufacturer_id`='$mid' limit 1";

    $result=$dblink->query($sql) or
        die("<p>Something went wrong with $sql<br>".$dblink->error);

    if ($result->num_rows == 0)
    {
        header('Content-Type: application/json');
        header('HTTP/1.1 200 OK');
        $output[]='Status: ERROR';
        $output[]='MSG: No entries found.';
        $output[]='Action: none';
        $responseData=json_encode($output);
        echo $responseData;
        die();
    }else{
        $sql="Select * from `serials` where `device_id`='$did' and `manufacturer_id`='$mid' limit 1000";
        $result=$dblink->query($sql) or
            die("<p>Something went wrong with $sql<br>".$dblink->error);
        $serials=array();

        while ($data=$result->fetch_array(MYSQLI_ASSOC))
            $serials[$data['auto_id']]=$data;

        header('Content-Type: application/json');
        header('HTTP/1.1 200 OK');
        $output[]='Status: Success';
        $jsonDevices=json_encode($serials);
        $output[]='MSG: '.$jsonDevices;
        $output[]='Action: none';
        $responseData=json_encode($output);
        echo $responseData;
        die();
    }

?>