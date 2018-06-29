
<?php
session_start();
	static $arraytest=array();
	if (@$_POST['unlockoutputs'])
		if (no_displayed_error_result($result, multichain('lockunspent', true)))
			output_success_text('All outputs successfully unlocked');
	
	if (@$_POST['sendasset']) {
		
		/*no_displayed_error_result($listassets, multichain('listassets', '*', true));
 	//print_r($listassets);
	foreach($listassets as $asset)
	{
		$assetdetails[$asset['name']] = $asset['details']['CartonSGTINID'];
	}
	$cartonitems=array();
	$carton= $_POST['asset'];
	print("This carton value was selected: ");
	print($carton);
	$cartonitems = array_keys($assetdetails,$carton);
	print("These items exist in the carton: ");
	print_r($cartonitems);
	
	for($item=0; $item<sizeof($cartonitems); $item++)
	{*/
	
		/*if (strlen($_POST['metadata']))
			$success=no_displayed_error_result($sendtxid, multichain('sendwithmetadatafrom',
				$_POST['from'], $_POST['to'], array($_POST['asset'] => floatval($_POST['qty'])), bin2hex($_POST['metadata'])));*/
		//else
			$success=no_displayed_error_result($sendtxid, multichain('sendassetfrom',
				$_POST['from'], $_POST['to'], $_POST['asset'], floatval($_POST['qty'])));
				
		if ($success)
			output_success_text('Asset successfully sent in transaction '.$sendtxid);
		
		
	//array_push($arraytest,(string)$cartonitems[$item]);
	//print_r($arraytest);
	//$_SESSION["var"] = $arraytest;

    	//}	
	}
	
?>

			<div class="row">

				<div class="col-sm-5">
					<h3>Available Balances</h3>
			
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
						<table class="table table-bordered table-condensed table-break-words <?php echo ($address==@$getnewaddress) ? 'bg-success' : 'table-striped'?>">
<?php
			if (isset($label)) {
?>
							<tr>
								<th style="width:65%;">Label</th>
								<td><?php echo html($label)?></td>
							</tr>
<?php
			}
?>
							<tr>
								<th style="width:65%;">Address</th>
								<td class="td-break-words small"><?php echo html($address)?></td>
							</tr>
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
							<tr>
								<th><?php echo html($balance['name'])?></th>
								<td><?php echo html($unlockedqty)?><?php echo ($lockedqty>0) ? (' ('.$lockedqty.' locked)') : ''?></td>
							</tr>
<?php
					}
?>
						</table>
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
				
				<div class="col-sm-7">
					<h3>Send Asset</h3>
					
					<form class="form-horizontal" method="post" action="./?chain=<?php echo html($_GET['chain'])?>&page=<?php echo html($_GET['page'])?>">
						<div class="form-group">
							<label for="from" class="col-sm-3 control-label">From address:</label>
							<div class="col-sm-9">
							<select class="form-control" name="from" id="from">
<?php
	foreach ($usableaddresses as $address) {
?>
								<option value="<?php echo html($address)?>"><?php echo format_address_html($address, true, $labels)?></option>
<?php
	}
?>						
							</select>
							</div>
						</div>
						
		
 
                  
				  
						<div class="form-group">
							<label for="asset" class="col-sm-3 control-label">Asset name:</label>
							<div class="col-sm-9">
							<select class="form-control" name="asset" id="asset" onchange="showValue()">
<?php
	foreach ($keyusableassets as $asset => $dummy) {
		
?>
								<option value="<?php echo html($asset)?>"><?php echo html($asset)?></option> 
<?php
	}
	
?>						
							</select>
							</div>
						</div>
					
					
						<div class="form-group">
							<label for="to" class="col-sm-3 control-label">To address:</label>
							<div class="col-sm-9">
							<select class="form-control" name="to" id="to">
<?php
	foreach ($receiveaddresses as $address) {
		if ($address==$getinfo['burnaddress'])
			continue;
?>
								<option value="<?php echo html($address)?>"><?php echo format_address_html($address, @$keymyaddresses[$address], $labels)?></option>
<?php
	}
?>						
							</select>
							</div>
						</div>
						<div class="form-group">
							<label for="qty" class="col-sm-3 control-label">Quantity:</label>
							<div class="col-sm-9">
								<input class="form-control" name="qty" id="qty" placeholder="0.0">
							</div>
						</div>
						<!--<div class="form-group">
							<label for="metadata" class="col-sm-3 control-label">Metadata:</label>
							<div class="col-sm-9">
								<textarea class="form-control" rows="3" name="metadata" id="metadata"></textarea>
							</div>
						</div>-->
						<div class="form-group">
							<div class="col-sm-offset-3 col-sm-9">
								<input class="btn btn-default" type="submit" name="sendasset" value="Send Asset">
							</div>
						</div>
					</form>

				</div>
			</div>