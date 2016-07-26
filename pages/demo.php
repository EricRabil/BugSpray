<?php
$data = array ();
$data ["tabTitle"] = "Setup BugSpray";
$context = array ();
$context ["data"] = $data;
$context ["settings"] = $settings;
$styles = array ();
$scripts = array ();
render ( 'demo.phtml', 'Backbones', $context, $styles, $scripts );