<?php

include "lib/php/jsondb.php";
include "config/config.php";

session_start();

if(!$config['useLogin'])
		$_SESSION['loggedin'] = true;
		
if(isset($_GET['action']))
{
	switch($_GET['action']){
		case "add":
			if($_SESSION['loggedin'] == true)
				add();
			break;
		case "delete":
			if($_SESSION['loggedin'] == true)
				delete();
			break;
		case "save":
			if($_SESSION['loggedin'] == true)
				save();
			break;
		case "security":
			security();
			break;
		case "logout":
			logout();
			break;
	}
}

function add(){
	$id = addItem(array(
		'title' => $_GET['title'], 
		'text' => $_GET['text'],
		'date' => $_GET['date']
		)); 
		
	echo $id;	
}

function save(){
	setItem( $_GET['id'], 
		array(
		'title' => $_GET['title'], 
		'text' => $_GET['text'],
		'date' => $_GET['date']
		)); 
}

function delete(){
	delItem($_GET['id']); 
}

function security(){
	if($config['loginKey'] == $_GET['passwd'])
	{
		echo "true";
		$_SESSION['loggedin'] = true;
	}
	else
	{
		echo "false";
		$_SESSION['loggedin'] = false;
	}
}

function logout(){
session_destroy();
}

?>
