<?php
class MockController extends Yaf_Controller_Abstract {
    public function mocksAction() {
        try {
            $mockModel = new Model_Mock();
            $page = $this->getRequest()->getParam('page');
            $count = $this->getRequest()->getParam('count');
            $mocks = $mockModel->getMocks($page, $count);

            Tool_Rest::outGetSucceed($mocks);
        } catch (Exception $e) {
            Tool_Log::logger()->addError($e->getMessage());
            Tool_Rest::outGetFailed('');
        }
    }

    public function mockAction() {
        try {
            $mockModel = new Model_Mock();
            $name = $this->getRequest()->getParam('name');
            $mock = $mockModel->getMock($name);

            if ($mock == false) {
                Tool_Rest::outGetFailed('');
            }

            $value = \Mock\Mock::mock($mock['content']);
            if (is_array($value)) {
                Tool_Response::outJson($value);
            }

            echo $value;
            exit;
        } catch (Exception $e) {
            Tool_Log::logger()->addError($e->getMessage());
            Tool_Rest::outCreateFailed('');
        }
    }

    public function createAction() {
        try {
            $title = Core_Config::getRequest('title', false);
            $content = Core_Config::getRequest('content', false);
            if (empty($title) || empty($content)) {
                Tool_Rest::outGetFailed("title/content cannt empty");
            }

            $mockModel = new Model_Mock();
            $value = $mockModel->create($title, $content);

            Tool_Rest::outCreateSucceed($value);
        } catch (Exception $e) {
            Tool_Log::logger()->addError($e->getMessage());
            Tool_Rest::outCreateFailed('');
        }
    }

    public function updateAction() {
        try {
            $name = $this->getRequest()->getParam('name');
            $title = Core_Config::getRequest('title', false);
            $content = Core_Config::getRequest('content', false);
            if (empty($name)) {
                Tool_Rest::outGetFailed("name cannt empty");
            }

            if (empty($title) && empty($content)) {
                Tool_Rest::outGetFailed("nothing changed");
            }

            $mockModel = new Model_Mock();
            $value = $mockModel->update($name, $title, $content);

            Tool_Rest::outGetSucceed($value);
        } catch (Exception $e) {
            Tool_Log::logger()->addError($e->getMessage());
            Tool_Rest::outGetFailed('');
        }
    }
}