<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <title>Clover Picker - Menu</title>
</head>
<body TEXT="#CC0000" BGCOLOR="#FFFFFF" ALINK="#FF0099" VLINK="#003333">
<center>
<h4>Clover Picker</h4>
<font size="5">
<?php
    $dir = ".";
    $files = scandir($dir);
    sort($files);
    $i=1;
    foreach($files as $file) {
        if($file != "." && $file != ".." && $file != "index.php" && $file != "board.php") {
            echo "<li><a href='board.php?board=$file'>/$file/</a></li>";
            $i++;
	   }
	}
    echo "<br/>";
?>
</font>
<a href="../thread-ripper">Thread Ripper</a>
</center>
</body>
</html>