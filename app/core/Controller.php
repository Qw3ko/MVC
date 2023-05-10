<?php

namespace App\Core;

use App\core\View;

interface IController{
    public function index();
}

class Controller implements IController
{
    protected $view;

    public function __construct()
    {
        $this->view = new View();
    }

    public function index(){

    }
}