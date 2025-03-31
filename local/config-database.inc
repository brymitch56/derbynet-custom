<?php
$homedir = '/var/lib/derbynet/2025/2025 Derby';
$db_connection_string = 'sqlite:/var/lib/derbynet/2025/2025 Derby/derbynet.sqlite3';
$db = new PDO($db_connection_string, '', '',
               array (
));

$db->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
?>