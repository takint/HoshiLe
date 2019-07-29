<?php

require_once("AdminHeader.inc.php");

// Controller parser
$controller = isset($_GET["controller"]) ? $_GET["controller"] : "";
$action = isset($_GET["action"]) ? $_GET["action"] : "list"; // Default will be view
$sortBy = isset($_GET["sort"]) ? $_GET["sort"] : "";
$data = isset($_GET["id"]) ? $_GET["id"] : "";

AdminPage::$title .= sprintf(" - %s %s", $controller, $action);
AdminPage::header();
AdminPage::navigator();
AdminPage::body($controller);

// Routing
switch($controller){
    case "product":
        if(!empty($_POST)) {
            ProductController::postActionResult($_POST);
        } else {
            ProductController::getActionResult($action, $sortBy, $data);
        }
    break;
    case "order":
    break;
    case "user":
    break;
    default:
    break;
}

AdminPage::footer();

?>