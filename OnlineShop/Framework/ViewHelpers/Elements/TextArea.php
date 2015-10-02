<?php

namespace Framework\ViewHelpers\Elements;


class TextArea extends Element
{
    public function __construct() {
        $this->elementName = "textarea";
        $this->innerValue = true;

        return $this;
    }
}