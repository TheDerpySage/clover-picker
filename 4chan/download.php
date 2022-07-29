<?php
function iAmError($n)
{
	return "<h3>An Error Occured: $n</h3><video width='500' autoplay loop><source src='../assets/jazz.webm' type='video/webm' autoplay='true'>Your shitty browser does not support Webms. Get a real browser you fucking nerd.</video>";
}
function scandir2($n)
{
	return array_slice(scandir($n), 2);
}
function printThatArray($array)
{
	$temp = "";
	foreach ($array as $line) {
		$temp .= $line;
		$temp .= "<br/>";
	}
	return $temp;
}
function remove_old_files($dir, $seconds)
{
	foreach (scandir2($dir) as $file) {
		if ((time() - filectime("$dir/$file")) >= $seconds) {
			unlink("$dir/$file");
		}
	}
}

/* GET */
$board = isset($_GET['board']) ? $_GET['board'] : '';
$thread = isset($_GET['thread']) ? $_GET['thread'] : '';
$zip = isset($_GET['zip']) ? $_GET['zip'] : '';
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
				<div class='header'>
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
					if (!empty($board)) {
						$files = scandir2($board);
						sort($files);
						if (!empty($thread)) {
							/* Validate thread based on if it exists in this dir */
							if (array_search($thread, $files) !== false) {
								$files = scandir2("output");
								$file = "$thread.zip";
								/* If file exists, dont remake */
								if (array_search($file, $files)) {
									$result = 0;
								} else {
									exec("cd $board/$thread && zip -r ../../output/$file ./", $output, $result);
									$output = printThatArray($output);
								}
								/* As long as no error occured, serve */
								if ($result == 0) {
									echo "<h4><a href='board.php?board=$board'><--Back to /$board/---</a></h4>";
									echo "<h2><a href='output/$file'>Download $board/$thread.zip</a></h2>";
									echo "<h4><a href='thread.php?board=$board&thread=$thread'><--Back to /$thread/---</a></h4>";
									echo "<h4><a href='board.php?board=$board'><--Back to /$board/---</a></h4>";
								} else {
									echo iAmError("$output<br />Exit Code: $result");
								}
							} else echo iAmError("Thread does not exist in this boards archive.");
						} else echo iAmError("No Thread specified.");
					} else echo iAmError("No Board specified.");
					remove_old_files("output", 1800);
					?>
				</div>
			</td>
		</tr>
	</table>
</body>

</html>