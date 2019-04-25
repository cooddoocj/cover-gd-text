<?php


$files = glob('images/covers/*');
foreach ($files as $file) {
	$size = round(filesize($file)/256)/4;
	if ( file_exists($file) && $size > 200 ) {
		echo "<p>$file - $size KB</p>";
	}
}

?>