<?php
function scandir2($n)
{
    return array_slice(scandir($n), 2);
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <link rel="stylesheet" type="text/css" href="assets/style.css">
    <title>Clover Picker - Menu</title>
    <base target="cont">
</head>

<body TEXT="#CC0000" BGCOLOR="#FFFFFF" ALINK="#FF0099" VLINK="#003333">
    <h2><a href="index2.html">Clover Picker</a></h2>
    <span class="sidenav">
        <?php
        $dir = "4chan";
        $files = scandir2($dir);
        sort($files);
        foreach ($files as $file) {
            if (is_dir("$dir/$file") && $file != "output") {
                echo "<li><a href='$dir/board.php?board=$file'>/$file/</a></li>";
            }
        }
        echo "<br/>";
        ?>
        <a href="./archiver.php">Thread Archiver</a><br /><br />
        <a href="./about.html">About</a>
    </span>

</body>

</html>