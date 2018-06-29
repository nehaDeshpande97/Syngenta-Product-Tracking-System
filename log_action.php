<?php
session_start();
//include "connection_trial.php";
require_once 'functions.php';
$config=read_config();
if (isset($_POST['submit'])) {
 
$User_Name = $_POST['username'];
$Password  = $_POST['password'];
$role=$_POST['role'];
$a = array();
//$role1=$config[$chain]['name'];
foreach ($config as $chain => $rpc)
		{
			
			if (strpos($rpc['name'], $role) !== false)
			{
				
			//if($User_Name==$rpc['rpcuser'] && $Password==$rpc['rpcpassword'] )
			//{
				if($rpc['name']=="Warehouse0" && $User_Name==$rpc['rpcuser'] && $Password==$rpc['rpcpassword'] )
					{
					header('Location: index.php?role=Warehouse&offset=0'); 
					}
					
				else if(strpos($rpc['name'], "Franchise") !== false)
				{
					print("In franchise if loop");
					
					foreach ($config as $chain => $rpc)
					{
						if (strpos($rpc['name'], "Franchise") !== false)
						{
							if($User_Name==$rpc['rpcuser'] && $Password==$rpc['rpcpassword'])
								header('Location: index.php?role=Franchise&offset='.$rpc['name'][9]); 
						}
					}
				}
				
				else if(strpos($rpc['name'], "Retailer") !== false)
				{
					
					foreach ($config as $chain => $rpc)
					{
						if (strpos($rpc['name'], "Retailer") !== false)
						{
							if($User_Name==$rpc['rpcuser'] && $Password==$rpc['rpcpassword'])
								header('Location: index.php?role=Retailer&offset='.$rpc['name'][8]); 
						}
					}
				}
			}
				else
				{
					print("Username or Password or Role is incorrect");
				}
				
				
				
				
			}
				
		}
		?>
