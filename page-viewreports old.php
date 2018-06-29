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

<h2>Product Report</h2>

<table>
<tr>
    <th>Product</th>
    <th>Expected Path</th>
    <th>Product Journey</th>
	<th>Status</th>
  </tr>


<?php
$connectionInfo = array("UID" => "pocadmin", "pwd" => "sys@12345", "Database" => "BlockChain_DB1", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
						$serverName = "tcp:synmobpocsrv.database.windows.net,1433";
						$conn = sqlsrv_connect($serverName, $connectionInfo);
		no_displayed_error_result($listassets, multichain('listassets', '*', true));
		//print_r($listassets);
		foreach ($listassets as $stream)
		{
			//print($stream['name']);
			if (no_displayed_error_result($result, multichain('subscribe', $stream['name']))) {
    				//output_success_text('Successfully subscribed to stream: '.$stream['name']);
    				$subscribed=true;
					if(no_displayed_error_result($resulttransact, multichain('listassettransactions', $stream['name'])))
						//print("\nPath added of stream name:  ");	
						//print($stream['name']);
						//print(sizeof($resulttransact));
						if(sizeof($resulttransact) == 2)
						{
							//print("  STILL PENDING   \n");
						//print_r($resulttransact[0]['addresses']);
						//print_r($resulttransact[1]['addresses']);
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
						
	                    $a = (string)$stream['name'];
						$query = "SELECT * FROM dbo.IdealPath WHERE CartonItemSGTINID='$a'";
						$result = sqlsrv_query($conn,$query);
						if( $result === false) 
						{
							die( print_r( sqlsrv_errors(), true) );
						}
					//print("    IDEAL PATH   ");
						while( $row = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC) ) {
						  //print_r($row);
						  $expectedPath = $row['WarehouseID']."-->".$row['FranchiseID']."-->".$row['RetailerID'];
						  $FranchiseID = $row['FranchiseID'];
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
								
							 $expectedPath	= "Warehouse"."-->".$franchisename."-->".$retailername;
								
								
						?>
						<tr>
								<td> <?php echo html($stream['name']) ?> </td>
								<td> <?php echo html($expectedPath) ?> </td>
								<td> <?php echo html($productPath) ?> </td>
								<td> Pending </td>
						</tr>
							<?php
							
						}
						
						else if(sizeof($resulttransact) > 2)
						{
							
							?>
							<tr>
								<td> <?php echo html($stream['name']) ?> </td>
							<?php
						
						
						//print("Connection Sucess");
						//$a = "011896400168418021ALX0YDVV04";
						 $a = (string)$stream['name'];
						$query = "SELECT * FROM dbo.IdealPath WHERE CartonItemSGTINID='$a'";
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
								
							 $expectedPath	= "Warehouse"."-->".$franchisename."-->".$retailername;	
								
								
								
							
										
						?>
						
								<td> <?php echo html($expectedPath) ?> </td>
							<?php
		
							
						
						//print("     ASSET TRANSACTION COMPLETE   \n");
						//print_r($resulttransact[0]['addresses']);
						$franchiseid = array_keys($resulttransact[1]['addresses'],1);
						//print($franchiseid[0]);
						$retailerid = array_keys($resulttransact[2]['addresses'],1);
						//print_r($retailerid[0]);
						
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
						
						
						
						
						?>
						
								<td> <?php echo html($productPath) ?> </td>
							<?php
						
						
						 //[CartonItemSGTINID] => 010896400145818021XAH6489XKC [WarehouseID] => 1PirN5MsuomdGuesocjnLkjktYVysgCRbLttEV [FranchiseID] => 1J2DrV3hVmZWWaXw8zvWj8ok7jaBRcuX18MHRp [RetailerID] => 1TPKc1HgN71hyzUQRbBSY7Y3U2by18Wa4fmCNF ) 
						
					 //&& strcmp( $FranchiseID, $franchiseid[0] ) == 0 
						
						if(strcmp($RetailerID, $retailerid[0] ) == 0)
						{
							print("For $a:  ");
							print("reatiler same");
						}
						if(strcmp( $FranchiseID, $franchiseid[0] ) == 0)
						{
							print("For $a:  ");
							print("franchise same");
						}
						
						if(strcmp($WarehouseID, key($resulttransact[0]['addresses']) ) == 0 && strcmp($RetailerID, $retailerid[0] ) == 0)
						{//print("--- PATH CORRECT!! --");
					
					?>
						
								<td>Complete: &#x2705; </td>
							<?php
						}
						else
						{
							print("   R:   ");
						print($RetailerID);
					    print(" == ");
					 print($retailerid[0]);
					 print("   W:   ");
					 print($WarehouseID);
					    print(" == ");
					 print(key($resulttransact[0]['addresses']));
					 print("    F:    ");
					 print($FranchiseID);
					    print(" == ");
					 print($franchiseid[0]);
							?>
						
								<td>Complete: &#x274C; </td>
							<?php
							//print("--- PATH INCORRECT!! --");
						}
						
						}
    			}
			
			
				
		}
		
				?>
				
			

  </table>

</body>
</html>

	
  


