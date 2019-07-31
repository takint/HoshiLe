<?php

class OrderDetailDAO {

    private static $db;

    public static function initialize() {
        //Initialize the database connection
        self::$db = new PDOAgent('OrderDetail');
    }

    //READ a single Order Detail
    public static function getOrderDetails(int $orderId): array {

        $sql = 'SELECT * FROM OrderDetails WHERE orderId = :orderId';

        // Query
        self::$db->query($sql);

        // Bind a parameter
        self::$db->bind(':orderId', $orderId);

        // Execute
        self::$db->execute();

        // Return the result
        return self::$db->getResultSet();
    }
}

?>