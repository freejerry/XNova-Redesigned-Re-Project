<?php

/**
 * write.php
 *
 * @version 1
 * @copyright 2009 by Anthony for XNova Redesigned
 */


//Get the target user
$lang = doquery("SELECT `id`,`username`,`galaxy`,`system`,`planet` FROM {{table}} WHERE `id` = '".idstring($_GET['to'])."' LIMIT 1;", 'users', true);

//Start the parse array
$parse = $lang;

$parse['subject'] = htmlentities($_GET['subject']);
$parse['date'] = date("j<\s\up>S</\s\up> F Y");

echo AddUniToLinks(parsetemplate(gettemplate('network/write'), $parse));

?>