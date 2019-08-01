<?php

class CustomerController {
    private static $sortType = "";

    public static function getActionResult($action, $sortBy = "", $data = null) {
        self::$sortType = $sortBy;
        switch($action){
            case "view": 
                $jcustomer = RestClient::call("GET", USER_API, array("id" => $data));
                $cust = User::deserialize($jcustomer);
                AdminPage::customerDetails($cust, "view");
            break;
            case "edit":
                $jcustomer = RestClient::call("GET", USER_API, array("id" => $data));
                $cust = User::deserialize($jcustomer);
                AdminPage::customerDetails($cust, "edit");
            break;
            // For customer management we avoid to add new or delete from admin page
            case "delete":
            case "add":
            default:
                self::displayList($sortBy);
            break;
        }
    }

    public static function postActionResult($postData) {
        $validation = self::validationData($postData);

        if(count($validation) == 0){
            // Product have id it must be an update action
            if($postData['id'] != 0) {
                $result = RestClient::call("PUT", USER_API, $postData);
            } else { // otherwise, it is an insert action
                $result =  RestClient::call("POST", USER_API, $postData);
            }

            AdminPage::redirectToList("customer");
        } else {
            $nc = new User();
            $nc->setId($postData['id']);
            $nc->setName($postData['name']);
            $nc->setBrand($postData['email']);
            AdminPage::customerDetails($np, "edit", $validation);
        }
    }

    private static function validationData($fromData){
        $errors = array();

        if(empty($fromData['name'])) {
            $errors[] = "Please correct user full name";
        }

        return $errors;
    }

    private static function displayList(){
        $jcustomers = RestClient::call("GET", USER_API);
        $customers = array_map('User::deserialize', $jcustomers);
        usort($customers, "self::compareUser");

        AdminPage::customerList($customers);
    }

    private static function compareUser(User $p1, User $p2){
        if(self::$sortType != ""){
            switch(self::$sortType){   
                case "name" : return $p1->getName() <=> $p2->getName();
                case "email": return $p1->getEmail() <=> $p2->getEmail();
                default: return $p1->getId() <=> $p2->getId();
            }
        } else {
            return $p1->getId() <=> $p2->getId();
        }
    }
}

?>