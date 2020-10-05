
<?php
	//echo "---AUTH---";
	
	$passes = array("go");
	
	function update($pass) {
	    return $pass.date("H");		    
	}
	$passes = array_map("update", $passes);

	
	if(!isset($_COOKIE['pass'])) {
		foreach(getallheaders() as $name => $value) {	
			if($name=='Pass') {
				$pass=$value;
				if (!in_array(strtolower($pass), $passes)) {	
					$error = '500 Forbidden';
					exit($error);
				}
			}
		}
	}
	
	//echo "---END AUTH---";
?> 

