<?php

namespace App\Controller;


use App\Core\AbstracteController;

class SecuriteController extends AbstracteController
{
   

    public function __construct()
    {
      
    }

    public function register() {}
    public function create() {}
    public function delete() {}
    public function edit() {}
    public function show() {}
    public function store() {}
    public function update() {}

    public function index()
    {
        $this->render('login/login');
    }

 

 
    public function destroy()
    {
       
    }
    
}
