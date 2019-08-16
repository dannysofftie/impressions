<?php

require_once 'configs/config.php';

if (file_exists('vendor'))
    require_once 'vendor/autoload.php';

/**
 * Module loader function
 *
 * @param [string] $directory directory name to load modules from
 * @return void
 */
function moduleLoader($directory)
{
    $modules = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory, 0));

    foreach ($modules as $module) {
        if ($module->isDir()) {
            continue;
        }
        require_once $module->getPathname();
    }
}


use Models\Database;

if (REQUIRE_DATABASE) {
    // load all database models
    moduleLoader('models');

    // boot eloquent database
    new Database();

    // controllers loader
    moduleLoader('controllers');
}
// load libraries
moduleLoader('libraries');
