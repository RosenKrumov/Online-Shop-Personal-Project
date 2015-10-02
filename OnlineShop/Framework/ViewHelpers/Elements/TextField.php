<?php


namespace Framework\ViewHelpers\Elements;


class TextField extends Element
{
    public function __construct() {
        $this->elementName = "input";
        $this->setAttribute("type", "text");

        return $this;
    }
}