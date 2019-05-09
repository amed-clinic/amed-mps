<?php
require_once ('config/config.php');

if ( $UrlPage != "" ) {
  require_once ("system/index.php");
}else if ( $UrlPage == "" ){
  require_once ("system/index.php");
}else {
  require_once ("under.php");
}
?>
