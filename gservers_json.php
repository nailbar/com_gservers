<?php

// Get the defines
require_once("config.php");

// Required defines
//  * PREFIX_DBHOST
//  * PREFIX_DBUSER
//  * PREFIX_DBPASS
//  * PREFIX_DBNAME

// Connect to database
$mysqli = new mysqli(PREFIX_DBHOST, PREFIX_DBUSER, PREFIX_DBPASS, PREFIX_DBNAME);
if(!$mysqli) die("ERR1: Database connection failed!");

// Handle sorting
$sorting = "";
switch(isset($_GET['sorting']) ? $_GET['sorting'] : "") {
case "status": $sorting = " ORDER BY restartsend='no' DESC,goingdown='no' DESC"; break;
case "game": $sorting = " ORDER BY type"; break;
case "name": $sorting = " ORDER BY servername"; break;
case "map": $sorting = " ORDER BY currentmap"; break;
case "players": $sorting = " ORDER BY currentplayers DESC"; break;
}

// Handle filters
$filter = "";
if(isset($_GET['filter'])) if(trim($_GET['filter'])) {
    $filters = array();
    foreach(explode(",", $_GET['filter']) as $f) if(trim($f)) {
        $filters[] = $mysqli->real_escape_string(trim($f));
    }
    if(count($filters)) {
        $filter = sprintf(" WHERE type IN('%s')", implode("','", $filters));
    }
}

// Query for content
$q = "SELECT * FROM servers{$filter}{$sorting}";
$resp = $mysqli->query($q);
if(!$resp) die("ERR2: Query error!");

// Fetch content
$data = array();
while($row = $resp->fetch_assoc()) {
  $data[] = array(
    'serverid' => $row['serverid'],
    'servername' => $row['servername'],
    'ip' => $row['ip'],
    'port' => $row['port'],
    'type' => $row['type'],
    'currentmap' => $row['currentmap'],
    'currentplayers' => $row['currentplayers'],
    'maxplayers' => $row['maxplayers'],
    'restartsend' => $row['restartsend'],
    'goingdown' => $row['goingdown']
  );
}

// Output content
echo "SUCCESS:" . json_encode($data);

?>