<?php
/**
 * @Filename: login.php 
 * @Author: ProboxDu
 * @Date:   2018-06-13 22:40:07
 * @Last Modified by:   ProboxDu
 * @Last Modified time: 2018-07-01 11:57:44
 */
?>
<?php
	include("conn.php");
	session_start();
	header('Content-Type:text/html;charset=utf-8');
	if (isset($_POST['login'])){
		if (isset($_POST['username']) && isset($_POST['password'])){
			$user = $_POST['username'];
			if (isset($_SESSION['username']) && $_SESSION['username']===$user){
				echo "<script>alert('您已经登录了！');</script>";
				exit;
			}
			$pwd = md5($_POST['password']);
			$sql = "SELECT * FROM users WHERE username = '$user' AND password = '$pwd';"; 
			$result = mysqli_query($conn, $sql);
			if (mysqli_fetch_row($result)){
				if($_POST['remember']){ 
					setcookie('username',$user,time()+3600);
					setcookie('password',md5($pwd),time()+3600);
					echo $_COOKIE['username']." ".$_COOKIE['password'];
				}
				$_SESSION['username']=$user;
				echo '<script>alert("登录成功！");location.href="javascript:history.back()";</script>';
				exit;
			}else {
				echo '<script>alert("登录失败！");location.href="javascript:history.back()";</script>';
				exit;
			};
		};
	};
?>