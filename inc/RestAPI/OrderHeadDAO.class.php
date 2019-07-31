<?php

class OrderHeadDAO {

    private static $db;

    public static function initialize() {
        //Initialize the database connection
        self::$db = new PDOAgent('OrderHead');
    }

    //READ a single Order Head
    public static function getOrderHead(int $id): ?OrderHead {

        $sql = 'SELECT * FROM OrderHeads WHERE id = :id';

        // Query
        self::$db->query($sql);

        // Bind a parameter
        self::$db->bind(':id', $id);

        // Execute
        self::$db->execute();

        // Return the result
        $result = self::$db->singleResult();
        return $result ? $result : null;
    }

    //READ a list of OrderHeads
    public static function getOrderHeads(): array {

        $sql = 'SELECT * FROM OrderHeads';

        // Query
        self::$db->query($sql);

        // Execute
        self::$db->execute();

        // Return the result
        return self::$db->getResultSet();
    }

    public static function createOrderHead(OrderHead $newOrder): int {
        // INSERT statement for OrderHeads
        $sqlInsert = "INSERT INTO OrderHeads (userId, createDate) VALUES (:userId, NOW());";

        // Prepare the query
        self::$db->query($sqlInsert);

        self::$db->bind(':userId', $newOrder->getUserId());

        //Execute the query
        self::$db->execute();

        return self::$db->lastInsertedId();
    }

    public static function updateOrderHead(OrderHead $updateOrder) : int {
        try{
            // UPDATE statement for Order Head
            $sqlUpdate = "UPDATE OrderHeads SET userId = :userId, createDate = :createDate WHERE id = :id;";

            // Prepare the query
            self::$db->query($sqlUpdate);

            self::$db->bind(':id', $updateOrder->getId());
            self::$db->bind(':userId', $updateOrder->getUserId());
            self::$db->bind(':createDate', $updateOrder->getCreateDate());

            // Execute the query
            self::$db->execute();

            $count = self::$db->rowCount();

            // Check the appropriate updates
            if ($count < 0) {
                throw new Exception("There was an error updating the database!");
            }

        } catch (Exception $ex) {
            echo $ex->getMessage();
            self::$db->debugDumpParams();
            return -1;
        }

        //Get the number of affected rows
        return $count;
    }

    public static function deleteOrderHead(int $orderId) : bool {
        try {
            // DELETE statement for Order Head
            $sqlDelete = "DELETE FROM OrderHeads WHERE id = :id;";

            // Prepare the query
            self::$db->query($sqlDelete);

            self::$db->bind(':id', $orderId);

            // Execute the query
            self::$db->execute();

            // Check the appropriate delete
            if (self::$db->rowCount() != 1) {
                throw new Exception("There was an error deleting the database!");
            }

        } catch (Exception $ex) {
            echo $ex->getMessage();
            self::$db->debugDumpParams();
            return false;
        }

        return true;
    }
}

?>