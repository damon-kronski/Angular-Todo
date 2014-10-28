<?php 

/***************************************************/
/****************** Main Settings ******************/
/***************************************************/

// Base path
$config['base_path'] = "http://localhost/angular.V3/";
	
// Default Items for empty database
$config['defaultArray'] = array(array('id' => 1,'title' => 'These is a sample todo','text' => 'With some description','date' => '01/01/2014'),array('id' => 2,'title' => 'And thats the other one','text' => '','date' => '01/01/2014'));



/***************************************************/
/************* Security & DB Settings **************/
/***************************************************/

// Use Login?
$config['useLogin'] = false;

// SHA-256 encrypted password
$config['loginKey'] = "937e8d5fbb48bd4949536cd65b8d35c426b80d2f830c5c308e2cdec422ae2244";

// Store ToDo-List in Cookies? (else in json File on Server)
$config['useCookies'] = true;
	
// Path to json file on server
$config['jsonDBPath'] = "data/db.json";



/***************************************************/
/**************** Language Settings ****************/
/***************************************************/
	
// Default language code
$config['languages'] = array("en" => "english","de" => "deutsch");
	
// Default language code
$config['default-language'] = "en";

?>
