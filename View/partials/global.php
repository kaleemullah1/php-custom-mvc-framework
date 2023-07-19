<?php extract(\App\Providers\View::$data) ?>
<!DOCTYPE html>
<html>
    <!--header-->
    <?php include 'header.php'; ?>

    <body style="background: darkgray;">
    <?php
        if(!empty($content)){
            require_once $content;
        }
    ?>

    <!--footer-->
    <?php // include 'footer.php'; ?>
    </body>
</html>