<?php
function iAmError($n) {
    return "<p>An Error Occured: $n</p><video width='500' autoplay loop><source src='../../assets/jazz.webm' type='video/webm' autoplay='true'>Your shitty browser does not support Webms. Get a real browser you fucking nerd.</video>";
}

function zipAndServe($dir, $zip_file) {
    // Get real path for our folder
    $rootPath = realpath($dir);
    // Initialize archive object
    $zip = new ZipArchive();
    $zip->open($zip_file, ZipArchive::CREATE | ZipArchive::OVERWRITE);
    // Create recursive directory iterator
    /* @var SplFileInfo[] $files */
    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($rootPath), RecursiveIteratorIterator::LEAVES_ONLY);
    foreach ($files as $name => $file){
	// Skip directories (they would be added automatically)
	if (!$file->isDir()){
	    // Get real and relative path for current file
	    $filePath = $file->getRealPath();
	    $relativePath = substr($filePath, strlen($rootPath) + 1);
	    // Add current file to archive
	    $zip->addFile($filePath, $relativePath);
	}
    }
    // Zip archive will be created only after closing object
    $zip->close();
    ob_clean();
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($zip_file));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: no-cache, no-store, must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($zip_file));
    readfile($zip_file);
    unlink($zip_file);
}

/* GET */
$thread = isset($_GET['thread']) ? $_GET['thread'] : '';
?>
<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'>
<html lang='en'>
<head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
    <meta http-equiv='Cache-Control' content='no-cache, no-store, must-revalidate' />
    <link rel='stylesheet' type='text/css' href='../../assets/style.css'>
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
		    if (!empty($thread)){
			$cd = basename(__DIR__);
			$dir = ".";
			$files = scandir($dir);
			$temp = array_diff($files, [".", "..","index.php","images.php","update.php"]);
			$files = array_values($temp);
			sort($files);
			echo "<h4><a href='index.php'><--Back to /$cd/---</a></h4>";
			/* Validate thread based on if it exists in this dir */
			if (array_search($thread, $files) !== false){
			    echo "<p>Creating and Serving /$thread/...<br/>Please wait warmly...</p>";
			    zipAndServe("$dir/$thread", "$thread.zip");
			} else echo iAmError("Thread does not exist in this boards archive.");
		    } else echo iAmError("No Thread specified.");
		?>
		</div>
	    </td>
	</tr>
    </table>
</body>
</html>
