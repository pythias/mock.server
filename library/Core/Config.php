<?php

class Core_Config {
    static private $_configs = array();

    static public function get($key, $default = null) {
        $keys = explode('.', $key);
        if (count($keys) < 1) return null;

        $name = strtolower(array_shift($keys));
        if (isset(self::$_configs[$name]) == false) {
            self::$_configs[$name] = include(APP_PATH . "/conf/{$name}.php");
        }
        
        $value = self::$_configs[$name];
        while (true) {
            if (count($keys) == 0) {
                break;
            }

            $key = array_shift($keys);
            if (isset($value[$key]) == false) {
                return $default;
            }

            $value = $value[$key];
        }
        
        return $value;
    }

    static public function getRequest($key) {
        return isset($_REQUEST[$key]) ? $_REQUEST[$key] : null;
    }

    static public function getCookie($key) {
        return isset($_COOKIE[$key]) ? $_COOKIE[$key] : null;
    }

    static public function setCookie($key, $value, $expireSeconds) {
        return setcookie($key, $value, time() + $expireSeconds);
    }

    static public function getSession($key) {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    static public function getServer($key) {
        return isset($_SERVER[$key]) ? $_SERVER[$key] : null;
    }

    static public function getRootUrl() {
        $protocol = self::getServer('SERVER_PROTOCOL');
        $protocol = strtolower(substr($protocol, 0, strpos($protocol, '/')));
        if (self::getServer('HTTPS') == 'on') $protocol = $protocol . 's';
        
        $host = self::getServer('HTTP_HOST');
        if (empty($host)) {
            $port = self::getServer('SERVER_PORT');
            $port = ($port == '80') ? '' : (':' . $port);
            $host = self::getServer('SERVER_NAME') . $port;
        }
        
        return $protocol . '://' . $host;
    }
}