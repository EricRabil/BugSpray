<?php

interface IView {

    const TEMPLATESDIR = '../templates';

    public function __construct(\Steel\MVC\MVCBundle $bundle);

    public function render();
}
