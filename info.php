<?php

/**
 * @Filename: info.php 
 * @Author: ProboxDu
 * @Date:   2018-06-27 20:51:26
 * @Last Modified by:   ProboxDu
 * @Last Modified time: 2018-07-01 11:37:25
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
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link href="css/sitelogo.css" rel="stylesheet" type="text/css">
    <link href="css/cropper.min.css" rel="stylesheet" type="text/css">
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
        <div class="row">
            <div class="col-3">
                <div class="container-fluid">
                    <ul id="clothingnav1" class="nav nav-pills flex-column nav-fill" role="tablist">
                        <li> <img src="images/头像.jpg" class="img-fluid" alt="" /></li>

                        <li class="nav-item"> <a class="nav-link <?php echo $_GET['page'] == "my"?"active":""; ?>" href="#home1" id="hometab1" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">个人资料</a> </li>
                        <li class="nav-item"> <a class="nav-link <?php echo $_GET['page'] == "goods"?"active":""; ?>" href="#paneTwo1" role="tab" id="hatstab1" data-toggle="tab" aria-controls="hats">商品管理</a> </li>
                        <li class="nav-item"> <a class="nav-link <?php echo $_GET['page'] == "favors"?"active":""; ?>" href="#paneTwo2" role="tab" id="hatstab2" data-toggle="tab" aria-controls="hats">收藏夹 </a> </li>
                        <li class="nav-item"> <a class="nav-link <?php echo $_GET['page'] == "order"?"active":""; ?>" href="#paneTwo3" role="tab" id="hatstab3" data-toggle="tab" aria-controls="hats">我的订单</a> </li>
                    </ul>
                </div>
            </div>
            <div class="col-9">
                <div class="container-fluid">
                    <!-- Content Panel -->

                    <div id="clothingnavcontent1" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade <?php echo $_GET['page'] == "my"?"show active":""; ?>" id="home1" aria-labelledby="hometab1">
                            <div class="container-fluid">
                                <ul id="iclothingnav" class="nav nav-pills" role="tablist">
                                    <li class="nav-item"> <a class="nav-link active" href="#ihome1" id="ihometab1" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">基本信息</a> </li>
                                    <li class="nav-item"> <a class="nav-link" href="#ipaneTwo1" role="tab" id="ihatstab1" data-toggle="tab" aria-controls="hats">修改密码</a> </li>
                                </ul>
                                <br/>
                                <!-- Content Panel -->
                                <div id="iclothingnavcontent" class="tab-content">
                                    <div role="tabpanel" class="tab-pane fade show active" id="ihome1" aria-labelledby="ihometab1">
                                        <div class="container-fluid">
                                            <div class="media-object-default">
                                                <div class="media"> <img class="d-flex mr-3" src="images/头像.jpg" width="100" alt="placeholder image">
                                                    <div class="media-body">
                                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-avatar">修改头像</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <form role="form" action="update_info.php" method="POST"  class="form">
                                                <div class="form-group">
                                                    <br/>
                                                    <div class="row">
                                                        <div class="col-2" style="text-align: center ">
                                                            <label for = "uname"><strong>用户名</strong></label>
                                                        </div>
                                                        <div class="col-10">
                                                             <input type="text" class="form-control" id="uname" name="username" value="<?php echo $info['username'];?>">
                                                        </div>
                                                    </div>
                                                    <br/>
                                                    <div class="row">
                                                        <div class="col-2" style="text-align: center ">
                                                            <label for="name"><strong>姓名</strong></label>
                                                        </div>
                                                        <div class="col-10">
                                                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $info['name'];?>"> </div>
                                                    </div>
                                                    <br/>
                                                    <div class="row">
                                                        <div class="col-2" style="text-align: center ">
                                                            <label><strong>性别</strong></label>
                                                        </div>
                                                        <div class="col-10">
                                                            <?php
                                                                if ($info['sex']=='male'){
                                                                    echo '<input type="radio" value="male" name="gender" checked>男';
                                                                    echo '<input type="radio" value="female" name="gender">女';
                                                                }else {
                                                                    echo '<input type="radio" value="male" name="gender">男';
                                                                    echo '<input type="radio" value="female" name="gender" checked>女';
                                                                }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <br/>
                                                    <div class="row">
                                                        <div class="col-2" style="text-align: center">
                                                            <label for="phone"><strong>手机</strong></label>
                                                        </div>
                                                        <div class="col-10">
                                                            <input type="text" class="form-control" maxlength="11" id="phone" name="phone" value="<?php echo $info['phone'];?>">
                                                        </div>
                                                    </div>
                                                    <br/>
                                                    <div class="row">
                                                        <div class="col-2" style="text-align: center">
                                                            <label for="idcard"><strong>身份证</strong></label>
                                                        </div>
                                                        <div class="col-10">
                                                            <input type="text" class="form-control" maxlength="18" id="idcard" name="idcard"value="<?php echo $info['idcard'];?>">
                                                        </div>
                                                    </div>
                                                    <br/>
                                                    <div class="row">
                                                        <div class="col-2" style="text-align: center">
                                                            <label for="address"><strong>地址</strong></label>
                                                        </div>
                                                        <div class="col-10">
                                                            <input type="text" class="form-control" id="address" name="address" value="<?php echo $info['address'];?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <br/>
                                                <div style="text-align: right">
                                                    <button type="submit" class="btn btn-primary" name="chinfo">修改信息</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="ipaneTwo1" aria-labelledby="ihatstab1">
                                        <div class="container-fluid">
                                            <form  role="form" action="update_info.php" method="POST" class="form">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-2" style="text-align: center">
                                                            <label for="opwd"><strong>原密码</strong></label>
                                                        </div>
                                                        <div class="col-10">
                                                            <input type="password" class="form-control" id="opwd" name="oldpwd" placeholder="Old Password">
                                                        </div>
                                                    </div>
                                                    <br/>
                                                    <div class="row">
                                                        <div class="col-2" style="text-align: center">
                                                            <label for="pwd"><strong>新密码</strong></label>
                                                        </div>
                                                        <div class="col-10">
                                                            <input type="password" class="form-control" id="pwd" name="pwd" placeholder="New Password">
                                                        </div>
                                                    </div>
                                                    <br/>
                                                    <div class="row">
                                                        <div class="col-2" style="text-align: center">
                                                            <label for="repwd"><strong>确认密码</strong></label>
                                                        </div>
                                                        <div class="col-10">
                                                            <input type="password" class="form-control" id="repwd" name="repwd" placeholder="Repeat Password">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div style="text-align: right">
                                                    <button type="submit" class="btn btn-primary" name="chpwd">修改密码</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade <?php echo $_GET['page'] == "goods"?"show active":""; ?>" id="paneTwo1" aria-labelledby="hatstab1">
                            <div class="container-fluid">
                                <ul id="gclothingnav" class="nav nav-pills" role="tablist">
                                    <li class="nav-item"> <a class="nav-link active" href="#ghome1" id="ghometab1" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">销售中</a> </li>
                                    <li class="nav-item"> <a class="nav-link" href="#gpaneTwo1" role="tab" id="ghatstab1" data-toggle="tab" aria-controls="hats">已出售</a> </li>
                                    <li class="nav-item"> <a class="nav-link" href="#gpaneTwo2" role="tab" id="ghatstab2" data-toggle="tab" aria-controls="hats">添加商品</a> </li>
                                </ul>
                                <br/>
                                <!-- Content Panel -->
                                <div id="gclothingnavcontent" class="tab-content">
                                    <div role="tabpanel" class="tab-pane fade show active" id="ghome1" aria-labelledby="ghometab1">
                                        <div class="container-fluid">
                                            <?php
                                                $sql = "SELECT * FROM goods WHERE uid = ".$info['uid']." AND total > 0;";
                                                $result = mysqli_query($conn, $sql);
                                                $cnt = 0;
                                                if (mysqli_num_rows($result) > 0) {
                                                    while($row = mysqli_fetch_assoc($result)){
                                                        if ($cnt % 3 == 0){
                                                            if ($cnt != 0) echo '</div><br/>';
                                                            echo '<div class="row">';
                                                        }
                                                        echo '<div class="col-4">';
                                                        echo '<div class="card">';
                                                        echo '<img class="card-img-top" src="'.$row['imgs'].'" alt="">';
                                                        echo '<div class="card-block">';
                                                        echo '<p class="card-title text-center"><a href="goods.php?id='.$row['cid'].'">'.$row['cname'].'</a></p>';
                                                        echo '<div class="float-left error">&yen;'.$row['price'].'</div>';
                                                        echo '<div class="float-right">';
                                                        echo '<form role="form" action="update_goods.php" method="POST" class="form">';
                                                        echo '<input type="hidden" name="cid" value="'.$row['cid'].'" />';
                                                        echo '<button type="submit" class="btn btn-danger" name="delete"><i class="fa fa-trash" aria-hidden="true" ></i></button>
                                                            </form>';
                                                        echo '</div></div></div></div>';
                                                        $cnt++;
                                                    }
                                                    echo '</div>';
                                                }
                                            ?>
                                            <br/>
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="gpaneTwo1" aria-labelledby="ghatstab1">
                                        <div class="container-fluid">
                                            <?php
                                                $sql = "SELECT * FROM goods WHERE uid = ".$info['uid']." AND total = 0;";
                                                $result = mysqli_query($conn, $sql);
                                                $cnt = 0;
                                                if (mysqli_num_rows($result) > 0) {
                                                    while($row = mysqli_fetch_assoc($result)){
                                                        if ($cnt % 3 == 0){
                                                            if ($cnt != 0) echo '</div><br/>';
                                                            echo '<div class="row">';
                                                        }
                                                        echo '<div class="col-4">';
                                                        echo '<div class="card">';
                                                        echo '<img class="card-img-top" src="'.$row['imgs'].'" alt="">';
                                                        echo '<div class="card-block">';
                                                        echo '<p class="card-title text-center"><a href="goods.php?id='.$row['cid'].'">'.$row['cname'].'</a></p>';
                                                        echo '<div class="float-left error">&yen;'.$row['price'].'</div>';
                                                        echo '<div class="float-right">';
                                                        echo '<form  role="form" action="update_goods.php" method="POST" class="form">';
                                                        echo '<input type="hidden" name="cid" value="'.$row['cid'].'" />';
                                                        echo '<button type="submit" class="btn btn-danger" name="delete"><i class="fa fa-trash" aria-hidden="true" ></i></button>
                                                            </form>';
                                                        echo '</div></div></div></div>';
                                                        $cnt++;
                                                    }
                                                    echo '</div>';
                                                }
                                            ?>
                                            <br/>
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="gpaneTwo2" aria-labelledby="ghatstab2">
                                        <div class="container-fluid">
                                            <form role="form" action="update_goods.php" method="POST"class="form" enctype="multipart/form-data">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-2" style="text-align: center ">
                                                            <label for="gname"><strong>商品名称</strong></label>
                                                        </div>
                                                        <div class="col-10">
                                                            <input type="text" class="form-control" id="gname" name="gname">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-2" style="text-align: center ">
                                                            <label><strong>商品类型</strong></label>
                                                        </div>
                                                        <div class="col-10">
                                                            <select name="options">
                                                                <option value="life">生活日用</option>
                                                                <option value="books">书籍报刊</option>
                                                                <option value="digital">闲置数码</option>
                                                                <option value="clothes">鞋服配饰</option>
                                                                <option value="animation">动漫周边</option>
                                                                <option value="others">其他</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-2" style="text-align: center ">
                                                            <label for="instruct"><strong>商品描述</strong></label>
                                                        </div>
                                                        <div class="col-10">
                                                            <textarea type="text" class="form-control" id="instruct" name="instruct"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-2" style="text-align: center ">
                                                            <label for="oprice"><strong>原&nbsp;&nbsp;价</strong></label>
                                                        </div>
                                                        <div class="col-10">
                                                            <input type="number" step="0.01" class="form-control" id="oprice" name="oprice">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-2" style="text-align: center ">
                                                            <label for="price"><strong>现&nbsp;&nbsp;价</strong></label>
                                                        </div>
                                                        <div class="col-10">
                                                            <input type="number" step="0.01" class="form-control" id="price" name="price" >
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-2" style="text-align: center ">
                                                            <label for="total"><strong>总&nbsp;&nbsp;量</strong></label>
                                                        </div>
                                                        <div class="col-10">
                                                            <input type="number" class="form-control" id="total" name="total">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-2" style="text-align: center ">
                                                            <label for="pic"><strong>上传图片</strong></label>
                                                        </div>
                                                        <div class="col-10">
                                                            <input type="file" class="form-control" id="pic" name="pic">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div style="text-align: right">
                                                    <button type="submit" class="btn btn-primary" name="update">确认添加</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade <?php echo $_GET['page'] == "favors"?"show active":""; ?>" id="paneTwo2" aria-labelledby="hatstab2">
                            <div class="container-fluid">
                                <ul id="fclothingnav" class="nav nav-pills" role="tablist">
                                    <li class="nav-item"> <a class="nav-link active" href="#fhome1" id="fhometab1" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">我的收藏</a> </li>
                                </ul>
                                <br/>
                                <!-- Content Panel -->
                                <div id="fclothingnavcontent" class="tab-content">
                                    <div role="tabpanel" class="tab-pane fade show active" id="fhome1" aria-labelledby="fhometab1">
                                        <div class="container-fluid">
                                            <?php
                                                $sql = "SELECT * FROM favors WHERE bid = ".$info['uid'].";";
                                                $result = mysqli_query($conn, $sql);
                                                $cnt = 0;
                                                if (mysqli_num_rows($result) > 0) {
                                                    while($row = mysqli_fetch_assoc($result)){
                                                        $sql = "SELECT * FROM goods WHERE cid = ".$row['cid'].";";
                                                        $res = mysqli_query($conn, $sql);
                                                        $cinfo = mysqli_fetch_array($res);
                                                        if ($cnt % 3 == 0){
                                                            if ($cnt != 0) echo '</div><br/>';
                                                            echo '<div class="row">';
                                                        }
                                                        echo '<div class="col-4">';
                                                        echo '<div class="card">';
                                                        echo '<img class="card-img-top" src="'.$cinfo['imgs'].'" alt="">';
                                                        echo '<div class="card-block">';
                                                        echo '<p class="card-title text-center"><a href="goods.php?id='.$row['cid'].'">'.$cinfo['cname'].'</a></p>';
                                                        echo '<div class="float-left error">&yen;'.$cinfo['price'].'</div>';
                                                        echo '<div class="float-right">';
                                                        echo '<form  role="form" action="update_cart_favors.php" method="POST" class="form">';
                                                        echo '<input type="hidden" name="cid" value="'.$row['cid'].'" />';
                                                        echo '<button type="submit" class="btn btn-danger" name="del_favors"><i class="fa fa-trash" aria-hidden="true" ></i></button>
                                                            </form>';
                                                        echo '</div></div></div></div>';
                                                        $cnt++;
                                                    }
                                                    echo '</div>';
                                                }
                                            ?>
                                            <br/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade <?php echo $_GET['page'] == "order"?"show active":""; ?>" id="paneTwo3" aria-labelledby="hatstab3">
                            <div class="container-fluid">
                                <ul id="oclothingnav" class="nav nav-pills" role="tablist">
                                    <li class="nav-item"> <a class="nav-link active" href="#ohome1" id="ohometab1" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">交易中订单</a> </li>
                                    <li class="nav-item"> <a class="nav-link" href="#opaneTwo1" role="tab" id="ohatstab1" data-toggle="tab" aria-controls="hats">历史订单</a> </li>
                                </ul>
                                <br/>
                                <!-- Content Panel -->
                                <div id="oclothingnavcontent" class="tab-content">
                                    <div role="tabpanel" class="tab-pane fade show active" id="ohome1" aria-labelledby="ohometab1">
                                        <div class="container-fluid">
                                            <div class="media-object-default">
                                                <?php
                                                    $sql = "SELECT * FROM order_form WHERE bid = ".$info['uid']." AND confirm = '0';";
                                                    $result = mysqli_query($conn, $sql);
                                                    if (mysqli_num_rows($result) > 0) {
                                                        while($row = mysqli_fetch_assoc($result)){
                                                            $sql = "SELECT * FROM goods WHERE cid = ".$row['cid'].";";
                                                            $res = mysqli_query($conn, $sql);
                                                            $cinfo = mysqli_fetch_array($res);
                                                            echo '<div class="media"> <img class="d-flex mr-3" src="'.$cinfo['imgs'].'" width="100" alt=""/>';
                                                            echo '<div class="media-body"><div class="row">
                                                                <div class="col-3">
                                                                    <p class="text-center"> <strong>商品名称</strong></p>
                                                                </div>
                                                                <div class="col-9">
                                                                    <a class="text-left" href="goods.php?id='.$cinfo['cid'].'"> <strong>'.$cinfo['cname'].'</strong></a>
                                                                </div>
                                                            </div>';
                                                            echo '<div class="row">
                                                                <div class="col-3">
                                                                    <p class="text-center"> <strong>卖家信息</strong></p>
                                                                </div>
                                                                <div class="col-9">
                                                                    <p class="text-left"> <strong>'.$row['sid'].'</strong></p>
                                                                </div>
                                                            </div>';
                                                            echo '<div class="row">
                                                                <div class="col-3">
                                                                    <p class="text-center"> <strong>下单时间</strong></p>
                                                                </div>
                                                                <div class="col-9">
                                                                    <p class="text-left"> <strong>'.$row['otime'].'</strong></p>
                                                                </div>
                                                            </div>';
                                                            echo '<br/>
                                                            <form role="form" method="POST" class="form" action="update_order.php">
                                                                <input type="hidden" name="oid" value="'.$row['oid'].'" />
                                                                <div class="text-right">
                                                                    <button type="submit" class="btn btn-danger" name="delete">删除订单</button>
                                                                    <button type="submit" class="btn btn-primary" name="confirm">确认订单</button>
                                                                </div>
                                                            </form>';
                                                            echo '</div></div>';
                                                        }
                                                    }
                                                ?>
                                            </div>
                                            <br/>
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="opaneTwo1" aria-labelledby="ohatstab1">
                                        <div class="container-fluid">
                                            <div class="media-object-default">
                                                <?php
                                                    $sql = "SELECT * FROM order_form WHERE bid = ".$info['uid']." AND confirm = '1';";
                                                    $result = mysqli_query($conn, $sql);
                                                    if (mysqli_num_rows($result) > 0) {
                                                        while($row = mysqli_fetch_assoc($result)){
                                                            $sql = "SELECT * FROM goods WHERE cid = ".$row['cid'].";";
                                                            $res = mysqli_query($conn, $sql);
                                                            $cinfo = mysqli_fetch_array($res);
                                                            echo '<div class="media"> <img class="d-flex mr-3" src="'.$cinfo['imgs'].'" width="100" alt=""/>';
                                                            echo '<div class="media-body"><div class="row">
                                                                <div class="col-3">
                                                                    <p class="text-center"> <strong>商品名称</strong></p>
                                                                </div>
                                                                <div class="col-9">
                                                                    <a class="text-left" href="goods.php?id='.$cinfo['cid'].'"> <strong>'.$cinfo['cname'].'</strong></a>
                                                                </div>
                                                            </div>';
                                                            echo '<div class="row">
                                                                <div class="col-3">
                                                                    <p class="text-center"> <strong>卖家信息</strong></p>
                                                                </div>
                                                                <div class="col-9">
                                                                    <p class="text-left"> <strong>'.$row['sid'].'</strong></p>
                                                                </div>
                                                            </div>';
                                                            echo '<div class="row">
                                                                <div class="col-3">
                                                                    <p class="text-center"> <strong>下单时间</strong></p>
                                                                </div>
                                                                <div class="col-9">
                                                                    <p class="text-left"> <strong>'.$row['otime'].'</strong></p>
                                                                </div>
                                                            </div>';
                                                            echo '<br/>
                                                            <form role="form" method="POST" class="form" action="update_order.php">
                                                                <input type="hidden" name="oid" value="'.$row['oid'].'" />
                                                                <div class="text-right">
                                                                    <button type="submit" class="btn btn-danger" name="delete">删除订单</button>
                                                                </div>
                                                            </form>';
                                                            echo '</div></div>';
                                                        }
                                                    }
                                                ?>
                                            </div>
                                            <br/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="modal fade" id="modal-avatar" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form class="avatar-form">
                    <div class="modal-header">
                        <h4 class="modal-title" id="avatar-modal-label">上传图片</h4>
                        <button class="close" data-dismiss="modal" type="button">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="avatar-body">
                            <div class="avatar-upload">
                                <input class="avatar-src" name="avatar_src" type="hidden">
                                <input class="avatar-data" name="avatar_data" type="hidden">
                                <button class="btn btn-danger" type="button" style="height: 35px;" onClick="$('input[id=avatarInput]').click();">请选择图片</button>
                                <span id="avatar-name"></span>
                                <input class="custom-file-input" id="avatarInput" name="avatar_file" type="file" hidden="true">
                            </div>
                            <div class="row">
                                <div class="col-9">
                                    <div class="avatar-wrapper"></div>
                                </div>
                                <div class="col-3">
                                    <div class="avatar-preview preview-lg" id="imageHead"></div>
                                </div>
                            </div>
                            <div class="row avatar-btns">
                                <div class="col-4">
                                    <div class="btn-group">
                                        <button class="btn btn-danger fa fa-undo" data-method="rotate" data-option="-90" type="button" title="Rotate -90 degrees"> 向左旋转</button>
                                    </div>
                                    <div class="btn-group">
                                        <button class="btn  btn-danger fa fa-repeat" data-method="rotate" data-option="90" type="button" title="Rotate 90 degrees"> 向右旋转</button>
                                    </div>
                                </div>
                                <div class="col-5 ml-auto">
                                    <button class="btn btn-danger fa fa-arrows" data-method="setDragMode" data-option="move" type="button" title="移动">
                                        <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="$().cropper(&quot;setDragMode&quot;, &quot;move&quot;)">
                                </span>
                                    </button>
                                    <button type="button" class="btn btn-danger fa fa-search-plus" data-method="zoom" data-option="0.1" title="放大图片">
                                        <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="$().cropper(&quot;zoom&quot;, 0.1)">
                                </span>
                                    </button>
                                    <button type="button" class="btn btn-danger fa fa-search-minus" data-method="zoom" data-option="-0.1" title="缩小图片">
                                        <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="$().cropper(&quot;zoom&quot;, -0.1)">
                                </span>
                                    </button>
                                    <button type="button" class="btn btn-danger fa fa-refresh" data-method="reset" title="重置图片">
                                        <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="$().cropper(&quot;reset&quot;)" aria-describedby="tooltip866214">
                                        </span>
                                    </button>
                                </div>
                                <div class="col-3">
                                    <button class="btn btn-danger btn-block avatar-save fa fa-save" type="button" data-dismiss="modal"> 保存修改</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <br/>
    <footer class="footer navbar-fixed-bottom ">
        <div style="text-align: center">
            <p>Copyright &copy; 2018.ProboxDu All Rights Reserved.</p>
        </div>
    </footer>
    <script src="js/html2canvas.min.js"></script>
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap-4.0.0.js"></script>
    <script src="js/check.js"></script>
    <script src="js/sitelogo.js"></script>
    <script stc="js/cropper.js"></script>
</body>

</html>