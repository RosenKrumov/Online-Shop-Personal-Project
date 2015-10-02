<?php

namespace Framework\Routers;


class DefaultRouter implements IRouter
{
    public function getUri(){
        return substr($_SERVER['PHP_SELF'], strlen($_SERVER['SCRIPT_NAME']) + 1);
    }

    public function getPost()
    {
        return $_POST;
    }
}