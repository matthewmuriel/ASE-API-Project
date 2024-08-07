<?php
function db_connect($db)
{
	$username="pyuser";
	$password=".Ja-HatyUa7qW]aP";
	$host="localhost";
	$dblink=new mysqli($host,$username,$password,$db);
	return $dblink;
}

//check if the serial number exists
function serial_check($sn){
	$ch=curl_init("https://ec2-3-141-169-14.us-east-2.compute.amazonaws.com/api/query_serial");
	$data="sn=".$sn;
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
		return false;
	}else{
		return true;
	}
}

function device_check($did){
	$ch=curl_init("https://ec2-3-141-169-14.us-east-2.compute.amazonaws.com/api/query_device");
	$data="did=".$did;
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
	
	if ($resultsArray[0] == "Status: Success"){
		return true;
	}else{
		return false;
	}
}

function manufacturer_check($mid){
	$ch=curl_init("https://ec2-3-141-169-14.us-east-2.compute.amazonaws.com/api/query_manufacturer");
	$data="mid=".$mid;
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
	
	if ($resultsArray[0] == "Status: Success"){
		return true;
	}else{
		return false;
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