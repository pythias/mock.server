<?php
class Model_Mock {
    private $_redis = null;
    public function __construct() {
        $this->_redis = Tool_Redis::getConnection('mocks');
    }

    public function create($title, $content) {
        try {
            $name = \Mock\Mock::mock("@string('alpha', 16, 16)");
            while ($this->_redis->exists($name)) {
                $name = \Mock\Mock::mock("@string('alpha', 16, 16)");
            }

            if ($this->_redis->hSet($name, 'title', $title) == false) {
                return false;
            }

            if ($this->_redis->hSet($name, 'content', $content) == false) {
                $this->_redis->delete($name);
                return false;
            }

            if ($this->_redis->rPush('_mocks_', $name) == false) {
                $this->_redis->delete($name);
                return false;
            }

            return array(
                'mock_name' => $name, 
                'mock_title' => $title,
                'mock_content' => $content,
            );
        } catch (Exception $e) {
            return false;
        }
    }

    public function update($name, $title, $content) {
        try {
            if (empty($title) && empty($content)) {
                return false;
            }

            if ($title) {
                return this->_redis->hSet($name, 'title', $title);
            } else if ($content) {
                return this->_redis->hSet($name, 'content', $content);
            }

            return this->_redis->hMSet($name, array('title', 'content'), array($title, $content));
        } catch (Exception $e) {
            return false;
        }
    }

    public function getMocks($page = 1, $count = 10) {
        try {
            $from = ($page - 1) * $count;
            $names = $this->_redis->lRange('_mocks_', $from, $count);
            $mocks = array();
            foreach ($name as $name) {
                $mock = $this->getMock($name);
                if ($mock) {
                    $mock['name'] = $name;
                    $mocks[] = $mock;
                }
            }

            return $mocks;
        } catch (Exception $e) {
            return false;
        }
    }

    public function getMock($name) {
        try {
            $mock = $this->_redis->hGetAll($name);
            if ($mock) {
                $mock['name'] = $name;
            }

            return $mock;
        } catch (Exception $e) {
            return false;
        }        
    }
}

function alleria_after($url, $after = 1000) {
    \Tarth\Tool\Redis::setCacheServer(get_option_value($worker->config, 'resource.cache', '127.0.0.1:6379'));
    \Tarth\Tool\Redis::setQueueServer(get_option_value($worker->config, 'resource.queue', '127.0.0.1:6379'));
    
    \Tarth\Tool\Task::createApiTask($url)->runAfter($after / 1000);
    return \Tarth\Tool\Task::exec();
}
