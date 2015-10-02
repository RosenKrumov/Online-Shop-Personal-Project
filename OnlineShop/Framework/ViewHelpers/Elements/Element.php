<?php


namespace Framework\ViewHelpers\Elements;


use Framework\ViewHelpers\FormViewHelper;

abstract class Element
{
    public $attributes = [];
    public $elementName;
    public $innerValue = false;

    public function setName($value){
        $this->attributes['name'] = $value;
        return $this;
    }

    public function setClasses($classes){
        $this->attributes['class'] = $classes;
        return $this;
    }

    public function setAttribute($attribute, $value){
        $this->attributes[$attribute] = $value;
        return $this;
    }

    public function setValue($value){
        $this->setAttribute('value', $value);
        return $this;
    }

    public function create(){
        FormViewHelper::$elements[] = $this;
        return new FormViewHelper();
    }
}