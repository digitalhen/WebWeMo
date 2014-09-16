<?php
error_reporting(1);
//$max_age = 30;     /* 30 second cache */

// TODO: Remove this before production
@header("Access-Control-Allow-Origin: *");

//@header( 'Content-type: application/json' );
//@header( 'Cache-Control: max-age=' . $max_age );
//@header( 'Expires: ' . gmdate( 'D, d M Y H:i:s', time() + $max_age ) . ' GMT' );


require_once 'libs/JSON.php';
require_once 'libs/WeMo-PHP-Toolkit-master/models/Device.php';
require_once 'libs/WeMo-PHP-Toolkit-master/models/Outlet.php';


$whichFunction =  $_GET["f"];
$whichSwitch = $_GET["switch"];



if($whichFunction == 'fetchState'){
	$call = json_encode(fetchState($whichSwitch));
} else if($whichFunction == 'fetchSwitchList') {
	$call = json_encode(fetchSwitchList());
} else if($whichFunction == 'toggleSwitch') {
	$call = json_encode(toggleSwitch($whichSwitch));
}
/*else if($whichFunction == 'grabMedia'){
	$call = json_encode(grabMedia($whichSlug));
}*/

function fetchState($theSwitch) {
	$switchData = file_get_contents('data/switches.json');
	$switchData = json_decode($switchData);

	$the_data = array();

	foreach($switchData as $switches) {
		foreach($switches as $switch) {
			//$the_data = array(
			//	'id' => $switch['id']
			//);
			if($switch->id == $theSwitch) {
				$outlet = new \wemo\models\Outlet($switch->ipaddress, $switch->port);

				$iconUrl = $switch->iconUrl;
				$state = $outlet->getIsOn();

				array_push($the_data, array( 
					'id' => $switch->id,
					'iconurl' => $iconUrl,
					'state' => $state			
				));
			}
		}
	}

	return $the_data;


	//return $the_data;
	//return "test";
	//$outlet = new \wemo\models\Outlet("192.168.1.186");
	//return $outlet->getName();

}

function fetchSwitchList() {
	$switchData = file_get_contents('data/switches.json');
	$switchData = json_decode($switchData);

	$the_data = array();

	foreach($switchData as $switches) {
		foreach($switches as $switch) {
			//$the_data = array(
			//	'id' => $switch['id']
			//);

			$outlet = new \wemo\models\Outlet($switch->ipaddress, $switch->port);
			$iconUrl = $switch->iconUrl;
			$state = $outlet->getIsOn();
			
			array_push($the_data, array( 
				'id' => $switch->id,
				'iconurl' => $iconUrl,
				'state' => $state			
			));


		}
	}




	return $the_data;
}

function toggleSwitch($theSwitch) {
	$switchData = file_get_contents('data/switches.json');
	$switchData = json_decode($switchData);

	$the_data = array();

	foreach($switchData as $switches) {
		foreach($switches as $switch) {
			//$the_data = array(
			//	'id' => $switch['id']
			//);
			if($switch->id == $theSwitch) {
				$outlet = new \wemo\models\Outlet($switch->ipaddress, $switch->port);
				$state = $outlet->getIsOn();

				if($state) {
					$outlet->setIsOn(false);
				} else {
					$outlet->setIsOn(true);
				}

				$iconUrl = $switch->iconUrl;
				$state = $outlet->getIsOn();

				array_push($the_data, array( 
					'id' => $switch->id,
					'iconurl' => $iconUrl,
					'state' => $state			
				));
			}
		}
	}

	return $the_data;
}

/*
function fetchSettings($theSlug) {
	$the_data = array();

	$theTable = 'ImageGrid_settings';
	$settingsQuery = "SELECT * FROM `".$theTable."` WHERE `slug`='".$theSlug."'";
	$settingsResult = mysql_query($settingsQuery);
	while($row = mysql_fetch_assoc($settingsResult)) { // while is probably not required
		$the_data = array( 
				'id' => $row['id'],
				'visibility' => $row['visibility'],
				'sort' => $row['sort'],
				'updated' => $row['updated'],
				'slug' => $row['slug'],
				'hed' => $row['hed'],
				'dek' => $row['dek'],
				'filters' => $row['filters'],
				'promoURL' => $row['promoURL'],
				'socialTag' => $row['socialTag'],
				'creditKey' => $row['creditKey'],
				'creditList' => $row['creditList']
			);

			error_log($row['slug']);
	}

	return $the_data;
}
*/

echo $call;


?>