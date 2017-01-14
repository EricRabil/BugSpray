<?php

class IndexView implements IView {

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
        $page = 'index.phtml';
        $pageTitle = $this->steel->config['general']['niceName'];
        $scripts = array();
        $styles = array();
        $this->context['title'] = $this->model->pageTitle;
        $this->context['body'] = $this->model->bodyText;
        extract($this->context);
        require $this::TEMPLATESDIR . '/layout.phtml';
    }

}
