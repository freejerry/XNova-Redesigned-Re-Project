<?php

/**
 * fleetrecall.php
 *
 * @version 2.0
 * @copyright 2010 by MadnessRed for XNova Redesigned
 */

//Not really worth the file anymore, since its been moved to a function.
header('Content-Type: text/plain');
die(RecallFleet(idstring($_GET['fleet_id']), idstring($_GET['passkey']), $user['id']));

?>
