<?php
function printThatArray($array){
    foreach($array as $line){
	$temp .= $line;
	$temp .= "<br/>";
    }
    return $temp;
}

/* POST */
if (isset($_POST['update'])){
    $thread = isset($_POST['thread']) ? $_POST['thread'] : '';
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <link rel="stylesheet" type="text/css" href="assets/style.css">
</head>
<body bgcolor="#000000">
    <table width="600" align="center">
	<tr>
	    <td>
		<div class="header" >
		    <h1>Clover Picker - Archiver</h1>
		</div>
	    </td>
	</tr>
	<tr>
	    <td>
		<div class="body">
			<?php if (empty($thread)) { ?>
        	<h5>Threads entered here will be added to the site</h5>
		    <h5>Enter Thread</h5>
		    <form action="" method="post">
			<input type="text" name="thread" placeholder="Thread URL" size="50" required="yes"><br/><br/>
			<input class="text" type="submit" name="update" value="Add to Archive" onClick='document.getElementById("text").style.display="initial";'><br/><br/>
			<span style="display:none;" id="text">LOADING... PLEASE WAIT...</span>
		    </form>
		    <?php
				} else {
					$scrub_thread = escapeshellcmd($thread);
					$command = "thread-archiver --silent --runonce --path=./ $scrub_thread";
					exec($command, $output, $result);
					$output = printThatArray($output);
					echo "<h5>Thread: $thread</h5>";
					if ($result != '0'){
						echo "<h5>An Error Occured.</h5><h5>$output</h5><h5>Exit Code: $result</h5><h5><a href='./archiver.php'>Refreshing in 10 Seconds...</a></h5>";
						header('Refresh: 10; URL=./archiver.php');
					} else {
						echo "<h5>Executed Successfully.</h5><h5>$output</h5><h5><a href='./archiver.php'>Refreshing in 10 Seconds...</a></h5>";
						header('Refresh: 10; URL=./archiver.php');
					}
				}
		    ?>
		</div>
	    </td>
	</tr>
    </table>
</body>
</html>
