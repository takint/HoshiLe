<?php

class ProductController {
    public static function actionResult($action, $sortBy = "", $data = null) {
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
}

?>