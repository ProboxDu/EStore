<?php

/**
 * @Filename: logout.php 
 * @Author: ProboxDu
 * @Date:   2018-06-19 00:15:18
 * @Last Modified by:   ProboxDu
 * @Last Modified time: 2018-07-01 11:39:38
 */
?>
<?php
    header('Content-type:text/html;charset=utf-8');
    session_start();
    if(isset($_SESSION['username'])){
        session_unset();//free all session variable
        session_destroy();//销毁一个会话中的全部数据
        setcookie(session_name(),'',time()-3600);//销毁与客户端的卡号
        echo "<script>alert('注销成功！');location.href='index.php';</script>";
        exit();
    }else{
        echo "<script>alert('注销失败！');</script>";
    };
?>