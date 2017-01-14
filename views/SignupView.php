<?php

class SignupView implements IView {

    private $bundle;
    private $model;
    private $steel;
    private $context = [];

    public function __construct(\Steel\MVC\MVCBundle $bundle) {
        $this->bundle = $bundle;
        $this->model = $this->bundle->get_model();
        $this->steel = $this->model->steel;
        $this->headerselect = "HS::Signup";
    }

    public function render() {
        $page = 'signup.phtml';
        $pageTitle = 'Signup';
        $scripts = array();
        $styles = array();
        extract($this->context);
        require $this::TEMPLATESDIR . '/layout.phtml';
    }

}
