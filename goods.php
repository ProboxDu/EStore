<?php

/**
 * @Filename: goods.php 
 * @Author: ProboxDu
 * @Date:   2018-06-27 13:44:26
 * @Last Modified by:   ProboxDu
 * @Last Modified time: 2018-07-01 11:37:09
 */
?>
<?php
    include("conn.php");
    session_start();
    header('Content-Type:text/html;charset=utf-8');
    $cinfo = array();
    $uinfo = array();
    if (isset($_GET['id'])){
        $cid = $_GET['id'];
        $sql = "SELECT * FROM goods WHERE cid = $cid;";
        $result = mysqli_query($conn, $sql);
        $cinfo = mysqli_fetch_assoc($result);
        if (!$cinfo){
            echo '<script>alert("错误的id！");location.href="javascript:history.back()";</script>';
            exit;
        }
        #print_r($cinfo);
        $sql = "SELECT * FROM users WHERE uid = ".$cinfo['uid'].";";
        $result = mysqli_query($conn, $sql);
        $uinfo = mysqli_fetch_assoc($result);
        #print_r($uinfo);
    }else {
        echo '<script>alert("错误的请求！");location.href="javascript:history.back()";</script>';
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
                <?php 
                    if (isset($_SESSION["username"])){
                        echo '<li class="nav-item"> <a class="btn" href="logout.php" ><i class="fa fa-sign-out" aria-hidden="true"></i> 注销</a> </li>';
                    }else {
                        echo '<li class="nav-item"> <a class="btn" href="#" data-toggle="modal" data-target="#modal-login"><i class="fa fa-sign-in" aria-hidden="true"></i> 登录</a> </li>';
                    };
                ?>
            </ul>
        </div>
    </nav>
    <div class="modal fade" id="modal-login" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title" id="modal-login-label">
                        <h4 class="text-center">登录</h4>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <form role="form" action="login.php" method="post" class="form">
                            <div class="form-group">
                                <div class="input-group">
                                  <div class="input-group-prepend"> <span class="input-group-text" id="basicaddon1"><i class="fa fa-user" aria-hidden="true"></i></span> </div>
                                  <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" onBlur="checkUsername()" aria-describedby="basicaddon1">
                              </div>
                                <div class="error"> <span id="nameInfo"></span></div>
                            </div>
                            
                            <div class="form-group">
                                <div class="input-group">
                                  <div class="input-group-prepend"> <span class="input-group-text" id="basicaddon2"> <i class="fa fa-lock" aria-hidden="true"></i></span> </div>
                                  <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" onBlur="checkPassword()" aria-describedby="basicaddon2">
                              </div>
                                 <div class="error"> <span id="passwordInfo"></span></div>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" name="remember" value="1"> Remember me
                                </label>
                            </div>
                            <div style="float:left;">
                                <a href="" data-toggle="modal" data-dismiss="modal" data-target="#modal-register">还没有账号？点我注册</a>
                                </div>
                                <div style="float:right;">
                                    <button type="submit" name="login" class="btn btn-primary" onclick="return checkLogForm()">Log in</button>
                                </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-register" tabindex="-1" role="dialog" aria-labelledby="modal-register-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title" id="modal-register-label">
                        <h4>注册</h4>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <form role="form" action="register.php" method="post" class="form">
                            <div class="form-group">
                                <label for="_username">用户名</label>
                                <input type="text" class="form-control" id="_username" name = "username" placeholder="Enter username" onBlur="check_Username()">
                                <div class="error"> <span id="_nameInfo"></span></div>
                            </div>
                            <div class="form-group">
                                <label for="_phone">手机号码</label>
                                <input type="number" class="form-control" id="_phone" name = "phone" placeholder="Enter Phone number" onBlur="check_Phone()">
                                <div class="error"> <span id="phoneInfo"></span></div>
                            </div>
                            <div class="form-group">
                                <label for="_password">密码(8-16)</label>
                                <input type="password" class="form-control" id="_password" name ="password" placeholder="Enter password" onBlur="check_Password()">
                                <div class="error"><span id="_passwordInfo"></span> </div>
                            </div>
                            <div class="form-group">
                                <label for="repassword">重复密码</label>
                                <input type="password" class="form-control" id="repassword" placeholder="Repeat password" onBlur="checkRepassword()">
                                <div class="error"> <span id="repasswordInfo"></span></div>
                            </div>
                            <div style="text-align: right">
                                <button type="submit" name="register" class="btn btn-primary" onclick="return checkReForm()">Sign Up</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br/>
    <div class="container">
        <div class="container-fluid">
            <div class="card col-12">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <a href="#"> 卖家: <?php echo $uinfo['username']?></a>
                        </div>
                        <div class="col-6" style="text-align: right">
                            该用户历史成交量: <?php echo $uinfo['volume']?>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-6">
                                <img src="<?php echo $cinfo['imgs']?>" class="img-fluid" height="450" width="450" alt="Placeholder image">
                            </div>
                            <div class="col-6">
                                <div class="container-fluid">
                                    <div style="text-align: center">
                                        <h4><strong><?php echo $cinfo['cname']?></strong></h4>
                                    </div>
                                    <br/>
                                    <form role="form" method="POST" action="update_cart_favors.php" class="form">
                                        <input type="hidden" name="cid" value="<?php echo $cinfo['cid']?>" />
                                        <div class="row">
                                            <div class="col-3" style="text-align: center">
                                                <label><strong> 分&nbsp;&nbsp;类</strong></label>
                                            </div>
                                            <div class="col-9">
                                                <p><?php switch ($cinfo['type']){
                                                    case "books":echo "书籍报刊"; break;
                                                    case "digital":echo "闲置数码";break;
                                                    case "clothes":echo "鞋服配饰";break;
                                                    case "life":echo "生活日用";break;
                                                    case "animation":echo "动漫周边";break;
                                                    default:echo "其他";
                                                }?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-3" style="text-align: center">
                                                <label><strong> 简&nbsp;&nbsp;介</strong></label>
                                            </div>
                                            <div class="col-9">
                                                <p><?php echo $cinfo['instruction']?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-3" style="text-align: center">
                                                <label><strong> 原&nbsp;&nbsp;价</strong></label>
                                            </div>
                                            <div class="col-9">
                                                <p>&yen;<?php echo $cinfo['ori_price']?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-3" style="text-align: center">
                                                <label><strong> 现&nbsp;&nbsp;价</strong></label>
                                            </div>
                                            <div class="col-9">
                                                <p class="error"><strong> &yen;<?php echo $cinfo['price']?></strong></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-3" style="text-align: center">
                                                    <label><strong> 数&nbsp;&nbsp;量</strong></label>
                                                </div>
                                                <div class="col-9">
                                                    <input type="number" name="number" value="1" max="<?php echo $cinfo['total'];?>">
                                                    总<?php echo $cinfo['total'];?>件
                                                </div>
                                            </div>
                                        </div>
                                        <br/>
                                        <div class="text-right">
                                            <button type="submit" name="add_favors" class="btn btn-light"><i class="fa fa-star" aria-hidden="true" ></i> 加入收藏夹</button>
                                            <button type="submit" name="add_cart" class="btn btn-danger"><i class="fa fa-shopping-cart" aria-hidden="true" ></i> 加入购物车</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br/>
    <footer class="footer navbar-fixed-bottom ">
        <div style="text-align: center">
            <p>Copyright &copy; 2018.ProboxDu All Rights Reserved.</p>
        </div>
    </footer>
    <script src="/js/jquery-3.2.1.min.js"></script>
    <script src="/js/popper.min.js"></script>
    <script src="/js/bootstrap-4.0.0.js"></script>
    <script src="/js/check.js"></script>
</body>

</html>