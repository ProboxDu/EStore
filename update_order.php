<?php

/**
 * @Filename: update_order.php 
 * @Author: ProboxDu
 * @Date:   2018-06-29 15:10:57
 * @Last Modified by:   ProboxDu
 * @Last Modified time: 2018-07-01 13:29:04
 */
?>
<?php
    include("conn.php");
    session_start();
    header('Content-Type:text/html;charset=utf-8');
    $info=array();
    if (!empty($_SESSION['username'])){
        $sql = "SELECT * FROM users WHERE username = '".$_SESSION['username']."';";
        $result = mysqli_query($conn, $sql);
        $info = mysqli_fetch_row($result);
        #print_r($info);
    }else {
        echo '<script>alert("您还没有登录！");location.href="javascript:history.back()";</script>';
        exit;
    }
    #var_dump($_POST);

    if (isset($_POST['delete'])){
        $oid = $_POST['oid'];
        $sql = "SELECT * FROM order_form WHERE oid = $oid;";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        if (!$row){
            echo '<script>alert("无此订单！");location.href="javascript:history.back()";</script>';
            exit;
        }
        $cid = $row['cid'];
        $tot_price = $row['tot_price'];
        $sql = "SELECT * FROM goods WHERE cid = $cid;";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        $total = (int)$tot_price / $row['price'];
        $sql = "UPDATE goods SET total = total + $total WHERE cid = $cid;";
        if (mysqli_query($conn, $sql)){
            $sql = "DELETE FROM order_form WHERE oid = $oid;";
            if (mysqli_query($conn, $sql)){
                echo '<script>alert("该订单已成功删除!");location.href="javascript:history.back()";</script>';
                exit;
            }else {
                die('订单删除失败: ' . mysqli_error($conn));
            }
        }else {
            die('商品更新失败: ' . mysqli_error($conn));
        }
    }
    if (isset($_POST['confirm'])){
        $oid = $_POST['oid'];
        $sql = "SELECT * FROM order_form WHERE oid = $oid;";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        if (!$row){
            echo '<script>alert("无此订单！");location.href="javascript:history.back()";</script>';
            exit;
        }
        $uid = $row['sid'];
        $sql = "UPDATE order_form SET confirm = '1' WHERE oid = $oid;";
        if (mysqli_query($conn, $sql)){
            $sql = "UPDATE users SET volume = volume + 1 WHERE uid = $uid;";
            if (mysqli_query($conn, $sql)){
                echo '<script>alert("该订单已成功确认!");location.href="javascript:history.back()";</script>';
                exit;
            }else {
                die('更新成交数失败: ' . mysqli_error($conn));
            }  
        }else {
            die('订单确认失败: ' . mysqli_error($conn));
        }
    }
?>