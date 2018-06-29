<?php
	
	require_once 'functions.php';
	
	$config=read_config();
	$chain=@$_GET['chain'];
	$role=@$_GET['role'];
	$offset=@$_GET['offset'];
	//print($role);
	if (strlen($chain))
		$name=@$config[$chain]['name'];
	else
		$name='';

?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		
		<title>MultiChain Demo</title>
		<!--
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
		-->
		<link rel="stylesheet" href="bootstrap.min.css">
		<link rel="stylesheet" href="styles.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	<style>
	.navbar-default .navbar-nav > li > a:hover, .navbar-default .navbar-nav > li > a:focus {
    background-color: transparent;
    color: white;
}

	</style>
	
	</head>
	<body>
		<div class="container">
		<?php
		if($name == 'Warehouse0')
		{
			$namenew = 'Warehouse';
		?>
		
		
			<div class="row">
			<div class="col-sm-4">
			<h1 style="font-size:30px"><strong>PRODUCT TRACKER
			</strong>
			
			</h1>
			</div>

			<div class="col-sm-4"></div>
			
			<div class="col-sm-4" style="text-align:right">
			<h1 style = "font-size:30px"><?php if (strlen($name)) { ?> <span class="glyphicon glyphicon-user" style="color:#87ceeb"></span> <?php echo html($namenew)?><?php } ?></h1>
			
			</div>
			</div>
  
			<?php
		}
		
		else
		{
			?>
			<div class="row">
			<div class="col-sm-4">
			<h1 style="font-size:30px"><strong>PRODUCT TRACKER
			</strong></h1>
			</div>

			<div class="col-sm-4"></div>
			
			<div class="col-sm-4" style="text-align:right">
			<h1 style = "font-size:30px"><?php if (strlen($name)) { ?> <span class="glyphicon glyphicon-user" style="color:#87ceeb;"></span> <?php echo html($name)?><?php } ?></h1>
			
			</div>
			</div>
		<?php
		}
		?>
		
<?php
	if ($chain=='default') {
		$name=@$config[$chain]['name'];
?>
			
			<div class="navbar navbar-default" style="align:center; background-color:#87ceeb;outline:none;border:none;">
			<ul class="nav navbar-nav" style="align:center; background-color:#87ceeb;outline:none;border:none;">
			
                <li ><a href="./?chain=<?php echo html($chain)?>&page=send" style="font-size:20px;color:black;"><b>&nbsp;&nbsp;&nbsp;&nbsp;ISSUE</b></a></li>
						<li><a href="./?chain=<?php echo html($chain)?>&page=viewreports" style="font-size:20px;color:black;"><b>REPORTS</b></a></li>
						
						<li><a href="login.html" style="font-size:20px;color:black;"><b>LOGOUT</b></a></li>
				</ul>
				</div>
                <br>
				<br>
				
			

<?php
		set_multichain_chain($config[$chain]);
		
		switch (@$_GET['page']) {
			
			case 'send':
				require_once 'page-'.$_GET['page'].'.php';
				break;
				case 'default':
				require_once 'page-'.$_GET['page'].'.php';
				break;
				case 'label':
				require_once 'page-'.$_GET['page'].'.php';
				break;
				case 'viewreports':
				require_once 'page-'.$_GET['page'].'.php';
				break;
				case 'issue':
				require_once 'page-'.$_GET['page'].'.php';
				break;
			default:
				require_once 'page-send.php';
				break;
		}
		
	} 
	
	else if ($chain=='f1') {
		$name=@$config[$chain]['name'];
		
?>
<div class="navbar navbar-default" style="align:center; background-color:#87ceeb;outline:none;border:none;">
			<ul class="nav navbar-nav" style="align:center; background-color:#87ceeb;outline:none;border:none;">
			
                <li ><a href="./?chain=<?php echo html($chain)?>&page=send franchise" style="font-size:20px;color:black;">&nbsp;&nbsp;&nbsp;&nbsp;<b>ISSUE</b></a></li>
				
						<li><a href="login.html" style="font-size:20px;color:black;"><b>LOGOUT</b></a></li>
				</ul>
				</div>
                <br>
				<br>

<?php
		set_multichain_chain($config[$chain]);
		
		switch (@$_GET['page']) {
			
			case 'send':
				require_once 'page-'.$_GET['page'].'.php';
				break;
			case 'default':
				require_once 'page-'.$_GET['page'].'.php';
				break;
				case 'label':
				require_once 'page-'.$_GET['page'].'.php';
				break;
				
			default:
				require_once 'page-send franchise.php';
				break;
		}
		
	}

else if ($chain=='f2') {
		$name=@$config[$chain]['name'];
		
?>
			
			<div class="navbar navbar-default" style="align:center; background-color:#87ceeb;outline:none;border:none;">
			<ul class="nav navbar-nav" style="align:center; background-color:#87ceeb;outline:none;border:none;">
			
                <li ><a href="./?chain=<?php echo html($chain)?>&page=send franchise" style="font-size:20px;color:black;">&nbsp;&nbsp;&nbsp;&nbsp;<b>ISSUE</b></a></li>
				
						<li><a href="login.html" style="font-size:20px;color:black;"><b>LOGOUT</b></a></li>
				</ul>
				</div>
                <br>
				<br>
			
			

<?php
		set_multichain_chain($config[$chain]);
		
		switch (@$_GET['page']) {
			
			case 'send':
				require_once 'page-'.$_GET['page'].'.php';
				break;
			case 'default':
				require_once 'page-'.$_GET['page'].'.php';
				break;
				case 'label':
				require_once 'page-'.$_GET['page'].'.php';
				break;
				
			default:
				require_once 'page-send franchise.php';
				break;
		}
		
	}	
	
	else if ($chain=='r1') {
		$name=@$config[$chain]['name'];
		
?>
			
			<?php
			header('Location: scanning.php');
			?>	
			
				

<?php
	set_multichain_chain($config[$chain]);
		
		switch (@$_GET['page']) {
			
			case 'send':
				require_once 'page-'.$_GET['page'].'.php';
				break;
			case 'default':
				require_once 'page-'.$_GET['page'].'.php';
				break;
				case 'label':
				require_once 'page-'.$_GET['page'].'.php';
				break;
				
			default:
				require_once 'page-send franchise.php';
				break;
		}	
		
	}
	
	else if ($chain=='r2') {
		$name=@$config[$chain]['name'];
		
?>
			
		
		<?php
			header('Location: scanning.php');
			?>	
				

<?php
	set_multichain_chain($config[$chain]);
		
		switch (@$_GET['page']) {
			
			case 'send':
				require_once 'page-'.$_GET['page'].'.php';
				break;
			case 'default':
				require_once 'page-'.$_GET['page'].'.php';
				break;
				case 'label':
				require_once 'page-'.$_GET['page'].'.php';
				break;
				
			default:
				require_once 'page-send franchise.php';
				break;
		}	
		
	}
			
	
	else {
?>
			<p class="lead"><br/>Choose an available node to get started:</p>
		
			<p>
<?php
		foreach ($config as $chain => $rpc)
		{
			$rolenew = $role.$offset;
			//print($rolenew);
			if (strcmp($rpc['name'], $rolenew) == 0)
			{
			if (isset($rpc['rpchost']))
				//echo '<p class="lead"><a href="./?chain='.html($chain).'">'.html($rpc['name']).'</a><br/>';
				header('Location: index.php?chain='.$chain);
?>
			</p>
<?php
}
}
	}
?>
		</div>
	</body>
</html>