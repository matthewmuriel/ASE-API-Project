<?php

    if ($mid==NULL)
    {
        header('Content-Type: application/json');
        header('HTTP/1.1 200 OK');
        $output[]='Status: ERROR';
        $output[]='MSG: Missing Manufacturer ID.';
        $output[]='Action: query_manufacturer';
        $responseData=json_encode($output);
        echo $responseData;
        die();
    }

    if (($rid==NULL && $status==NULL))//missing manufacturer id
    {
        header('Content-Type: application/json');
        header('HTTP/1.1 200 OK');
        $output[]='Status: ERROR';
        $output[]='MSG: Missing Manufacturer ID or Status Modification.';
        $output[]='Action: query_manufacturer';
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

    //check if the length of the manufacturer name is no more than 32 characters
    if ($rid != NULL && strlen($rid) > 32)
    {
        header('Content-Type: application/json');
        header('HTTP/1.1 200 OK');
        $output[]='Status: ERROR';
        $output[]='MSG: Manufacturer name is too long';
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

    //if mid is numeric then get the manufacturer name from the manufacturer table
    if (is_numeric($mid)){
        $dblink = db_connect("equipment");
        $sql="SELECT * From `manufacturers` where `auto_id`='$mid'";
        $result=$dblink->query($sql) or
            die("<p>Something went wrong with $sql<br>".$dblink->error);
        $row=$result->fetch_assoc();
        $mid=$row['name'];
    }

    //if both the manufacturer name and status are not null, then update the manufacturer name and status
    if ($rid != NULL && $status != NULL){
        $rid = ucfirst($rid);
        $dblink = db_connect("equipment");
        //check if the manufacturer name already exists
        $sql="SELECT * From `manufacturers` where `name`='$rid'";
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

        //update the manufacturer name and status
        $sql="UPDATE `manufacturers` SET `name`='$rid', `status`='$status' where `name`='$mid'";
        $result=$dblink->query($sql) or
            die("<p>Something went wrong with $sql<br>".$dblink->error);
        
        //return success message if the manufacturer name and status are updated
        if ($dblink->affected_rows > 0){
            header('Content-Type: application/json');
            header('HTTP/1.1 200 OK');
            $output[]='Status: Success';
            $output[]='MSG: Name and status updated';
            $output[]='Action: none';
            $responseData=json_encode($output);
            echo $responseData;
            die();
        }else {
            //return error message if the manufacturer name and status are not updated
            header('Content-Type: application/json');
            header('HTTP/1.1 200 OK');
            $output[]='Status: ERROR';
            $output[]='MSG: Manufacturer name and status not updated';
            $output[]='Action: none';
            $responseData=json_encode($output);
            echo $responseData;
            die();
        }

    }

    //if the manufacturer id is not null, then update the manufacturer
    if ($rid != NULL){
        $rid = ucfirst($rid);
        $dblink = db_connect("equipment");
        $sql="SELECT * From `manufacturers` where `name`='$rid'";
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

        //update the manufacturer name
        $sql="UPDATE `manufacturers` SET `name`='$rid' where `name`='$mid'";
        $result=$dblink->query($sql) or
            die("<p>Something went wrong with $sql<br>".$dblink->error);

        //return success message if the manufacturer name is updated
        if ($dblink->affected_rows > 0){
            header('Content-Type: application/json');
            header('HTTP/1.1 200 OK');
            $output[]='Status: Success';
            $output[]='MSG: Name updated';
            $output[]='Action: none';
            $responseData=json_encode($output);
            echo $responseData;
            die();
        }else {
            //return error message if the manufacturer name is not updated
            header('Content-Type: application/json');
            header('HTTP/1.1 200 OK');
            $output[]='Status: ERROR';
            $output[]='MSG: Manufacturer name not updated';
            $output[]='Action: none';
            $responseData=json_encode($output);
            echo $responseData;
            die();
        }
    }

    //if the status is not null, then update the manufacturer status
    if ($status != NULL){
        $dblink = db_connect("equipment");
        //update the status of the manufacturer
        $sql="UPDATE `manufacturers` SET `status`='$status' where `name`='$mid'";
        $result=$dblink->query($sql) or
            die("<p>Something went wrong with $sql<br>".$dblink->error);
        
        //return success message if the status is updated
        if ($dblink->affected_rows > 0){
            header('Content-Type: application/json');
            header('HTTP/1.1 200 OK');
            $output[]='Status: Success';
            $output[]='MSG: Status updated';
            $output[]='Action: none';
            $responseData=json_encode($output);
            echo $responseData;
            die();
        }else {
            //return error message if the status is not updated
            header('Content-Type: application/json');
            header('HTTP/1.1 200 OK');
            $output[]='Status: ERROR';
            $output[]='MSG: Manufacturer status not updated';
            $output[]='Action: none';
            $responseData=json_encode($output);
            echo $responseData;
            die();
        }
    }


?>