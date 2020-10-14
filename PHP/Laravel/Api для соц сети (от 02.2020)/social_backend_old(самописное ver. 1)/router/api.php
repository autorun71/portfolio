<?php

use core\Router;

Router::get('api/test', ['\App\Api\TestController'], 'Test');
Router::get('api/(.*)', ['\App\Api\ApiController', 'test'], 'Test');