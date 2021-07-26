<?php

namespace Env;

class Env
{

    private static $instance = null;

    private $envVar = [];

    private $isInit = false;

    private function __construct()
    {
        if( !$this->isInit ) {
            $this->init();
            $this->isInit = true;
        }
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Env();
        }
        return self::$instance;
    }

    private function init()
    {

    }

    private function get($key)
    {
        return $this->envVar[$key];
    }

    public function isset($key)
    {
        return isset( $this->envVar[$key] ) && !empty( $this->envVar[$key] );
    }

    public function set($key, $value)
    {
        $this->envVar[$key] = $value;
    }

}
