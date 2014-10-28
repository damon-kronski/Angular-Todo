<?php

class AngularPhp{

	public function ArrayToJs2D($Array,$Name){
		$counter = 1;
		$max = count($Array);
		$result = "var ".$name." = {\n";
		
		foreach($Array as $key => $value)
		{
			$result .= $key.": '".$value."'";
		
			if($counter < $max)
				$result .= ",";
				
			$result .= "\n";	
				
			$counter++;
		}	
		
		$result .= "};\n";
		
		return $result;
	}
	
	public function ArrayToJs3DItem($Array,$Last){
		$counter = 1;
		$max = count($Array);
		$result = "{\n";
		
		foreach($Array as $key => $value)
		{
			$result .= $key.": '".$value."'";
		
			if($counter < $max)
				$result .= ",";
				
			$result .= "\n";	
				
			$counter++;
		}	
		
		$result .= "}";
		
		if(!$Last)
			$result .= ",";
			
		$result .= "\n";	
		
		return $result;
	}	

	public function ArrayToJs3D($Array,$Name){
		$counter = 1;
		$max = count($Array);
		$result = "var ".$Name." = [\n";
		
		foreach($Array as $item)
		{
			$result .= $this->ArrayToJs3DItem($item, $counter == $max);
			$counter++;
		}	
		
		$result .= "];";
		
		return $result;
	}}

?>
