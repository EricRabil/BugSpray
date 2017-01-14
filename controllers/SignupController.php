<?php

class SignupController implements IController{
    
    private $bundle;
    private $model;
    private $steel;
    
    public function __construct(\Steel\MVC\MVCBundle $bundle) {
        $this->bundle = $bundle;
        $this->model = $bundle->get_model();
        $this->steel = $this->model->steel;
    }

    public function main($params) {
        
    }

}