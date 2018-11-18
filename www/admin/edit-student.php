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
        $updateid=$_GET['updateid'];
        $id=$_POST['id'];
        $name=$_POST['name'];
        $gender=$_POST['gender'];
        $tel=$_POST['tel'];
        $type=$_POST['type'];
        $borrowed_amo=intval($_POST['borrowed_amo']);
        $borrowed_total=intval($_POST['borrowed_total']);
        $sql="update student set id=:id, name=:name, gender=:gender, tel=:tel, type=:type, borrowed_amo=:borrowed_amo, borrowed_total=:borrowed_total where id=:updateid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':gender', $gender, PDO::PARAM_STR);
        $query->bindParam(':tel', $tel, PDO::PARAM_STR);
        $query->bindParam(':type', $type, PDO::PARAM_STR);
        $query->bindParam(':borrowed_amo', $borrowed_amo, PDO::PARAM_STR);
        $query->bindParam(':borrowed_total', $borrowed_total, PDO::PARAM_STR);
        $query->bindParam(':updateid', $updateid, PDO::PARAM_STR);
        $query->execute();
        $_SESSION['msg']='修改成功';
        header('location:manage-students.php');      
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
    <div class="content-wra
    <div class="content-wrapper">
         <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">修改学生信息</h4>
            </div>
        </div>
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3"">
<div class="panel panel-info">
<div class="panel-heading">
学生信息
</div>
<div class="panel-body">
<form role="form" method="post">
<?php 
$id=$_GET['updateid'];
$sql = "SELECT id, name, gender, tel, type, borrowed_amo, borrowed_total from student where id=:id";
$query = $dbh -> prepare($sql);
$query->bindParam(':id',$id,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
    foreach($results as $result)
    {
    ?>  
        <div class="form-group">
        <label>学号<span style="color:red;">*</span></label>
        <input class="form-control" type="text" name="id" value="<?php echo htmlentities($result->id);?>" required />
        </div>

        <div class="form-group">
        <label>姓名<span style="color:red;">*</span></label>
        <input class="form-control" type="text" name="name" value="<?php echo htmlentities($result->name);?>" required />
        </div>

        <div class="form-group">
        <label>性别<span style="color:red;">*</span></label>
        <select class="form-control" name="gender" required>
        <?php  if ( $result->gender == "男" ) { ?>
                <option value="男">男</option>
                <option value="女">女</option>
        <?php }else{ ?>
                <option value="女">女</option>
                <option value="男">男</option>
        <?php } ?>
        </select>
        </div>

        <div class="form-group">
        <label>手机<span style="color:red;">*</span></label>
        <input class="form-control" type="text" name="tel" value="<?php echo htmlentities($result->tel);?>" required /> 
        </div>
 
        <div class="form-group">
        <label>读者类型<span style="color:red;">*</span></label>
        <select class="form-control" name="type" required>
        <?php  if ( $result->type == "本科" ) { ?>
            <option value="本科">本科</option>
            <option value="硕士">硕士</option>
            <option value="博士">博士</option>
        <?php }else if ( $result->type == "硕士" ){ ?>
            <option value="硕士">硕士</option>
            <option value="本科">本科</option>
            <option value="博士">博士</option>
        <?php } else { ?>
            <option value="博士">博士</option>
            <option value="本科">本科</option>
            <option value="硕士">硕士</option>
        <?php }?>
        </select>
        </div>

        <div class="form-group">
        <label>已借书量<span style="color:red;">*</span></label>
        <input class="form-control" type="text" name="borrowed_amo" value="<?php echo htmlentities($result->borrowed_amo);?>" required /> 
        </div>

        <div class="form-group">
        <label>总借书量<span style="color:red;">*</span></label>
        <input class="form-control" type="text" name="borrowed_total" value="<?php echo htmlentities($result->borrowed_total);?>" required /> 
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
