<?php


namespace Framework\ViewHelpers\Elements;


use Framework\ViewHelpers\DropdownViewHelper;

class DropdownOption extends Element
{
    public function setValue($value)
    {
        $this->attributes['value'] = $value;
        return $this;
    }
    public function setInnerValue($value)
    {
        $this->innerValue = $value;
        return $this;
    }
    public function create()
    {
        DropdownViewHelper::$elements[] = $this;
        return new DropdownViewHelper();
    }
}