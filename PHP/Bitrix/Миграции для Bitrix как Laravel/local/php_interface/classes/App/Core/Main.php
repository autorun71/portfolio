<?php


namespace App\Core;




use App\Service\CLI;

class Main
{

    const configPath = "/local/php_interface/config";
    const settingsPath = '/bitrix/.settings.php';
    public static function config($configName)
    {
        try {
            $array = null;
            $configName = str_replace(['/'], [''], $configName);
            $arConf = explode('.', $configName);
            $config = array_shift($arConf);
            $pathConfig = $_SERVER['DOCUMENT_ROOT'] . self::configPath . '/' . $config . '.php';
            if (file_exists($pathConfig)) {
                $array = include $pathConfig;
            }else{
                throw new \Error('File >> ' . $pathConfig . ' not exist!');
            }
            if (!empty($arConf)){
                foreach ($arConf as $key){
                    if (!empty($array[$key])){
                        $array = $array[$key];
                    }else{
                        throw new \Error('Key "' . $key . '" not exist in config >> '. $pathConfig . '!');
                    }
                }
            }
            return $array;
        }catch (\Error $error) {
            self::printError($error);
        }
    }

    public static function printError(\Error $error)
    {
        CLI::log($error->getMessage(), $error->getFile(), $error->getLine());
        die();
    }

    public static function getMigrations()
    {
        $result = [];
        $migrationPath = $_SERVER['DOCUMENT_ROOT'] . self::config('app.path.migrations');
        $migration = array_diff( scandir( $migrationPath), array('..', '.'));
        if (!empty($migration)){
            $result = [
                'path' => $migrationPath,
                'migration' => $migration
            ];
        }
        return $result;
    }

    public static function getSettings()
    {
        $settingsPath = $_SERVER['DOCUMENT_ROOT'] . self::settingsPath;
        if (file_exists($settingsPath)) {
            return include $settingsPath;
        }
        return [];
    }

}