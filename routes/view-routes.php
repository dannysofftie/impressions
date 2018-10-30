<?php
/**
 * Router handler for view requests
 * @category handles view requets, each function returns a view
 * @version 1.0.0
 * @author Danny Sofftie <danny@oratech.co.ke>
 */
use Libraries\Router;

Router::get('/', function ()
{
    include_once 'views/default.php';
}
 );
