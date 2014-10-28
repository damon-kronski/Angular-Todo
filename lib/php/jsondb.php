<?php

include("config/config.php");

function delItem($id){
	$db = readDB();
	$dbnew = rmArray($db,$id);
	writeDB($dbnew);
}

function addItem($item){
	$db = readDB();
	$item['id'] = getNewId($db);
	$dbnew = addArray($db,$item);
	writeDB($dbnew);
	return $item['id'];
}

function setItem($id,$value){
	$db = readDB();
	$dbnew = setArray($db,$id,$value);
	writeDB($dbnew);
}

function writeDB($array){
	global $config;
	if($config['useCookies'])
		setcookie("TodoDB",json_encode($array));
	else{
		$fh = fopen($config['jsonDBPath'], 'w+');
		fwrite($fh, json_encode($array));
		fclose($fh);
	}
}

function readDB(){
	global $config;
	if($config['useCookies']){
		if(isset($_COOKIE["TodoDB"]))
			return json_decode($_COOKIE["TodoDB"], true);
		else {
			writeDB($config['defaultArray']);
			return json_decode($config['defaultArray'], true);
		}
	}else{
		if(!file_exists($config['jsonDBPath']))
			writeDB($config['defaultArray']);
			
		$fh = fopen($config['jsonDBPath'], 'r');
		$json = fread($fh, filesize("data/db.json"));
		fclose($fh);
		return json_decode($json, true);
	}
	
}

function rmArray($array, $id){
	foreach ($array as $key => $value) {
		foreach ($value as $ckey => $cvalue) {
			if ($ckey == 'id' AND $cvalue == $id) {
				unset($array[$key]);
				continue 2;
			}
		}
	}
	
	return $array;
}

function addArray($array, $value){
	$array[] = $value;
	return $array;
}

function setArray($array, $id,$item){
	foreach ($array as $key => $value) {
		foreach ($value as $ckey => $cvalue) {
			if ($ckey == 'id' AND $cvalue == $id) {
				foreach($item as $ikey => $ivalue){
					$array[$key][$ikey] = $ivalue;
				}
			}
		}
	}
	
	return $array;
}

function getNewId($db){
	if(count($db) >= 1){
		return end($db)['id'] + 1;
	}else
	{
		return 1;
	}
}

?>
