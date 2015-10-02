<?php

namespace Framework\ViewHelpers\Elements;


class PasswordField extends Element
{
    public function __construct() {
        $this->elementName = "input";
        $this->setAttribute("type", "password");

        return $this;
    }
}