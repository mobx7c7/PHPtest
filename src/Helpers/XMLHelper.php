<?php
namespace BuscadorCEP\Helpers;

class XMLHelper
{
    private function encode_push($arr, $dom, $node)
    {
        foreach ($arr as $key => $val) {
            if (is_array($val)) {
                $childNode = $dom->createElement($key);
                self::encode_push($newValue, $dom, $childNode);
            } else {
                $childNode = $dom->createElement($key, $val);
            }
            $node->appendChild($childNode);
        }

        $dom->appendChild($node);
    }
    public static function encode($name, $data)
    {
        $dom = new \DOMDocument();
        $dom->encoding = 'utf-8';
        $dom->xmlVersion = '1.0';
        $dom->formatOutput = true;
        $root = $dom->createElement($name);
        self::encode_push($data, $dom, $root);
        return $dom->saveXML(NULL,LIBXML_NOEMPTYTAG);
    }
}
