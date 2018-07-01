<?php

/**
 * @Filename: conn.php 
 * @Author: ProboxDu
 * @Date:   2018-06-18 20:49:06
 * @Last Modified by:   ProboxDu
 * @Last Modified time: 2018-07-01 11:36:45
 */
?>
<?php
	include("waf.php");
	$servername = "localhost";
	$username = "root";
	$password = "20170521";
	$dbname = "db_estore";
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	if (!$conn) {
    	die("Connection failed: " . mysqli_connect_error());
	}
	mysqli_set_charset($conn, "utf8");
?>