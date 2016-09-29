<?php
if ( !isset($_SESSION["ID"] ) ) {
    header('Location: ../login.php');
    exit;
}
if ($_SESSION['user_level'] >= 3) {
    session_destroy();
    header('Location: ../login.php');
    exit;
}
include '_header.php';
include '../function/database.php';
?>
<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Logo and responsive toggle -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar" aria-expanded="false"></button>
            <a class="navbar-brand" href="/"><span class="glyphicon glyphicon-home"></span>Giano</a>
        </div>
<!-- Navbar links -->
        <div class="collapse navbar-collapse" id="navbar">
             <ul class="nav navbar-nav">
                <li class="dropdown"> <a href="#" class="dropdown-toggle" id="drop1" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">Utenti<span class="caret"></span> </a>
                    <ul class="dropdown-menu" aria-labelledby="drop1">
                        <li><a href="list_user.php">Lista Utenti</a></li>
                        <li><a href="create_user.php">Aggiungi Utente</a></li>
                        <li role="separator" class="divider"></li>
                        <?php
                    $pdo = Database::connect();
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql = 'SELECT permissions FROM permissions WHERE id=?';
                    $q = $pdo->prepare($sql);
                    $q->execute(array($_SESSION['user_level']));
                    $data = $q->fetch(PDO::FETCH_ASSOC);
                        if($data['permissions'] == 1)  echo '<li><a href="list_profile.php">Gestione Profili</a></li>';
                    Database::disconnect();
                        ?>
                        <li><a href="#"></a></li>
                    </ul>
                </li>
                <li class="dropdown"> <a href="#" class="dropdown-toggle" id="drop2" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">Devices<span class="caret"></span> </a>
                    <ul class="dropdown-menu" aria-labelledby="drop2">
                        <li><a href="list_device.php">Lista Devices</a></li>
                        <li><a href="create_device.php">Aggiungi Devices</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                    </ul>
                </li>
                <li class="dropdown"> <a href="#" class="dropdown-toggle" id="drop3" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">Tags<span class="caret"></span> </a>
                    <ul class="dropdown-menu" aria-labelledby="drop3">
                        <li><a href="list_tag.php">Lista Tags</a></li>
                        <li><a href="create_tag.php">Aggiungi Tags</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                    </ul>
                </li>
            </ul>
    <!-- Menu right -->
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="index.php">
                    <button type="button" class="btn btn-warning btn-sm">
                    <span class="glyphicon glyphicon-cog"></span> Admin
                    </button></a>
                </li>
                <li>
                    <a href="/profile.php">
                    <button type="button" class="btn btn-primary btn-sm">
                        <span class="glyphicon glyphicon-user"></span> Profile
                    </button></a>
                </li>
                <li>
                    <a href="/logout.php">
                    <button type="button" class="btn btn-primary btn-sm">
                        <span class="glyphicon glyphicon-log-in"></span> Logout
                        </button>
                    </a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>

