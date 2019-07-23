<?php

class ProductDAO {

    private static $db;

    static function initialize() {
        //Initialize the database connection
        self::$db = new PDOAgent('Product');
    }

    //READ a single Product
    static function getProduct(int $id) : Product {

        $sql = 'SELECT * FROM Products WHERE id = :id;';

        // Query
        self::$db->query($sql);

        // Bind a parameter
        self::$db->bind(':id', $id);

        // Execute
        self::$db->execute();

        // Return the result
        return self::$db->singleResult();
    }

    //READ a list of Products
    static function getProducts() : array   {

        $sql = 'SELECT * FROM Products;';

        // Query
        self::$db->query($sql);

        // Execute
        self::$db->execute();

        // Return the result
        return self::$db->getResultSet();
    }
}

?>