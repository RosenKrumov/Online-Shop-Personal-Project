<?php


namespace Framework\ViewHelpers;


use Framework\ViewHelpers\Elements\DropdownOption;

class DropdownViewHelper
{
    /**
     * @var Elements\Element[]
     */
    public static $elements = array();
    private static $attributes = array();
    public static function init()
    {
        self::$elements = array();
        self::$attributes = array();
        return new self();
    }
    public static function render()
    {
        $attributesString = "";
        foreach (self::$attributes as $attribute => $value) {
            $attributesString .= " $attribute = " . "\"$value\"";
        }
        $result = "<select" . $attributesString . ">";
        foreach (self::$elements as $element) {
            $result .= "<option ";
            $attributesString = "";
            foreach ($element->attributes as $attribute => $value) {
                $attributesString .= " $attribute = " . "\"$value\"";
            }
            $result .= $attributesString . ">";
            $result .= $element->innerValue;
        }
        $result .= "</select>";
        echo $result;
    }
    public static function setAction($action)
    {
        self::setAttribute("action", $action);
        return new self();
    }
    public static function setMethod($method)
    {
        self::setAttribute("method", $method);
        return new self();
    }
    public static function setClasses($classes)
    {
        self::setAttribute("class", $classes);
        return new self();
    }
    public static function setAttribute($attribute, $value)
    {
        self::$attributes[$attribute] = $value;
        return new self();
    }
    public static function initOption()
    {
        return new DropdownOption();
    }
}