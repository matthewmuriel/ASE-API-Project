<?php
    if ($status == NULL){
        //set the status to auto default to only return active manufacturers
        $status='active';
    }

    if ($did == NULL)//decive id is missing
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
    //check if device id is composed of only numbers
    else if (is_numeric($did)) {
        $dblink=db_connect("equipment");
        //query the database for the device id and return the device name
        $sql= "Select `name` , `status` from `devices` where `auto_id`=$did";
        $rst=$dblink->query($sql) or
            die("<p>Something went wrong with $sql<br>".$dblink->error);
        $data=$rst->fetch_array(MYSQLI_ASSOC);

        //success message to be returned if the device is found and return the device name
        if ($rst->num_rows > 0) {

            //check if the device is active before returning json of equipment
            if ($data['status'] != 'active' && $status != 'inactive') {
                //error message to be returned if device is inactive
                header('Content-Type: application/json');
                header('HTTP/1.1 200 OK');
                $output[]='Status: Success';
                $output[]='MSG: Device Inactive';
                $output[]='Action: none';
                $responseData=json_encode($output);
                echo $responseData;
                die();
            }

            $sql= "Select `auto_id`, `manufacturer_id`, `serial_number` from `serials` where `device_id` = $did limit 1000";
            $rst=$dblink->query($sql) or
                die("<p>Something went wrong with $sql<br>".$dblink->error);
            
            if ($rst->num_rows == 0) {
                //error message to be returned if the device is not found
                header('Content-Type: application/json');
                header('HTTP/1.1 200 OK');
                $output[]='Status: Success';
                $output[]='MSG: No entries found.';
                $output[]='Action: none';
                $responseData=json_encode($output);
                echo $responseData;
                die();
            }

            //append the returned results to the serials array don't include the auto_id as the key
            while ($data=$rst->fetch_array(MYSQLI_ASSOC))
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
        }else {
            //error message to be returned if the device is not found
            header('Content-Type: application/json');
            header('HTTP/1.1 200 OK');
            $output[]='Status: ERROR';
            $output[]='MSG: Device not found';
            $output[]='Action: none';
            $responseData=json_encode($output);
            echo $responseData;
            die();
        }
    }
    //perform a query_device action if the device id is not numeric
    else {
        $dblink=db_connect("equipment");
        $sql="Select `auto_id`, `status` from `devices` where `name`='$did'";
        $rst=$dblink->query($sql) or
            die("<p>Something went wrong with $sql<br>".$dblink->error);
        $data=$rst->fetch_array(MYSQLI_ASSOC);

        //success message to be returned if the device is found
        if ($rst->num_rows > 0) {
            $did=$data['auto_id'];

            if ($rst->num_rows == 0) {
                //error message to be returned if device type is found but no devices exist
                header('Content-Type: application/json');
                header('HTTP/1.1 200 OK');
                $output[]='Status: Success';
                $output[]='MSG: No entries found.';
                $output[]='Action: none';
                $responseData=json_encode($output);
                echo $responseData;
                die();
            }

            //check if the device is active before returning json of equipment
            if ($data['status'] != 'active' && $status != 'inactive') {
                //error message to be returned if the device is not found
                header('Content-Type: application/json');
                header('HTTP/1.1 200 OK');
                $output[]='Status: Success';
                $output[]='MSG: Device Inactive';
                $output[]='Action: none';
                $responseData=json_encode($output);
                echo $responseData;
                die();
            }

            $sql= "Select `auto_id`, `manufacturer_id`, `serial_number` from `serials` where `device_id` = $did limit 1000";
            $rst=$dblink->query($sql) or
                die("<p>Something went wrong with $sql<br>".$dblink->error);
            
            //append the returned results to the serials array don't include the auto_id as the key
            while ($data=$rst->fetch_array(MYSQLI_ASSOC))
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
        }else {
            //error message to be returned if the device is not found
            header('Content-Type: application/json');
            header('HTTP/1.1 200 OK');
            $output[]='Status: ERROR';
            $output[]='MSG: Device not found';
            $output[]='Action: none';
            $responseData=json_encode($output);
            echo $responseData;
            die();
        }
        
    }


?>