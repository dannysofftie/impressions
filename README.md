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

```md
git clone https://github.com/dannysofftie/php-boilerplate.git
```

and run

```md
cd php-boilerplate && composer install
```

## Folder structure

```js
autoload
    autoload.php
configs 
    config.php
controllers
    Products.php
libraries
    Bcrypt.php 
    Json.php 
    Mailer.php 
    Request.php 
    Router.php
    Session.php
models 
    Database.php
    Product.php;
routes
    data
        routes.php
    view
        routes.php
uploads;
views
    index.php
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

// Router implementation handles requests as
// get, post, put, patch and delete requests $_SERVER['REQUEST_METHOD'] is enforced
// as a constraint when adding routes, and receiving requests from client applications.
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

## License

MIT License

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
