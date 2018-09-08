# PHP Application BoilerPlate

A boilerplate to get you started with your PHP projects easily, with a little to no configuration.

## Content included

- A simple custom router
- Laravel's ORM Illuminate database library
- A request library
- PHPMailer mailing library
- Bcrypt library
- Session library to manage your app sessions easily
- Well defined folder structure

To get started, clone this repo

``` 
git clone https://github.com/DannySofftie/php-boilerplate.git 
```


and run
> composer install

## Folder structure

```js
autoload
    - autoload.php
configs
    - config.php
controllers
    - Products.php
libraries
    - Bcrypt.php
    - Json.php
    - Mailer.php
    - Request.php
    - Router.php
    - Session.php
models
    - Database.php
    - Product.php
routes
    - data-routes.php
    - view-routes.php
uploads
views
    - index.php
.htaccess
composer.json
composer.lock
```

## Router

The router library allows you to easily handle requests to your application. The router instance will be called in your application's root index file. e.g. index.php

```php
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
```

All your routes can be added before calling  
> Router::startRouter();

In view-routes.php,

```php
<?php
/**
 * Router handler for view requests
 * @category handles view requets, each function returns a view
 * @version 1.0.0
 * @author Danny Sofftie <danny@oratech.co.ke>
 */
use Libraries\Router;

Router::get('/', function () {
    include_once 'views/default.php';
});
```

In data-routes.php,

```php
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
```

## Request

To make requests to external services and APIs, make requests as below

```php
use Libraries\Request;

$data = [
    'samplekey' => 'value',
    'otherkey' => 'othervalue'
];

$headers = [
    'Content-Type' => 'application/json',
    'Content-Length' => sizeof($data)
];

$response = Request::post('https://example.com', $data, $headers);
// the $response variable contains response from the request
```

The request library supports POST, GET, PUT, PATCH and DELETE requests.