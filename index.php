<?
include '../include/config.inc.php';
session_start();
if (!isset($_SESSION["ID"]) ) {
 header('Location: login.php');
}else{
    include ("_header.php");
    include ("_menu.php");
?>


    <!-- Content -->
    <?
$a=$_GET['a'];
switch($a)
{
case tag:
            ?>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Gestione TAG
                        <small>I tuoi TAG</small>
                    </h1>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Cardcode</th>

                                            <th>Stato</th>
                                            <th>Azione</th>
                                        </tr>
                                    </thead>
                                    <?
$sql = "SELECT * FROM tags WHERE userid=".$_SESSION['ID']."";
$result = mysql_query($sql);
while ($array = mysql_fetch_array($result))
{
 echo"<tbody><tr><td>".$array['cardcode']."</td><td>";
 if ($array['status'] == 1) echo "attivato";  else echo "disattivato";
echo"<td></td></tr>";
}
        echo"</tbody></table>";
    mysql_close($sql);
echo "</div></div></div>";

                                ?>

                            </div>
                        </div>
                    </div>
                    <?
break;

    case log:
        ?>
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h1 class="page-header">Storico LOG
                                        <small>I tuoi log</small>
                                    </h1>

    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Cardcode</th>
                                            <th>Risorsa</th>
                                            <th>Data - Ora</th>
                                        </tr>
                                    </thead>
                                    <?
$sql = "SELECT * FROM log WHERE userid=".$_SESSION['ID']."";
$result = mysql_query($sql);
while ($array = mysql_fetch_array($result))
{
 echo"<tbody><tr><td>".$array['cardcode']."</td><td>";

$sql1 = "SELECT name FROM devices WHERE id=".$array['device']."";
$result1 = mysql_query($sql1);
while ($array1 = mysql_fetch_array($result1))
{
echo $array1['name'];
}
mysql_close($sql2);
echo"</td><td>".$array['date_log']."</td></tr>";
}
        echo"</tbody></table>";
    mysql_close($sql);
echo "</div></div></div>";

                                ?>


                                </div>
                            </div>
                        </div>
                        <?
        break;
    case profile:

$sql = "SELECT * FROM users WHERE userid=".$_SESSION["ID"]."";
$result = mysql_query($sql);
$array = mysql_fetch_array($result);

        break;
    default:
            ?>
                            <div class="container">


                                <div class="row">
                                    <div class="col-lg-12">
                                        <h1 class="page-header">titolone
                                            <small>titolino</small>
                                        </h1>
                                        <p>qui ci metto qualocosa </p>
                                    </div>
                                </div>


                            </div>
                            <?


}

            ?>

                                <!-- /.container -->

                                <?
    include('_footer.php');
    ?>



                                    </body>

                                    </html>


                                    <?
};
?>
                                      <!-- jQuery -->
                            <script src="js/jquery-1.11.3.min.js"></script>

                            <!-- Bootstrap Core JavaScript -->
                            <script src="js/bootstrap.min.js"></script>

                            <!-- IE10 viewport bug workaround -->
                            <script src="js/ie10-viewport-bug-workaround.js"></script>

                            <!-- Placeholder Images -->
                            <script src="js/holder.min.js"></script>
