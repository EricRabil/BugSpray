<?php
$config = array();

$config['general'] = array();
    $config['general']['host'] = "http://localhost";
    $config['general']['name'] = "bugspray";
    $config['general']['niceName'] = "BugSpray";

//Values used to make BugSpray more developer-friendly
$config['development'] = array();

$config['security'] = array();

$config['db'] = array();
    $config['db']['username'] = "bugspray";
    $config['db']['password'] = "bugspray";
    $config['db']['ip'] = "127.0.0.1";
    $config['db']['port'] = "3306";
    $config['db']['dbname'] = "bugspray";

//Controls variables for pages
$config['pages'] = array();

//Advanced values/arrays that should only be tweaked by administrators that know what
//they're doing!
$config['advanced'] = array();
    //Note: If you are disabling CDN for LAN-only use, be advised that not all scripts may
    //function correctly.
    $config['advanced']['useCDN'] = false;

    //Any links put in the CDN section will be used in the website.
    //They are processed in the order they are entered.
    //If you are using SRI, make sure that you have matching key names.
    $config['advanced']['CDN'] = array();
    $config['advanced']['CDN']['CSS'] = array();
    $config['advanced']['CDN']['JS'] = array();
    $config['advanced']['CDN']['CSS']['tether'] = "https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/css/tether.min.css";
    $config['advanced']['CDN']['CSS']['bootstrap'] = "https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/cyborg/bootstrap.min.css";
    $config['advanced']['CDN']['CSS']['fontawesome'] = "https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css";
    $config['advanced']['CDN']['JS']['bootstrap'] = "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js";
    $config['advanced']['CDN']['JS']['bootstrap-ie10'] = "https://maxcdn.bootstrapcdn.com/js/ie10-viewport-bug-workaround.js";
    $config['advanced']['CDN']['JS']['jquery'] = "https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js";
    $config['advanced']['CDN']['JS']['jsapi'] = "https://www.google.com/jsapi";

    //If for whatever reason your CSS/JS resource does not have a SRI, remove or do not add it
    //to this array and it will not be SRI'd.
    $config['advanced']['CDN']['CSS_SRI'] = array(
      'tether' => "sha256-y4TDcAD4/j5o4keZvggf698Cr9Oc7JZ+gGMax23qmVA=",
      'bootstrap' => "sha384-gv0oNvwnqzF6ULI9TVsSmnULNb3zasNysvWwfT/s4l8k5I+g6oFz9dye0wg3rQ2Q",
      'fontawesome' => "sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN",
    );
    $config['advanced']['CDN']['JS_SRI'] = array(
      'bootstrap' => "sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa",
      'bootstrap-ie10' => "sha384-EZKKO3vHj6CHKQPIi5+Ubzvx7GjCAfgb/28vGjgly8qKb2DMq7V5D2o//Bjp9z03",
      'jquery' => "sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ",
      'jsapi' => "https://www.google.com/jsapi"
    );

    //If you have customized your file structure, make sure the changes reflect here if you
    //plan on using local resources instead of CDN.
    $config['advanced']['localResources'] = array();
    $config['advanced']['localResources']['CSS'] = array();
    $config['advanced']['localResources']['js'] = array();
    $config['advanced']['localResources']['CSS']['bootstrap'] = $config['general']['host'].'/css/cyborg.css';
    $config['advanced']['localResources']['CSS']['tether'] = $config['general']['host'].'/css/tether.css';
    $config['advanced']['localResources']['CSS']['fontawesome'] = $config['general']['host'] . '/css/fontawesome.css';
    $config['advanced']['localResources']['JS']['bootstrap'] = $config['general']['host'].'/js/bootstrap.js';
    $config['advanced']['localResources']['JS']['bootstrap-ie10'] = $config['general']['host'] . '/js/ie10-viewport-bug-workaround.js';
    $config['advanced']['localResources']['JS']['jquery'] = $config['general']['host'].'/js/jquery.js';
    $config['advanced']['localResources']['JS']['jsapi'] = $config['general']['host'].'/js/jsapi.js';
?>
