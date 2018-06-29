<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color:#87ceeb;
} ;
}
tr:nth-child(odd) {
    background-color:#dddddd;
</style>
</head>
<body>

<table>
<tr>
    <th>Product</th>
    <th>Expected Path</th>
    <th>Product Journey</th>
	<th>Status</th>
  </tr>


<?php
$connectionInfo = array("UID" => "pocadmin", "pwd" => "sys@12345", "Database" => "BlockChain_DB1", "LoginTimeout" => 120, "Encrypt" => 1, "TrustServerCertificate" => 0);
						$serverName = "tcp:synmobpocsrv.database.windows.net,1433";
						$conn = sqlsrv_connect($serverName, $connectionInfo);
		no_displayed_error_result($listassets, multichain('listassets', '*', true));
		foreach ($listassets as $stream)
		{
			//print("for");
			//print($stream['name']);
			
			if (no_displayed_error_result($result, multichain('subscribe', $stream['name']))) {
    				//output_success_text('Successfully subscribed to stream: '.$stream['name']);
    				$subscribed=true;
					if(no_displayed_error_result($resulttransact, multichain('listassettransactions', $stream['name'])))
		
						//print("\n RESULT TRANSACT: \n \n ");
						//print_r($resulttransact);
						if(sizeof($resulttransact) == 2)
						{
							//print("  STILL PENDING   \n");
					
						$franchiseid = array_keys($resulttransact[1]['addresses'],1);
						//print($franchiseid[0]);
						//print_r($resulttransact[2]['addresses']);
						$productPath = key($resulttransact[0]['addresses'])."-->".$franchiseid[0];
						
						$a = (string)$franchiseid[0];
						$query = "SELECT FranchiseName FROM dbo.franchiseDetails WHERE FranchiseID='$a'";
						$result = sqlsrv_query($conn,$query);
						if( $result === false) 
						{
							die( print_r( sqlsrv_errors(), true) );
						}
						while( $row = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC) ) {
							
							$franchisename = $row['FranchiseName'];
								}
							
						$productPath = "Warehouse"."-->".$franchisename;
							
							//print("Product Path");
							//print($productPath);
						
						//print("Connection Sucess");
						
	                    $cartonitem = (string)$stream['name'];
						$query = "SELECT * FROM dbo.IdealPath WHERE CartonItemSGTINID='$cartonitem'";
						$result = sqlsrv_query($conn,$query);
						if( $result === false) 
						{
							die( print_r( sqlsrv_errors(), true) );
						}
					//print("    IDEAL PATH   ");
						while( $row = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC) ) {
						  //print_r($row);
						  //$row['WarehouseID']
						  $expectedPath = $row['WarehouseID']."-->".$row['FranchiseID']."-->".$row['RetailerID'];
						  
						  $retailername = $row['RetailerID'];
						}
						
						$query = "SELECT * FROM dbo.retailerDetails WHERE Name='$retailername'";
						$result = sqlsrv_query($conn,$query);
						if( $result === false) 
						{
							die( print_r( sqlsrv_errors(), true) );
						}
					//print("    IDEAL PATH   ");
						while( $row = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC) ) {
						  //print_r($row);
						  //$expectedPath = $row['WarehouseID']."-->".$row['FranchiseID']."-->".$row['RetailerID'];
						  
						  $location = $row['City'];
						}
						
						$expectedPath = $expectedPath."-->". $location;
						
						
						 
						 /* $FranchiseID = $row['FranchiseID'];
						  $RetailerID = $row['RetailerID'];
						  
						//print("Expected Path:  ");
						//print($expectedPath);
								}	
								
								
						$query = "SELECT FranchiseName FROM dbo.franchiseDetails WHERE FranchiseID='$FranchiseID'";
						$result = sqlsrv_query($conn,$query);
						if( $result === false) 
						{
							die( print_r( sqlsrv_errors(), true) );
						}
						while( $row = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC) ) {
							
							$franchisename = $row['FranchiseName'];
								}
								
								
								
						$query = "SELECT Name FROM dbo.RetailerDetails WHERE RetailerID='$RetailerID'";
						$result = sqlsrv_query($conn,$query);
						if( $result === false) 
						{
							die( print_r( sqlsrv_errors(), true) );
						}
						while( $row = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC) ) {
							
							$retailername = $row['Name'];
								}
								*/
							 //$expectedPath	= "Warehouse"."-->".$franchisename."-->".$retailername;
								
								
						?>
						<tr>
								<td> <?php echo html($stream['name']) ?> </td>
								<td> <?php echo html($expectedPath) ?> </td>
								<td> <?php echo html($productPath) ?> </td>
								<td> In Transit </td>
						</tr>
							<?php
							
						}
						
						else if(sizeof($resulttransact) > 2)
						{
							
							?>
							<tr>
								<td> <?php echo html($stream['name']) ?> </td>
							<?php
						
						
						
						 $cartonitem = (string)$stream['name'];
						$query = "SELECT * FROM dbo.IdealPath WHERE CartonItemSGTINID='$cartonitem'";
						$result = sqlsrv_query($conn,$query);
						if( $result === false) 
						{
							die( print_r( sqlsrv_errors(), true) );
						}
					//print("    IDEAL PATH   ");
						while( $row = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC) ) {
						  //print_r($row);
						  $expectedPath = $row['WarehouseID']."-->".$row['FranchiseID']."-->".$row['RetailerID'];
						  $WarehouseID = $row['WarehouseID'];
						  $FranchiseID = $row['FranchiseID'];
						  $RetailerID = $row['RetailerID'];
						  $expectedPath	= "Warehouse"."-->".$FranchiseID."-->".$RetailerID;	
						  }
						  
						  
						 $query = "SELECT * FROM dbo.retailerDetails WHERE Name='$RetailerID'";
						$result = sqlsrv_query($conn,$query);
						if( $result === false) 
						{
							die( print_r( sqlsrv_errors(), true) );
						}
					//print("    IDEAL PATH   ");
						while( $row = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC) ) {
						  //print_r($row);
						  //$expectedPath = $row['WarehouseID']."-->".$row['FranchiseID']."-->".$row['RetailerID'];
						  
						  $location = $row['City'];
						}
						
						$expectedPath = $expectedPath."-->".$location;
								
								
								
							
										
						?>
						
								<td> <?php echo html($expectedPath) ?> </td>
							<?php
		
							
						$franchiseid = array_keys($resulttransact[1]['addresses'],1);
						
						$retailerid = array_keys($resulttransact[2]['addresses'],1);
						
						$productPath = key($resulttransact[0]['addresses'])."-->".$franchiseid[0]."-->".$retailerid[0];
						
						$a = (string)$franchiseid[0];
						$query = "SELECT FranchiseName FROM dbo.franchiseDetails WHERE FranchiseID='$a'";
						$result = sqlsrv_query($conn,$query);
						if( $result === false) 
						{
							die( print_r( sqlsrv_errors(), true) );
						}
						while( $row = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC) ) {
							
							$franchisename = $row['FranchiseName'];
								}
								
						$a = (string)$retailerid[0];
						$query = "SELECT Name FROM dbo.RetailerDetails WHERE RetailerID='$a'";
						$result = sqlsrv_query($conn,$query);
						
						if( $result === false) 
						{
							die( print_r( sqlsrv_errors(), true) );
						}
						while( $row = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC) ) {
							
							$retailername = $row['Name'];
								}
							
						$productPath = "Warehouse"."-->".$franchisename."-->".$retailername;
						
						
						//print("cartonitem");
						//print($cartonitem);
						//$city = "";
						$saleFlag = 0;
						$query = "SELECT * FROM dbo.scanLocation WHERE CartonItemSGTINID='$cartonitem'";
						
						$result = sqlsrv_query($conn,$query);
						//print("result");
						//print_r($result);
						if( $result === false) 
						{
							die( print_r( sqlsrv_errors(), true) );
						}
						
						while( $row = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC) ) {
							$saleFlag = 1;
							$city = $row['City'];
							$productPath = $productPath."-->".$city;
								}
						?>
						
								<td> <?php echo html($productPath) ?> </td>
							<?php
						
						if($saleFlag == 1)
						{
						if(strcmp($expectedPath, $productPath) == 0 )
						{//print("--- PATH CORRECT!! --");
					
					?>
						
								<td>Complete: &#x2705; </td>
							<?php
						}
						else
						{
							?>
						
								<td>Complete: &#x274C; </td>
							<?php
							//print("--- PATH INCORRECT!! --");
						}
						}
						
						else
						{
							?>
							<td>Sale Pending</td>
							<?php
						}
						
						}
    			}
			
			
				
		}
		
				?>
				
			

  </table>

</body>
</html>

	
  


