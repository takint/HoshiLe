<?php

class ProductDAO {

    private static $db;

    static function initialize() {
        //Initialize the database connection
        self::$db = new PDOAgent('Product');
    }

    //READ a single Product
    static function getProduct(int $id): ?Product {

        $sql = 'SELECT * FROM Products WHERE id = :id';

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

    //READ a list of Products
    static function getProducts(array $ids = null): array {

        $sql = 'SELECT * FROM Products';
        if (!empty($ids)) {
            $sql .= ' WHERE id in (' . implode(', ', $ids) . ')';
        }

        // Query
        self::$db->query($sql);

        // Execute
        self::$db->execute();

        // Return the result
        return self::$db->getResultSet();
    }

    static function createProduct(Product $newProduct): int{
        // INSERT statement for Product
        $sqlInsert = "INSERT INTO Products (name, brand, price, imageUrl) VALUES (:name, :brand, :price, :imageUrl);";

        // Prepare the query
        self::$db->query($sqlInsert);

        self::$db->bind(':name', $newProduct->getName());
        self::$db->bind(':brand', $newProduct->getBrand());
        self::$db->bind(':price', $newProduct->getPrice());
        self::$db->bind(':imageUrl', $newProduct->getImageUrl());

        //Execute the query
        self::$db->execute();

        return self::$db->lastInsertedId();
    }

    static function updateProduct(Product $updateProduct) : int {
        try{
            // UPDATE statement for Product
            $sqlUpdate = "UPDATE Products SET name = :name, brand = :brand, price = :price, imageUrl = :imageUrl WHERE id = :id;";

            // Prepare the query
            self::$db->query($sqlUpdate);

            self::$db->bind(':id', $updateProduct->getId());
            self::$db->bind(':name', $updateProduct->getName());
            self::$db->bind(':brand', $updateProduct->getBrand());
            self::$db->bind(':price', $updateProduct->getPrice());
            self::$db->bind(':imageUrl', $updateProduct->getImageUrl());

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

    static function deleteProduct(int $productId) : bool {
        try {
            // DELETE statement for Product
            $sqlDelete = "DELETE FROM Products WHERE id = :id;";

            // Prepare the query
            self::$db->query($sqlDelete);

            self::$db->bind(':id', $productId);

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