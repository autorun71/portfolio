<?php

namespace App\Service\DebugBar;

class Debug extends BaseDebug
{
    private
        $type,
        $object,
        $user;

    private $startTime = null;
    private $_tabs = 0;

    public function __construct($type, $object = 'UNKNOWN', $user = 'Unknown')
    {
        $this->type = $type;
        $this->object = $object;
        $this->user = $user;

        parent::__construct();
    }

    public function commit($messages)
    {
        $text = $this->serialize($messages);

        $time = time();

        if (!$this->startTime) {
            $this->startTime = $time;
        }

        $params = [
            'TEXT' => $text,
            'TYPE' => $this->type,
            'OBJECT' => $this->object,
            'USER' => $this->user,
            'START_TIME' => $this->startTime,
            'TIMESTAMP' => $time
        ];
        $query = $this->debugBar->insert($params);

        return $this->query($query);
    }

    public function get()
    {
        $where = [
            '=TYPE' => $this->type,
            'OBJECT' => $this->object,
            'USER' => $this->user,
        ];

        $query = $this->debugBar->select([], $where);

        return $this->query($query);
    }

    public function print($var)
    {
        if (!is_object($var) && !is_array($var) && !is_resource($var)) {
            echo gettype($var) . '(' . strlen($var) . '): ' . $var . PHP_EOL;
        } else {
            echo ucfirst(gettype($var));
            if (is_array($var)) {
                echo '(' . count($var) . ')';
            } else {
                echo ' ' . get_class($var);
            }
            echo PHP_EOL;
            echo $this->_setTab();
            echo '(';
            echo PHP_EOL;
            if (is_object($var)){
                $reflect = new \ReflectionClass($var);
                $props   = $reflect->getProperties();
                $methods = $reflect->getMethods();
                echo $this->_setTab('+');
                echo "[props]" . ' => ';
                echo PHP_EOL;
                echo $this->_setTab('');
                echo "(";
                echo PHP_EOL;

                foreach ($props as $prop){
                    $k = $prop->getName();
                    $v = $this->getPropValue($prop->getName(), $var);
                    echo $this->_setTab('+');
                    echo "[{$k}]" . ' => ';
                    $this->print($v);
                    echo $this->_setTab('-');
                    echo PHP_EOL;
                }


                echo $this->_setTab('');
                echo ")";
                echo $this->_setTab('-');
                echo PHP_EOL;


                // methods
                echo $this->_setTab('+');
                echo "[methods]" . ' => ';
                echo PHP_EOL;
                echo $this->_setTab('');
                echo "(";
                echo PHP_EOL;

                foreach ($props as $prop){
                    $k = $prop->getName();

                    echo $this->_setTab('+');
                    echo "[{$k}]" . " => {$k}()";
                    echo $this->_setTab('-');
                    echo PHP_EOL;
                }


                echo $this->_setTab('');
                echo ")";
                echo $this->_setTab('-');
                echo PHP_EOL;
            }else{
                foreach ((is_object($var) ? (array)$var : $var) as $k => $v) {
                    echo $this->_setTab('+');
                    echo "[{$k}]" . ' => ';
                    $this->print($v);
                    echo $this->_setTab('-');
                    echo PHP_EOL;
                }
            }

            echo PHP_EOL;
            echo $this->_setTab();
            echo ')';
        }
    }

    private function _setTab($add = '', $reload = false)
    {
        if ($reload) {
            $this->_tabs = 0;
        }
        if ($add == '+') {
            $this->_tabs++;
        } elseif ($add == '-') {
            $this->_tabs--;
        }

        $tab = '';
        for ($i = 1; $i <= $this->_tabs; $i++) {
            $tab .= "\t";
        }

        return $tab;
    }
}