<?php
class Bootstrap extends Yaf_Bootstrap_Abstract {
    public function _initLoader() {
        Yaf_Loader::import(APP_PATH . "/vendor/autoload.php");
    }

    public function _initRoute(Yaf_Dispatcher $dispatcher) {
        $router = $dispatcher->getRouter();

        $router->addRoute('mock_mock', new Yaf_Route_Rewrite('mock/:name', array('controller' => 'mock','action' => 'mock')));
        $router->addRoute('mock_update', new Yaf_Route_Rewrite('mock/:name/update', array('controller' => 'mock','action' => 'update')));
        $router->addRoute('mock_mocks', new Yaf_Route_Rewrite('mock/:page/:count', array('controller' => 'mock','action' => 'mocks')));
        $router->addRoute('mock_create', new Yaf_Route_Rewrite('mock/create', array('controller' => 'mock','action' => 'create')));
    }
}