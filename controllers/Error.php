<?php
class ErrorController extends Yaf_Controller_Abstract {
    public function errorAction($exception) {
        $errorMessage = $exception->getMessage();
        Tool_Rest::outGetNotFound($errorMessage);
    }
}
