<?php

/**
 * 
 * PHP version 5.6.x | 7.x | 8.x
 * 
 * @category Modules
 * @package WHMCS
 * @author Pejman Kheyri <pejmankheyri@gmail.com>
 * @copyright 2021 All rights reserved.
 */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use WHMCS\ClientArea;
use WHMCS\Database\Capsule as Capsule;

$docroute = str_replace("modules\addons\server_custom_configs","",__DIR__);
$docroute = str_replace("modules/addons/server_custom_configs","",$docroute);

require($docroute."init.php");
require('functions.php');

$userid = 0;
$userdomain = '';

try {
	$url  = Capsule::table('tblconfiguration')->select('value')->where('setting','=','SystemURL')->first();
	$system_url = $url->value; 

	$whmusername = Capsule::table('tbladdonmodules')
		->select('setting','value')
		->where('module','=','server_custom_configs')
		->where('setting','=','whmusername')
		->get();

	$whmusername = $whmusername[0]->value;

	$userid = $_SESSION['uid'];
	$hostingid = $_REQUEST['hostId'];
	
	$userdetails = Capsule::table('tblhosting')
		->join('tblclients', 'tblhosting.userid', '=', 'tblclients.id')
		->join('tblservers', 'tblservers.id', '=', 'tblhosting.server')
		->join('mod_server_custom_configs_setting', 'tblservers.id', '=', 'mod_server_custom_configs_setting.server_id')
		->select('tblservers.hostname','tblservers.secure','tblhosting.username','tblhosting.domain','tblclients.email','tblhosting.password','mod_server_custom_configs_setting.server_hash')
		->where('tblclients.id','=',$userid)
		->where('tblhosting.id','=',$hostingid)
		->get();
	
	$hash = $userdetails[0]->server_hash;

	if($hash && $whmusername){
		
		if($userid && $hostingid){

			$userhostname = $userdetails[0]->hostname;
			$username = $userdetails[0]->username;
			$userdomain = $userdetails[0]->domain;
			$useremail = $userdetails[0]->email;
			$usersecure = $userdetails[0]->secure;
			$userHashedpassword = $userdetails[0]->password;

			$command = 'DecryptPassword';
			$postData = array(
				'password2' => $userHashedpassword,
			);
			$results = localAPI($command, $postData, $adminUsername);
			$userpassword = $results['password'];

			if($username && $userpassword){
				if(strtolower($usersecure) == 'on'){
					$protocol = 'https://';
					$port = '2087';
				} else {
					$protocol = 'http://';
					$port = '2086';
				}

				$serverIp = $protocol.$userhostname;
				$apiType = 'json-api';

				$accountsummary = 'accountsummary?api.version=1&user='.$username;

				$WHM_accountsummary = WHM_Request('accountsummary',$whmusername,$hash,$serverIp,$port,$apiType,$accountsummary);
				$acctsumm = $WHM_accountsummary->data->acct;
				$planName = $acctsumm[0]->plan;
				$planName = str_replace(' ', '%20', $planName);

				if($planName){
					
					$removeacct = 'removeacct?user='.$username;
					$WHM_removeacct = WHM_Request('removeacct',$whmusername,$hash,$serverIp,$port,$apiType,$removeacct);
					$removeSumm = $WHM_removeacct->result;
					$removed = $removeSumm[0]->status;
					
					if($removed == 1){
						
						$createacct = 'createacct?api.version=1&username='.$username.'&password='.$userpassword.'&domain='.$userdomain.'&contactemail='.$useremail.'&plan='.$planName;
						$WHM_createacct = WHM_Request('createacct',$whmusername,$hash,$serverIp,$port,$apiType,$createacct);
						$createsumm = $WHM_createacct->metadata->result;
						
						if($createsumm == 1){
							
							insert_log('Reset Host','<span style="background-color:green;color:#ffffff;padding:0px 5px;">Reset Host Done Successfully</span>',$userid,$userdomain);
							
							$Send_Welcome_Email = Send_Welcome_Email($hostingid);
							if($Send_Welcome_Email['result'] == 'success'){
								insert_log('Reset Host','<span style="background-color:green;color:#ffffff;padding:0px 5px;">Welcome Email Sent Successfully</span>',$userid,$userdomain);
							} else {
								insert_log('Reset Host','<span style="background-color:red;color:#ffffff;padding:0px 5px;">Error Sending Welcome Email !</span>',$userid,$userdomain);
							}
							
							header("Location: ".$system_url."clientarea.php?action=productdetails&id=".$hostingid."&ResetMessage=successfull");
							exit;
						} else {
							insert_log('Reset Host','<span style="background-color:red;color:#ffffff;padding:0px 5px;">Account Creation Failed !</span>',$userid,$userdomain);
							header("Location: ".$system_url."clientarea.php?action=productdetails&id=".$hostingid."&ResetMessage=failed");
							exit;
						}
					} else {
						insert_log('Reset Host','<span style="background-color:red;color:#ffffff;padding:0px 5px;">Error Remove Account From WHM Panel !</span>',$userid,$userdomain);
						header("Location: ".$system_url."clientarea.php?action=productdetails&id=".$hostingid."&ResetMessage=removefailed");
						exit;
					}
				} else {
					insert_log('Reset Host','<span style="background-color:red;color:#ffffff;padding:0px 5px;">Error Getting User Plan From WHM Panel !</span>',$userid,$userdomain);
					header("Location: ".$system_url."clientarea.php?action=productdetails&id=".$hostingid."&ResetMessage=getplanfailed");
					exit;
				}
			} else {
				insert_log('Reset Host','<span style="background-color:red;color:#ffffff;padding:0px 5px;">Error Getting Logged In User Data !</span>',$userid,$userdomain);
				header("Location: ".$system_url."clientarea.php?action=productdetails&id=".$hostingid."&ResetMessage=nouserdata");
				exit;
			}

		} else {
			insert_log('Reset Host','<span style="background-color:red;color:#ffffff;padding:0px 5px;">No Logged In User Or No Hosting For User !</span>',$userid,$userdomain);
			header("Location: ".$system_url."clientarea.php?action=productdetails&id=".$hostingid."&ResetMessage=nouser");
			exit;
		}
	} else {
		insert_log('Reset Host','<span style="background-color:red;color:#ffffff;padding:0px 5px;">Check Module Configs !</span>',$userid,$userdomain);
		header("Location: ".$system_url."clientarea.php?action=productdetails&id=".$hostingid."&ResetMessage=getconfigfailed");
		exit;
	}
} catch (\Exception $e) {
	echo "Reset Host Try Exception: {$e->getMessage()}";
}


?>