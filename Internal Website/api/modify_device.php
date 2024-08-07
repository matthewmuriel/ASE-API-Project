<?php
    
    if($did==NULL)//decive id is missing
    {
        header('Content-Type: application/json');
        header('HTTP/1.1 200 OK');
        $output[]='Status: ERROR';
        $output[]='MSG: Missing device id.';
        $output[]='Action: query_device';
        $responseData=json_encode($output);
        echo $responseData;
        die();
    }
    
    if (($rid==NULL && $status==NULL))//missing device id
    {
        header('Content-Type: application/json');
        header('HTTP/1.1 200 OK');
        $output[]='Status: ERROR';
        $output[]='MSG: Missing Device ID or Status Modification.';
        $output[]='Action: query_device';
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


    //check if the length of the device name is no more than 32 characters
    if (strlen($rid) > 32)
    {
        header('Content-Type: application/json');
        header('HTTP/1.1 200 OK');
        $output[]='Status: ERROR';
        $output[]='MSG: Device name is too long';
        $output[]='Action: none';
        $responseData=json_encode($output);
        echo $responseData;
        die();
    }
    //check if status is either active or inactive if it is not null
    if ($status != NULL && $status != 'active' && $status != 'inactive')
    {
        header('Content-Type: application/json');
        header('HTTP/1.1 200 OK');
        $output[]='Status: ERROR';
        $output[]='MSG: Invalid Status';
        $output[]='Action: none';
        $responseData=json_encode($output);
        echo $responseData;
        die();
    }

    //if did is numeric then get the device name from the device table
    if (is_numeric($did)){
        $dblink = db_connect("equipment");
        $sql="SELECT * From `devices` where `auto_id`='$did'";
        $result=$dblink->query($sql) or
            die("<p>Something went wrong with $sql<br>".$dblink->error);
        $row=$result->fetch_assoc();
        $did=$row['name'];
    }

    //if both the device name and status are not null, then update the device name and status
    if ($rid != NULL && $status != NULL){
        $rid = strtolower($rid);
        $dblink = db_connect("equipment");
        //check if the device name already exists
        $sql="SELECT * From `devices` where `name`='$rid'";
        $result=$dblink->query($sql) or
            die("<p>Something went wrong with $sql<br>".$dblink->error);

        if ($result->num_rows > 0){
            header('Content-Type: application/json');
            header('HTTP/1.1 200 OK');
            $output[]='Status: ERROR';
            $output[]='MSG: Name already exists';
            $output[]='Action: none';
            $responseData=json_encode($output);
            echo $responseData;
            die();
        }

        //update the device name and status
        $sql="UPDATE `devices` SET `name`='$rid', `status`='$status' where `name`='$did'";
        $result=$dblink->query($sql) or
            die("<p>Something went wrong with $sql<br>".$dblink->error);

        header('Content-Type: application/json');
        header('HTTP/1.1 200 OK');
        $output[]='Status: Success';
        $output[]='MSG: Name and status updated';
        $output[]='Action: none';
        $responseData=json_encode($output);
        echo $responseData;
        die();
    }
    //if only the device name is not null, then update the device name
    if ($rid != NULL){
        $rid = strtolower($rid);
        $dblink = db_connect("equipment");
        //check if the device name already exists
        $sql="SELECT * From `devices` where `name`='$rid'";
        $result=$dblink->query($sql) or
            die("<p>Something went wrong with $sql<br>".$dblink->error);

        if ($result->num_rows > 0){
            header('Content-Type: application/json');
            header('HTTP/1.1 200 OK');
            $output[]='Status: ERROR';
            $output[]='MSG: Name already exists';
            $output[]='Action: none';
            $responseData=json_encode($output);
            echo $responseData;
            die();
        }

        //update the device name
        $sql="UPDATE `devices` SET `name`='$rid' where `name`='$did'";
        $result=$dblink->query($sql) or
            die("<p>Something went wrong with $sql<br>".$dblink->error);

        header('Content-Type: application/json');
        header('HTTP/1.1 200 OK');
        $output[]='Status: Success';
        $output[]='MSG: Name updated';
        $output[]='Action: none';
        $responseData=json_encode($output);
        echo $responseData;
        die();
    }
    //if only the status is not null, then update the device status
    if ($status != NULL){
        $dblink = db_connect("equipment");
        //update the device status
        $sql="UPDATE `devices` SET `status`='$status' where `name`='$did'";
        $result=$dblink->query($sql) or
            die("<p>Something went wrong with $sql<br>".$dblink->error);

        header('Content-Type: application/json');
        header('HTTP/1.1 200 OK');
        $output[]='Status: Success';
        $output[]='MSG: Status updated';
        $output[]='Action: none';
        $responseData=json_encode($output);
        echo $responseData;
        die();
    }
?>