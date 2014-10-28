<?php

function lang($Key){
	GLOBAL $language;
	
	if(isset($language[$Key]))
		{
		$Value = $language[$Key];
		$Value = str_replace("ä", "&auml;",$Value);
		$Value = str_replace("ö", "&ouml;",$Value);
		$Value = str_replace("ü", "&uuml;",$Value);
		$Value = str_replace("Ä", "&Auml;",$Value);
		$Value = str_replace("Ö", "&Ouml;",$Value);
		$Value = str_replace("Ü", "&Uuml;",$Value);
		
		echo $Value;
		}		
	else
		echo "";
}

function getLangPath($Key){
	GLOBAL $config;
	
	if(isset($config['languages'][$Key]))
		if(file_exists("language/".$config['languages'][$Key].".php"))
			return "language/".$config['languages'][$Key].".php";
		else
			return "language/".$config['languages'][$config['default-language']].".php";
	else
		return "language/".$config['languages'][$config['default-language']].".php";
}
