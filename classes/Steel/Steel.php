<?php
namespace Steel;

require_once 'autoload.php';

use Steel\Database\Connection;

class Steel {

    private $mvcMap = [];
    private $components;
    private $path;
    public $config;

    private $initialized = false;

    public $application = false;

    public $database;

    private function set_mvc_map() {
        $this->mvcMap['index'] = new \Steel\MVC\MVCIdentifier('MVC-INDEX', 'index', 'IndexModel', 'IndexView', 'IndexController', array(), array());
        $this->mvcMap['signup'] = new \Steel\MVC\MVCIdentifier('MVC-SIGNUP', 'signup', 'SignupModel', 'SignupView', 'SignupController', array(), array());
    }

    public function init() {
        if(!$this->initialized){
            $this->path = trim(preg_replace("/[^a-z0-9_\\/]+/i", "", (isset($_GET['method'])) ? $_GET['method'] : 'index'), '/');
            $conf = new \Steel\Settings();
            $conf->setup();
            $this->config = $conf->getConfig();
            if($this->config['steel']['useSessions']){
                session_start();
            }
            if($this->config['database']['enabled']){
                $this->database = new Connection($this->config['database']);
            }else{
                $this->database = false;
            }
            $this->require_interfaces();
            if ($this->config['steel']['autoinclude']) {
                $this->require_includes();
            }
            $this->set_mvc_map();
            if($this->config['steel']['useApplication']){
                $this->use_app_controller();
            }
            $this->process_request();
            $this->initialized = true;
        }
    }

    private function use_app_controller(){
        if($this->config['steel']['useApplication']){
            require_once $this->config['steel']['application']['filepath'];
            $this->application = new $this->config['steel']['application']['fully_qualified_name']($this);
            if (!is_subclass_of($this->application, '\Steel\IApplication')) {
                echo get_class($this->application)." must be implement \Steel\IApplication";
                exit();
            }
        }else{
            return false;
        }
    }

    private function require_interfaces() {
        require dirname(__FILE__) . '/../../models/IModel.php';
        require dirname(__FILE__) . '/../../controllers/IController.php';
        require dirname(__FILE__) . '/../../views/IView.php';
        return true;
    }

    public function get_config() {
        return $this->config;
    }

    private function require_includes() {
        $files = scandir(dirname(__FILE__) . "/../../include");
        $include = [];
        foreach ($files as $file) {
            $extension = explode('.', $file);
            if (isset($extension[1]) && !empty($extension[1]) && $extension[1] === "php") {
                array_push($include, $file);
            }
        }
        foreach ($include as $file) {
            require dirname(__FILE__) . "/../../include/" . $file;
        }
    }

    public function get_mvc_map() {
        return $this->mvcMap;
    }

    private function process_request() {
        $this->components = explode('/', $this->path);
        $class = $this->components[0];
        if (!array_key_exists($class, $this->mvcMap)) {
            $this->display_error(2, array('path' => $this->path));
            return;
        }
        $mvcID = $this->mvcMap[$class];
        $mvc = new \Steel\MVC\MVCBundle($this, $mvcID);
        $intercepted = ($this->config['steel']['useApplication']) ? $this->application->call($mvc, $this->components) : false;
        if(!$intercepted){
            $status = $mvc->runMVC();
            if ($status != 1) {
                switch ($status) {
                    case 2:
                        $this->display_error(2, array('path' => $this->path));
                        break;
                    case 3:
                        $this->display_error(3, array('message' => "MVC " + $mvcID->get_uid + " has already been executed."));
                        break;
                }
            }
        }else{
            return;
        }
    }

    public function get_components() {
        return $this->components;
    }

    public function display_error($int, $args) {
        $errorID = new \Steel\MVC\MVCIdentifier('MVC-ERR', 'error', 'ErrorModel', 'ErrorView', 'ErrorController', array('__construct', 'main'), array(dirname(__FILE__) . '/../../models/IErrorModel.php', dirname(__FILE__) . '/../../controllers/IErrorController.php'));
        $mvc = new \Steel\MVC\MVCBundle($this, $errorID);
        $mvc->init();
        $mvc->get_controller()->parse_error($int, $args);
        $mvc->get_view()->render();
    }

    public function get_path(){
        return $this->path;
    }

}
