<?php

namespace Steel\MVC;

class MVCBundle {

    private $mvcID;
    private $model;
    private $view;
    private $controller;
    private $params = [];
    private $initialized = false;
    private $components;
    private $steel;

    public function __construct(\Steel\Steel $steel, \Steel\MVC\MVCIdentifier $mvcidentifier) {
        $this->mvcID = $mvcidentifier;
        foreach ($this->mvcID->get_dependencies() as $path) {
            require_once $path;
        }
        require_once dirname(__FILE__) . '/../../../models/' . $mvcidentifier->get_model_name() . '.php';
        require_once dirname(__FILE__) . '/../../../controllers/' . $mvcidentifier->get_controller_name() . '.php';
        require_once dirname(__FILE__) . '/../../../views/' . $mvcidentifier->get_view_name() . '.php';
        $this->steel = $steel;
    }

    public function init() {
        if(!$this->initialized){
            $modelName = $this->mvcID->get_model_name();
            $viewName = $this->mvcID->get_view_name();
            $controllerName = $this->mvcID->get_controller_name();
            $this->model = new $modelName($this->steel);
            $this->controller = new $controllerName($this);
            $this->view = new $viewName($this);
            $this->initialized = true;
        }
    }

    /*
     * Code Interpretation:
     * 1 = Success
     * 2 = Not found
     */

    public function runMVC() {
        if (!$this->initialized) {
            $this->init();
        }
        $this->handle_params();
        if (array_key_exists(1, $this->components)) {
            if (in_array($this->components[1], $this->mvcID->get_forbidden_paths())) {
                return 2;
            }
            if (method_exists($this->controller, $this->components[1])) {
                $this->controller->{$this->components[1]}($this->params);
                $this->view->render();
                return 1;
            } else {
                return 2;
            }
        } else {
            $this->controller->main($this->params);
            $this->view->render();
            return 1;
        }
    }

    public function get_mvc_identifier() {
        return $this->mvcID;
    }

    public function set_mvc_identifier($mvcidentifier) {
        if (!$this->initialized) {
            $this->mvcID = $mvcidentifier;
            require_once dirname(__FILE__) . '/../../../models/' . $mvcidentifier->get_model_name() . '.php';
            require_once dirname(__FILE__) . '/../../../controllers/' . $mvcidentifier->get_controller_name() . '.php';
            require_once dirname(__FILE__) . '/../../../views/' . $mvcidentifier->get_view_name() . '.php';
            return true;
        } else {
            return false;
        }
    }

    public function is_initialized() {
        return $this->initialized;
    }

    public function get_model() {
        if(!isset($this->model)){
            return false;
        }
        return $this->model;
    }

    public function get_view() {
        if(!isset($this->view)){
            return false;
        }
        return $this->view;
    }

    public function get_controller() {
        if(!isset($this->controller)){
            return false;
        }
        return $this->controller;
    }

    public function throw_error($int) {
        $this->steel->display_error($int);
    }

    private function handle_params() {
        $this->components = $this->steel->get_components();
        if (count($this->components) <= 3) {
            foreach ($this->components as $key => $val) {
                if ($key < 2) {
                    continue;
                }
                array_push($this->params, $val);
            }
        }
    }

}
