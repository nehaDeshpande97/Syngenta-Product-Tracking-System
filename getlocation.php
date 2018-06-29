<?php
   $connectionInfo = array("UID" => "pocadmin", "pwd" => "sys@12345", "Database" => "BlockChain_DB1", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
$serverName = "tcp:synmobpocsrv.database.windows.net,1433";
$conn = sqlsrv_connect($serverName, $connectionInfo);
//connection done 











//if latitude and longitude are submitted
if(!empty($_POST['latitude']) && !empty($_POST['longitude'])){
    //send request and receive json data by latitude and longitude
    $url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($_POST['latitude']).','.trim($_POST['longitude']).'&sensor=false';
    $json = @file_get_contents($url);
	$barcodetext= $_POST['barcoding'];
	
	$barcodetext = substr($barcodetext,1,strlen($barcodetext));
  $data = json_decode($json);
    $status = $data->status;
    
 //  if request status is successful
    if($status == "OK"){
        //get address from json data
        $location = $data->results[0]->formatted_address;
     $myArray = explode(',', $location);
   // print($myArray[5]);
	$city = substr($myArray[5],1,strlen($myArray[5]));
	$query1 = "INSERT INTO scanLocation (CartonItemSGTINID,City) VALUES (?, ?)";
	
$params=array($barcodetext,$city);
$result1 = sqlsrv_query($conn,$query1,$params);
if( $result1 === false) {
   die( print_r( sqlsrv_errors(), true) );
}
	 
    }else{
        $location =  '';
    }
    
    //return address to ajax 
  //  echo $location;*/
}
?>
