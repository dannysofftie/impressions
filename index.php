<?php
// require file with controllers and models
require_once 'autoload/autoload.php';

// require router added into the route table
require_once 'routes/view-routes.php';
require_once 'routes/data-routes.php';

use Libraries\Router;

// start handling all added routes
Router::startRouter();

// Router implementation will and can handle multiple request schemes with similar signature
// e.g Router::get('/products') and Router::post('/products')
// Not limited to specific request schemes
