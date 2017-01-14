<?php

interface IErrorController extends IController {

    public function not_found($url);

    public function internal_error($message);
}
