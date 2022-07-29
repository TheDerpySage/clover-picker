<?php
function iAmError($n)
{
	return "<h3>An Error Occured: $n</h3><video width='500' autoplay loop><source src='../assets/jazz.webm' type='video/webm' autoplay='true'>Your shitty browser does not support Webms. Get a real browser you fucking nerd.</video>";
}
function scandir2($n)
{
  return array_slice(scandir($n), 2);
}

/* GET */
$board = isset($_GET['board']) ? $_GET['board'] : '';

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
	<script type="text/javascript" src="../dependencies/jquery-3.3.1.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../dependencies/datatables.min.css" />
	<script type="text/javascript" src="../dependencies/datatables.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../assets/style.css">
	<style>
		#table1_wrapper {
			margin-right: 10px;
			margin-left: 10px;
		}
	</style>
</head>

<body bgcolor="#000000">
	<span class="main">
		<table width="600" align="center">
			<tr>
				<td>
					<div class="header">
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
						$files = scandir2($dir);
						sort($files);
						/* Make sure we were supplied a board */
						if (!empty($board)) {
							/* Make sure the supplied board matches one we have */
							if (array_search($board, $files) !== false) {
								/* After successful validation, parse for threads and print the list */
								echo "<h2>/$board/ Threads</h2>";
								$dir = "$board/";
								$files = scandir2($dir);
								sort($files);
								echo "<table id='table1' align='center' cellpadding='10'>
										<thead>
										<tr>
										<th scope='col'>Title</th>
										<th scope='col'>Thread #</th>
										<th scope='col'>Images</th>
										<th scope='col'>Status</th>
										<th scope='col'>Info</th>
										</tr>
										</thead>
										<tbody>";
								foreach ($files as $file) {
									/* Catch any zip files and delete them */
									if (explode(".", $file)[1] != "zip") {
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
								echo "</tbody></table><br/>";
							} else echo iAmError("Board does not exist in archive.");
						} else echo iAmError("Board not specified.");
						?>
					</div>
				</td>
			</tr>
		</table>
	</span>
</body>
<script>
	$(document).ready(function() {
		$("#table1").dataTable({
			"iDisplayLength": 10,
			"aLengthMenu": [
				[10, 25, 50, 100, -1],
				[10, 25, 50, 100, "All"]
			],
			"order": [
				[1, "des"]
			]
		});
	});
</script>

</html>