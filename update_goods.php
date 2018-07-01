<?php

/**
 * @Filename: update_goods.php 
 * @Author: ProboxDu
 * @Date:   2018-06-27 21:36:42
 * @Last Modified by:   ProboxDu
 * @Last Modified time: 2018-07-01 11:39:13
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
      
    }else {
        echo '<script>alert("非法请求!");location.href="javascript:history.back()";</script>';
        exit;
    }
    #var_dump($_POST);
    #var_dump($_FILES['pic']);
    if (isset($_POST['update'])){
        if (empty($_FILES['pic']) || empty($_POST['gname']) || empty($_POST['options']) || empty($_POST['instruct']) || empty($_POST['oprice']) || empty($_POST['price']) || empty($_POST['total'])){
            echo '<script>alert("商品信息不完整!");location.href="javascript:history.back()";</script>';
            exit;
        }
        $uid = $info[0];
        $file = $_FILES['pic'];//得到传输的数据
        $name = $file['name'];//得到文件名称
        $type = strtolower(substr($name, strrpos($name, '.') + 1)); //得到文件类型，并且都转化成小写
        $allow_type = array('jpg','jpeg','gif','png'); //定义允许上传的类型
        //判断文件类型是否被允许上传
        if(!in_array($type, $allow_type)){
            echo '<script>alert("文件类型不合法!");location.href="javascript:history.back()";</script>';
            exit;
        }
        if ($file["size"]>=1024000){
            echo '<script>alert("文件大于1MB!");location.href="javascript:history.back()";</script>';
            exit;
        }
        //判断是否是通过HTTP POST上传的
        if(!is_uploaded_file($file['tmp_name'])){
            //如果不是通过HTTP POST上传的
            echo '<script>alert("非法请求!");location.href="javascript:history.back()";</script>';
            exit;
        }
        $upload_path = "images/"; //上传文件的存放路径
        //开始移动文件到相应的文件夹
        $filename = $upload_path.$uid."_".date("Ymdhis").".".$type;
        echo $filename;

        if(move_uploaded_file($file['tmp_name'],$filename)){
            #echo '<script>alert("图片添加成功!");location.href="javascript:history.back()";</script>';
        }else{
            echo '<script>alert("图片添加失败!");location.href="javascript:history.back()";</script>';
            exit;
        }
        $name = $_POST['gname'];
        $type = $_POST['options'];
        $instruct = $_POST['instruct'];
        $ori_price = $_POST['oprice'];
        $price = $_POST['price'];
        $total = $_POST['total'];
        $sql = "SELECT COUNT(*) AS total FROM goods;";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        $cnt = $row['total'];
        $sql = "INSERT INTO goods(cid, cname, type, instruction, ori_price, price, total, imgs, uid) VALUES($cnt, '$name', '$type', '$instruct', $ori_price, $price, $total, '$filename', $uid);";
        if (mysqli_query($conn, $sql)){
            echo '<script>alert("商品添加成功!");location.href="javascript:history.back()";</script>';
            exit;
        }else {
            die('商品添加失败: ' . mysqli_error($conn));
        }
    }
    if (isset($_POST['delete'])){
        $uid = $info[0];
        $cid = $_POST['cid'];
        $sql = "SELECT * FROM goods WHERE uid = $uid AND cid = $cid;";
        $result = mysqli_query($conn, $sql);
        if (!mysqli_fetch_row($result)){
            echo '<script>alert("您没有发布这件商品！");location.href="javascript:history.back()";</script>';
            exit;
        }
        $sql = "DELETE FROM goods WHERE uid = $uid AND cid = $cid;";
        if (mysqli_query($conn, $sql)){
            echo '<script>alert("商品删除成功!");location.href="javascript:history.back()";</script>';
            exit;
        }else {
            die('商品删除失败: ' . mysqli_error($conn));
        }
    }
?>