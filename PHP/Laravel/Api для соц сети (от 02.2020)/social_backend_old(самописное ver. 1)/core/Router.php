<?php
namespace core;

use App\Controllers\Error404Controller;

class Router
{
    public static $route;
    public static $routes = [];



    public static function get($url, $route, $name = false){
        $url = trim($url, '/');
        $urlMode = "/^". str_replace('/', '\/', $url) ."$/i";
        if (!empty($route[0]) && class_exists($route[0])){
            $route['controller'] = $route[0];
            if(!empty($route[1]) && method_exists($route['controller'], $route[1])){
                $route['action'] = $route[1];
            }elseif(method_exists($route['controller'], 'indexAction')){
                $route['action'] = 'indexAction';
            }
            else
                return false;
            self::$routes[] = [
                'url' => $urlMode,
                'controller' => $route['controller'],
                'action' => $route['action'],
                'name' => ($name ? $name : $url),
                'method' => 'GET'
            ];
            return true;
        }
    }

    public static function post($url, $route, $name = false){
        $url = trim($url, '/');
        $urlMode = "/^". str_replace('/', '\/', $url) ."$/i";
        if (!empty($route[0]) && class_exists($route[0])){
            $route['controller'] = $route[0];
            if(!empty($route[1]) && method_exists($route['controller'], $route[1])){
                $route['action'] = $route[1];
            }elseif(method_exists($route['controller'], 'indexAction')){
                $route['action'] = 'indexAction';
            }
            else
                return false;
            self::$routes[] = [
                'url' => $urlMode,
                'controller' => $route['controller'],
                'action' => $route['action'],
                'name' => ($name ? $name : $url),
                'method' => 'POST'
            ];
            return true;
        }
    }

    public static function put($url, $route, $name = false){
        $url = trim($url, '/');
        $urlMode = "/^". str_replace('/', '\/', $url) ."$/i";
        if (!empty($route[0]) && class_exists($route[0])){
            $route['controller'] = $route[0];
            if(!empty($route[1]) && method_exists($route['controller'], $route[1])){
                $route['action'] = $route[1];
            }elseif(method_exists($route['controller'], 'indexAction')){
                $route['action'] = 'indexAction';
            }
            else
                return false;
            self::$routes[] = [
                'url' => $urlMode,
                'controller' => $route['controller'],
                'action' => $route['action'],
                'name' => ($name ? $name : $url),
                'method' => 'PUT'
            ];
            return true;
        }
    }

    public static function init(){
        $uri = isset($_SERVER['REDIRECT_URL']) ? trim($_SERVER['REDIRECT_URL'], '/') : '';
        foreach (self::$routes as $route){
            if(preg_match($route['url'], $uri, $match) && $_SERVER['REQUEST_METHOD'] == $route['method']){
                if (count($match) > 1 )
                    $req = array_filter($match, function ($k) { return $k != 0; }, ARRAY_FILTER_USE_KEY);

                $route['uri'] = $uri;
                $route['queri'] = $_SERVER['QUERY_STRING'];
                if(isset($req)) $route['request'] = $req;
                self::$route = $route;

                break;
            }
        }

        if (empty(self::$route)) {
            self::$route = [
                'controller' => 'App\Controllers\Error404Controller',
                'action' => 'indexAction',
                'name' => '404',
            ];
        }

        return (new self::$route['controller']);
    }
}