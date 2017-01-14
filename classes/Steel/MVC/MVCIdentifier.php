<?php

namespace Steel\MVC;

class MVCIdentifier {

    private $uid;
    private $path;
    private $modelName;
    private $viewName;
    private $controllerName;
    private $forbiddenPaths;
    private $dependencies;

    public function __construct($uid, $path, $model, $view, $controller, $forbidden = array('__construct', 'main'), $dependencies = []) {
        $this->uid = $uid;
        $this->path = $path;
        $this->modelName = $model;
        $this->viewName = $view;
        $this->controllerName = $controller;
        if(!in_array('__construct', $forbidden)){
            array_push($forbidden, '__construct');
        }
        if(!in_array('main', $forbidden)){
            array_push($forbidden, 'main');
        }
        $this->forbiddenPaths = $forbidden;
        $this->dependencies = $dependencies;
    }

    public function get_path() {
        return $this->path;
    }

    public function get_model_name() {
        return $this->modelName;
    }

    public function get_view_name() {
        return $this->viewName;
    }

    public function get_controller_name() {
        return $this->controllerName;
    }

    public function get_forbidden_paths() {
        return $this->forbiddenPaths;
    }

    public function get_uid() {
        return $this->uid;
    }

    public function get_dependencies() {
        return $this->dependencies;
    }

}
