<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <title>Clover Picker - Menu</title>
<base target="cont">
</head>
<body TEXT="#CC0000" BGCOLOR="#FFFFFF" ALINK="#FF0099" VLINK="#003333">
<h4><center>Clover Picker</center></h4>
<font size="5">
<?php
    $dir = "./4chan";
    $files = scandir($dir);
    sort($files);
    $i=1;
    foreach($files as $file) {
        if($file != "." && $file != ".." && $file != "thread-ripper") {
            echo "<li><a href='$dir/$file'>/$file/</a></li>";
            $i++;
            if(!file_exists("$dir/$file/index.php")){
                copy("assets/index.txt", "$dir/$file/index.php");
                copy("assets/images.txt", "$dir/$file/images.php");
                copy("assets/download.txt", "$dir/$file/download.php");
            }
	   }
	}
    echo "<br/>";
?>
</font>
<a href="./thread-ripper">Thread Ripper</a>
</body>
</html>