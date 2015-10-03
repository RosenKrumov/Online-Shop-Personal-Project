<?php


namespace Framework\ViewHelpers;


class AjaxScriptViewHelper
{
    private static $sourceId;
    private static $ajaxElement;
    private static $preventDefault;
    private static $data;
    private static $destinationId;
    public static function init()
    {
        self::$sourceId = "#";
        self::$ajaxElement = array();
        self::$preventDefault = false;
        self::$data = array();
        self::$destinationId = "#";
        return new self();
    }
    public static function render()
    {
        $inner = "{\n";
        if (count(self::$data) > 0) {
            foreach (self::$data as $key => $value) {
                $inner .= "\t\t\t" . $key . ": " . $value . ",\n";
            }
        }
        $inner .= "\t\t}\n";
        $result = "<script>\n";
        $result .= "$(\"" . self::$sourceId . "\").click(function(e) {\n";
        if(self::$preventDefault) {
            $result .= "\te.preventDefault();\n";
        }
        $result .= "\t$.ajax({\n";
        if(count(self::$ajaxElement) > 0) {
            foreach (self::$ajaxElement as $key => $value) {
                $result .= "\t\t" . $key . ":'" . $value . "',\n";
            }
        }
        $result .= "\t\tdata: " . $inner;
        $result .= "\t}).done(function(data) {\n";
        $result .= "\t\t$(\"" . self::$destinationId . "\").text(data);\n";
        $result .= "\t})\n";
        $result .= "});\n";
        $result .= "</script>";
        echo $result;
    }
    public static function setSourceId($id)
    {
        self::$sourceId .= $id;
        return new self();
    }
    public static function setPreventDefault()
    {
        self::$preventDefault = true;
        return new self();
    }
    public static function setAjaxElement($key, $value)
    {
        self::$ajaxElement[$key] = $value;
        return new self();
    }
    public static function setData($key, $value)
    {
        self::$data[$key] = $value;
        return new self();
    }
    public static function setDestinationId($id)
    {
        self::$destinationId .= $id;
        return new self();
    }
}