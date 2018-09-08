<?php
/**
 * Router handler for data requests, data sent or requested from server must be handled
 * by this route file, errors will be thrown when trying to access unhandled routes.
 * Each route's path first parameter specifies a controller class, while second parameter after path
 * specifies method in controller to execute.
 *
 * @category handles data requets, each function takes path and controller method to be executed
 * @version 1.0.0
 * @author Danny Sofftie <danny@oratech.co.ke>
 */

use Libraries\Router;

Router::get('/products/categories-list', 'listCategories');

Router::post('/products/:product-name', function ($params) {
    var_dump($params);
});

Router::post('/products/:product', function ($params) {
    var_dump($params);
});
