<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <link rel="stylesheet" type="text/css" href="../../assets/style.css">
</head>
<body bgcolor="#000000">
<table width="600" align="center">
  	<tr>
	  <td>
		<div class="header" >
		  <h1>4chan Thread Archive</h1>
		</div>
	  </td>
	</tr>
	<tr>
	  <td>
		  <div class="body">
            <?php
              $cd = basename(__DIR__);
              echo "<h2>/$cd/ Threads</h2>";
                $dir = ".";
                $files = scandir($dir);
                sort($files);
                $i=1;
                foreach($files as $file) {
                    if($file != "." && $file != ".." && $file != "index.php") {
                        echo "<li><a href='$dir/$file/$file.html'>/$file/</a></li>";
                        $i++;
	               }
	           }
              echo "<br/>";
            ?>
		   </div>
		   </td>
  </tr>
	<tr>
		<td>
			<div class="footer">
			<p>Copyright © TheDerpySage 2018</p>
          </div>
  </tr>
</table>
</body>
</html>
