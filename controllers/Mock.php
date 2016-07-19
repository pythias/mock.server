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
                $this->failure();
            }

            $value = \Mock\Mock::mock($mock['mock_content']);
            if (is_array($value)) {
                if (headers_sent() == false) {
                    header('Content-type: application/json; charset=utf-8', true);
                }

                $value = json_encode($value);
            }

            echo $value;
        } catch (Exception $e) {
            Tool_Log::logger()->addError($e->getMessage());
            Tool_Rest::outCreateFailed('');
        }
    }

    public function createAction() {
        try {
            $title = Comm_Context::post('title', false);
            $content = Comm_Context::post('content', false);
            if (empty($title) || empty($content)) {
                $this->failure(0, "title/content cannt empty");
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
            $title = Comm_Context::post('title', false);
            $content = Comm_Context::post('content', false);
            if (empty($name)) {
                $this->failure(0, "name cannt empty");
            }

            if (empty($title) && empty($content)) {
                $this->failure(0, "nothing changed");
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