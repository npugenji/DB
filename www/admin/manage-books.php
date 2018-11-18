<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
{   
    header('location:index.php');
}
else{ 
    if(isset($_GET['del'])){
        $ISBN=$_GET['del'];
        $sql = "delete from book WHERE ISBN=:ISBN";
        $query = $dbh->prepare($sql);
        $query -> bindParam(':ISBN',$ISBN, PDO::PARAM_STR);
        $query -> execute();
        header('location:manage-books.php');
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
    <!-- DATATABLE STYLE  -->
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
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
                <h4 class="header-line">管理书籍</h4>
            </div>
            <div class="row">
                <?php if($_SESSION['error']!="") {?>
                <div class="col-md-6">
                <div class="alert alert-danger" >
                 <?php echo htmlentities($_SESSION['error']);?>
                <?php echo htmlentities($_SESSION['error']="");?>
                </div>
                </div>
                <?php } ?>

                <?php if($_SESSION['msg']!="") {?>
                <div class="col-md-6">
                <div class="alert alert-success" >
                 <?php echo htmlentities($_SESSION['msg']);?>
                <?php echo htmlentities($_SESSION['msg']="");?>
                </div>
                </div>
                <?php } ?>

                <?php if($_SESSION['updatemsg']!="")
                {?>
                <div class="col-md-6">
                <div class="alert alert-success" >
                 <?php echo htmlentities($_SESSION['updatemsg']);?>
                <?php echo htmlentities($_SESSION['updatemsg']="");?>
                </div>
                </div>
                <?php } ?>

            </div>


        </div>
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           书籍列表
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>书名</th>
                                            <th>作者</th>
                                            <th>ISBN</th>
                                            <th>出版社</th>
                                            <th>出版日期</th>
                                            <th>是否可借</th>
                                            <th>操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php $sql = "SELECT * from book";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>                                      
                                        <tr class="odd gradeX">
                                            <td class="center"><?php echo htmlentities($cnt);?></td>
                                            <td class="center"><?php echo htmlentities($result->name);?></td>
                                            <td class="center"><?php echo htmlentities($result->author);?></td>
                                            <td class="center"><?php echo htmlentities($result->ISBN);?></td>
                                            <td class="center"><?php echo htmlentities($result->press);?></td>
                                            <td class="center"><?php echo htmlentities($result->pub_date);?></td>
                                            <td class="center">
                                                <?php if ( $result->available )
                                                    {
                                                        echo "是";
                                                    }
                                                    else
                                                    {
                                                        echo "否";
                                                    }
                                                ?>
                                            </td>
                                            <td class="center">

                                            <a href="edit-book.php?preISBN=<?php echo htmlentities($result->ISBN);?>"><button class="btn btn-primary"><i class="fa fa-edit "></i> 修改</button>
                                          <a href="manage-books.php?del=<?php echo htmlentities($result->ISBN);?>" onclick="return confirm('Are you sure you want to delete?');" >  <button class="btn btn-danger"><i class="fa fa-pencil"></i> 删除</button>
                                            </td>
                                        </tr>
                                        <?php $cnt=$cnt+1;}} ?>               
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--End Advanced Tables -->
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
    <!-- DATATABLE SCRIPTS  -->
    <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
      <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>
</body>
</html>
<?php } ?>
