<?php
$example = array ();
$example ["title"] = "This is an example!";
$context = array ();
$context ["example"] = $example;
$context ["settings"] = $settings;
$styles = array ();
$scripts = array ();
render ( 'index.phtml', 'Backbones', $context, $styles, $scripts );