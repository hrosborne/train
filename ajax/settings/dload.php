<?php

require ('function.php');
session_start();
db_connect();

header('Content-disposition: attachment; filename=SMS Mobile Application.apk');
header('Content-type: application/pdf');
readfile('SMS Mobile Application.apk');

?>