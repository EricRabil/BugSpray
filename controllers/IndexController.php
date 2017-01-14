<?php

class IndexController implements IController {

    private $model;
    private $bundle;

    public function __construct(\Steel\MVC\MVCBundle $bundle) {
        $this->bundle = $bundle;
        $this->model = $this->bundle->get_model();
    }

    public function main($params) {
        $this->model->pageTitle = "This is Steel!";
        $this->model->bodyText = "If you see this screen, Steel is working!";
    }

}
