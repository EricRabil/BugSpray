<?php
namespace Steel;

interface IApplication{
    public function __construct(\Steel\Steel $steel);
    public function on_load();
    public function call(\Steel\MVC\MVCBundle $bundle, $arguments);
    public function intercepts($classname);
}
