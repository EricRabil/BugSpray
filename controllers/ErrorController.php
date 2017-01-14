<?php

class ErrorController implements IErrorController {

    private $model;
    private $bundle;
    private $error_map = array(
        404 => 'not_found',
        2 => 'not_found',
        3 => 'internal_error'
    );

    public function __construct(\Steel\MVC\MVCBundle $bundle) {
        $this->model = $bundle->get_model();
        $this->bundle = $bundle;
    }

    public function main($params) {
        return;
    }

    public function parse_error($code, $args) {
        if (array_key_exists($code, $this->error_map)) {
            $func = $this->error_map[$code];
            $this->$func($args);
        }
    }

    public function internal_error($args) {
        $this->model->set_error_text($args['message']);
        $this->model->set_error_title("Internal Server Error");
    }

    public function not_found($args) {
        $message = sprintf("Sorry! %s couldn't be found.", htmlspecialchars($_SERVER['REQUEST_URI']));
        $this->model->set_error_text($message);
        $this->model->set_error_title("404 - That's an error.");
        $this->model->set_error_code(404);
        $this->generate_image();
    }
    
    private function generate_image(){
        
    }

}
