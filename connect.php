<?php 
$host =	'localhost';
$user = 'root';
$pass = '';
$dbnm = 'news_db';

$conn = new mysqli($host, $user, $pass, $dbnm);

if ($conn->connect_error) {
	echo "Connection Failed";
	exit();
} 