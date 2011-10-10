<?php
define('INSIDE'  , true);
require("vars.php");
include("mr_attack.php");
include("mr_report.php");

$att_ships[1]= array(
	'id' => 1,
	'fleet' => 1,
	'type' => 214,
	'weaps' => 200000,
	'shields' => 50000,
	'hull' => 200000);

$att_ships[2]= array(
	'id' => 2,
	'fleet' => 1,
	'type' => 214,
	'weaps' => 200000,
	'shields' => 50000,
	'hull' => 200000);

$att_ships[3]= array(
	'id' => 3,
	'fleet' => 1,
	'type' => 214,
	'weaps' => 200000,
	'shields' => 50000,
	'hull' => 200000);

$def_ships[1]= array(
	'id' => 1,
	'fleet' => 1,
	'type' => 214,
	'weaps' => 200000,
	'shields' => 50000,
	'hull' => 200000);

$def_ships[2]= array(
	'id' => 2,
	'fleet' => 1,
	'type' => 214,
	'weaps' => 200000,
	'shields' => 50000,
	'hull' => 200000);
	
$fleets['a'][1] = array(
	'owner' => 'Anthony',
	'leader' => 1,
	'origin' => '1:1:1',
	'techs' => array(12,12,12)
);
	
$fleets['v'][1] = array(
	'owner' => 'Tom',
	'leader' => 1,
	'origin' => '1:1:2',
	'techs' => array(10,10,10)
);
	
$result = mr_attack($att_ships,$def_ships,true);
$report = mr_report($result,$fleets,true);

echo $report;

echo "<br /><br />";

print_r($result['losses']);
echo "<br /><br />";

print_r($result['won']);
echo "<br /><br />";

echo "Round 1";
print_r($result['rounds'][1]);
echo "<br /><br />";

echo "Round 2";
print_r($result['rounds'][2]);
echo "<br /><br />";

echo "Round 3";
print_r($result['rounds'][3]);
echo "<br /><br />";

echo "Round 4";
print_r($result['rounds'][4]);
echo "<br /><br />";

echo "Round 5";
print_r($result['rounds'][5]);
echo "<br /><br />";

echo "Round 6";
print_r($result['rounds'][6]);
echo "<br /><br />";

echo "Round All";
print_r($result['rounds']);
echo "<br /><br />";


?>