<?php


namespace App\Service;


class CLI
{

    public static function getArgument(string $argument, array $args, $separator = '-')
    {
        $result = false;

        foreach ($args as $key => $arg) {
            if ($arg == $separator . $argument) {
                $result = null;
                if (!empty($args[$key + 1]) && $args[$key + 1][0] != '-') {
                    $result = $args[$key + 1];
                }
            }
        }
        return $result;
    }

    public static function argumentsToArray(array $args, $separator = '-')
    {
        $result = [];
        foreach ($args as $key => $arg) {
            if ($arg[0] == $separator) {
                $newKey = str_replace($separator, '', $arg);
                $result[$newKey] = '';
                if (!empty($args[$key + 1]) && $args[$key + 1][0] != '-') {
                    $result[$newKey] = $args[$key + 1];
                }
            }
        }
        return $result;
    }
    static function serverImitation($s)
    {
        $time = time();
        $exit = false;
        while (!$exit) {
            if ($time + $s <= time()) {
                $exit = true;
                break;
            }
        }
    }

    static function success($messages)
    {
        echo "\e[32m" . $messages . "\n";
    }
    static function error($messages)
    {
        echo "\e[31m" . $messages . "\n";
    }
    public static function log(...$messages)
    {

        !defined('CLI_TIME_START') && define('CLI_TIME_START', microtime(true));
        ob_start();
        if (php_sapi_name() == 'cli' || (defined('BROWSER_DEBUG') && BROWSER_DEBUG)) {
            echo date('[d.m.Y H:i:s] ');
            foreach ($messages as $message) {
                if ($message === false){
                    $message = 'false';
                }elseif ($message === null){
                    $message = 'null';
                }
                print_r($message);
                echo ' ';
            }
            echo "\n";
            if (php_sapi_name() != 'cli'){
                echo '<br>';
            }
        }
        $mess = ob_get_clean();
        self::setLog($mess, 'debug_CLI_' . CLI_TIME_START);

        echo $mess;

    }


    static function setLog($text, $object=null, ...$args){
        if (defined('EXPORT_XML_DEBUG') && EXPORT_XML_DEBUG){
            $mess = [$text];
            foreach ($args as $arg){
                if (is_array($arg)){
                    foreach ($arg as $k=>$v){
                        $mess[] = (is_int($k) ? '' : "$k: ") . (is_array($v) ? json_encode($v) : $v);
                    }
                }else{
                    $mess[] = $arg;
                }
            }
            $text = implode(PHP_EOL.'<br>'.PHP_EOL.'<br>', $mess);
            $logger = \Monolog\Registry::getInstance('cli_log');
            $logger->info($text, ['item_id' => $object]);
        }

    }


}