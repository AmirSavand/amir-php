<?php
// Requirements
require "include/amir.php";
require "include/db.php";
require "include/authenticate.php";
require "include/route.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta data -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0" />
    <meta name="description" content="PHP package with various systems to get started on a PHP project.">
    <meta name="keywords" content="PHP, package, framework, simple, amir">
    <meta name="author" content="Amir Mehdi Savand">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Title and favicon -->
    <title><?php if (!empty($base->title)) {echo $base->title;}?>Amir PHP</title>
    <link rel="icon" href="static/img/favicon.png">

    <!-- Load stylesheets -->
    <link rel="stylesheet" href="http://bootswatch.com/paper/bootstrap.min.css">
    <link rel="stylesheet" href="static/css/amir.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" id="navbar-brand" href="<?=Route::find("home")->url?>">Amir PHP</a>
            </div>

            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <?php foreach (Route::all() as $route): ?>
                    <li class="<?php if ($route->name === $base->name): ?>active<?php endif;?>">
                        <a href="<?=$route->url?>"><?=$route->label?></a>
                    </li>
                    <?php endforeach;?>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <li><a href="http://github.com/AmirSavand/amir-php" target="_blank">GitHub</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Alert -->
    <section id="alert">
        <div onclick="Amir.Alert.hide()" style="display: none"></div>
    </section>

    <!-- Page -->
    <section id="page">
        <?php include $base->include;?>
    </section>

    <!-- Footer -->
    <section id="footer">
        <!-- Load scripts -->
        <script>auth = <?=json_encode($auth)?>;</script>
        <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
        <script src="static/js/amir.js"></script>

        <!-- Alert -->
        <?php if (Amir::alert()): ?>
        <script>
            Amir.Alert.show("<?=Amir::alert()["content"]?>", "<?=Amir::alert()["type"]?>");
        </script>
        <?php endif;?>

        <!-- Extra footer -->
        <?=$base->extra?>
    </section>
</body>
</html>

<?php
// Clear alert
Amir::clear_alert();

// Close connection
mysqli_close($sql);
?>
