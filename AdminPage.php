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
        if(!empty($_POST)) {
            OrderController::postActionResult($_POST);
        } else {
            OrderController::getActionResult($action, $sortBy, $data);
        }
    break;
    case "user":
        if(!empty($_POST)) {
            CustomerController::postActionResult($_POST);
        } else {
            CustomerController::getActionResult($action, $sortBy, $data);
        }
    break;
    case "dashboard":
        DashboardController::getActionResult($action, $sortBy, $data);
    break;
    default:
        AdminPage::pageNotFound();
    break;
}

AdminPage::footer();

?>