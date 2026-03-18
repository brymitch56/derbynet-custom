<?php
$homedir = '/var/lib/derbynet/2026/2026 Derby';
$db_connection_string = 'sqlite:/var/lib/derbynet/2026/2026 Derby/derbynet.sqlite3';
$db = new PDO($db_connection_string, '', '',
               array (
));

$db->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
?>