<div class="navbar navbar-inverse set-radius-zero" >
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" >
                    <img src="assets/img/logo.png" height="70" width="300"/>
                </a>

            </div>
			<?php if($_SESSION['login'])
			{
			?> 
            <div class="right-div">
                <a href="logout.php" class="btn btn-danger pull-right">退出</a>
            </div>
            <?php }?>
        </div>
</div>
    <!-- LOGO HEADER END-->
<?php if($_SESSION['login'])
{
?>    
<section class="menu-section">
        <div class="container">
            <div class="row ">
                <div class="col-md-12">
                    <div class="navbar-collapse collapse ">
                        <ul id="menu-top" class="nav navbar-nav navbar-right">
                            <li><a href="dashboard.php">主界面</a></li>
                            <li><a href="borrow_log.php">借阅记录</a></li>
                            <li><a href="borrow-book.php">书籍</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } else { ?>
        <section class="menu-section">
        <div class="container">
            <div class="row ">
                <div class="col-md-12">
                    <div class="navbar-collapse collapse ">
                        <ul id="menu-top" class="nav navbar-nav navbar-right">                        
							<li><a href="adminlogin.php">管理员登录</a></li>
                            <li><a href="index.php">普通用户登录</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php } ?>