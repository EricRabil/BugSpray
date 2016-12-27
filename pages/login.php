<?php
if(isset($_SESSION['pages']['login']['error'])){
  echo $_SESSION['pages']['login']['error'].' - '.$lang['errors'][$_SESSION['pages']['login']['error']];
}
?>
