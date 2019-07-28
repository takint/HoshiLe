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
            break;
            default:
                $jproducts = RestClient::call("GET", PRODUCT_API);
                $products = array_map('Product::deserialize', $jproducts);
                AdminPage::productList($products);
            break;
        }
    }

    public static function postActionResult($postData) {
        // Product have id it must be an update action
        if($postData['productId'] != 0) {
            RestClient::call("PUT", PRODUCT_API, $productDto);
        } else { // otherwise, it is an insert action
            RestClient::call("POST", PRODUCT_API, $productDto);
        }
    }
}

?>