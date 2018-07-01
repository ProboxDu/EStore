<?php

/**
 * @Filename: update_info.php 
 * @Author: ProboxDu
 * @Date:   2018-06-27 17:20:30
 * @Last Modified by:   ProboxDu
 * @Last Modified time: 2018-07-01 12:55:28
 */
?>
<?php
    include("conn.php");
    session_start();
    header('Content-Type:text/html;charset=utf-8');
    #var_dump($_POST);
    $info=array();
    if (!empty($_SESSION['username'])){
        $sql = "SELECT * FROM users WHERE username = '".$_SESSION['username']."';";
        $result = mysqli_query($conn, $sql);
        $info = mysqli_fetch_row($result);
      
    }else {
        echo '<script>alert("非法请求!");location.href="javascript:history.back()";</script>';
        exit;
    }
    if (isset($_POST['chinfo'])){
        $uid = $info[0];
        $user = $_POST['username'];
        $name = $_POST['name'];
        $sex = $_POST['gender'];
        $phone = $_POST['phone'];
        $idcard = $_POST['idcard'];
        $address = $_POST['address'];
        if ($user != $info[1]){
            $sql = "SELECT COUNT(*) FROM users WHERE username = '$user';";
            $result = mysqli_query($conn,$sql);
            $row = mysqli_fetch_row($result);
            if($row){
                echo '<script>alert("该用户名已被使用!");location.href="javascript:history.back()";</script>';
                exit;
            }
        }
        if (!is_numeric($phone)) {
            echo '<script>alert("手机号格式不正确!");location.href="javascript:history.back()";</script>';
            exit;
        }
        $sql = "UPDATE users SET username='$user', name = '$name', sex = '$sex', phone = $phone, idcard = '$idcard', address = '$address' WHERE uid = $uid";
        if (mysqli_query($conn, $sql)){
            echo '<script>alert("信息修改成功!");location.href="javascript:history.back()";</script>';
            exit;
        }else {
            die('信息修改失败: ' . mysqli_error($conn));
        }
    }
    if (isset($_POST['chpwd'])){
        $uid = $info[0];
        $pwd = md5($_POST['oldpwd']);
        $sql = "SELECT * FROM users WHERE uid = $uid AND password = '$pwd';";
        #echo $sql;
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_row($result);
        if (!$row){
            echo '<script>alert("原密码错误!");location.href="javascript:history.back()";</script>';
            exit;
        }
        $pwd = $_POST['pwd'];
        $repwd = $_POST['repwd'];
        if ($pwd === $repwd){
            $pwd = md5($pwd);
            $sql = "UPDATE users SET password = '$pwd' WHERE uid = $uid;";
            if (mysqli_query($conn, $sql)){
                echo '<script>alert("密码修改成功!");location.href="javascript:history.back()";</script>';
                exit;
            }else {
                die('密码修改失败: ' . mysqli_error($conn));
            }
        }else {
            echo '<script>alert("两次密码输入不一致!");location.href="javascript:history.back()";</script>';
            exit;
        }
    }
?>