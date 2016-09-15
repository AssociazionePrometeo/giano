<!DOCTYPE html>
<!-- Template by Quackit.com -->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>Giano Manager</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS: You can use this stylesheet to override any Bootstrap styles and/or apply your own styles -->
    <link href="css/custom.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <?
    session_start();
    if (!isset($_SESSION["ID"])) {

?>


<div class="page-header">
    <center><h1>Giano Manager <small></small></h1></center>
</div>
        <!-- Content -->

    <div class="col-md-6 col-md-offset-3">
    <div class="jumbotron" >

                <form class="form-horizontal" action="checkuser.php" method="post">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">User</label>
                    <div class="col-sm-offset-1 col-sm-8">
                        <input type="text" class="form-control" name="username" placeholder="User">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-offset-1 col-sm-8">
                        <input type="password" class="form-control" name="password" placeholder="Password">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-1 col-sm-10">
                       <center><?php if (isset($_SESSION["message"])) echo $_SESSION["message"]; unset($_SESSION["message"]) ?></center>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-5 col-sm-10">
                        <button type="submit" class="btn btn-default">Sign in</button>
                    </div>
                </div>
        </form>
        </div>
    </div>

        <!-- /.container -->
        <?
        //include('_footer.php');
    }else{
        header('Location: index.php');
    }

    ?>


             <!-- jQuery -->
            <script src="js/jquery-1.11.3.min.js"></script>

            <!-- Bootstrap Core JavaScript -->
            <script src="js/bootstrap.min.js"></script>

            <!-- IE10 viewport bug workaround -->
            <script src="js/ie10-viewport-bug-workaround.js"></script>

            <!-- Placeholder Images -->
            <script src="js/holder.min.js"></script>

</body>

</html>
