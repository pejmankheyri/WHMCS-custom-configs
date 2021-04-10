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

use WHMCS\Database\Capsule as Capsule;

function insert_log($title,$description,$userid,$userdomain){
	try{
		date_default_timezone_set('Asia/Tehran');
		$insert_log = Capsule::table('mod_server_custom_configs_log')->insert([
				'log_title' => $title,
				'log_description' => $description,
				'user_id' => $userid,
				'user_domain' => $userdomain,
				'ip_address' => $_SERVER['REMOTE_ADDR'],
				'is_read' => 0,
				'created_at' => date("Y-m-d H:i:s"),
		]);	
		
		return $insert_log;
	} catch (\Exception $e) {
		echo "Insert Log Try Exception: {$e->getMessage()}";
	}
}

function WHM_Request($type,$whmusername,$hash,$serverIp,$port,$apiType,$apiQuery) {
	
	try{
		$query = $serverIp.":".$port."/".$apiType."/".$apiQuery;

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);

		$header[0] = "Authorization: WHM $whmusername:" . preg_replace("'(\r|\n)'","",$hash);
		curl_setopt($curl,CURLOPT_HTTPHEADER,$header);
		curl_setopt($curl, CURLOPT_URL, $query);

		$result = curl_exec($curl);

		if ($result == false) {
			error_log("curl_exec threw error \"" . curl_error($curl) . "\" for $query");
		}

		curl_close($curl);
		
		logModuleCall('server_custom_configs', $type, $query, $result, $processedData, $replaceVars);
		return json_decode($result);
	} catch (\Exception $e) {
		echo "WHM Request Try Exception: {$e->getMessage()}";
	}
}

function Send_Welcome_Email($hostingid){
	$command = 'SendEmail';
	$postData = array(
		// '//example1' => 'example',
		'messagename' => 'Hosting Account Welcome Email',
		'id' => $hostingid,
		// '//example2' => 'example',
		// 'customtype' => 'product',
		// 'customsubject' => 'Product Welcome Email',
		// 'custommessage' => '<p>Thank you for choosing us</p><p>Your custom is appreciated</p><p>{$custommerge}<br />{$custommerge2}</p>',
		// 'customvars' => base64_encode(serialize(array("custommerge"=>$populatedvar1, "custommerge2"=>$populatedvar2))),
	);

	$results = localAPI($command, $postData, $adminUsername);
	return $results;
}

?>