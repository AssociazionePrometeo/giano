<?php
if (session_status() == PHP_SESSION_NONE) {session_start();}
if (!isset($_SESSION["ID"])) {
    include '_header.php';
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
        <?php
        //include('_footer.php');
    }
    else{
        header('Location: index.php');
    }

?>
</body>
</html>
