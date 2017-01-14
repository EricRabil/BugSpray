<?php

class ErrorView implements IView {

    private $bundle;
    private $model;
    private $steel;
    private $context = [];

    public function __construct(\Steel\MVC\MVCBundle $bundle) {
        $this->bundle = $bundle;
        $this->model = $this->bundle->get_model();
        $this->steel = $this->model->steel;
        $this->headerselect = "HS::Home";
    }

    public function render() {
        $page = 'error.phtml';
        $scripts = array();
        $styles = array();
        $pageTitle = $this->model->get_error_code();
        $this->context['errorTitle'] = $this->model->get_error_title();
        $this->context['errorText'] = $this->model->get_error_text();
        $this->context['errorType'] = $this->model->get_error_type();
        extract($this->context);
        require $this::TEMPLATESDIR . '/layout.phtml';
    }

}
