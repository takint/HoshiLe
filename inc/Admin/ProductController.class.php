<?php

class ProductController {
    public static function getActionResult($action, $sortBy = "", $data = null) {
        switch($action){
            case "view": 
                $jproduct = RestClient::call("GET", PRODUCT_API, array("id" => $data));
                $prod = Product::deserialize($jproduct);
                AdminPage::productDetails($prod, "view");
            break;
            case "add":
                $np = new Product();
                AdminPage::productDetails($np, "add");
            break;
            case "edit":
                $jproduct = RestClient::call("GET", PRODUCT_API, array("id" =>$data));
                $prod = Product::deserialize($jproduct);
                AdminPage::productDetails($prod, "edit");
            break;
            case "delete":
                $isDeleted = RestClient::call("DELETE", PRODUCT_API, array("id" =>$data));
                if($isDeleted){
                   self::displayList();
                }
            break;
            default:
                self::displayList();
            break;
        }
    }

    public static function postActionResult($postData) {
        // Product have id it must be an update action
        if($postData['id'] != 0) {
            $result = RestClient::call("PUT", PRODUCT_API, $postData);
        } else { // otherwise, it is an insert action
            $result =  RestClient::call("POST", PRODUCT_API, $postData);
        }

        AdminPage::redirectToList("product");
    }

    private static function validationData(){
        
    }

    private static function displayList(){
        $jproducts = RestClient::call("GET", PRODUCT_API);
        $products = array_map('Product::deserialize', $jproducts);
        AdminPage::productList($products);
    }
}

?>