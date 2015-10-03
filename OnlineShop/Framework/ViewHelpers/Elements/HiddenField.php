<?php


namespace Framework\ViewHelpers\Elements;


class HiddenField extends Element
{
    public function __construct() {
        $this->elementName = "input";
        $this->setAttribute("type", "hidden");

        return $this;
    }
}