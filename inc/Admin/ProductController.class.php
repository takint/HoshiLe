<?php

class ProductController {
    private static $sortType = "";

    public static function getActionResult($action, $sortBy = "", $data = null) {
        self::$sortType = $sortBy;
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
        $validation = self::validationData($postData);

        if(count($validation) == 0){
            // Product have id it must be an update action
            if($postData['id'] != 0) {
                $result = RestClient::call("PUT", PRODUCT_API, $postData);
            } else { // otherwise, it is an insert action
                $result =  RestClient::call("POST", PRODUCT_API, $postData);
            }

            AdminPage::redirectToList("product");
        } else {
            $np = new Product();
            $np->setId($postData['id']);
            $np->setName($postData['name']);
            $np->setBrand($postData['brand']);
            $np->setPrice($postData['price']);
            $np->setImageUrl($postData['imageUrl']);
            AdminPage::productDetails($np, "edit", $validation);
        }
    }

    private static function validationData($fromData){
        $errors = array();

        if(empty($fromData['name'])) {
            $errors[] = "Please enter product name";
        }
        if(empty($fromData['brand'])) {
            $errors[] = "Please enter product brand";
        }
        if(empty($fromData['price'])) {
            $errors[] = "Please enter product price";
        }

        return $errors;
    }

    private static function displayList(){
        $jproducts = RestClient::call("GET", PRODUCT_API);
        $products = array_map('Product::deserialize', $jproducts);
        usort($products, "self::compareProduct");

        AdminPage::productList($products);
    }

    private static function compareProduct(Product $p1, Product $p2){
        if(self::$sortType != ""){
            switch(self::$sortType){   
                case "name" : return $p1->getName() <=> $p2->getName();
                case "brand": return $p1->getBrand() <=> $p2->getBrand();
                case "price": return $p1->getPrice() <=> $p2->getPrice();
                default: return $p1->getId() <=> $p2->getId();
            }
        } else {
            return $p1->getId() <=> $p2->getId();
        }
    }
}

?>