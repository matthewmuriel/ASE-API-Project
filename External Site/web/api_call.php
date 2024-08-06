<?php
$ch=curl_init("https://ec2-3-141-169-14.us-east-2.compute.amazonaws.com/api/modify_serial");
$data="sn=SN-999?rsn=SN-999";
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

if ($resultsArray[0] === "Status: Error"){
    echo "error";
}
else{
    echo "success";
}
?>