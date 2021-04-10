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

if (!defined("WHMCS"))
    die("This file cannot be accessed directly");

use Illuminate\Database\Capsule\Manager as Capsule;
use WHMCS\View\Menu\Item as MenuItem;

add_hook('ClientAreaPrimarySidebar', 1, function (MenuItem $primarySidebar) {
	
	try {
		$userid = $_SESSION['uid'];
		$hostingid = $_REQUEST['id'];
		
		$userdetails = Capsule::table('tblhosting')
			->join('tblclients', 'tblhosting.userid', '=', 'tblclients.id')
			->join('tblservers', 'tblservers.id', '=', 'tblhosting.server')
			->select('tblservers.type')
			->where('tblclients.id','=',$userid)
			->where('tblhosting.id','=',$hostingid)
			->get();	
				
		$serverType = $userdetails[0]->type;

		if($serverType == 'cpanel'){
			$Reset_host = $primarySidebar->getChild('Service Details Actions');
			if (!is_null($Reset_host)) {
				$Reset_host->addChild('Mailing List Subscription Prefs')
				->setLabel('Reset Host')
				->setName('Reset_Host')
				->setUri('modules/addons/server_custom_configs/reset_cpanel_host.php?hostId='.$hostingid)
				->setOrder(100);
				
				$footer = '<script type="text/javascript">
					document.getElementById("Primary_Sidebar-Service_Details_Actions-Reset_Host").onclick = function(){
						if (!confirm("آیا از ریست هاست خود اطمینان دارید؟!")) {
							return false;
						}
					}
					</script>';
					
				$ResetMessage = $_REQUEST['ResetMessage'];
				
				switch($ResetMessage){
					case 'successfull' :
						$footer .= '<div class="alert alert-success text-center">ریست هاست با موفقیت انجام شد. اطلاعات کاربری شما همان نام کاربری و رمز عبور قبلی است.</div>';
						break;
					case 'failed' :
						$footer .= '<div class="alert alert-danger text-center">ریست هاست با خطا مواجه شد !</div>';
						break;
					case 'removefailed' :
						$footer .= '<div class="alert alert-danger text-center">حذف اکانت کاربری با خطا مواجه شد !</div>';
						break;
					case 'getplanfailed' :
						$footer .= '<div class="alert alert-danger text-center">خطایی در دریافت اطلاعات پلن کاربر رخ داده است !</div>';
						break;
					case 'nouserdata' :
						$footer .= '<div class="alert alert-danger text-center">خطایی در بدست آوردن اطلاعات کاربر رخ داده است !</div>';
						break;
					case 'nouser' :
						$footer .= '<div class="alert alert-danger text-center">کاربری با این مشخصات یافت نشد !</div>';
						break;
					case 'getconfigfailed' :
						$footer .= '<div class="alert alert-danger text-center">دریافت تنظیمات ماژول با خطا مواجه شد !</div>';
						break;
				}
				
				$Reset_host->setFooterHtml($footer);
			}
		} else {
			// do nothing
		}
	} catch (\Exception $e) {
		echo "ClientAreaPrimarySidebar Hook Exception: {$e->getMessage()}";
	}

});

add_hook('AfterCronJob', 1, function($vars) {
    
	try{
		$hasTable = Capsule::schema()->hasTable('mod_server_custom_configs_log'); 
		
		if($hasTable){
			
			$ModuleConfigValues = Capsule::table('tbladdonmodules')
				->select('setting','value')
				->where('module','=','server_custom_configs')
				->get();

			foreach($ModuleConfigValues as $configKey => $configValue){
				if($configValue->setting == 'logmaximum'){
					$logmaximum = $configValue->value;
				}
			}
			
			$log_count = Capsule::table('mod_server_custom_configs_log')->count();
			if($log_count >= $logmaximum){
				Capsule::table('mod_server_custom_configs_log')->truncate();
			} else {
				//Do Nothing
			}

		} else {
			//Do Nothing
		}
	} catch (\Exception $e) {
		echo "AfterCronJob Hook Exception: {$e->getMessage()}";
	}
});

?>
