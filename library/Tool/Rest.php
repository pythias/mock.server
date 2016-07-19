<?php

class Tool_Rest {
    const CODE_SUCCESS = 0;
    const CODE_CREATE_FAILED = 1;
    const CODE_URL_NOT_FOUND = 2;
    const CODE_BAD_REQUEST = 3;
    const CODE_METHOD_NOT_ALLOWED = 4;
    const CODE_CODE_UNAUTHORIZED = 5;

    private static function _out($data) {
        // $format = $this->getRequest()->getParam('out');
        // if ($format != 'xml') {
        //     $format = 'json';
        // }
        $format = 'json';

        call_user_func_array(array('Tool_Response', 'out' . ucfirst($format)), array($data));
    }

    static public function outCreateSucceed($data = array()) {
        if (!headers_sent()) {
            header('HTTP/1.1 201 Created', true, 201);
        }

        self::_out($data);
    }

    static public function outCreateFailed($message = "", $code = self::CODE_CREATE_FAILED) {
        if (!headers_sent()) {
            header('HTTP/1.1 400 Bad Request', true, 400);
        }

        self::_out(array('error_code' => $code, 'error_message' => $message));
    }

    static public function outGetSucceed($data = array()) {
        if (!headers_sent()) {
            header('HTTP/1.1 200 OK', true, 200);
        }

        self::_out($data);
    }

    static public function outGetNotFound($message = "", $code = self::CODE_URL_NOT_FOUND) {
        if (!headers_sent()) {
            header('HTTP/1.1 404 Not Found', true, 404);
        }

        self::_out(array('error_code' => $code, 'error_message' => $message));
    }

    static public function outGetFailed($message = "", $code = self::CODE_BAD_REQUEST) {
        if (!headers_sent()) {
            header('HTTP/1.1 400 Bad Request', true, 400);
        }

        self::_out(array('error_code' => $code, 'error_message' => $message));
    }

    static public function outMethodInvalid($method, $code = self::CODE_METHOD_NOT_ALLOWED) {
        if (!headers_sent()) {
            header('HTTP/1.1 405 Method Not Allowed', true, 405);
        }

        self::_out(array('error_code' => $code, 'error_message' => "Method {$method} not allowed"));
    }

    static public function outUnauthorized($message = "", $code = self::CODE_UNAUTHORIZED) {
        if (!headers_sent()) {
            header('HTTP/1.1 401 Unauthorized', true, 401);
        }

        self::_out(array('error_code' => $code, 'error_message' => $message));
    }
}