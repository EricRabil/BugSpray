<?php
$this->config['version'] = '0.0.1 Indev';

$this->config['general'] = array();
    $this->config['general']['host'] = "http://localhost";

    //This is rarely used. Usage scenarios: error reporting, mysql
    $this->config['general']['name'] = "bugspray";

    //This is more commonly used. Usage scenarios: Navbar, etc.
    $this->config['general']['niceName'] = "BugSpray";

    //This CSS file is called after all other CSS files. It is used
    //to build off of existing files. Set to false to disable or
    //set to the URL of custom stylesheet.
    $this->config['general']['customCSS'] = $this->config['general']['host'].'/css/addon.css';

//Values used to make BugSpray more developer-friendly
$this->config['development'] = array();
  //This should be kept off unless you know what you're doing; Broadcasting your
  //version could result in attackers taking advantage of your instance being
  //outdated (if it is.)
  $this->config['development']['broadcastVersion'] = true;

$this->config['db'] = array();
    $this->config['db']['username'] = "bugspray";
    $this->config['db']['password'] = "bugspray";
    $this->config['db']['ip'] = "127.0.0.1";
    $this->config['db']['port'] = "3306";
    $this->config['db']['dbname'] = "bugspray";

//Controls variables for pages
$this->config['pages'] = array();
  $this->config['pages']['layout.phtml'] = array();

    //Static means that the buttons will show in their position no matter if the user is
    //logged in/out. Insert key/values here if you want to have extra buttons.

    //WARNING: Due to the nature of the buttons, you cannot have two with the same key.
    //If you need this, you must manually insert the button into ../templates/layout.phtml
    //MAKE A BACKUP BEFORE MODIFYING TEMPLATES!

    $this->config['pages']['layout.phtml']['navbar-static'] = array();
      $this->config['pages']['layout.phtml']['navbar-static']['left'] = array();
        $this->config['pages']['layout.phtml']['navbar-static']['left'][$lang['page']['names']['home']] = '/';
        $this->config['pages']['layout.phtml']['navbar-static']['left'][$lang['page']['names']['recentbugs']] = '/bugs/recent';

      $this->config['pages']['layout.phtml']['navbar-static']['right'] = array();

      //Key must match the static button array key and must exist - This is used to identify
      //which button, if any, is tied to the current URL.
      $this->config['pages']['layout.phtml']['navbar-static']['buttonHS'] = array();
        $this->config['pages']['layout.phtml']['navbar-static']['buttonHS'][$lang['page']['names']['home']] = 'HS::Home';
        $this->config['pages']['layout.phtml']['navbar-static']['buttonHS'][$lang['page']['names']['recentbugs']] = 'HS::RecentBugs';
        $this->config['pages']['layout.phtml']['navbar-static']['buttonHS'][$lang['page']['names']['login']] = 'HS::Login';

//Advanced values/arrays that should only be tweaked by administrators that know what
//they're doing!

$this->config['advanced'] = array();

    //Note: If you are disabling CDN for LAN-only use, be advised that not all scripts may
    //function correctly.

    $this->config['advanced']['useCDN'] = false;

    //Any links put in the CDN section will be used in the website.
    //They are processed in the order they are entered.
    //If you are using SRI, make sure that you have matching key names.

    //If for whatever reason your CSS/JS resource does not have a SRI, remove or do not add it
    //to this array and it will not be SRI'd.

    //Resources are called in the order they are entered. EX: JQuery is called before JSApi.

    $this->config['advanced']['CDN'] = array();
    $this->config['advanced']['CDN']['CSS'] = array();
      $this->config['advanced']['CDN']['CSS']['tether'] = "https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/css/tether.min.css";
      $this->config['advanced']['CDN']['CSS']['bootstrap'] = "https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/cyborg/bootstrap.min.css";
      $this->config['advanced']['CDN']['CSS']['fontawesome'] = "https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css";

      $this->config['advanced']['CDN']['CSS_SRI'] = array(
        'tether' => "sha256-y4TDcAD4/j5o4keZvggf698Cr9Oc7JZ+gGMax23qmVA=",
        'bootstrap' => "sha384-gv0oNvwnqzF6ULI9TVsSmnULNb3zasNysvWwfT/s4l8k5I+g6oFz9dye0wg3rQ2Q",
        'fontawesome' => "sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN",
      );

    $this->config['advanced']['CDN']['JS'] = array();

      $this->config['advanced']['CDN']['JS']['jquery'] = "https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js";
      $this->config['advanced']['CDN']['JS']['bootstrap'] = "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js";
      $this->config['advanced']['CDN']['JS']['bootstrap-ie10'] = "https://maxcdn.bootstrapcdn.com/js/ie10-viewport-bug-workaround.js";
      $this->config['advanced']['CDN']['JS']['jsapi'] = "https://www.google.com/jsapi";

      $this->config['advanced']['CDN']['JS_SRI'] = array(
        'bootstrap' => "sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa",
        'bootstrap-ie10' => "sha384-EZKKO3vHj6CHKQPIi5+Ubzvx7GjCAfgb/28vGjgly8qKb2DMq7V5D2o//Bjp9z03",
        'jquery' => "sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ",
        'jsapi' => "https://www.google.com/jsapi"
      );

    //If you have customized your file structure, make sure the changes reflect here if you
    //plan on using local resources instead of CDN.

    //Resources are called in the order they are entered. EX: JQuery is called before JSApi.

    $this->config['advanced']['localResources'] = array();
      $this->config['advanced']['localResources']['CSS'] = array();
      $this->config['advanced']['localResources']['js'] = array();
      $this->config['advanced']['localResources']['CSS']['bootstrap'] = $this->config['general']['host'].'/css/cyborg.css';
      $this->config['advanced']['localResources']['CSS']['tether'] = $this->config['general']['host'].'/css/tether.css';
      $this->config['advanced']['localResources']['CSS']['fontawesome'] = $this->config['general']['host'] . '/css/fontawesome.css';
      $this->config['advanced']['localResources']['JS']['jquery'] = $this->config['general']['host'].'/js/jquery.js';
      $this->config['advanced']['localResources']['JS']['bootstrap'] = $this->config['general']['host'].'/js/bootstrap.js';
      $this->config['advanced']['localResources']['JS']['bootstrap-ie10'] = $this->config['general']['host'] . '/js/ie10-viewport-bug-workaround.js';
      $this->config['advanced']['localResources']['JS']['jsapi'] = $this->config['general']['host'].'/js/jsapi.js';

    //CPD == Carries Post Data
    $this->config['advanced']['errorMaps'] = array();
      $this->config['advanced']['errorMaps']['A03'] = 'CPD';
?>
