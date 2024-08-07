<?php
    //if check is set to false, then return the list of all devices regardless of status
    if ($check == 'false')
    {
        $dblink=db_connect("equipment");
        $sql="Select `name`,`auto_id` from `devices`";
        $result=$dblink->query($sql) or
            die("<p>Something went wrong with $sql<br>".$dblink->error);
        $devices=array();
    
        while ($data=$result->fetch_array(MYSQLI_ASSOC))
            $devices[$data['auto_id']]=$data['name'];
    
        header('Content-Type: application/json');
        header('HTTP/1.1 200 OK');
        $output[]='Status: Success';
        $output[]='MSG: '.json_encode($devices);
        $output[]='Action: none';  
        $responseData=json_encode($output);
        echo $responseData;
        die();
    }
    else
    {
        $dblink=db_connect("equipment");
        $sql="Select `name`,`auto_id` from `devices` where `status`='active'";
        $result=$dblink->query($sql) or
            die("<p>Something went wrong with $sql<br>".$dblink->error);
        $devices=array();
    
        while ($data=$result->fetch_array(MYSQLI_ASSOC))
            $devices[$data['auto_id']]=$data['name'];
    
        header('Content-Type: application/json');
        header('HTTP/1.1 200 OK');
        $output[]='Status: Success';
        $jsonDevices=json_encode($devices);
        $output[]='MSG: '.$jsonDevices;
        $output[]='Action: none';  
        $responseData=json_encode($output);
        echo $responseData;
        die();
    }
    


?>