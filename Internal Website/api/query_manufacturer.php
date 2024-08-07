<?php
    if ($status == NULL){
        //set the status to auto default to only return active manufacturers
        $status='active';
    }
    if ($mid==NULL)//missing manufacturer id
    {
        header('Content-Type: application/json');
        header('HTTP/1.1 200 OK');
        $output[]='Status: ERROR';
        $output[]='MSG: Invalid or missing manufacturer id.';
        $output[]='Action: none';
        $responseData=json_encode($output);
        echo $responseData;
        die();
    }
    //check if the manufacturer id is numeric
    else if (is_numeric($mid)) {
        $dblink=db_connect("equipment");
        //query the database for the manufacturer id and return the manufacturers name
        $sql= "Select `name`, `status` from `manufacturers` where `auto_id`='$mid'";
        $rst=$dblink->query($sql) or
            die("<p>Something went wrong with $sql<br>".$dblink->error);
        $data=$rst->fetch_array(MYSQLI_ASSOC);
        
        //success message to be returned if the manufacturers is found and return the manufacturers name
        if ($rst->num_rows > 0) {
            //check if the manufacturers is active before returning json of equipment
            if ($data['status'] != 'active' && $status != 'inactive') {
                //error message to be returned if the manufacturers is inactive
                header('Content-Type: application/json');
                header('HTTP/1.1 200 OK');
                $output[]='Status: Success';
                $output[]='MSG: Manufacturer Inactive';
                $output[]='Action: none';
                $responseData=json_encode($output);
                echo $responseData;
                die();
            }

            $sql= "Select `auto_id`, `device_id`, `serial_number` from `serials` where `manufacturer_id` = $mid limit 1000";
            $rst=$dblink->query($sql) or
                die("<p>Something went wrong with $sql<br>".$dblink->error);

            if ($rst->num_rows == 0) {
                //error message to be returned if the manufacturers is not found
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

            //return the serials array as json
            header('Content-Type: application/json');
            header('HTTP/1.1 200 OK');
            $output[]='Status: Success';
            $jsonManufacturers=json_encode($serials);
            $output[]='MSG: '.$jsonManufacturers;
            $output[]='Action: none';
            $responseData=json_encode($output);
            echo $responseData;
            
            die();
        }else {
            //error message to be returned if the manufacturers is not found
            header('Content-Type: application/json');
            header('HTTP/1.1 200 OK');
            $output[]='Status: ERROR';
            $output[]='MSG: Manufacturer not found';
            $output[]='Action: none';
            $responseData=json_encode($output);
            echo $responseData;
            die();
        }
    }
    else {
        $dblink=db_connect("equipment");
        $sql="Select `auto_id`, `status` from `manufacturers` where `name`='$mid'";
        $rst=$dblink->query($sql) or
            die("<p>Something went wrong with $sql<br>".$dblink->error);
        $data=$rst->fetch_array(MYSQLI_ASSOC);
        
        if ($rst->num_rows > 0){
            $mid =$data['auto_id'];

            if ($rst->num_rows == 0){
                //error message to be returned if the manufacturers is not found
                header('Content-Type: application/json');
                header('HTTP/1.1 200 OK');
                $output[]='Status: Success';
                $output[]='MSG: No entries found.';
                $output[]='Action: none';
                $responseData=json_encode($output);
                echo $responseData;
                die();
            }

            //check if the manufacturers is active before returning json of equipment
            if ($data['status'] != 'active' && $status != 'inactive') {
                //error message to be returned if the manufacturers is inactive
                header('Content-Type: application/json');
                header('HTTP/1.1 200 OK');
                $output[]='Status: Success';
                $output[]='MSG: Manufacturer Inactive';
                $output[]='Action: none';
                $responseData=json_encode($output);
                echo $responseData;
                die();
            }

            $sql= "Select `auto_id`, `device_id`, `serial_number` from `serials` where `manufacturer_id` = $mid limit 1000";
            $rst=$dblink->query($sql) or
                die("<p>Something went wrong with $sql<br>".$dblink->error);
            
            //append the returned results to the serials array don't include the auto_id as the key
            while ($data=$rst->fetch_array(MYSQLI_ASSOC))
                $serials[$data['auto_id']]=$data;

            //return the serials array as json
            header('Content-Type: application/json');
            header('HTTP/1.1 200 OK');
            $output[]='Status: Success';
            $jsonManufacturers=json_encode($serials);
            $output[]='MSG: '.$jsonManufacturers;
            $output[]='Action: none';
            $responseData=json_encode($output);
            echo $responseData;

            die();

        } else {
            //error message to be returned if the manufacturers is not found
            header('Content-Type: application/json');
            header('HTTP/1.1 200 OK');
            $output[]='Status: ERROR';
            $output[]='MSG: Manufacturer not found';
            $output[]='Action: none';
            $responseData=json_encode($output);
            echo $responseData;
            die();
        }
        
    }
?>