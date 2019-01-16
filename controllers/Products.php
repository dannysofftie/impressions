<?php
use Models\Product;
use Libraries\JSON;

/**
 * Users controller.
 *
 * Will handle interaction with table users in the database
 */
class Products
{

    /**
     * Get all users from database and return
     *
     * @return void
     */
    public static function listProducts()
    {
        $allProducts = Product::all();

        echo JSON::stringify($allProducts);
    }
}
