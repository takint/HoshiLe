<?php

class AdminPage {
    
    public static $title = "Admin page";

    public static function header() { 
        include_once('views/header.view.php');
    }

    public static function body(){
        include_once('views/body.view.php');
    }

    public static function footer() { 
        include_once('views/footer.view.php');
    }

    public static function navigator() {
        include_once('views/nav.view.php');
    }
}

?>