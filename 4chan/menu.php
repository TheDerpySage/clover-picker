<?php
    echo "<h4>Clover Picker</h4>";
    $dir = ".";
    $files = scandir($dir);
    sort($files);
    $i=1;
    foreach($files as $file) {
	if($file != "." && $file != ".." && $file != "index.php" && $file != "board.php" && $file != "menu.php" && $file != "images.php") {
	    echo "<li><a href='$dir/board.php?board=$file'>/$file/</a></li>";
	    $i++;
	}
    }
    echo "<p><a href='../ripper.php'>Thread Ripper</a></p>";
    echo "<p><a href='../frameset/'>Frames Version</a></p>";
?>