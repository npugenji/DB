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
        $ISBN=$_POST['ISBN'];
        $name=$_POST['name'];
        $author=$_POST['author'];
        $press=$_POST['press'];
        $pub_date=$_POST['pub_date'];
        $available=$_POST['available'];

        $sql="INSERT INTO book(ISBN,name,author,press,pub_date,available) VALUES(:ISBN,:name,:author,:press,:pub_date,:available)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':ISBN',$ISBN,PDO::PARAM_STR);
        $query->bindParam(':name',$name,PDO::PARAM_STR);
        $query->bindParam(':author',$author,PDO::PARAM_STR);
        $query->bindParam(':press',$press,PDO::PARAM_STR);
        $query->bindParam(':pub_date', $pub_date, PDO::PARAM_STR);
        $query->bindParam(':available',$available,PDO::PARAM_STR);
        $query->execute();
        $rowcnt = $query->rowCount();
        if($rowcnt)
        {
            $_SESSION['msg']="成功添加书籍";
            header('location:manage-books.php');
        }
        else 
        {
            $_SESSION['error']="书籍添加错误，请检查数据是否有误";
            header('location:manage-books.php');
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
                <h4 class="header-line">添加书籍</h4>
            </div>
        </div>
        

<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3"">
<div class="panel panel-info">
<div class="panel-heading">书籍信息</div>
<div class="panel-body">
<form role="form" method="post">

<div class="form-group">
    <label>ISBN<span style="color:red;">*</span></label>
    <input class="form-control" type="text" name="ISBN" autocomplete="off" required />
</div>

<div class="form-group">
<label>书名<span style="color:red;">*</span></label>
<input class="form-control" type="text" name="name" autocomplete="off"  required />
</div>

<div class="form-group">
<label>作者<span style="color:red;">*</span></label>
<input class="form-control" type="text" name="author" autocomplete="off" required />
</div>

<div class="form-group">
<label>出版社<span style="color:red;">*</span></label>
<input class="form-control" type="text" name="press" autocomplete="off" required />
</div>

<div class="form-group">
<label>出版日期<span style="color:red;">*</span></label>
<input class="form-control" type="date" name="pub_date" autocomplete="off" required />
</div>

<div class="form-group">
<label>是否能外借<span style="color:red;">*</span></label>
<select class="form-control" name="available" required>
    <option value="">请选择是否能外借</option>
    <option value=1>是</option>
    <option value=0>否</option>
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
