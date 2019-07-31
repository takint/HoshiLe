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

    public static function createOrderDetail(OrderDetail $orderDetail): int {

        $sqlInsert = "INSERT INTO OrderDetails (orderId, productId, quantity) VALUES (:orderId, :productId, :quantity)";

        // Prepare the query
        self::$db->query($sqlInsert);

        self::$db->bind(':orderId', $orderDetail->getOrderId());
        self::$db->bind(':productId', $orderDetail->getProductId());
        self::$db->bind(':quantity', $orderDetail->getQuantity());

        //Execute the query
        self::$db->execute();

        return self::$db->lastInsertedId();
    }
}

?>