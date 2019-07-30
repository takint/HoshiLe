<?php

require_once('inc/config.inc.php');
require_once('inc/Entity/BaseEntity.class.php');
require_once('inc/Entity/User.class.php');
require_once('inc/RestAPI/PDOAgent.class.php');
require_once('inc/RestAPI/UserDAO.class.php');

//Instantiate a new User Mapper
UserDAO::initialize();

//Pull the request data
$requestData = json_decode(file_get_contents('php://input'));

//Do something based on the request
switch ($_SERVER['REQUEST_METHOD']) {

    //If there was a request with an id, return that user.
    case 'GET':
        if (isset($requestData->id)) {
            $user = UserDAO::getUser($requestData->id);
        } else if (isset($requestData->email) && isset($requestData->password)) {
            $user = UserDAO::getUserByEmail($requestData->email);
            if (!($user && $user->verifyPassword($requestData->password))) {
                $user = null;
            }
        } else {
            $customers = UserDAO::getUsers();
            $stdCustomers = array();

            foreach ($customers as $cust) {
                $stdCustomers[] = $cust->serialize();
            }

            header('Content-Type: application/json');
            echo json_encode($stdCustomers);
            break;
        }

        header('Content-Type: application/json');
        echo json_encode(is_null($user) ? null : $user->serialize());
        break;

    // Create a user.
    case 'POST':
        $user = User::deserialize($requestData);
        try {
            $user->setHashedPassword($user->getPassword());
            $result = UserDAO::createUser($user);
        } catch (PDOException $ex) {
            $result = null;
        }
        header('Content-Type: application/json');
        echo json_encode($result);
        break;

    // Update user's profile or password.
    case 'PUT':
        if (isset($requestData->name) && isset($requestData->email)) {
            $user = User::deserialize($requestData);
            try {
                $result = UserDAO::updateUser($user);
            } catch (PDOException $ex) {
                $result = false;
            }
        } else if (isset($requestData->curPassword) && isset($requestData->newPassword)) {
            try {
                $user = UserDAO::getUser($requestData->id);
                if ($user && $user->verifyPassword($requestData->curPassword)) {
                    $user->setHashedPassword($requestData->newPassword);
                    $result = UserDAO::updatePassword($user);
                } else {
                    $result = false;
                }
            } catch (PDOException $ex) {
                $result = false;
            }
        } else if (isset($requestData->shoppingCart)) {
            try {
                $user = UserDAO::getUser($requestData->id);
                $user->setShoppingCart($requestData->shoppingCart);
                $result = UserDAO::updateShoppingCart($user);
            } catch (PDOException $ex) {
                $result = false;
            }
        } else {
            $result = false;
        }
        header('Content-Type: application/json');
        echo json_encode($result);
        break;

    default:
        echo json_encode(array('message' => 'Você fala HTTP?'));
        break;
}

?>