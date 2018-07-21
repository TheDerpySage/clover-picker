<?php
function printThatArray($array){
    foreach($array as $line){
	$temp .= $line;
	$temp .= "<br/>";
    }
    return $temp;
}

/* POST */
if (isset($_POST['submit'])){
    $method = isset($_POST['method']) ? $_POST['method'] : '';
    $thread = isset($_POST['thread']) ? $_POST['thread'] : '';
}
?>
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
		<h1>Clover Picker</h1>
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
		    if (!isset($_POST['submit'])){
			$files = scandir($dir);
			$temp = array_diff($files, [".", "..", "download.php", "index.php", "images.php", "update.php"]);
			$files = array_values($temp);
			sort($files);
			$i=1;
			echo "<table align='center' cellpadding='10'>";
			foreach($files as $file) {
			    /* Catch any zip files and unlink them */
			    if (explode(".", $file)[1] != "zip"){
				echo "<tr>";
				$json = json_decode(file_get_contents("$dir/$file/$file.json"), true);
				if ($json['posts'][0]['sub'] != '')
				    $title = $json['posts'][0]['sub'];
				else $title = $json['posts'][0]['semantic_url'];
				if (empty($json['posts'][0]['closed']))
				    echo "<td><form action='' method='post'>$title</td><td><a href='$dir/$file/$file.html'>/$file/</a></td><td><a href='images.php?method=all&thread=$file'>Images</a></td><td><a href='download.php?thread=$file'>ZIP</a></td><td><input type='submit' name='submit' value='Update'><input type='hidden' name='thread' value='$file'></form></td>";
				else echo "<td><form action='' method='post'>$title</td><td><a href='$dir/$file/$file.html'>/$file/</a></td><td><a href='images.php?method=all&thread=$file'>Images</a></td><td><a href='download.php?thread=$file'>ZIP</a></td><td>Closed</form></td>";
				echo "</tr>";
			    } else unlink($file);
			    $i++;
			}
			echo "</table><br/>";
		    } else {
			$thread = escapeshellcmd($thread);
			$command = "/usr/bin/thread-archiver --silent --runonce --path=../../ https://boards.4chan.org/$cd/thread/$thread/";
			exec($command, $output, $result);
			$output = printThatArray($output);
			if ($result != '0'){
			    echo "<p>An Error Occured.</p><p>Exit Code: $result</p><p>$output</p><p><a href='./'>Refreshing in 5 Seconds...</a></p>";
			    header('Refresh: 5; URL=./');
			} else {
			    reset($output);
			    $lineOne = next($output);
			    $lineTwo = next($output);
			    $lineFour = end($output);
			    prev($output);
			    $lineThree = prev($output);
			    echo "<p>Thread: /$thread/</p><p>$output</p><p><a href='./'>Refreshing in 5 Seconds...</a></p>";
			    header('Refresh: 5; URL=./');
			}
		    }
		?>
	    </div>
	</td>
    </tr>
</table>
</body>
</html>
