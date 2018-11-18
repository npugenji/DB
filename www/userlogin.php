<?php
	session_start();
	error_reporting(0);
	include('includes/config.php');
	if($_SESSION['login']!='')
	{
		$_SESSION['login']='';
	}
	if(isset($_POST['login']))
	{
		//code for captach verification
			$id=$_POST['id'];
			$password=md5($_POST['password']);
			$sql ="SELECT id,Password FROM student WHERE id=:id and password=:password";
			$query= $dbh -> prepare($sql);
			$query-> bindParam(':id', $id, PDO::PARAM_STR);
			$query-> bindParam(':password', $password, PDO::PARAM_STR);
			$query-> execute();
			$results=$query->fetchAll(PDO::FETCH_OBJ);

			if($query->rowCount() > 0)
			{
				$_SESSION['login'] = $_POST['id'];
				$_SESSION['stdid'] = $_POST['id'];
				echo "<script type='text/javascript'> document.location = 'dashboard.php'; </script>";
			}
			else
			{
				echo "<script>alert('账号或密码错误');</script>";
			}
	}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>图书管理系统</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

</head>
<body>
    <!------MENU SECTION START-->
<?php include('includes/header.php');?>
<!-- MENU SECTION END-->
<div class="content-wrapper">
<div class="container">
<div class="row pad-botm">
<div class="col-md-12">
<h4 class="header-line">用户登录</h4>
</div>
</div>
             
<!--LOGIN PANEL START-->           
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3" >
<div class="panel panel-info">
<div class="panel-body">
<form role="form" method="post">

	<div class="form-group">
	<label>账号</label>
	<input class="form-control" type="text" name="id" required autocomplete="off" />
	</div>
	<div class="form-group">
	<label>密码</label>
	<input class="form-control" type="password" name="password" required autocomplete="off"  />
	<!-- <p class="help-block"><a href="user-forgot-password.php">忘记密码</a></p> -->
	</div>

 <button type="submit" name="login" class="btn btn-info">登录</button>
</form>
 </div>
</div>
</div>
</div>  
<!---LOGIN PABNEL END-->
 
    </div>
    </div>
	<!-- CONTENT-WRAPPER SECTION END-->
	<?php include('includes/footer.php');?>
	<!-- FOOTER SECTION END-->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
	<!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>

</body>
</html>
