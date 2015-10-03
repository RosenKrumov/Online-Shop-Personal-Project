<?php


namespace Framework\ViewHelpers;


use Framework\ViewHelpers\Elements\Checkbox;
use Framework\ViewHelpers\Elements\EmailField;
use Framework\ViewHelpers\Elements\HiddenField;
use Framework\ViewHelpers\Elements\PasswordField;
use Framework\ViewHelpers\Elements\RadioButton;
use Framework\ViewHelpers\Elements\Submit;
use Framework\ViewHelpers\Elements\TextArea;
use Framework\ViewHelpers\Elements\TextField;

class FormViewHelper
{
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

        $result = "<form" . $attributesString . ">";

        foreach (self::$elements as $element) {
            $result .= "<$element->elementName";

            $attributesString = "";

            foreach ($element->attributes as $attribute => $value) {
                $attributesString .= " $attribute = " . "\"$value\"";
            }

            $result .= $attributesString . ">";

            if ($element->innerValue === true) {
                $result .= ($element->attributes['value'] != null ? $element->attributes['value'] : "");
                $result .= "</$element->elementName>";
            }
        }

        $result .= "</form>";

        return $result;
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

    public static function initTextField()
    {
        return new TextField();
    }

    public static function initTextArea()
    {
        return new TextArea();
    }

    public static function initPasswordField()
    {
        return new PasswordField();
    }

    public static function initRadioButton()
    {
        return new RadioButton();
    }

    public static function initCheckbox()
    {
        return new Checkbox();
    }

    public static function initSubmit()
    {
        return new Submit();
    }

    public static function initHiddenField(){
        return new HiddenField();
    }
}