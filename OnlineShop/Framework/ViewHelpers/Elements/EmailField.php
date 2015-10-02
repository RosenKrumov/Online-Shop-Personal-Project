<?php


namespace Framework\ViewHelpers\Elements;


class EmailField extends Element
{
    public function __construct() {
        $this->elementName = "input";
        $this->setAttribute("type", "email");

        return $this;
    }
}