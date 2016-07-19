<?php

class Tool_Xml {
    static public function fromArray($data) {
        $xml = new SimpleXMLElement('<?xml version="1.0"?><data></data>');
        self::fromArray($data, $xml);
        return $xml->asXML();
    }

    static public function arrayToXml($data, &$xml) {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                if (is_numeric($key)) {
                    $key = "item{$key}";
                }

                $subNode = $xml->addChild($key);
                self::arrayToXml($value, $subNode);
            } else {
                $xml->addChild($key, htmlspecialchars($value));
            }
        }
    }
}