<?php
function iAmError($n) {
    return "<p>An Error Occured: $n</p><video width='500' autoplay loop><source src='../assets/jazz.webm' type='video/webm' autoplay='true'>Your shitty browser does not support Webms. Get a real browser you fucking nerd.</video>";
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
			    $dir = "$board";
			    $files = scandir($dir);
			    $temp = array_diff($files, [".", ".."]);
			    $files = array_values($temp);
			    sort($files);
			    $i=1;
			    echo "<table align='center' cellpadding='10'>";
			    foreach($files as $file) {
				/* Catch any zip files and delete them */
				if (explode(".", $file)[1] != "zip"){
				    /* Open New Entry */
				    echo "<tr>";
				    /* Get our JSON */
				    $us_json = json_decode(file_get_contents("$dir/$file/$file.json"), true);
				    /* Get a workable Title */
				    if ($us_json['posts'][0]['sub'] != '')
					$title = $us_json['posts'][0]['sub'];
				    else $title = $us_json['posts'][0]['semantic_url'];
				    /* Start forming the entry, include images and download links */
				    $temp = "<td>$title</td><td><a href='$dir/$file/$file.html'>/$file/</a></td><td><a href='images.php?method=all&board=$board&thread=$file'>Images</a></td><td><a href='download.php?board=$board&thread=$file'>ZIP</a></td>";
				    /* Check if thread has an Update, is Up to Date, or is Closed */
				    if (empty($us_json['posts'][0]['closed'])) {
					/* If not closed according to our JSON, get their JSON for comparisons */
					$them_json = json_decode(file_get_contents("http://a.4cdn.org/$dir/thread/$file.json"), true);
					/* If new replies exist according to their JSON OR they have a closed marker that we don't have, show Update button */
					if (($us_json['posts'][0]['replies'] < $them_json['posts'][0]['replies']) || (!empty($them_json['posts'][0]['closed']))) {
					    $temp .= "<td><a href='update.php?board=$board&thread=$file'>Update</a></td>";
					} else $temp .= "<td>Up To Date</td>";
				    } else $temp .= "<td>Closed</td>";
				    /* Enter Entry and Close */
				    echo $temp . "</tr>";
				} else unlink($file);
				$i++;
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
