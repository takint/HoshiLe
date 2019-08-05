<?php

class DashboardController {
    public static function getActionResult($action, $sortBy = "", $data = null) {
        switch($action){
            default:
                self::displayList();
            break;
        }
    }

    private static function displayList(){
        $jorders = RestClient::call("GET", ORDER_API);
        $jproducs = RestClient::call("GET", PRODUCT_API);
        $jusers = RestClient::call("GET", USER_API);
        $orders = array_map('OrderHead::deserialize', $jorders);
        usort($orders, "self::compareOrder");

        AdminPage::orderList($orders);
    }
}

?>