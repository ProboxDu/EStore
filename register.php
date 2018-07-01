<?php

/**
 * @Filename: register.php 
 * @Author: ProboxDu
 * @Date:   2018-06-18 20:01:53
 * @Last Modified by:   ProboxDu
 * @Last Modified time: 2018-07-01 12:38:51
 */
?>
<?php 
	include("conn.php");
	session_start();
	header('Content-Type:text/html;charset=utf-8');
	if (isset($_POST["register"])){
		if (isset($_POST['username']) && isset($_POST['password'])){
			$user = $_POST['username'];
			$pwd = md5($_POST["password"]);
			$sql = "SELECT * FROM users WHERE username = '$user';"; 
			$result = mysqli_query($conn, $sql);
			if (mysqli_num_rows($result) > 0){
				if (mysqli_fetch_row($result)){
					echo '<script>alert("该用户名已被使用！");location.href="javascript:history.back()";</script>';
					exit;
				}	
			}
			$sql = "SELECT COUNT(*) FROM users;";
			$result = mysqli_query($conn, $sql);
			$row = mysqli_fetch_row($result);
			$cnt = $row[0] + 1;
			$phone = $_POST['phone'];
			$sql = "INSERT INTO users(uid, username, password, phone) VALUES($cnt,'$user','$pwd',$phone);";
			if (mysqli_query($conn, $sql)){
				$_SESSION['username']=$user;
				echo '<script>alert("注册成功！");location.href="javascript:history.back()";</script>';
				exit;
			}else {
	    		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			};
		};
	};
?>