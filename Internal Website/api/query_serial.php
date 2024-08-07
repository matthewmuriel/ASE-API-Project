<?php
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
    } else {
        $dblink=db_connect("equipment");
        $sql="Select * from `serials` where `serial_number`='$sn'";;
        $rst=$dblink->query($sql) or
            die("<p>Something went wrong with $sql<br>".$dblink->error);

        //if serial number is found return success message
        if ($rst->num_rows > 0) {
            $data=$rst->fetch_array(MYSQLI_ASSOC);
            
            header('Content-Type: application/json');
            header('HTTP/1.1 200 OK');
            $output[]='Status: Success';
            $jsonData=json_encode($data);
            $output[]='MSG: '.$jsonData;
            $output[]='Action: none';
            $responseData=json_encode($output);
            echo $responseData;
            die();
        }else {
            //if serial number is not found return error message
            header('Content-Type: application/json');
            header('HTTP/1.1 200 OK');
            $output[]='Status: ERROR';
            $output[]='MSG: Serial number not found';
            $output[]='Action: none';
            $responseData=json_encode($output);
            echo $responseData;
            die();
        }
    }


?>