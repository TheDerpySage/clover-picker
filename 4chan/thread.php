<?php
function iAmError($n) {
    return "<p>An Error Occured: $n</p><video width='500' autoplay loop><source src='../assets/jazz.webm' type='video/webm' autoplay='true'>Your shitty browser does not support Webms. Get a real browser you fucking nerd.</video>";
}
function get_http_response_code($n) {
    $headers = get_headers($n);
    return substr($headers[0], 9, 3);
}

/* GET */
$board = isset($_GET['board']) ? $_GET['board'] : ''
$thread = isset($_GET['thread']) ? $_GET['thread'] : '';

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

                ?>
            </div>
        </td>
    </tr>
</table>
</span>
</body>
</html>
