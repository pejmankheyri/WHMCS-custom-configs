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

use Illuminate\Database\Capsule\Manager as Capsule;

function server_custom_configs_config() {
	$configarray = array(
		'name' => 'Server Custom Configs', 
		'version' => '1.0.1', 
		'author' => 'pejman kheyri', 
		'description' => 'Server Custom Configs Like Reset Hosts', 
		'language' => 'farsi',  		
		"fields" => array(
			"whmusername" => array (
				"FriendlyName" => "WHM UserName", 
				"Type" => "text", 
				"Size" => "25", 
				"Default" => "root"
			),
			"logmaximum" => array (
				"FriendlyName" => "Log Table Maximum Rows", 
				"Type" => "text", 
				"Size" => "25", 
				"Default" => "5000"
			)
		)
	); 
	return $configarray; 
} 

function server_custom_configs_activate() {
	
	try {
		
		$create_log = "CREATE TABLE IF NOT EXISTS `mod_server_custom_configs_log` (`id` INT(11) NOT NULL AUTO_INCREMENT,`log_title` varchar(128) NOT NULL,`log_description` text NOT NULL,`user_id` int(11) NOT NULL,`user_domain` varchar(128) NOT NULL,`ip_address` varchar(64) NOT NULL,`is_read` int(11) NOT NULL,`created_at` timestamp NOT NULL,PRIMARY KEY (`id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
		$setting_log = full_query($create_log);
	
		$create_setting = "CREATE TABLE IF NOT EXISTS `mod_server_custom_configs_setting` (`id` INT(11) NOT NULL AUTO_INCREMENT,`server_id` int(11) NOT NULL,`server_hash` varchar(128) NOT NULL,`is_active` int(11) NOT NULL,PRIMARY KEY (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
		$setting_result = full_query($create_setting);

	} catch (\Exception $e) {
		echo "Unable to create mod_server_custom_configs Tables: {$e->getMessage()}";
	}
} 

function server_custom_configs_deactivate() {

	// $query = "DROP TABLE `mod_server_custom_configs_log`";
	// $result = full_query($query);
} 

function server_custom_configs_output($vars) {	
	try {
		$modulelink = $vars['modulelink']; 
		$mess = $_GET['mess'];
		
		if($mess == "InsertDone"){
			echo server_custom_configs_insert_success_mess();
		}

		$tab = $_GET['tab'];
		echo '
		<style type="text/css">
			#a_tab{
				background-color: #1A4D80;
				color: #ffffff;
			}
		</style> 
		<ul class="nav nav-tabs client-tabs" style="direction: rtl;float: right;">
			<li class="tab"><a class="clientTab-2" ' . (($tab == "logs") ? "id='a_tab'" : "") . '" href="addonmodules.php?module=server_custom_configs&amp;tab=logs">logs</a></li>
			<li class="tab"><a class="clientTab-1" ' . ((($tab == "settings") || ($tab == "")) ? "id='a_tab'" : "") . '" href="addonmodules.php?module=server_custom_configs&tab=settings">settings</a></li>
		</ul>
		<div class="clear"></div>';
		
		if (!isset($tab) || $tab == "settings") {
			
			if (!empty($_GET['deleteserver'])) {
				$serverid = (int)$_GET['deleteserver'];
				$deleteserver = Capsule::table('mod_server_custom_configs_setting')->where('id', '=', $serverid)->delete();
			}

			if($_POST['server_id'] && $_POST['cpanel_hash']){
				
				$getserver = Capsule::table('mod_server_custom_configs_setting')
					->select('mod_server_custom_configs_setting.server_id')
					->where('mod_server_custom_configs_setting.server_id','=',$_POST['server_id'])
					->get();
				
				if(empty($getserver)){
					$insert = Capsule::table('mod_server_custom_configs_setting')->insert([
						'server_id' => $_POST['server_id'], 
						'server_hash' => $_POST['cpanel_hash'],
						'is_active' => 1
					]);
					if($insert){
						header("Location: $modulelink&mess=InsertDone");
						exit;					
					} else {
						echo server_custom_configs_insert_failed_mess();
					}				
				} else {
					echo server_custom_configs_duplicate_failed_mess();
				}				
			}
			
			$servers = Capsule::table('tblservers')
				->select('tblservers.id','tblservers.hostname','tblservers.secure','tblservers.type')
				->where('tblservers.type','=','cpanel')
				->get();

			foreach($servers as $serversVal){
				$server_name .= '<option value="' . $serversVal->id . '">' . $serversVal->hostname . '</option>';
			}
			
			echo '<div style="direction:rtl;text-align: right;background-color: whiteSmoke;margin: 0px;padding: 10px;">
			<form action="" method="post" id="form">
					<label for="server_id">Server Name : </label>
			        <select required name="server_id" id="server_id">
						<option></option>
                        ' . $server_name . '
                    </select>
					<br>
					<label for="cpanel_hash">Hash : </label>
					<input required type="text" name="cpanel_hash" id="cpanel_hash" size="30"/>
					<br>
					<input class="btn btn-primary" type="submit" value="save" class="button" />
				</form></div>';
				
			echo '
			<!--<script src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
			<link rel="stylesheet" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css" type="text/css">
			<link rel="stylesheet" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables_themeroller.css" type="text/css">
			<script type="text/javascript">
				$(document).ready(function(){
					$(".datatable").dataTable();
				});
			</script>-->

			<div style="text-align: center;background-color: whiteSmoke;margin: 0px;padding: 10px;">
			<table dir="rtl" class="datatable" border="0" cellspacing="1" cellpadding="3" width="100%">
			<thead>
				<tr>
					<th>#</th>
					<th>server</th>
					<th>hash</th>
					<th>isActive</th>
					<th></th>
				</tr>
			</thead>
			<tbody>';

			$servers = Capsule::table('mod_server_custom_configs_setting')
				->join('tblservers', 'tblservers.id', '=', 'mod_server_custom_configs_setting.server_id')
				->select('mod_server_custom_configs_setting.server_hash','tblservers.hostname','mod_server_custom_configs_setting.is_active','mod_server_custom_configs_setting.id')
				->get();
				
			$i = 0;
			foreach($servers as $serverkey => $servervalue){
				$i++;
				echo '<tr>
				<td>' . $i . '</td>
				<td>' . $servervalue->hostname . '</td>
				<td>' . $servervalue->server_hash . '</td>
				<td>' . $servervalue->is_active . '</td>
				<td><a class="btn btn-primary confirmation" href="addonmodules.php?module=server_custom_configs&tab=settings&deleteserver=' . $servervalue->id . '" title="delete">delete</a></td></tr>';
			}				
			
			echo '
			</tbody>
			</table>
			<script type="text/javascript">
				$(".confirmation").on("click", function () {
					return confirm("Are You Sure ?");
				});			
			</script>
			</div>';

		} elseif ($tab == "logs") {
			echo '
			<!--<script src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
			<link rel="stylesheet" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css" type="text/css">
			<link rel="stylesheet" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables_themeroller.css" type="text/css">
			<script type="text/javascript">
				$(document).ready(function(){
					$(".datatable").dataTable();
				});
			</script>-->

			<div style="text-align: center;background-color: whiteSmoke;margin: 0px;padding: 10px;">
			<table dir="rtl" class="datatable" border="0" cellspacing="1" cellpadding="3" width="100%">
			<thead>
				<tr>
					<th>#</th>
					<th>user</th>
					<th>title</th>
					<th>description</th>
					<th>domain</th>
					<th>ip</th>
					<th>date</th>
				</tr>
			</thead>
			<tbody>
			';
			
			// Getting pagination values.
			$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
			$limit = (isset($_GET['limit']) && $_GET['limit'] <= 50) ? (int)$_GET['limit'] : 10;
			$start = ($page > 1) ? ($page * $limit) - $limit : 0;
			$order = isset($_GET['order']) ? $_GET['order'] : 'DESC';

			$logs = Capsule::table('mod_server_custom_configs_log')
				->join('tblclients', 'tblclients.id', '=', 'mod_server_custom_configs_log.user_id')
				->select('mod_server_custom_configs_log.log_title','mod_server_custom_configs_log.user_id','mod_server_custom_configs_log.log_description','mod_server_custom_configs_log.user_domain','mod_server_custom_configs_log.ip_address','mod_server_custom_configs_log.created_at','tblclients.email')
				->orderBy('created_at', $order)
				->offset($start)
				->limit($limit)
				->get();
				
			
			if($page && $limit){
				$i = ($page-1) * $limit;
			} else {
				$i = 0;
			}

			$count = Capsule::table('mod_server_custom_configs_log')->count();

			//Page calculation
			$Spage = ceil($count / $limit);
			
			foreach($logs as $logskey => $logsvalue){
				$i++;
				echo '<tr>
				<td>' . $i . '</td>
				<td><a href="clientssummary.php?userid='.$logsvalue->user_id.'" target="_blank">' . $logsvalue->email . '</a></td>
				<td>' . $logsvalue->log_title . '</td>
				<td>' . $logsvalue->log_description . '</td>
				<td>' . $logsvalue->user_domain . '</td>
				<td>' . $logsvalue->ip_address . '</td>
				<td>' . $logsvalue->created_at . '</td>
				</tr>';
			}				

			echo '
			</tbody>
			</table>';
			$list = "";
			for ($a = 1; $a <= $Spage; $a++) {
				$selected = ($page == $a) ? 'selected="selected"' : '';
				$list .= "<option value='addonmodules.php?module=server_custom_configs&tab=logs&page={$a}&limit={$limit}&order={$order}' {$selected}>{$a}</option>";
			}
			echo "<select  onchange=\"this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);\">{$list}</select>
			total : " .$count."</div>";
		}
	} catch (\Exception $e) {
		echo "Unable to load log data`s: {$e->getMessage()}";
	}
}

function server_custom_configs_insert_success_mess(){
	echo '<div class="successbox">
		<strong>
		<span class="title">Success</span>
		</strong><br>Server Hash Code Saved Successfully</div>';
}

function server_custom_configs_insert_failed_mess(){
	echo '<div class="errorbox">
		<strong>
		<span class="title">Error</span>
		</strong><br>Error Insert Setting</div>';
}

function server_custom_configs_duplicate_failed_mess(){
	echo '<div class="errorbox">
		<strong>
		<span class="title">Error</span>
		</strong><br>Error Duplicate Servers For Setting</div>';
}

?>