<?php

$file = "default.png";

$types = explode(",","dry,ice,jungle,normal,water,desert");
foreach($types as $type){
	for($one = 0; $one <= 1; $one++){
	for($two = 0; $two <= 1; $two++){
	for($three = 0; $three <= 1; $three++){
	for($four = 0; $four <= 1; $four++){

		$ext = '';
		if($one == 1){ $ext .= "_1"; }
		if($two == 1){ $ext .= "_2"; }
		if($three == 1){ $ext .= "_3"; }
		if($four == 1){ $ext .= "_4"; }

		copy($file, $type.$ext.".png");

	}
	}
	}
	}
}

echo "Done";

?>

