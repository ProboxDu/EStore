<?php

/**
 * @Filename: index.php 
 * @Author: ProboxDu
 * @Date:   2018-06-15 19:00:01
 * @Last Modified by:   ProboxDu
 * @Last Modified time: 2018-07-01 11:35:52
 */
?>
<?php
    include("conn.php");
    session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/css/bootstrap-4.0.0.css" rel="stylesheet" type="text/css">
    <link href="/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="/css/style.css" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Eater" rel="stylesheet">
    <title>EStore</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light navbar-static-top"> <a class="navbar-brand" href="#">
		<div style="font-family: 'Eater', cursive;">EStore</div></a>
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
            <ul id="clothingnav1" class="nav nav-pills" role="tablist">
                <li class="nav-item"> <a class="nav-link active" href="#home1" id="hometab1" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">Home</a> </li>
                <li class="nav-item"> <a class="nav-link " href="#paneTwo1" role="tab" id="hatstab1" data-toggle="tab" aria-controls="hats">生活日用 </a></li>
                <li class="nav-item"> <a class="nav-link" href="#paneTwo2" role="tab" id="hatstab2" data-toggle="tab" aria-controls="hats">书籍报刊 </a></li>
                <li class="nav-item"> <a class="nav-link" href="#paneTwo3" role="tab" id="hatstab3" data-toggle="tab" aria-controls="hats">闲置数码 </a></li>
                <li class="nav-item"> <a class="nav-link" href="#paneTwo4" role="tab" id="hatstab4" data-toggle="tab" aria-controls="hats">鞋服配饰 </a></li>
                <li class="nav-item"> <a class="nav-link" href="#paneTwo5" role="tab" id="hatstab5" data-toggle="tab" aria-controls="hats">动漫周边 </a></li>
                <li class="nav-item"> <a class="nav-link" href="#paneTwo6" role="tab" id="hatstab6" data-toggle="tab" aria-controls="hats">其他 </a></li>
            </ul>
            <br/>
            <!-- Content Panel -->
            <div id="clothingnavcontent1" class="tab-content">
                <div role="tabpanel" class="tab-pane fade show active" id="home1" aria-labelledby="hometab1">
                    <div class="container-fluid">
                        <div id="demo" class="carousel slide" data-ride="carousel">
                            <!-- 指示符 -->
                            <ul class="carousel-indicators">
                                <li data-target="#demo" data-slide-to="0" class="active"></li>
                                <li data-target="#demo" data-slide-to="1"></li>
                                <li data-target="#demo" data-slide-to="2"></li>
                            </ul>
                            <!-- 轮播图片 -->
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="https://static.runoob.com/images/mix/img_fjords_wide.jpg" alt="">
                                </div>
                                <div class="carousel-item">
                                    <img src="https://static.runoob.com/images/mix/img_nature_wide.jpg" alt="">
                                </div>
                                <div class="carousel-item">
                                    <img src="https://static.runoob.com/images/mix/img_mountains_wide.jpg" alt="">
                                </div>
                            </div>
                            <!-- 左右切换按钮 -->
                            <a class="carousel-control-prev" href="#demo" data-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </a>
                            <a class="carousel-control-next" href="#demo" data-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </a>
                        </div>
                        <br/>
                        <div class="row">
                            <img src="icons/one_title.png" height="100" width="400" alt="" />
                            <div class="one_title"> <a href="#"><img src="icons/book.png" class="icons" alt=""/></a>
                                <h2><a href="#">最新上架<span>New Arrivals goods</span></a></h2>
                                <p><a href="#"><img src="icons/more.gif" alt=""/></a></p>
                            </div>
                        </div>
                        <?php
                            $sql = "SELECT * FROM goods WHERE total > 0 ORDER BY cid DESC;";
                            $result = mysqli_query($conn, $sql);
                            $cnt = 0;
                            if (mysqli_num_rows($result) > 0) {
                                while($row = mysqli_fetch_assoc($result)){
                                    if ($cnt % 4 == 0){
                                        if ($cnt != 0) echo '</div><br/>';
                                        echo '<div class="row">';
                                    }
                                    echo '<div class="col-3">';
                                    echo '<div class="card">';
                                    echo '<img class="card-img-top" src="'.$row['imgs'].'" alt="">';
                                    echo '<div class="card-block">';
                                    echo '<p class="card-title text-center"><a href="goods.php?id='.$row['cid'].'">'.$row['cname'].'</a></p>';
                                    echo '<div class="float-left error">&yen;'.$row['price'].'</div>';
                                    echo '</div></div></div>';
                                    $cnt++;
                                }
                                echo '</div>';
                            }
                        ?>
						<br/>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="paneTwo1" aria-labelledby="hatstab1">
                    <div class="container-fluid">
                        <div class="row">
                            <img src="icons/one_title.png" height="100" width="400" alt="" />
                            <div class="one_title"> <a href="#"><img src="icons/book.png" class="icons" alt=""/></a>
                                <h2><a href="#">最新上架<span>New Arrivals goods</span></a></h2>
                                <p><a href="#"><img src="icons/more.gif" alt=""/></a></p>
                            </div>
                        </div>
                        <?php
                            $sql = "SELECT * FROM goods WHERE type = 'life' AND total > 0 ORDER BY cid DESC;";
                            $result = mysqli_query($conn, $sql);
                            $cnt = 0;
                            if (mysqli_num_rows($result) > 0) {
                                while($row = mysqli_fetch_assoc($result)){
                                    if ($cnt % 4 == 0){
                                        if ($cnt != 0) echo '</div><br/>';
                                        echo '<div class="row">';
                                    }
                                    echo '<div class="col-3">';
                                    echo '<div class="card">';
                                    echo '<img class="card-img-top" src="'.$row['imgs'].'" alt="">';
                                    echo '<div class="card-block">';
                                    echo '<p class="card-title text-center"><a href="goods.php?id='.$row['cid'].'">'.$row['cname'].'</a></p>';
                                    echo '<div class="float-left error">&yen;'.$row['price'].'</div>';
                                    echo '</div></div></div>';
                                    $cnt++;
                                }
                                echo '</div>';
                            }
                        ?>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="paneTwo2" aria-labelledby="hatstab2">
                    <div class="container-fluid">
                    	<div class="row">
							<img src="icons/one_title.png" height="100" width="400" alt="" />
							<div class="one_title"> <a href="#"><img src="icons/book.png" class="icons" alt=""/></a>
								<h2><a href="#">最新上架<span>New Arrivals goods</span></a></h2>
								<p><a href="#"><img src="icons/more.gif" alt=""/></a></p>
							</div>
						</div>
						<?php
                            $sql = "SELECT * FROM goods WHERE type = 'books' AND total > 0  ORDER BY cid DESC;";
                            $result = mysqli_query($conn, $sql);
                            $cnt = 0;
                            if (mysqli_num_rows($result) > 0) {
                                while($row = mysqli_fetch_assoc($result)){
                                    if ($cnt % 4 == 0){
                                        if ($cnt != 0) echo '</div><br/>';
                                        echo '<div class="row">';
                                    }
                                    echo '<div class="col-3">';
                                    echo '<div class="card">';
                                    echo '<img class="card-img-top" src="'.$row['imgs'].'" alt="">';
                                    echo '<div class="card-block">';
                                    echo '<p class="card-title text-center"><a href="goods.php?id='.$row['cid'].'">'.$row['cname'].'</a></p>';
                                    echo '<div class="float-left error">&yen;'.$row['price'].'</div>';
                                    echo '</div></div></div>';
                                    $cnt++;
                                }
                                echo '</div>';
                            }
                        ?>
                    </div>
            	</div>
				<div role="tabpanel" class="tab-pane fade" id="paneTwo3" aria-labelledby="hatstab3">
					<div class="container-fluid">
						<div class="row">
							<img src="icons/one_title.png" height="100" width="400" alt="" />
							<div class="one_title"> <a href="#"><img src="icons/book.png" class="icons" alt=""/></a>
								<h2><a href="#">最新上架<span>New Arrivals goods</span></a></h2>
								<p><a href="#"><img src="icons/more.gif" alt=""/></a></p>
							</div>
						</div>
						<?php
                            $sql = "SELECT * FROM goods WHERE type = 'digital' AND total > 0 ORDER BY cid DESC;";
                            $result = mysqli_query($conn, $sql);
                            $cnt = 0;
                            if (mysqli_num_rows($result) > 0) {
                                while($row = mysqli_fetch_assoc($result)){
                                    if ($cnt % 4 == 0){
                                        if ($cnt != 0) echo '</div><br/>';
                                        echo '<div class="row">';
                                    }
                                    echo '<div class="col-3">';
                                    echo '<div class="card">';
                                    echo '<img class="card-img-top" src="'.$row['imgs'].'" alt="">';
                                    echo '<div class="card-block">';
                                    echo '<p class="card-title text-center"><a href="goods.php?id='.$row['cid'].'">'.$row['cname'].'</a></p>';
                                    echo '<div class="float-left error">&yen;'.$row['price'].'</div>';
                                    echo '</div></div></div>';
                                    $cnt++;
                                }
                                echo '</div>';
                            }
                        ?>
					</div>
				</div>
				<div role="tabpanel" class="tab-pane fade" id="paneTwo4" aria-labelledby="hatstab4">
					<div class="container-fluid">
						<div class="row">
							<img src="icons/one_title.png" height="100" width="400" alt="" />
							<div class="one_title"> <a href="#"><img src="icons/book.png" class="icons" alt=""/></a>
								<h2><a href="#">最新上架<span>New Arrivals goods</span></a></h2>
								<p><a href="#"><img src="icons/more.gif" alt=""/></a></p>
							</div>
						</div>
						<?php
                            $sql = "SELECT * FROM goods WHERE type = 'clothes' AND total > 0 ORDER BY cid DESC;";
                            $result = mysqli_query($conn, $sql);
                            $cnt = 0;
                            if (mysqli_num_rows($result) > 0) {
                                while($row = mysqli_fetch_assoc($result)){
                                    if ($cnt % 4 == 0){
                                        if ($cnt != 0) echo '</div><br/>';
                                        echo '<div class="row">';
                                    }
                                    echo '<div class="col-3">';
                                    echo '<div class="card">';
                                    echo '<img class="card-img-top" src="'.$row['imgs'].'" alt="">';
                                    echo '<div class="card-block">';
                                    echo '<p class="card-title text-center"><a href="goods.php?id='.$row['cid'].'">'.$row['cname'].'</a></p>';
                                    echo '<div class="float-left error">&yen;'.$row['price'].'</div>';
                                    echo '</div></div></div>';
                                    $cnt++;
                                }
                                echo '</div>';
                            }
                        ?>
					</div>
				</div>
				<div role="tabpanel" class="tab-pane fade" id="paneTwo5" aria-labelledby="hatstab5">
					<div class="container-fluid">
						<div class="row">
							<img src="icons/one_title.png" height="100" width="400" alt="" />
							<div class="one_title"> <a href="#"><img src="icons/book.png" class="icons" alt=""/></a>
								<h2><a href="#">最新上架<span>New Arrivals goods</span></a></h2>
								<p><a href="#"><img src="icons/more.gif" alt=""/></a></p>
							</div>
						</div>
						<?php
                            $sql = "SELECT * FROM goods WHERE type = 'animation' AND total > 0 ORDER BY cid DESC;";
                            $result = mysqli_query($conn, $sql);
                            $cnt = 0;
                            if (mysqli_num_rows($result) > 0) {
                                while($row = mysqli_fetch_assoc($result)){
                                    if ($cnt % 4 == 0){
                                        if ($cnt != 0) echo '</div><br/>';
                                        echo '<div class="row">';
                                    }
                                    echo '<div class="col-3">';
                                    echo '<div class="card">';
                                    echo '<img class="card-img-top" src="'.$row['imgs'].'" alt="">';
                                    echo '<div class="card-block">';
                                    echo '<p class="card-title text-center"><a href="goods.php?id='.$row['cid'].'">'.$row['cname'].'</a></p>';
                                    echo '<div class="float-left error">&yen;'.$row['price'].'</div>';
                                    echo '</div></div></div>';
                                    $cnt++;
                                }
                                echo '</div>';
                            }
                        ?>
					</div>
				</div>
                <div role="tabpanel" class="tab-pane fade" id="paneTwo6" aria-labelledby="hatstab6">
                    <div class="container-fluid">
                        <div class="row">
                            <img src="icons/one_title.png" height="100" width="400" alt="" />
                            <div class="one_title"> <a href="#"><img src="icons/book.png" class="icons" alt=""/></a>
                                <h2><a href="#">最新上架<span>New Arrivals goods</span></a></h2>
                                <p><a href="#"><img src="icons/more.gif" alt=""/></a></p>
                            </div>
                        </div>
                        <?php
                            $sql = "SELECT * FROM goods WHERE type = 'others' AND total > 0 ORDER BY cid DESC;";
                            $result = mysqli_query($conn, $sql);
                            $cnt = 0;
                            if (mysqli_num_rows($result) > 0) {
                                while($row = mysqli_fetch_assoc($result)){
                                    if ($cnt % 4 == 0){
                                        if ($cnt != 0) echo '</div><br/>';
                                        echo '<div class="row">';
                                    }
                                    echo '<div class="col-3">';
                                    echo '<div class="card">';
                                    echo '<img class="card-img-top" src="'.$row['imgs'].'" alt="">';
                                    echo '<div class="card-block">';
                                    echo '<p class="card-title text-center"><a href="goods.php?id='.$row['cid'].'">'.$row['cname'].'</a></p>';
                                    echo '<div class="float-left error">&yen;'.$row['price'].'</div>';
                                    echo '</div></div></div>';
                                    $cnt++;
                                }
                                echo '</div>';
                            }
                        ?>
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