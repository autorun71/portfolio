<?php


namespace core;


use Error;

class Controller
{
    protected $data = [];

    function __construct()
    {
        $this->setData('site_name', SITE_NAME);


    }

    protected function setData($key, $val)
    {
        $this->data[$key] = $val;
    }

    protected function unsetData($key)
    {
        if (isset($this->data[$key]))
            unset($this->data[$key]);
    }

    protected function getData($key)
    {
        if (isset($this->data[$key]))
            return $this->data[$key];
    }

    protected function render($view, $data = [])
    {
        if(empty($data)) $data = $this->data;
        $view = str_replace('.', '/', $view);
        $templLink = "../frontend/view/" . $view . ".view.php";
        try {
            if (file_exists($templLink)) {
                ob_start();
                include $templLink;
                return ob_get_clean();
            } else
                throw new Error($view);
        } catch (Error $e) {
            if (DEBUG) echo ("Template <b>{$e->getMessage()}</b> not found in file: <b>{$e->getFile()}: {$e->getLine()}</b>");
        }


    }
}