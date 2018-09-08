<?php
// require file with controllers and models
require_once 'autoload/autoload.php';

// require router added into the route table
require_once 'routes/view-routes.php';
require_once 'routes/data-routes.php';

use Libraries\Router;

// start handling all added routes
Router::startRouter();

// Router implementation currently handles all requests as
// get requets, $_SERVER['REQUEST_METHOD'] is not enforced
// as a constraint when adding routes, and receiving requests from clients.
