<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['login'])==0)
    {   
header('location:index.php');
}
else{ 
    if (isset($_GET['return']))
    {
        $borrowid = $_GET['bid'];
        $sql = "insert into request( borrowid, type ) values( :bid, '还书' )";
        $query = $dbh->prepare($sql);
        $query-> bindParam(':bid', intval($borrowid));
        $query -> execute();
    }
    if (isset($_GET['renew']))
    {
        $borrowid = $_GET['bid'];
        $sql = "insert into request( borrowid, type ) values( :bid, '续借' )";
        $query = $dbh->prepare($sql);
        $query-> bindParam(':bid', intval($borrowid));
        $query -> execute();
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
                <h4 class="header-line">借阅记录</h4>
    </div>
    

            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          记录详情 
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>书名</th>
                                            <th>ISBN</th>
                                            <th>借书日</th>
                                            <th>到期日</th>
                                            <th>还书日</th>
                                            <th>操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php 
$sid=$_SESSION['stdid'];
$sql="SELECT borrow_info.id as borrowid, book.name as bookname, book.ISBN as bookISBN, borrow_date, due_date, return_date from book, borrow_info where borrow_info.studid = :sid AND book.ISBN = borrow_info.ISBN";
$query = $dbh -> prepare($sql);
$query-> bindParam(':sid', $sid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>                                      
                                        <tr class="odd gradeX">
                                            <td class="center"><?php echo htmlentities($cnt);?></td>
                                            <td class="center"><?php echo htmlentities($result->bookname);?></td>
                                            <td class="center"><?php echo htmlentities($result->bookISBN);?></td>
                                            <td class="center"><?php echo htmlentities($result->borrow_date);?></td>
                                            <td class="center"><?php echo htmlentities($result->due_date);?></td>
                                            <td class="center">
                                                <?php if($result->return_date==""){?>
                                                <span style="color:red">
                                                <?php   echo htmlentities("未归还"); ?>
                                                </span>
                                                <?php } else {
                                                echo htmlentities($result->return_date);
                                                }?>
                                            </td>

                                            <td class="center">
                                            <?php if($result->return_date==""){?>
                                            <a href="borrow_log.php?bid=<?php echo htmlentities($result->borrowid);?>&return=1"><button type="submit" class="btn btn-primary">还书</button>
                                            
                                            <a href="borrow_log.php?bid=<?php echo htmlentities($result->borrowid);?>&renew=1"><button type="submit"  class="btn btn-info">续借</button>
                                            </td>
                                        <?php }?>
                                           
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
