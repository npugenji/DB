<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
{   
    header('location:index.php');
}
else
{ 
    if(isset($_POST['update']))
    {
        $preISBN=$_GET['preISBN'];
        $name=$_POST['name'];
        $author=$_POST['author'];
        $ISBN=$_POST['ISBN'];
        $press=$_POST['press'];
        $pub_date=$_POST['pub_date'];
        $available=$_POST['available'];
        $sql="update book set ISBN=:ISBN, author=:author, name=:name, press=:press, pub_date=:pub_date, available=:available where ISBN=:preISBN";
        $query = $dbh->prepare($sql);
        $query->bindParam(':ISBN',$ISBN,PDO::PARAM_STR);
        $query->bindParam(':author',$author,PDO::PARAM_STR);
        $query->bindParam(':name',$name,PDO::PARAM_STR);
        $query->bindParam(':press',$press,PDO::PARAM_STR);
        $query->bindParam(':pub_date',$pub_date,PDO::PARAM_STR);
        $query->bindParam(':available',$available,PDO::PARAM_STR);
        $query->bindParam(':preISBN',$preISBN,PDO::PARAM_STR);
        $query->execute();
        $_SESSION['msg'] = '修改成功';
        header('location:manage-books.php?');      
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

            <div class="row">
                <?php if($_GET['msg']!="") {?>
                <div class="col-md-6">
                <div class="alert alert-success" >
                 <?php echo htmlentities($_GET['msg']);?>
                 <?php echo htmlentities($_GET['msg']='');?>
                </div>
                </div>
                <?php } ?>
            </div>
            
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">修改书籍信息</h4>
            </div>
        </div>
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3"">
<div class="panel panel-info">
<div class="panel-heading">
书籍信息
</div>
<div class="panel-body">
<form role="form" method="post">
<?php 
$ISBN=$_GET['preISBN'];
$sql = "SELECT name, author, ISBN, press, pub_date, available from book where ISBN=:ISBN";
$query = $dbh -> prepare($sql);
$query->bindParam(':ISBN',$ISBN,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
    foreach($results as $result)
    {
    ?>  
        <div class="form-group">
        <label>ISBN<span style="color:red;">*</span></label>
        <input class="form-control" type="text" name="ISBN" value="<?php echo htmlentities($result->ISBN);?>" required />
        </div>

        <div class="form-group">
        <label>书名<span style="color:red;">*</span></label>
        <input class="form-control" type="text" name="name" value="<?php echo htmlentities($result->name);?>" required />
        </div>

        <div class="form-group">
        <label>作者<span style="color:red;">*</span></label>
        <input class="form-control" type="text" name="author" value="<?php echo htmlentities($result->author);?>" required /> 
        </div>

        <div class="form-group">
        <label>出版社<span style="color:red;">*</span></label>
        <input class="form-control" type="text" name="press" value="<?php echo htmlentities($result->press);?>" required /> 
        </div>
 
        <div class="form-group">
        <label>出版日期<span style="color:red;">*</span></label>
        <input class="form-control" type="date" name="pub_date" value="<?php echo htmlentities($result->pub_date);?>" required />
        </div>

        <div class="form-group">
        <label>是否能外借<span style="color:red;">*</span></label>
        <select class="form-control" name="available" required>
        <?php  if ( $result->available ) { ?>
                <option value=1>是</option>
                <option value=0>否</option>
        <?php }else{ ?>
                <option value=0>否</option>
                <option value=1>是</option>
        <?php } ?>
        </select>
        </div>

        <?php }} ?>
        <button type="submit" name="update" class="btn btn-info">更新</button>

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
