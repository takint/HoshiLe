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
            $user = UserDAO::authUser($requestData->email, $requestData->password);
        }
        header('Content-Type: application/json');
        echo json_encode(is_null($user) ? null : $user->serialize());
        break;

    case 'POST':
        $user = User::deserialize($requestData, false, true);
        try {
            $result = UserDAO::createUser($user);
        } catch (PDOException $ex) {
            $result = null;
        }
        header('Content-Type: application/json');
        echo json_encode($result);
        break;

    default:
        echo json_encode(array('message' => 'Você fala HTTP?'));
        break;
}

?>