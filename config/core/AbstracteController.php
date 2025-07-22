<?php

namespace App\Core;

abstract class AbstracteController
{
    use Singleton;
    abstract public function index();
    abstract public function create();
    abstract public function edit();
    abstract public function destroy();
    abstract public function show();
    abstract public function store();
    abstract public function update();
    protected $layout = 'base';

    protected Session $session;

    public function __construct()
    {
        // $this->session = \App\Core\App::getDependency('session');
    }

    public function render($view, $data = [])
    {
        if (!empty($data)) {
            extract($data);
        }
        ob_start();
      
    }

}
