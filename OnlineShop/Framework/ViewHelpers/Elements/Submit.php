<?php


namespace Framework\ViewHelpers\Elements;


class Submit extends Element
{
    public function __construct()
    {
        $this->elementName = "input";
        $this->setAttribute("type", "submit");

        return $this;
    }
}