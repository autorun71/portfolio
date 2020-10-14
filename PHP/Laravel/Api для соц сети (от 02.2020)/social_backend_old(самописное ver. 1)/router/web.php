<?php

use core\Router;

Router::get('test[/]*(.*)', ['\App\Controllers\TestController'], 'Test');
Router::get('.*', ['\App\Controllers\AnyController'], 'Any');
