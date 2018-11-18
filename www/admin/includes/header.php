<div class="navbar navbar-inverse set-radius-zero" >
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand">
                    <img src="assets/img/logo.png" height="70" width="300"/>
                </a>

            </div>

            <div class="right-div">
                <a href="logout.php" class="btn btn-danger pull-right">退出</a>
            </div>
        </div>
    </div>
    <!-- LOGO HEADER END-->
    <section class="menu-section">
        <div class="container">
            <div class="row ">
                <div class="col-md-12">
                    <div class="navbar-collapse collapse ">
                        <ul id="menu-top" class="nav navbar-nav navbar-right">
                            <li><a href="dashboard.php">主界面</a></li>
                           
                            <li>
                                <a href="#" class="dropdown-toggle" id="ddlmenuItem" data-toggle="dropdown"> 书籍<i class="fa fa-angle-down"></i></a>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="ddlmenuItem">
                                    <li role="presentation">
                                        <a role="menuitem" tabindex="-1" href="add-book.php">添加书籍</a></li>
                                     <li role="presentation"><a role="menuitem" tabindex="-1" href="manage-books.php">管理书籍</a></li>
                                </ul>
                            </li>

                            <li><a href="manage-requests.php">管理请求</a></li>

                            <li><a href="#" class="dropdown-toggle" id="ddlmenuItem" data-toggle="dropdown">学生 <i class="fa fa-angle-down"></i></a>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="ddlmenuItem">
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="add-student.php">添加学生</a></li>
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="manage-students.php">管理学生</a></li>
                                </ul>
                            </li>
                    
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </section>