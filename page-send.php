
<?php
session_start();
	static $arraytest=array();
	if (@$_POST['unlockoutputs'])
		if (no_displayed_error_result($result, multichain('lockunspent', true)))
			output_success_text('All outputs successfully unlocked');
	
	if (@$_POST['sendasset']) {
		
		no_displayed_error_result($listassets, multichain('listassets', '*', true));
 	//print_r($listassets);
	foreach($listassets as $asset)
	{
		$assetdetails[$asset['name']] = $asset['details']['CartonSGTINID'];
	}
	$cartonitems=array();
	$carton= $_POST['asset'];
	//print("This carton value was selected: ");
	//print($carton);
	$cartonitems = array_keys($assetdetails,$carton);
	//print("These items exist in the carton: ");
	//print_r($cartonitems);
	$qty = 1.0;
	for($item=0; $item<sizeof($cartonitems); $item++)
	{
	
		/*if (strlen($_POST['metadata']))
			$success=no_displayed_error_result($sendtxid, multichain('sendwithmetadatafrom',
				$_POST['from'], $_POST['to'], array($_POST['asset'] => floatval($_POST['qty'])), bin2hex($_POST['metadata'])));*/
		//else
			$success=no_displayed_error_result($sendtxid, multichain('sendassetfrom',
				$_POST['from'], $_POST['to'], (string)$cartonitems[$item], floatval($qty)));
				
		if ($success)
			output_success_text('Asset successfully sent in transaction '.$sendtxid);
		
		
	//array_push($arraytest,(string)$cartonitems[$item]);
	//print_r($arraytest);
	//$_SESSION["var"] = $arraytest;

    	}	
	}
	
?>

			
<?php
	
	
	$sendaddresses=array();
	$usableaddresses=array();
	$keymyaddresses=array();
	$keyusableassets=array();
	$haslocked=false;
	$getinfo=multichain_getinfo();
	$labels=array();
	global $assetdetails;
	$assetdetails=array();
	$keyusablecartons=array();
	$transactpath=array();
	
	no_displayed_error_result($listassets, multichain('listassets', '*', true));
 	//print_r($listassets);
	foreach($listassets as $asset)
	{
		$assetdetails[$asset['name']] = $asset['details']['CartonSGTINID'];
	}
	//print_r($assetdetails);
	$asset='1994';
	//print($assetdetails[$asset]);
	
	$newarray=array();
	$carton="2000";
   $newarray = array_keys($assetdetails,$carton);
   //print_r($newarray);
   //print($newarray[0]);
   
	no_displayed_error_result($getinfo, multichain('getinfo'));
    
	
     	
		//print("Result array: ");
		//print($stream['name']);
		//print("\n");
		//print_r($resulttransact);
	if (no_displayed_error_result($getaddresses, multichain('getaddresses', true))) {
		
		if (no_displayed_error_result($listpermissions,
			multichain('listpermissions', 'send', implode(',', array_get_column($getaddresses, 'address')))
		))
			$sendaddresses=array_get_column($listpermissions, 'address');
			
		foreach ($getaddresses as $address)
			if ($address['ismine'])
				$keymyaddresses[$address['address']]=true;

		$labels=multichain_labels();

		if (no_displayed_error_result($listpermissions, multichain('listpermissions', 'receive')))
			$receiveaddresses=array_get_column($listpermissions, 'address');
		
		foreach ($sendaddresses as $address) {
			if (no_displayed_error_result($allbalances, multichain('getaddressbalances', $address, 0, true))) {

				if (count($allbalances)) {
					$assetunlocked=array();
					
					if (no_displayed_error_result($unlockedbalances, multichain('getaddressbalances', $address, 0, false))) {
						if (count($unlockedbalances))
							$usableaddresses[]=$address;
							
						foreach ($unlockedbalances as $balance)
							$assetunlocked[$balance['name']]=$balance['qty'];
					}
	
					$label=@$labels[$address];

?>
						
<?php
			if (isset($label)) {
?>
				
<?php
			}
?>
					
<?php
					foreach ($allbalances as $balance) {
						$unlockedqty=floatval($assetunlocked[$balance['name']]); //print("Unlockedqty: ");print($unlockedqty);
						$lockedqty=$balance['qty']-$unlockedqty; //print("lockedqty: ");print($lockedqty);
						
						if ($lockedqty>0)
							$haslocked=true;
						if ($unlockedqty>0)
							$keyusableassets[$balance['name']]=true;
						
						
						//print("keyussableassets");
						//print_r($keyusableassets);
?>
							
<?php
					}
?>
						
<?php
				}
			}
		}
	}
	foreach ($keyusableassets as $asset => $dummy) 
	{
		$keyusablecartons[$assetdetails[$asset]]=true;
	}
	//print("KeyUsableCartons");
	//print_r($keyusablecartons);
	
	if ($haslocked) {
?>
				<form class="form-horizontal" method="post" action="./?chain=<?php echo html($_GET['chain'])?>&page=<?php echo html($_GET['page'])?>">
					<input class="btn btn-default" type="submit" name="unlockoutputs" value="Unlock all outputs">
				</form>
<?php
	}
?>
				</div>
				<div class="row">
				<div class="col-sm-3"></div>
				<div class="col-sm-6" >
				
					<h2 style="text-align:center;margin-left:15%;font-size:30px;color:black;"><strong>ISSUE PRODUCTS</strong></h2>
					<br>
					<br>
					
					<form class="form-horizontal" method="post" action="./?chain=<?php echo html($_GET['chain'])?>&page=<?php echo html($_GET['page'])?>">
						<div class="form-group">
							<label for="from" class="col-sm-3 control-label"style="font-size:22px;">FROM ADDRESS</label>
							<div class="col-sm-9">
							<select class="form-control" name="from" id="from">
<?php
	foreach ($usableaddresses as $address) {
?>
								
								<option value="<?php echo html($address)?>"><?php echo html($labels[$address])?></option>
<?php
	}
?>						
							</select>
							</div>
						</div>
						
		<br>
 
                  
				  
						<div class="form-group">
							<label for="asset" class="col-sm-3 control-label"style="font-size:22px;">PRODUCT NAME</label>
							
							<div class="col-sm-9">
							<select class="form-control" name="asset" id="asset" onchange="showValue()">
<?php
	foreach ($keyusablecartons as $asset => $dummy) {
		
?>
								<option value="<?php echo html($asset)?>"><?php echo html($asset)?></option> 
<?php
	}
	
?>						
							</select>
							</div>
						</div>
					<br>
					
						<div class="form-group">
							<label for="to" class="col-sm-3 control-label"style="font-size:22px;">TO ADDRESS</label>
							<div class="col-sm-9">
							<select class="form-control" name="to" id="to" onchange="getfranchisedetails();">
<?php
	foreach ($receiveaddresses as $address) {
		if ($address==$getinfo['burnaddress'])
			continue;
?>
								
								<option value="<?php echo html($address)?>"><?php echo html(@$labels[$address])?></option>
<?php
	}
?>						
							</select>
							<div id="franchisedetails"> </div>
<script>
	function getfranchisedetails()
	{
		var x=document.getElementById("to").value;
		//alert(x);
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
		}
		xmlhttp.onreadystatechange=function()
		{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById("franchisedetails").innerHTML=xmlhttp.responseText;
		}
		}
		xmlhttp.open("GET","getfranchisedetails.php?franchiseid="+x,true);
		//alert("called xmlrequest");
		xmlhttp.send();
		//alert("sent");
	}

</script>						
							
							
							
							</div>
						</div>

						<!--<div class="form-group">
							<label for="metadata" class="col-sm-3 control-label">Metadata:</label>
							<div class="col-sm-9">
								<textarea class="form-control" rows="3" name="metadata" id="metadata"></textarea>
							</div>
						</div>-->
						<div class="form-group">
							<div class="col-sm-offset-3 col-sm-9"style="margin-left:50%;">
								<b><input style="background-color:#87ceeb;border:none; color:black; font-weight: bold;" class="btn btn-default" type="submit" name="sendasset" value="ISSUE"></b>
							</div>
						</div>
					</form>

				</div>
			</div>