<?php

$f=$_GET["franchiseid"];
//echo $f;
$connectionInfo = array("UID" => "pocadmin", "pwd" => "sys@12345", "Database" => "BlockChain_DB1", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
$serverName = "tcp:synmobpocsrv.database.windows.net,1433";
$conn = sqlsrv_connect($serverName, $connectionInfo);
//print("Connection Sucess");
$query = "SELECT * FROM dbo.retailerDetails WHERE RetailerID='$f' ";
$result = sqlsrv_query($conn,$query);
if( $result === false) {
    die( print_r( sqlsrv_errors(), true) );
}
else
//print("Query Success");
$i=0;
//$num = sqlsrv_num_rows($result);
$row = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC);

       

$retailerdetails = " RetailerName:  ". $row['Name']." Area: ".$row['Area']." City: ".$row['City']." Pincode: ".$row['Pincode'];
      echo $retailerdetails ;
     
?>