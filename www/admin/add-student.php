<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
{   
    header('location:index.php');
}
else{
    if(isset($_POST['startadd']))
    {
        $id=$_POST['id'];
        $name=$_POST['name'];
        $gender=$_POST['gender'];
        $password=md5($_POST['password']);
        $tel=$_POST['tel'];
        $type=$_POST['type'];

        $sql="INSERT INTO student(id,name,gender,password,tel,type) VALUES(:id,:name,:gender,:password,:tel,:type)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id',$id,PDO::PARAM_STR);
        $query->bindParam(':name',$name,PDO::PARAM_STR);
        $query->bindParam(':gender',$gender,PDO::PARAM_STR);
        $query->bindParam(':password',$password,PDO::PARAM_STR);
        $query->bindParam(':tel', $tel, PDO::PARAM_STR);
        $query->bindParam(':type',$type,PDO::PARAM_STR);
        $query->execute();
        $rowcnt = $query->rowCount();
        if($rowcnt)
        {
            $_SESSION['msg']="成功添加学生";
            header('location:manage-students.php');
        }
        else 
        {
            $_SESSION['error']="添加错误，请检查数据是否有误";
            header('location:manage-students.php');
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
                <h4 class="header-line">添加学生</h4>
            </div>
        </div>
        

<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3"">
<div class="panel panel-info">
<div class="panel-heading">学生信息</div>
<div class="panel-body">
<form role="form" method="post">

<div class="form-group">
<label>学号<span style="color:red;">*</span></label>
<input class="form-control" type="text" name="id" autocomplete="off" required />
</div>

<div class="form-group">
<label>姓名<span style="color:red;">*</span></label>
<input class="form-control" type="text" name="name" autocomplete="off"  required />
</div>

<div class="form-group">
<label>性别<span style="color:red;">*</span></label>
<select class="form-control" name="gender" required>
    <option value="男">男</option>
    <option value="女">女</option>
</select>
</div>

<div class="form-group">
<label>密码<span style="color:red;">*</span></label>
<input class="form-control" type="password" name="password" autocomplete="off" required />
</div>

<div class="form-group">
<label>电话<span style="color:red;">*</span></label>
<input class="form-control" type="text" name="tel" autocomplete="off" required />
</div>

<div class="form-group">
<label>读者类型<span style="color:red;">*</span></label>
<select class="form-control" name="type" required>
    <option value="本科">本科</option>
    <option value="硕士">硕士</option>
    <option value="博士">博士</option>
</select>
</div>

<input type="submit" name="startadd"/>

</form>
</div>
</div>
</div>
</div>
</div>
</div>
     <!-- CONTENT-WRAPPER SECTION END-->
  <?php include('includes/footer.php');?>
      <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY  -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
      <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>
</body>
</html>
<?php } ?>
