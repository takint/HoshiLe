<?php

define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_NAME', getenv('DB_NAME') ?: 'HoshiLe');
define('DB_PASS', getenv('DB_PASS') ?: '');

define('API_BASE', getenv('API_BASE') ?: 'http://localhost/HoshiLe/');
define('PRODUCT_API', API_BASE . 'ProductAPI.php');
define('USER_API', API_BASE . 'UserAPI.php');
define('ORDER_API', API_BASE . 'OrderAPI.php');

?>
