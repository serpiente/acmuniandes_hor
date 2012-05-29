<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

$db_hostname = 'apolo.uniandes.edu.co:3308';
$db_database = 'dbcrearhorario';
$db_username = 'usdbcrearhorario';
$db_password = '4CbWAHKz';

$db_server = mysql_connect($db_hostname, $db_username, $db_password);
mysql_select_db($db_database);


echo $db_server;
echo "HEY";

?>