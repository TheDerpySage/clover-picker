<?php
function iAmError($n) {
    return "<p>An Error Occured: $n</p><video width='500' autoplay loop><source src='../../assets/jazz.webm' type='video/webm' autoplay='true'>Your shitty browser does not support Webms. Get a real browser you fucking nerd.</video>";
}

/* GET */
$method = isset($_GET['method']) ? $_GET['method'] : '';
$board = isset($_GET['board']) ? $_GET['board'] : ''
$thread = isset($_GET['thread']) ? $_GET['thread'] : '';
$selection = isset($_GET['file']) ? $_GET['file'] : '';
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
		    $thread = escapeshellcmd($thread);
		    echo "<h2>/$thread/ Images</h2>";
		    echo "<h4><a href='index.php'><--Back to /$cd/---</a></h4>";
		    if (!empty($thread)){
			if ($method == 'all'){
			    $dir = ".";
			    $files = scandir($dir);
			    $temp = array_diff($files, [".", "..","index.php","images.php","update.php"]);
			    $files = array_values($temp);
			    sort($files);
			    /* Validate thread based on if it exists in this dir */
			    if (array_search($thread, $files) !== false){
				/* Print all thumbnail linking them to their images for this thread */
				$dir = "$thread/images";
				$files = scandir($dir);
				sort($files);
				$i=0;
				echo "<table><tr>";
				foreach($files as $file) {
				    if ($file != '.' && $file != '..'){
					$temp = strstr($file, '.', true);
					$thumb = "$thread/thumbs/$temp" . "s.jpg";
					echo "<td><a href='images.php?method=single&thread=$thread&file=$file'><image src='$thumb'><br/>$file</a></td>";
					$i++;
					if (($i % 5) == 0)
					    echo "</tr><tr>";
				    }
				}
				echo "</tr></table>";
			    } else echo iAmError("Given Thread does not exist in the archive.");
			} elseif ($method == 'single'){
			    if(!empty($selection)){
				$dir = ".";
				$files = scandir($dir);
				$temp = array_diff($files, [".", "..","index.php","images.php","update.php"]);
				$files = array_values($temp);
				sort($files);
				/* Validate thread based on if it exists in this dir */
				if (array_search($thread, $files) !== false){
				    $dir = "$thread/images";
				    $files = scandir($dir);
				    sort($files);
				    if (array_search($selection, $files) !== false){
					$ext = explode(".", $selection);
					if ($ext[1] == "webm"){
					    echo "<p><a href='images.php?method=all&thread=$thread'><-Back to /$thread/--</a></p><a href='$thread/images/$selection' target='_blank'><video controls autoplay><source src='$thread/images/$selection' type='video/webm'></video><br/>$selection</a>";
					} else echo "<p><a href='images.php?method=all&thread=$thread'><-Back to /$thread/--</a></p><a href='$thread/images/$selection' target='_blank'><image src='$thread/images/$selection'><br/>$selection</a>";
				    } else echo iAmError("Given File does not exist in this thread.");
				} else echo iAmError("Given Thread does not exist in the archive.");
			    } else echo iAmError("No File specified");
			} else echo iAmError("Incorrect Method.");
		    } else echo iAmError("No Thread specified.");
		    echo "<h4><a href='index.php'><--Back to /$cd/---</a></h4>";
		?>
		</div>
	    </td>
	</tr>
    </table>
</body>
</html>
