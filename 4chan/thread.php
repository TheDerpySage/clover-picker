<?php
function iAmError($n)
{
    return "<h3>An Error Occured: $n</h3><video width='500' autoplay loop><source src='../assets/jazz.webm' type='video/webm' autoplay='true'>Your shitty browser does not support Webms. Get a real browser you fucking nerd.</video>";
}
function get_http_response_code($n)
{
    $headers = get_headers($n);
    return substr($headers[0], 9, 3);
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
function scandir2($n)
{
    return array_slice(scandir($n), 2);
}

/* GET */
$board = isset($_GET['board']) ? $_GET['board'] : '';
$thread = isset($_GET['thread']) ? $_GET['thread'] : '';
$method = isset($_GET['method']) ? $_GET['method'] : '';

$con = stream_context_create(
    array(
        'http' => array(
            'method' => "GET",
            'header' => "User-Agent: " . $_SERVER['HTTP_USER_AGENT'] . "\r\n"
        )
    )
);
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
                    <div class="header">
                        <h1>Clover Picker</h1>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="body">
                        <?php
                        /* Check for Missing Args */
                        if (!empty($thread) && !empty($board)) {
                            $files = scandir2(".");
                            sort($files);
                            /* Validate Board */
                            if (array_search($board, $files) !== false) {
                                $files = scandir2("$board/");
                                sort($files);
                                /* Given Board, Validate Thread */
                                if (array_search($thread, $files) !== false) {
                                    /* First, catch if were closing a thread */
                                    if ($method == "close") {
                                        try {
                                            $json = json_decode(file_get_contents("$board/$thread/$thread.json"), true);
                                            $infile = fopen("$board/$thread/$thread.json", "w");
                                            $json['posts'][0]['closed'] = "1";
                                            $encoded = json_encode($json);
                                            fwrite($infile, $encoded);
                                            fclose($infile);
                                            echo "<h5>Thread: $thread</h5>";
                                            echo "<h5>Thread has been closed successfully.</h5><h5><a href='thread.php?board=$board&thread=$thread'>Refreshing in 10 Seconds...</a></h5>";
                                            header("Refresh: 10; URL=thread.php?board=$board&thread=$thread");
                                        } catch (Exception $e) {
                                            echo "<h5>Thread: $thread</h5>";
                                            echo "<h5>Something went wrong...</h5><h5>$e</h5><h5><a href='thread.php?board=$board&thread=$thread'>Refreshing in 10 Seconds...</a></h5>";
                                            header("Refresh: 10; URL=thread.php?board=$board&thread=$thread");
                                        }
                                        /* Else just show information */
                                    } else {
                                        $json = json_decode(file_get_contents("$board/$thread/$thread.json"), true);
                                        /* Get a Title */
                                        if ($json['posts'][0]['sub'] != '')
                                            $title = $json['posts'][0]['sub'];
                                        else $title = $json['posts'][0]['semantic_url'];
                                        /* Get Status */
                                        /* Check if closed according to our JSON */
                                        if (empty($json['posts'][0]['closed'])) {
                                            /* Check if 404'd */
                                            /* We do it this way now because 4chan's API fucked up response codes... */
                                            try {
                                                $them_json = json_decode(file_get_contents("https://a.4cdn.org/$board/thread/$thread.json", false, $con), true);
                                            } catch (Exception $e) {
                                                $them_json = '';
                                            }
                                            if ($them_json != '') {
                                                /* Get their JSON */
                                                $them_json = json_decode(file_get_contents("https://a.4cdn.org/$board/thread/$thread.json", false, $con), true);
                                                /* If new replies exist according to their JSON OR they have a closed marker that we don't have, show Update button */
                                                if (($json['posts'][0]['replies'] < $them_json['posts'][0]['replies']) || (!empty($them_json['posts'][0]['closed']))) {
                                                    $status = "<a href='update.php?board=$board&thread=$thread'>Update Availible</a>";
                                                } else $status = "Up To Date";
                                            } else {
                                                $status = "<a href='thread.php?board=$board&thread=$thread&method=close'>404 (Click to Close)</a>";
                                                /* Create ability to close out clientside threads */
                                            }
                                        } else $status = "Closed";

                                        /* Get Posted (UNIX Timestamp) */
                                        $raw_time = $json['posts'][0]['time'];
                                        $str_time = date('Y-m-d, H:i:s', $raw_time);

                                        /* Get Thread Image, and interestingly enough the time the thread started */
                                        if (!empty($json['posts'][0]['tim'])) {
                                            $tim = $json['posts'][0]['tim'];
                                            $thumb = "$board/$thread/thumbs/$tim" . "s.jpg";
                                        } else $thumb = '../assets/flubbed.gif';

                                        /* Enter Data */
                                        echo "<h4><a href='board.php?board=$board'><--Back to /$board/---</a></h4>";
                                        echo "<table align='center' cellpadding='10'><tr>";
                                        echo "<td><a href='images.php?method=all&board=$board&thread=$thread'><img src='$thumb'></a></td>";
                                        echo "<td><p>Title: $title</p><p>Thread: <a href='$board/$thread/$thread.html'>/$thread/</a></p><p>Date Posted: $str_time</p><p>Status:$response $status</p><p><a href='images.php?method=all&board=$board&thread=$thread'>All Images</a></p><p><a href='download.php?board=$board&thread=$thread'>Download ZIP</a></p></td>";
                                        echo "</tr></table>";
                                        echo "<h4><a href='board.php?board=$board'><--Back to /$board/---</a></h4>";
                                    }
                                } else {
                                    echo iAmError("Given Thread does not exist in the archive.");
                                }
                            } else {
                                echo iAmError("Given Board does not exist in the archive.");
                            }
                        } else {
                            echo iAmError("Missing Arguements.");
                        }
                        ?>
                    </div>
                </td>
            </tr>
        </table>
    </span>
</body>

</html>