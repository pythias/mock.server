<?php

class Tool_Redis {
    static private $_connections;

    static public function getConnection($pool = 'mocks') {
        if (!empty(self::$_connections[$pool])) {
            return self::$_connections[$pool];
        }

        $server = Core_Config::get("redis.{$pool}");

        $connection = new Redis();

        try {
            //Fix 'Redis::connect(): php_network_getaddresses: getaddrinfo failed: Name or service not known' in docker php
            list($ip, $port) = explode(':', $server);
            $connection->connect($ip, $port);
            //$connection->connect($server);
            $connection->server = $server;

            self::$_connections[$pool] = $connection;
        } catch (Exception $e) {
            Tool_Log::logger()->addError($e->getMessage());
        }

        return $connection;
    }
}