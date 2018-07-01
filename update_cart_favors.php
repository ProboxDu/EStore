<?php

/**
 * @Filename: update_cart_favors.php 
 * @Author: ProboxDu
 * @Date:   2018-06-29 20:47:09
 * @Last Modified by:   ProboxDu
 * @Last Modified time: 2018-07-01 13:33:00
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
    if (isset($_POST['add_cart'])){
        $uid = $info[0];
        $cid = $_POST['cid'];
        $total = $_POST['number'];
        $sql = "SELECT COUNT(*) AS total FROM shopping_cart;";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        if ($row['total'] >= 20){
            echo '<script>alert("购物车商品已经超过20！");location.href="javascript:history.back()";</script>';
            exit;
        }
        $sql = "SELECT * FROM goods WHERE cid = $cid;";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        if ($row['total'] < $total){
            echo '<script>alert("商品数量异常！");location.href="javascript:history.back()";</script>';
            exit;
        }
        if ($row['uid'] == $uid) {
            echo '<script>alert("您不能添加自己的物品哦！");location.href="javascript:history.back()";</script>';
            exit;
        }
        $price = $row['price'];
        $sql = "SELECT * FROM shopping_cart WHERE bid = $uid AND cid = $cid;";
        $result = mysqli_query($conn, $sql);
        if (mysqli_fetch_row($result)){
            echo '<script>alert("您的购物车已经有这件商品了！");location.href="javascript:history.back()";</script>';
            exit;
        }
        $time = date("Y-m-d h:i:s");
        $sql = "INSERT INTO shopping_cart(bid, cid, price, total, stime) VALUES($uid, $cid, $price, $total, '$time');";
        if (mysqli_query($conn, $sql)){
            echo '<script>alert("成功添加到购物车!");location.href="javascript:history.back()";</script>';
            exit;
        }else {
            die('商品添加失败: ' . mysqli_error($conn));
        }
    }
    if (isset($_POST['add_favors'])){
        $uid = $info[0];
        $cid = $_POST['cid'];
        $sql = "SELECT COUNT(*) AS total FROM favors;";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        if ($row['total'] >= 20){
            echo '<script>alert("收藏夹商品已经超过20！");location.href="javascript:history.back()";</script>';
            exit;
        }
        $sql = "SELECT * FROM favors WHERE bid = $uid AND cid = $cid;";
        $result = mysqli_query($conn, $sql);
        if (mysqli_fetch_row($result)){
            echo '<script>alert("您的收藏夹已经有这件商品了！");location.href="javascript:history.back()";</script>';
            exit;
        }
        $sql = "SELECT * FROM goods WHERE cid = $cid;";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        if ($row['uid'] == $uid) {
            echo '<script>alert("您不能添加自己的物品哦！");location.href="javascript:history.back()";</script>';
            exit;
        }
        $time = date("Y-m-d h:i:s");
        $sql = "INSERT INTO favors(bid, cid, ftime) VALUES($uid, $cid, '$time');";
        if (mysqli_query($conn, $sql)){
            echo '<script>alert("成功添加到收藏夹!");location.href="javascript:history.back()";</script>';
            exit;
        }else {
            die('商品添加失败: ' . mysqli_error($conn));
        }
    }
    if (isset($_POST['del_cart'])){
        $uid = $info[0];
        $cid = $_POST['cid'];
        $sql = "SELECT * FROM shopping_cart WHERE bid = $uid AND cid = $cid;";
        $result = mysqli_query($conn, $sql);
        if (!mysqli_fetch_row($result)){
            echo '<script>alert("您的购物车没有这件商品！");location.href="javascript:history.back()";</script>';
            exit;
        }
        $sql = "DELETE FROM shopping_cart WHERE bid = $uid AND cid = $cid;";
        if (mysqli_query($conn, $sql)){
            echo '<script>alert("成功从购物车删除!");location.href="javascript:history.back()";</script>';
            exit;
        }else {
            die('商品删除失败: ' . mysqli_error($conn));
        }
    }
    if (isset($_POST['del_favors'])){
        $uid = $info[0];
        $cid = $_POST['cid'];
        $sql = "SELECT * FROM favors WHERE bid = $uid AND cid = $cid;";
        $result = mysqli_query($conn, $sql);
        if (!mysqli_fetch_row($result)){
            echo '<script>alert("您的收藏夹没有这件商品！");location.href="javascript:history.back()";</script>';
            exit;
        }
        $sql = "DELETE FROM favors WHERE bid = $uid AND cid = $cid;";
        if (mysqli_query($conn, $sql)){
            echo '<script>alert("成功从收藏夹删除!");location.href="javascript:history.back()";</script>';
            exit;
        }else {
            die('商品删除失败: ' . mysqli_error($conn));
        }
    }
    if (isset($_POST['checkout'])){
        $bid = $info[0];
        if (!empty($_POST['checked'])){
            $checked = $_POST['checked'];
            foreach ($checked as $cid) {
                $total = $_POST['total'.$cid];
                $sql = "SELECT * FROM goods WHERE cid = $cid;";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                if ($row['total'] < $total){
                    echo '<script>alert("商品数量异常！");location.href="javascript:history.back()";</script>';
                    exit;
                }
                $sid = $row['uid'];
                $time = date("Y-m-d h:i:s");
                $tot_price = $row['price'] * $total;
                $sql = "INSERT INTO order_form(bid, sid, cid, tot_price, otime) VALUES($bid, $sid, $cid,$tot_price, '$time');";
                if (mysqli_query($conn, $sql)){
                    $total = $row['total'] - $total; 
                    $sql = "UPDATE goods SET total = $total WHERE cid = $cid;";
                    if (mysqli_query($conn, $sql)){
                        $sql = "DELETE FROM shopping_cart WHERE bid = $bid AND cid = $cid;";
                        if (mysqli_query($conn, $sql)){
                            echo '<script>alert("下单成功!");location.href="javascript:history.back()";</script>';
                            exit;
                        }
                    }else {
                        die('商品数量修改失败: ' . mysqli_error($conn));
                    }
                }else {
                    die('商品添加失败: ' . mysqli_error($conn));
                }
            }
        }
    }
?>