<?php

/**
 * @Filename: shopping_cart.php 
 * @Author: ProboxDu
 * @Date:   2018-06-15 20:24:35
 * @Last Modified by:   ProboxDu
 * @Last Modified time: 2018-07-01 11:37:51
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
        $info = mysqli_fetch_array($result);
        #print_r($info);
    }else {
        echo '<script>alert("您还没有登录！");location.href="javascript:history.back()";</script>';
        exit;
    }
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap-4.0.0.css" rel="stylesheet" type="text/css">
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="css/shopping_cart.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Eater" rel="stylesheet">
    <title>EStore</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light navbar-static-top">
        <a class="navbar-brand" href="#">
            <div style="font-family: 'Eater', cursive;">EStore</div>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent1" aria-controls="navbarSupportedContent1" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent1">
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
            </form>
            <ul class="navbar-nav ml-auto">
                <?php
                    if (isset($_SESSION["username"])){
                        echo '<li class="nav-item"> <a class="nav-link" href="#"> 欢迎您, '.$_SESSION["username"].' </a></li>';
                    };
                ?>
                <li class="nav-item"> <a class="nav-link" href="index.php">Index</a> </li>
                <li class="nav-item"> <a class="nav-link" href="info.php?page=my">个人中心</a> </li>
                <li class="nav-item"> <a class="nav-link" href="info.php?page=favors"><i class="fa fa-star" aria-hidden="true"></i>收藏夹</a> </li>
                <li class="nav-item"> <a class="nav-link" href="shopping_cart.php"><i class="fa fa-shopping-cart" aria-hidden="true"></i>购物车</a> </li>
                <li class="nav-item"> <a class="btn" href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> 注销</a> </li>
            </ul>
        </div>
    </nav>
    <br/>
<div class="container">
  <div class="container-fluid">
        <form role="form" method="POST" action="update_cart_favors.php" class="form">
            <div class="catbox">
                <table id="cartTable">
                    <thead>
                        <tr>
                            <th>
                                <label>
                                    <input class="check-all check" type="checkbox" />&nbsp;&nbsp;全选
								</label>
                            </th>
                            <th>商品</th>
                            <th>单价</th>
                            <th>数量</th>
                            <th>小计</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql = "SELECT * FROM shopping_cart WHERE bid = ".$info['uid'].";";
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                while($row = mysqli_fetch_assoc($result)){
                                    $sql = "SELECT * FROM goods WHERE cid = ".$row['cid'].";";
                                    $res = mysqli_query($conn, $sql);
                                    $cinfo = mysqli_fetch_array($res);
                                    echo '<tr>';
                                    echo '<td class="checkbox">
                                        <input class="check-one check" type="checkbox" name="checked[]" value="'.$row['cid'].'"/>
                                        </td>';
                                    echo '<td class="goods"><img src="'.$cinfo['imgs'].'" height="50" width="50" alt="" /><span>'.$cinfo['cname'].'</span></td>';
                                    echo '<td class="price">'.$row['price'].'</td>';
                                    echo ' <td class="count"><span class="reduce"></span>
                                    <input class="count-input" type="number" name="total'.$row['cid'].'" value="'.$row['total'].'" />
                                    <span class="add">+</span></td>';
                                    $subtotal = $row['price'] * $row['total'];
                                    echo '<td class="subtotal">'.$subtotal.'</td>';
                                    echo '</tr>';
                                }
                            }
                        ?>
                    </tbody>
                </table>
                <div class="foot" id="foot">
                    <label class="fl select-all">
                        <input type="checkbox" class="check-all check" />&nbsp;&nbsp;全选</label>
                    <div class="fl delete" id="deleteAll">
                        <button type="submit" class="btn btn-sm btn-danger" style="margin-top:8px;" name="del_cart">删 除</button>
                    </div>
                    <div class="fr closing" onclick="getTotal();">
                        <button type="submit" class="btn btn-sm btn-success" style="margin-top:8px;" name="checkout">结 算</button>
                    </div>
                    <input type="hidden" id="cartTotalPrice" />
                    <div class="fr total">合计：￥<span id="priceTotal">0.00</span></div>
                    <div class="fr selected" id="selected">已选商品<span id="selectedTotal">0</span>件<span class="arrow up">︽</span><span class="arrow down">︾</span></div>
                    <div class="selected-view">
                        <div id="selectedViewList" class="clearfix">
                            <div><img src="images/1.jpg" alt=""><span>取消选择</span></div>
                        </div>
                        <span class="arrow">◆<span>◆</span></span>
                    </div>
                </div>
            </div>
        </form>
    </div>
  </div>
    <br/>
    <footer class="footer navbar-fixed-bottom ">
        <div style="text-align: center">
            <p>Copyright &copy; 2018.ProboxDu All Rights Reserved.</p>
        </div>
    </footer>
    <script src="/js/jquery-3.2.1.min.js"></script>
    <script src="/js/bootstrap-4.0.0.js"></script>
    <script src="/js/shopping_cart.js"></script>
</body>

</html>