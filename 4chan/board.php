<?php
function iAmError($n) {
    return "<h3>An Error Occured: $n</h3><video width='500' autoplay loop><source src='../assets/jazz.webm' type='video/webm' autoplay='true'>Your shitty browser does not support Webms. Get a real browser you fucking nerd.</video>";
}
function get_http_response_code($n) {
    $headers = get_headers($n);
    return substr($headers[0], 9, 3);
}

/* GET */
$board = isset($_GET['board']) ? $_GET['board'] : '';

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <link rel="stylesheet" type="text/css" href="../assets/style.css">
</head>
<body bgcolor="#000000">
<span class="main">
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
		    /* First we get a list of boards we have */
		    $dir = ".";
		    $files = scandir($dir);
		    $temp = array_diff($files, [".", ".."]);
		    $files = array_values($temp);
		    sort($files);
		    /* Make sure we were supplied a board */
		    if (!empty($board)){
				/* Make sure the supplied board matches one we have */
				if (array_search($board, $files) !== false){
					/* After successful validation, parse for threads and print the list */
					echo "<h2>/$board/ Threads</h2>";
					$dir = "$board/";
					$files = scandir($dir);
					$temp = array_diff($files, [".", ".."]);
					$files = array_values($temp);
					sort($files);
					echo "<table align='center' cellpadding='10'>";
					foreach($files as $file) {
						/* Catch any zip files and delete them */
						if (explode(".", $file)[1] != "zip"){
							/* Open New Entry */
							$temp = "<tr>";
							/* Get our JSON */
							$json = json_decode(file_get_contents("$dir/$file/$file.json"), true);
							/* Get a workable Title */
							if ($json['posts'][0]['sub'] != '')
								$title = $json['posts'][0]['sub'];
							else $title = $json['posts'][0]['semantic_url'];
							/* Form the entry */
							$temp .= "<td>$title</td><td><a href='$dir/$file/$file.html'>/$file/</a></td>";
							$temp .= "<td><a href='images.php?method=all&board=$board&thread=$file'>Images</a></td>";
							if (empty($json['posts'][0]['closed']))
								$temp .= "<td>Open</td>";
							else $temp .= "<td>Closed</td>";
							$temp .= "<td><a href='thread.php?board=$board&thread=$file'>Info</a></td>";						
							/* Close and enter in the entry */ 
							$temp .= "</tr>";
							echo $temp;
						} else unlink($file);
					}
					echo "</table><br/>";
				} else echo iAmError("Board does not exist in archive.");
			} else echo iAmError("Board not specified.");
		?>
	    </div>
	</td>
    </tr>
</table>
</span>
</body>
</html>
