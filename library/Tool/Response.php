<?php 

class Tool_Response {
    static public function outJson($data = array()) {
        if (!headers_sent()) {
            header('Content-type: application/json; charset=utf-8', true);
        }
        
        echo json_encode($data);
        exit();
    }

    static public function outXml($data = array()) {
        if (!headers_sent()) {
            header('Content-type: application/xml; charset=utf-8', true);
        }

        echo Tool_Xml::fromArray($data);
        exit();
    }
}