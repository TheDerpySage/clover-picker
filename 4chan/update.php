<?php
function iAmError($n) {
    return "<h3>An Error Occured: $n</h3><video width='500' autoplay loop><source src='../assets/jazz.webm' type='video/webm' autoplay='true'>Your shitty browser does not support Webms. Get a real browser you fucking nerd.</video>";
}
function printThatArray($array){
    foreach($array as $line){
	$temp .= $line;
	$temp .= "<br/>";
    }
    return $temp;
}

/* GET */
$board = isset($_GET['board']) ? $_GET['board'] : '';
$thread = isset($_GET['thread']) ? $_GET['thread'] : '';
?>
<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'>
<html lang='en'>
<head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
    <meta http-equiv='Cache-Control' content='no-cache, no-store, must-revalidate' />
    <link rel='stylesheet' type='text/css' href='../assets/style.css'>
</head>
<body bgcolor='#000000'>
    <table width='600' align='center'>
	<tr>
	    <td>
		<div class='header' >
		    <h1>Clover Picker</h1>
		</div>
	    </td>
	</tr>
	<tr>
	    <td>
		<div class='body'>
<?php
  $board = escapeshellcmd("$board");
  $thread = escapeshellcmd("$thread");
  if (!empty($board)){
    $files = scandir($board);
    $temp = array_diff($files, [".", ".."]);
    $files = array_values($temp);
    sort($files);
    echo "<h4><a href='board.php?board=$board'><--Back to /$board/---</a></h4>";
    if (!empty($thread)){
    /* Validate thread based on if it exists in this dir */
      if (array_search($thread, $files) !== false){
        $command = "thread-archiver --silent --runonce --path=../ https://boards.4chan.org/$board/thread/$thread";
        exec($command, $output, $result);
        $output = printThatArray($output);
        echo "<h5>Thread: $thread</h5>";
        if ($result != '0'){
          echo "<h5>An Error Occured.</h5><h5>$output</h5><h5>Exit Code: $result</h5><h5><a href='thread.php?board=$board&thread=$thread'>Refreshing in 10 Seconds...</a></h5>";
          header("Refresh: 10; URL=thread.php?board=$board&thread=$thread");
        } else {
          echo "<h5>Executed Successfully.</h5><h5>$output</h5><h5><a href='thread.php?board=$board&thread=$thread'>Refreshing in 10 Seconds...</a></h5>";
          header("Refresh: 10; URL=thread.php?board=$board&thread=$thread");
        }
      } else echo iAmError("Thread does not exist in this boards archive.");
    } else echo iAmError("No Thread specified.");
   } else echo iAmError("No Board specified.");
?>
</div>
  </td>
</tr>
</table>
</body>
</html>
