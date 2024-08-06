<?php
    function equipment_call($url, $data){
        $api_url="https://ec2-3-141-169-14.us-east-2.compute.amazonaws.com/api/";
        $ch=curl_init($api_url.$url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//ignore ssl
        curl_setopt($ch, CURLOPT_POST,1);//tell curl we are using post
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);//this is the data
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//prepare a response
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'content-type: application/x-www-form-urlencoded',
            'content-length: '.strlen($data))
                    );
        $result=curl_exec($ch);
        curl_close($ch);
        $resultsArray=json_decode($result,true);
        
        if ($resultsArray[0] === "Status: Success"){
        
        $tmp=$resultsArray[1];
        $payloadData=explode("MSG:",$tmp);
        $payload = json_decode($payloadData[1],true);
        
        return $payload;
        }
        else{
            return "Error: ".$resultsArray[0]."<br>";
        }
    }

    function device_call($url, $data){
        $api_url="https://ec2-3-141-169-14.us-east-2.compute.amazonaws.com/api/";
        $ch=curl_init($api_url.$url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//ignore ssl
        curl_setopt($ch, CURLOPT_POST,1);//tell curl we are using post
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);//this is the data
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//prepare a response
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'content-type: application/x-www-form-urlencoded',
            'content-length: '.strlen($data))
                    );
        $result=curl_exec($ch);
        curl_close($ch);
        $resultsArray=json_decode($result,true);
        
        if ($resultsArray[0] === "Status: ERROR"){
            if ($resultsArray[1] === "MSG: Device not found"){
                return "Device not found";
            }
        }else{
            return "Device found";
        }
    }

    function add_device_equipment($url, $data){
        $api_url="https://ec2-3-141-169-14.us-east-2.compute.amazonaws.com/api/";
        $ch=curl_init($api_url.$url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//ignore ssl
        curl_setopt($ch, CURLOPT_POST,1);//tell curl we are using post
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);//this is the data
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//prepare a response
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'content-type: application/x-www-form-urlencoded',
            'content-length: '.strlen($data))
                    );
        $result=curl_exec($ch);
        curl_close($ch);
        $resultsArray=json_decode($result,true);
        
        if ($resultsArray[0] === "Status: Success"){
            return "Success";
        }else{
            return "Error: ".$resultsArray[0]."<br> ".$resultsArray[1]."<br>";
        }
    }

    function modify_device_equipment($url, $data){
        $api_url="https://ec2-3-141-169-14.us-east-2.compute.amazonaws.com/api/";
        $ch=curl_init($api_url.$url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//ignore ssl
        curl_setopt($ch, CURLOPT_POST,1);//tell curl we are using post
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);//this is the data
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//prepare a response
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'content-type: application/x-www-form-urlencoded',
            'content-length: '.strlen($data))
                    );
        $result=curl_exec($ch);
        curl_close($ch);
        $resultsArray=json_decode($result,true);
        
        if ($resultsArray[0] === "Status: Success"){
            $msg = $resultsArray[1];

            switch ($msg){
                case "MSG: Name and status updated";
                    return "Name/Status";
                    break;
                case "MSG: Name updated";
                    return "Name";
                    break;
                case "MSG: Status updated";
                    return "Status";
                    break;
                default:
                    return "Error";
            }

        }else{
            if ($resultsArray[1] === "MSG: Name already exists"){
                return "Exists";
        }
        }
    }

    function modify_equipment($url, $data){
        $api_url="https://ec2-3-141-169-14.us-east-2.compute.amazonaws.com/api/";
        $ch=curl_init($api_url.$url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//ignore ssl
        curl_setopt($ch, CURLOPT_POST,1);//tell curl we are using post
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);//this is the data
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//prepare a response
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'content-type: application/x-www-form-urlencoded',
            'content-length: '.strlen($data))
                    );
        $result=curl_exec($ch);
        curl_close($ch);
        $resultsArray=json_decode($result,true);
        
        if ($resultsArray[0] === "Status: Success"){
            $msg = $resultsArray[1];

            switch ($msg){
                case "MSG: Serial number, device id, and manufacturer id updated";
                    return "Serial/Device/Manufacturer";
                    break;
                case "MSG: Serial number and device id updated";
                    return "Serial/Device";
                    break;
                case "MSG: Serial number and manufacturer id updated";
                    return "Serial/Manufacturer";
                    break;
                case "MSG: Device id and manufacturer id updated";
                    return "Device/Manufacturer";
                    break;
                case "MSG: Serial number updated";
                    return "Serial";
                    break;
                case "MSG: Device id updated";
                    return "Device";
                    break;
                case "MSG: Manufacturer id updated";
                    return "Manufacturer";
                    break;
                default:
                    return "Error";
            }
            
        }else{
            if ($resultsArray[1] === "MSG: Serial number already exists"){
                return "Exists";
            }elseif($resultsArray[1] === "MSG: Serial number not found"){
                return "Not found";
            }
        }
    }

    function search_equipment($url, $data){
        $api_url="https://ec2-3-141-169-14.us-east-2.compute.amazonaws.com/api/";
        $ch=curl_init($api_url.$url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//ignore ssl
        curl_setopt($ch, CURLOPT_POST,1);//tell curl we are using post
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);//this is the data
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//prepare a response
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'content-type: application/x-www-form-urlencoded',
            'content-length: '.strlen($data))
                    );
        $result=curl_exec($ch);
        curl_close($ch);
        $resultsArray=json_decode($result,true);
        
        if ($resultsArray[0] === "Status: Success"){
            
            switch ($resultsArray[1]){
                case "MSG: No entries found.":
                    return "No Entries";
                    break;
                default:
                    return "Success";
            }

        }else{
            return "No Entries";
        }
    }

    function view_equipment($url, $data){
        $api_url="https://ec2-3-141-169-14.us-east-2.compute.amazonaws.com/api/";
        $ch=curl_init($api_url.$url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//ignore ssl
        curl_setopt($ch, CURLOPT_POST,1);//tell curl we are using post
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);//this is the data
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//prepare a response
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'content-type: application/x-www-form-urlencoded',
            'content-length: '.strlen($data))
                    );
        $result=curl_exec($ch);
        curl_close($ch);
        $resultsArray=json_decode($result,true);
        
        if ($resultsArray[0] === "Status: Success"){
            $tmp=$resultsArray[1];
            $payloadData=explode("MSG:",$tmp);
            $payload = json_decode($payloadData[1],true);

            return $payload;
        }else{
            return "Error: ".$resultsArray[0]."<br>";
        }
    
    }

    function redirect($url)
        { ?>
            <script type="text/javascript">
            <!--
            document.location.href="<?php echo $url; ?>";
            -->
            </script>
        <?php
        }
?>