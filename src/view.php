<?php

class View
{
    private $basePath;

    public function __construct($basePath = "templates/") {
        $this->basePath = $basePath;
    }

    public function render($page, $data = array()): void {
        require_once($this->basePath . 'layout.php');
    }
}