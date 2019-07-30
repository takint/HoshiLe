<?php

class AdminPage {
    
    public static $title = "Admin page";

    public static function header() { 
        include_once('views/header.view.php');
    }

    public static function body($currentCtr = "product"){
        include_once('views/body.view.php');
    }

    public static function footer() { 
        include_once('views/footer.view.php');
    }

    public static function navigator() {
        include_once('views/nav.view.php');
    }

    public static function productList($lstProducts) {
        include_once('views/product-list.view.php');
    }

    public static function productDetails($product, $mode = "view", $errors = []) {
        include_once('views/product-details.view.php');
    }

    public static function pageNotFound(){ ?>
        <h1>404</h1>
        <p><strong>Page not found</strong></p>
    <?php }

    public static function redirectToList($controllerName){ ?>
        <!doctype html>
        <html lang="en">
            <head>
                <meta http-equiv='refresh' content="0;URL='?controller=<?=$controllerName?>'">
            </head>
        </html>
    <?php }
}

?>