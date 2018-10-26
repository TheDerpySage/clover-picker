<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <title>Clover Picker - Menu</title>
<base target="cont">
</head>
<body TEXT="#CC0000" BGCOLOR="#FFFFFF" ALINK="#FF0099" VLINK="#003333">
<h4><center><a href="index2.html">Clover Picker</a></center></h4>
<font size="5">
<?php
    $dir = "4chan";
    $files = scandir($dir);
    sort($files);
    $i=1;
    foreach($files as $file) {
        if($file != "." && $file != ".." && $file != "index.php" && $file != "board.php" && $file != "images.php" && $file != "download.php" && $file != "update.php") {
            echo "<li><a href='$dir/board.php?board=$file'>/$file/</a></li>";
            $i++;
	   }
	}
    echo "<br/>";
?>
</font>
<a href="./archiver.php">Thread Archiver</a>
</body>
</html>
