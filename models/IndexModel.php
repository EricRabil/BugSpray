<?php

class IndexModel implements IModel {

    public $pageTitle;
    public $bodyText;
    public $background;
    public $steel;

    public function __construct(\Steel\Steel $steel) {
        $this->steel = $steel;
    }

}
