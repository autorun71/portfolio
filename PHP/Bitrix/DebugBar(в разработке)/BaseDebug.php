<?php


namespace App\Service\DebugBar;


use App\Core\DB\ConstructorSQL;
use App\Core\Main;

class BaseDebug
{
    /**
     * @var ConstructorSQL
     */
    protected $debugBar;

    /**
     * @var ConstructorSQL
     */
    protected $debugBarObjects;

    private $config = null;
    private $cms = null;
    private $dbConf = null;
    private $db = null;
    private $createTime = null;
    private $startTime = null;

    public function __construct()
    {
        $this->config = Main::config('app');
        $this->dbConf = Main::config('db');

        $this->__setConnect();

        $this->createTime = time();


    }



    private function __setConnect()
    {
        $result = [];
        $this->cms = $this->config['const']['CMS'][$this->config['main']['CMS']];

        $arQuery = $this->getQueryForCreateTable();
        if ($this->cms == 'Bitrix') {
            $this->getBitrixDB();
        }

        foreach ($arQuery as $query) {
            $result[] = $this->query($query);
        }

        return $result;
    }

    private function getBitrixDB()
    {
        $this->db = \Bitrix\Main\Application::getConnection();
    }

    protected function query($sql)
    {
        return $this->db->query($sql);
    }

    private function getQueryForCreateTable()
    {

        foreach ($this->dbConf['tables'] as $table) {
            switch ($table['name']) {
                case 'debug_bar':
                    $this->debugBar = new ConstructorSQL($table);
                    break;
                case 'debug_bar_objects':
                    $this->debugBarObjects = new ConstructorSQL($table);
                    break;
            }
        }
        return [
            $this->debugBar->create(),
            $this->debugBarObjects->create()
        ];

    }

    protected function serialize($var)
    {
        if ($var === '') {
            $var = "''";
        }
        if (is_null($var)) {
            $result = 'null';
        } elseif (is_bool($var)) {
            $result = $var ? 'true' : 'false';
        } elseif (is_int($var) || is_string($var) || is_double($var)) {
            $result = $var;
        } else {
            $result = serialize($var);
        }

        return $result;
    }

    protected function getPropValue(string $prop, $obj)
    {
        return (function () use ($prop) {
            return $this->$prop;
        })->call($obj);
    }
}