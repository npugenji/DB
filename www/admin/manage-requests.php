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
        $del=$_GET['del'];
        $sql = "delete from request where reqid=:del";
        $query = $dbh->prepare($sql);
        $query -> bindParam(':del',$del, PDO::PARAM_STR);
        $query -> execute();
        header('location:manage-requests.php');
    }
    if (isset($_GET['ok'])){
        $reqid = $_GET['ok'];
        $reqtype = $_GET['reqtype'];
        $sql = "select borrowid from request where reqid=:reqid";
        $query = $dbh->prepare($sql);
        $query -> bindParam(':reqid',$reqid, PDO::PARAM_STR);
        $query -> execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        $result = $results[0];
        $today = date("Y-m-d");
        if ( $reqtype == '借书' ){
            $sql = "update borrow_info set borrow_date=:today, due_date=:due_date where id = :borrowid";
            $due_date = date("Y-m-d",strtotime('+10 day',time()));
            $query = $dbh->prepare($sql);
            $query -> bindParam(':today', $today, PDO::PARAM_STR);
            $query -> bindParam(':due_date', $due_date, PDO::PARAM_STR);
            $query -> bindParam(':borrowid', $result->borrowid, PDO::PARAM_STR);
            
            $query -> execute();
            $sql = "update book set available = 0 where book.ISBN = ( select borrow_info.ISBN from borrow_info, request where borrow_info.id = request.borrowid and request.reqid = :reqid)";
            $query = $dbh->prepare($sql);
            $query -> bindParam(':reqid', $reqid, PDO::PARAM_STR);
            $query -> execute();

            $sql = "update student set borrowed_amo = borrowed_amo + 1, borrowed_total = borrowed_total + 1 where id= (select borrow_info.studid from request, borrow_info where request.reqid = :reqid and request.borrowid = borrow_info.id ) ";
            $query = $dbh->prepare($sql);
            $query -> bindParam(':reqid', $reqid, PDO::PARAM_STR);
            $query -> execute();
        }else if ( $reqtype == '还书' ){
            $sql = "update borrow_info set return_date = :return_date where borrow_info.id = ( select borrowid from request where request.reqid =:reqid ) ";
            $query = $dbh->prepare($sql);
            $query -> bindParam(':return_date', $today, PDO::PARAM_STR);
            $query -> bindParam(':reqid', $reqid, PDO::PARAM_STR);
            $query -> execute();

            $sql = "update book set available = 1 where book.ISBN = ( select borrow_info.ISBN from borrow_info, request where borrow_info.id = request.borrowid and request.reqid = :reqid)";
            $query = $dbh->prepare($sql);
            $query -> bindParam(':reqid', $reqid, PDO::PARAM_STR);
            $query -> execute();

            $sql = "update student set borrowed_amo = borrowed_amo - 1 where id= (select borrow_info.studid from request, borrow_info where request.reqid = :reqid and request.borrowid = borrow_info.id ) ";
            $query = $dbh->prepare($sql);
            $query -> bindParam(':reqid', $reqid, PDO::PARAM_STR);
            $query -> execute();
        }else if ( $reqtype == '续借' ){
            $sql = "update borrow_info set due_date=DATE_ADD(due_date,INTERVAL 10 DAY) where borrow_info.id = ( select borrowid from request where request.reqid =:reqid )";
            $query = $dbh->prepare($sql);
            $query -> bindParam(':reqid', $reqid, PDO::PARAM_STR);
            $query -> execute();
        }
        $sql = "delete from request where reqid=:reqid";
        $query = $dbh->prepare($sql);
        $query -> bindParam(':reqid', $reqid, PDO::PARAM_STR);
        $query -> execute();
        //header('location:manage-requests.php');
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
                <h4 class="header-line">管理请求</h4>
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
                           请求列表
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>请求号</th>
                                            <th>书名</th>
                                            <th>ISBN</th>
                                            <th>学号</th>
                                            <th>姓名</th>
                                            <th>请求类型</th>
                                            <th>操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php $sql = "SELECT reqid, book.ISBN as ISBN, book.name as bookname,  studid, student.name as studname, request.type as reqtype from request, borrow_info, book, student where request.borrowid = borrow_info.id and borrow_info.ISBN = book.ISBN and borrow_info.studid = student.id";
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
                                            <td class="center"><?php echo htmlentities($result->reqid);?></td>
                                            <td class="center"><?php echo htmlentities($result->bookname);?></td>
                                            <td class="center"><?php echo htmlentities($result->ISBN);?></td>
                                            <td class="center"><?php echo htmlentities($result->studid);?></td>
                                            <td class="center"><?php echo htmlentities($result->studname);?></td>
                                            <td class="center"><?php echo htmlentities($result->reqtype)?>
                                            </td>
                                            <td class="center">

                                            <a href="manage-requests.php?ok=<?php echo htmlentities($result->reqid);?>&reqtype=<?php echo htmlentities($result->reqtype)?>"><button class="btn btn-primary"><i class="fa fa-edit"></i> 批准</button>
                                          <a href="manage-requests.php?del=<?php echo htmlentities($result->reqid);?>" onclick="return confirm('确定拒绝吗?');" >  <button class="btn btn-danger"><i class="fa fa-pencil"></i> 拒绝</button>
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
