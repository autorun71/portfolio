<?php


namespace Webkul\Region\Service;


class Region extends CoreRegion
{

    private static array $instances = [];


    public function __construct()
    {
        parent::__construct();
    }

    public function instance(){
        return $this;
    }
//    public  function getInstance($url = false)
//    {
//        $cls = self::class;
//        if (!isset(self::$instances[$cls])) {
//            self::$instances[$cls] = new self();
//            if (!empty($url)){
//                self::$instances[$cls]->setDomain($url);
//                self::$instances[$cls]->init($url);
//            }
//        }
//
//        return self::$instances[$cls];
//    }

    public function setUrl($url){
        $this->setDomain($url);

        $this->init();
    }

    public function getRegion()
    {
        return $this->region;
    }

    public function getProps()
    {
        return $this->props;
    }

    public function hasRegion($code)
    {

    }
}