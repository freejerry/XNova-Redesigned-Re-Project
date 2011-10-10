<?php

/**
 * aks.php
 *
 * @version 1.0
 * @copyright 2008 by Anthony (MadnessRed) for Darkness of Evolution
 * 
 * Made from scratch by Anthony (MadnessRed) http://madnessred.co.cc/
 * This file is under the GPL license which must be included wit this file.
 *
 * You may not edit this comment block. You may not copy any part of this file into any other file with out copying this comment block with it and placing it above any code there might be.
 */

define('INSIDE'  , true);
define('INSTALL' , false);
define('BOARD'   , true);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

$page_title = "Board";
$parse['this_page']  = "";
/*
$parse['this_page'] .= "<table width=\"100%\">";
$parse['this_page'] .= "<tr><td class=\"c\">Board</td></tr>";
$parse['this_page'] .= "<tr>";
$parse['this_page'] .= "<th>";
*/
$parse['this_page'] .= "<iframe src=\"http://board.darkevo.org/\" name=\"boardframe\" id=\"boardframe\" frameborder=\"0\" border=\"0\" width=\"100%\" height=\"5000\" style=\"overflow:visible\" allowautotransparency=\"true\"></iframe>\n";
/*
$parse['this_page'] .= "</th>";
$parse['this_page'] .= "</tr>";
$parse['this_page'] .= "</table>";
*/

display(parsetemplate(gettemplate('basic_page'), $parse), $page_title, false);
die();

/*
    <html>
    <head> <title>Parent frame</title> </head>

    <body onload=”resizeFrame(document.getElementById(’boardframe’))” bgcolor=”#cccccc”>

    <script type=”text/javascript”>
    // Firefox worked fine. Internet Explorer shows scrollbar because of frameborder
    function resizeFrame(f) {
    f.style.height = f.contentWindow.document.body.scrollHeight + “px”;
    }
    </script>


    <iframe frameborder=0 border=0 src=”./board-frame.html” name=”boardframe” id=”boardframe”>
    </iframe>
*/
?>